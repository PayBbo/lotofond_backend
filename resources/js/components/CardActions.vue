<template>
    <div v-if="item">
        <div class="bkt-dropdown dropdown" v-for="action in main_actions"
             :class="{'bkt-dropdown__menu-item bkt-gap-small': type ==='menu',
             'd-none d-lg-block': action.place !== 'dropdown' && action.place !== 'permanent' && type !=='menu',
             'd-lg-none': action.place !== 'dropdown' && action.place !== 'permanent' && type ==='menu'}"
             v-if="!action.condition || (action.condition && item[action.status]==true)"
        >
            <div v-tooltip="type ==='menu' ? '' : (item[action.status] && action.status_icon ? action.status_label : action.label)"
                 class="bkt-cursor-pointer"
                :class="[
                     type ==='menu' ? '' : (item[action.status]||in_process.indexOf(action.icon)>=0 ?
                     (action.icon==='Star' ? 'bkt-bg-'+favourite_color : 'bkt-bg-'+action.color) : main_bg),
                     type ==='menu' ? '' : (action.color ? (action.icon==='Star' ? 'bkt-hover-'+favourite_color
                     : 'bkt-hover-'+action.color) : 'bkt-hover-'+main_bg),
                     type ==='menu' ? 'd-flex bkt-gap-small align-items-center w-100' : 'bkt-button'+button_type,
                     action.class
                ]"
                @click="makeAction(action.method, action.method_params, action.icon)"
                :id="action.dropdown_id ? action.dropdown_id : 'button-dropdown-'+action.icon"
                :data-bs-toggle="action.dropdown_id && ((action.status && item[action.status]) || !action.status) ? 'dropdown' : ''"
                :disabled="in_process.indexOf(action.icon)>=0"
            >
                <div :class="{'bkt-dropdown__menu-icon':type==='menu'}">
                    <span v-if="in_process.indexOf(action.icon)>=0"
                          :class="{'bkt-text-main' : type==='menu'}"
                          class="spinner-border spinner-border-sm flex-shrink-0" role="status">
                    </span>
                    <bkt-icon v-if="in_process.indexOf(action.icon)<0 "
                              class="bkt-button__icon"
                              :name="item[action.status] && action.status_icon ? action.status_icon : action.icon"
                              :color="type==='menu' ? 'main' : (item[action.status] ? 'white' : icon_color)">
                    </bkt-icon>
                </div>
                <div class="bkt-dropdown__menu-text" v-if="type==='menu'">
                    {{item[action.status] && action.status_icon ? action.status_label : action.label}}
                </div>
            </div>
            <div v-show="action.dropdown_id && ((action.status && item[action.status]) || !action.status)"
                 class="dropdown-menu dropdown-menu-end dropdown-menu-right bkt-dropdown__menu bkt-dropdown__menu_neutral"
                 :class="{'bkt-dropdown__menu_pointed':type!=='menu'}"
                 aria-labelledby="dropdownMenuClickableOutside"
            >
                <template v-if="action.dropdown_id==='inFavourite'">
                    <div class="bkt-dropdown__menu-item bkt-wrapper-between" style="cursor: pointer"
                         v-if="favourites_paths.length>1" @click="moveFavourite">
                        <div class="bkt-dropdown__menu-text">
                            Переместить
                        </div>
                        <div class="bkt-dropdown__menu-icon">
                            <bkt-icon name="FileArrowLeft" color="blue"></bkt-icon>
                        </div>
                    </div>
                    <div class="bkt-dropdown__menu-item bkt-wrapper-between" style="cursor: pointer"
                         @click="removeFromFavourites">
                        <div class="bkt-dropdown__menu-text">
                            Удалить
                        </div>
                        <div class="bkt-dropdown__menu-icon">
                            <bkt-icon name="Trash" color="red"></bkt-icon>
                        </div>
                    </div>
                </template>
                <template v-if="action.dropdown_id==='shareDropdown'">
                    <skeleton :count="networks.length" v-if="!item.id" height="38px" skeleton_class="mb-1"/>
                    <div  class="bkt-dropdown__menu-item bkt-wrapper-between bkt-cursor-pointer"
                          :class="{'mb-1':type!=='menu'}" v-if="item.id"
                    >
                        <a @click="copy" class="share-network-copy bkt-bg-primary">
                            <span class="share-icon h-100">
                                 <bkt-icon name="Clone" width="18px" height="18px" color="white"/>
                            </span>
                            <div class="bkt-dropdown__menu-text" style="line-height: 13px; text-align: center;">
                                Скопировать ссылку
                            </div>
                        </a>
                    </div>
                    <div class="bkt-dropdown__menu-item bkt-wrapper-between bkt-cursor-pointer"
                         :class="{'mb-1':type!=='menu'}" v-for="network in networks" v-if="item.id"
                    >
                        <ShareNetwork
                            :network="network.network"
                            :key="network.network"
                            :style="{backgroundColor: network.color}"
                            :url="'https://www.lotofond.ru/lot/'+item.id"
                            :title="sharing.title"
                            :description="short_description"
                            :hashtags="sharing.hashtags"
                        >
<!--                            <div class="bkt-dropdown__menu-icon">-->
                            <span class="share-icon h-100">
                                  <bkt-icon :name="network.name" width="18px" height="18px"
                                            color="white"></bkt-icon>
                            </span>
<!--                    </div>-->
                            <div class="bkt-dropdown__menu-text">
                                {{ network.label ?? network.name }}
                            </div>
                        </ShareNetwork>
                    </div>
                </template>
            </div>
        </div>
        <div class="bkt-dropdown" v-if="type!=='menu'">
            <button :class="['bkt-hover-primary bkt-button'+button_type, main_bg]"
                    v-tooltip="'Другое'" data-bs-toggle="dropdown" data-bs-auto-close="outside" :id="'moreDropdown'+item.id"
            >
                <bkt-icon class="bkt-button__icon mx-auto" name="More" :color="icon_color"></bkt-icon>
            </button>
            <div class="dropdown-menu dropdown-menu-end bkt-dropdown__menu_menu bkt-dropdown__menu bkt-dropdown__menu_body">
                <card-actions :item="item" type="menu" @changeStatus="emitChange" icon_color="main" :place="place"
                ></card-actions>
                <hr class="dropdown-divider">
                <div class="bkt-dropdown__menu-item" @click="changeStatus({icon:'Hide', type:'hide', status:'isHide'})">
                    <div class="bkt-dropdown__menu-icon">
                        <span v-show="in_process.indexOf('Hide')>=0"
                              class="spinner-border spinner-border-sm mx-auto"
                              role="status"></span>
                        <bkt-icon v-if="in_process.indexOf('Hide')<0" class="bkt-button__icon mx-auto" :height="'14px'" :width="'14px'"
                                  :name="item.isHide ? 'Unhide' : 'Hide'" :color="item.isHide ? icon_color : 'red'"></bkt-icon>
                    </div>
                    <div class="bkt-dropdown__menu-text">
                        {{item['isHide'] ? 'Восстановить' : 'Скрыть'}}
                    </div>
                </div>
                <div class="bkt-dropdown__menu-item"
                     @click="changeStatus({icon:'HideAll', type: item['isHide'] ? 'delete': 'make', status:'isHide'})"
                     v-if="item && item.trade && item.trade.lotCount>1"
                >
                    <div class="bkt-dropdown__menu-icon">
                        <span v-show="in_process.indexOf('HideAll')>=0"
                              class="spinner-border spinner-border-sm mx-auto"
                              role="status"></span>
                        <bkt-icon v-if="in_process.indexOf('HideAll')<0" class="bkt-button__icon mx-auto" :height="'14px'" :width="'14px'"
                                  :name="item.isHide ? 'Unhide' : 'Hide'" :color="item.isHide ? icon_color : 'red'"></bkt-icon>
                    </div>
                    <div class="bkt-dropdown__menu-text">
                        {{item['isHide'] ? 'Восстановить все лоты торга' : 'Скрыть все лоты торга'}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CardActions",
        props: {
            item: {
                type: Object
            },
            main_bg: {
                type: String,
                default: 'bkt-bg-main-light'
            },
            icon_color: {
                type: String,
                default: 'white'
            },
            type: {
                type: String,
                default: 'nav'
            },
            button_type: {
                type: String,
                default: ''
            },
            place: {
                type: String,
                default: 'card'
            },
            loading: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                // button_type: '',
                in_process: [],
                actions: [
                    {
                        icon: 'Pin',
                        status_icon: 'Unpin',
                        label: "Закрепить",
                        status_label: "Открепить",
                        color: 'primary',
                        code: '',
                        status: 'isPinned',
                        method: this.changeStatus,
                        method_params: {type: 'pin', icon: 'Pin', status: 'isPinned'},
                        place: 'all',
                        class: ''
                    },
                    {
                        icon: 'Viewed',
                        status_icon: 'Unviewed',
                        label: "Отметить просмотренным",
                        status_label: "Отметить непросмотренным",
                        color: 'primary',
                        code: '',
                        status: 'isWatched',
                        method: this.changeStatus,
                        method_params: {type: 'seen', icon: 'Viewed', status: 'isWatched'},
                        place: 'dropdown',
                        class: ''
                    },
                    // {
                    //     icon: 'Bookmark',
                    //     label: "Добавить метку",
                    //     color: 'orange',
                    //     code: '',
                    //     status: 'no_status',
                    //     method: this.addMark,
                    //     method_params: {icon: 'Bookmark'},
                    //     place: 'lot-card',
                    //     class: ''
                    // },
                    {
                        icon: 'Edit',
                        label: "Добавить заметку",
                        color: 'blue',
                        code: '',
                        status: 'note',
                        method: this.addNote,
                        method_params: {icon: 'Edit'},
                        place: 'dropdown',
                        class: ''
                    },
                    // {
                    //     icon: 'Target',
                    //     label: "В мониторинге",
                    //     color: 'red',
                    //     code: '',
                    //     status: 'inMonitoring',
                    //     method: this.navigate,
                    //     method_params: {icon: 'Target', path: '/monitoring'},
                    //     place: 'all',
                    //     class: '',
                    //     condition: true
                    // },
                    {
                        icon: 'Star',
                        status_icon: 'Unstar',
                        label: "Добавить в Избранное",
                        status_label: "Убрать из Избранного",
                        color: 'yellow',
                        code: '',
                        status: 'inFavourite',
                        method: this.addToFavourites,
                        method_params: {icon: 'Star'},
                        place: 'all',
                        dropdown_id: 'inFavourite',
                        class: ''
                    },
                    // {
                    //     icon: 'Bell',
                    //     label: "Уведомления",
                    //     color: 'green',
                    //     code: '',
                    //     status: 'hasNotSeenNotification',
                    //     method: this.navigate,
                    //     method_params: {icon: 'Bell', path: '/messages'},
                    //     place: 'all',
                    //     class: '',
                    //     condition: true
                    // },
                    {
                        icon: 'Share',
                        label: "Поделиться",
                        color: 'orange',
                        code: '',
                        status: '',
                        method: '',
                        method_params: {icon: 'Share'},
                        place: this.place==='lot-card' ? 'all':'permanent',
                        dropdown_id: 'shareDropdown',
                        class: '',
                    },
                    // {
                    //     icon: 'More',
                    //     label: "Поделиться",
                    //     color: 'body',
                    //     code: '',
                    //     status: '',
                    //     method: '',
                    //     method_params: {icon: 'More'},
                    //     place: 'all',
                    //     dropdown_id: 'moreDropdown',
                    //     class: '',
                    // },
                    // {
                    //     icon: 'Trash',
                    //     label: "Скрыть",
                    //     color: 'red',
                    //     code: '',
                    //     status: 'no_status',
                    //     method: this.changeStatus,
                    //     method_params: {type: 'hidden', icon: 'Trash'},
                    //     place: 'dropdown'
                    // },
                ],
                sharing: {
                    // url: 'https://news.vuejs.org/issues/180',
                    title: 'Лот №',
                    // description: '',
                    hashtags: 'lotofond,trade,lot',
                    // twitterUser: 'youyuxi',
                    media: 'https://www.lotofond.ru/images/card-image1.png'
                },
                networks: [
                    // {network: 'copy', name: 'Clipboard', label: 'Скопировать ссылку', color: '#2953ff'},
                    // { network: 'baidu', name: 'Baidu', icon: 'fas fah fa-lg fa-paw', color: '#2529d8' },
                    {network: 'email', name: 'Email', color: '#d82b1e'},
                    // { network: 'line', name: 'Line', icon: 'fab fah fa-lg fa-line', color: '#00c300' },
                    // { network: 'linkedin', name: 'LinkedIn', icon: 'fab fah fa-lg fa-linkedin', color: '#007bb5' },
                    // {network: 'odnoklassniki', name: 'Odnoklassniki', color: '#ed812b'},
                    // { network: 'skype', name: 'Skype', icon: 'fab fah fa-lg fa-skype', color: '#00aff0' },
                    // { network: 'sms', name: 'SMS', icon: 'far fah fa-lg fa-comment-dots', color: '#333333' },
                    // {network: 'twitter', name: 'Twitter', color: '#1da1f2'},
                    // {network: 'viber', name: 'Viber', color: '#59267c'},
                    {network: 'vk', name: 'Vk', label: 'Вконтакте', color: '#4a76a8'},
                    // { network: 'weibo', name: 'Weibo', icon: 'fab fah fa-lg fa-weibo', color: '#e9152d' },
                    {network: 'whatsapp', name: 'WhatsApp', color: '#25d366'},
                    {network: 'telegram', name: 'Telegram', color: '#0088cc'},
                    // { network: 'xing', name: 'Xing', icon: 'fab fah fa-lg fa-xing', color: '#026466' },
                ],
                short_description: '',
                details_description: '',
            }
        },
        computed: {
            current_path() {
                return this.$store.getters.current_path;
            },
            favourites_paths() {
                return this.$store.getters.favourites_paths;
            },
            favourite_color() {
                if ( this.item && this.item.favouritePaths && this.item.favouritePaths.length>0 ) {
                    if (this.item.favouritePaths[0].color) {
                        return this.item.favouritePaths[0].color;
                    }
                }
                return 'yellow'
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
            main_actions() {
                return this.actions.filter(item => {
                    if(this.type!=='menu') { return item.place === 'all' || item.place === 'permanent';}
                    return item.place !== 'permanent';
                });
            },
            auth_user() {
                return this.$store.getters.auth_user;
            }
        },
        methods: {
            makeAction(method, method_params, icon) {
                if(icon==='Share')
                {
                    this.sharing.title = 'Лот №'+this.item.lotNumber;
                    if(!this.item.lotNumber) {
                        this.sharing.title = 'Лот c Lotofond';
                    }
                    this.short_description = '';
                    this.details_description = '';
                    if(this.item && this.item.trade.applicationTime) {
                        this.details_description = 'Приём заявок';
                        if(this.item.trade.applicationTime.start) {
                            this.details_description += ' c '+this.$moment(this.item.trade.applicationTime.start).format('DD MMMM YYYY HH:mm');
                        }
                        if(this.item.trade.applicationTime.end) {
                            this.details_description += ' до '+this.$moment(this.item.trade.applicationTime.end).format('DD MMMM YYYY HH:mm');
                        }
                    }
                    this.details_description += '\nНачальная цена: '+this.$options.filters.priceFormat(this.item.startPrice) + ' ₽' +
                        '\nТекущая цена: '+this.$options.filters.priceFormat(this.item.currentPrice) + ' ₽';
                    if(this.item && (this.item.minPrice && this.item.minPrice>=0) && this.item.trade && this.item.trade.type &&
                        (this.item.trade.type!=='CloseAuction' && this.item.trade.type!=='OpenAuction')) {
                        this.details_description += '\nМинимальная цена: ' + this.$options.filters.priceFormat(this.item.minPrice) + ' ₽' ;
                    }
                    if (this.item && this.item.description && this.item.description.length > 0) {
                        this.short_description = this.item.description.slice(0, 250) + '... \n';
                    }
                    this.short_description += this.details_description;
                }

                if (method) {
                    if (this.isLoggedIn) {
                        if(this.in_process.indexOf(icon)<0)
                        {
                            method(method_params);
                        }
                        return;

                    } else {
                        this.$store.dispatch('sendAuthNotification')
                    }
                }
            },
            changeStatus(payload) {
                if (this.isLoggedIn) {
                    let url = 'changeTradeLotStatus';
                    this.toggleProcess(payload.icon);
                    if(payload.icon === 'HideAll') {
                        url = 'changeRelatedLotsStatus';
                    }
                    this.$store.dispatch(url, {lotId: this.item.id, type: payload.type})
                        .then(resp => {
                            this.$store.commit('saveTradeProperty', {
                                id: this.item.id,
                                key: payload.status,
                                value: !this.item[payload.status]
                            });
                            this.$store.commit('updateMonitoringItem', {
                                id: this.item.id,
                                key: payload.status,
                                value: !this.item[payload.status]
                            });
                            this.$store.commit('updateFavouriteItem', {
                                id: this.item.id,
                                key: payload.status,
                                value: !this.item[payload.status]
                            });
                            this.$emit('changeStatus', {
                                key: payload.status,
                                value: !this.item[payload.status],
                                lotId: this.item.id,
                            })
                        })
                        .finally(() => {
                            this.toggleProcess(payload.icon)
                        })
                } else {
                    this.$store.dispatch('sendAuthNotification', {self: this})
                }
            },
            addToFavourites(payload) {
                if (!this.item.inFavourite) {
                    if(!this.auth_user.email && this.auth_user.phone)
                    {
                        let parent = this.$parent;
                        if(this.place !=='lot-card') {
                            parent = this.$parent.$parent.$parent
                        }
                        if(parent.$refs) {
                            parent.$refs.editContact.setType('email');
                            this.$store.commit('openModal', '#editContactModal');
                        }
                        else {
                            this.$store.dispatch('sendNotification',
                                {message: 'Произошла ошибка. Попробуйте позже.', type: 'error'})
                        }
                    }
                    else {
                        this.toggleProcess(payload.icon);
                        this.$store.dispatch('addFavourite', {lots: [this.item.id]})
                            .then(resp => {
                                this.$store.commit('saveTradeProperty', {
                                    id: this.item.id,
                                    key: 'inFavourite',
                                    value: !this.item.inFavourite
                                });
                                this.$store.commit('saveTradeProperty', {
                                    id: this.item.id,
                                    key: 'favouritePaths',
                                    value: [this.favourites_paths[0]]
                                });
                                this.$store.commit('updateMonitoringItem', {
                                    id: this.item.id,
                                    key: 'inFavourite',
                                    value: !this.item.inFavourite
                                });
                                this.$store.commit('updateFavouriteItem', {
                                    id: this.item.id,
                                    key: 'inFavourite',
                                    value: !this.item.inFavourite
                                });
                                this.$store.commit('updateMonitoringItem', {
                                    id: this.item.id,
                                    key: 'favouritePaths',
                                    value: [this.favourites_paths[0]]
                                });
                                this.$store.commit('updateFavouriteItem', {
                                    id: this.item.id,
                                    key: 'favouritePaths',
                                    value: [this.favourites_paths[0]]
                                });
                                this.$store.dispatch('saveDataProperty', {
                                    module_key: 'lots', state_key: 'selected_lot',
                                    key: 'favouritePaths',
                                    value: [this.favourites_paths[0]]
                                }, {root: true});

                                this.$emit('changeStatus', {key: 'inFavourite', value: !this.item.inFavourite, icon:payload.icon});
                            })
                            .finally(() => {
                                this.toggleProcess(payload.icon)
                            })
                    }
                }
            },
            removeFromFavourites() {
                if (this.item.inFavourite) {
                    this.toggleProcess('Star');
                    this.$store.dispatch('removeFavourite', {
                        lotId: this.item.id,
                        pathId: this.item.favouritePaths[0].pathId
                    })
                        .then(resp => {
                            this.$store.commit('saveTradeProperty', {
                                id: this.item.id,
                                key: 'inFavourite',
                                value: !this.item.inFavourite
                            });
                            this.$store.commit('updateMonitoringItem', {
                                id: this.item.id,
                                key: 'inFavourite',
                                value: !this.item.inFavourite
                            });
                            this.$store.commit('updateFavouriteItem', {
                                id: this.item.id,
                                key: 'inFavourite',
                                value: !this.item.inFavourite
                            });
                            this.$store.commit('saveTradeProperty', {
                                id: this.item.id,
                                key: 'favouritePaths',
                                value: []
                            });
                            this.$store.commit('updateMonitoringItem', {
                                id: this.item.id,
                                key: 'favouritePaths',
                                value: []
                            });
                            this.$store.commit('updateFavouriteItem', {
                                id: this.item.id,
                                key: 'favouritePaths',
                                value: []
                            });
                            this.$store.dispatch('saveDataProperty', {
                                module_key: 'lots', state_key: 'selected_lot',
                                key: 'favouritePaths',
                                value: []
                            }, {root: true});
                            this.$emit('changeStatus', {key: 'inFavourite', value: !this.item.inFavourite})
                        })
                        .finally(() => {
                            this.toggleProcess('Star')
                        })
                }
            },
            moveFavourite() {
                this.$store.commit('setSelectedLot', this.item);
                this.$store.commit('openModal', '#moveFavouriteModal')
            },
            addNote() {
                this.$store.commit('setSelectedLot', this.item);
                this.$store.commit('openModal', '#noteModal')
            },
            addMark() {
                this.$store.commit('setSelectedLot', this.item);
                this.$store.commit('openModal', '#addMarkModal')
            },
            navigate(payload) {
                this.$router.push(payload.path)
            },
            addProcess(icon) {
                if (this.in_process.findIndex(item => item == icon) < 0) {
                    this.in_process.push(icon);
                }
            },
            removeProcess(icon) {
                let index = this.in_process.findIndex(item => item == icon);
                if (index >= 0) {
                    this.in_process.splice(index, 1);
                }
            },
            toggleProcess(icon) {
                let index = this.in_process.indexOf(icon);
                if (index >= 0) {
                    this.in_process.splice(index, 1);
                } else {
                    this.in_process.push(icon);
                }
            },
            emitChange(payload) {
                this.$emit('changeStatus', payload)
            },
            copy() {
                let url = 'https://www.lotofond.ru/lot/'+ this.item.id;

                let append_content = '<textarea class="textarea_copy"></textarea>';
                document.querySelector('body').insertAdjacentHTML('beforeend', append_content);

                let textarea_copy = document.querySelector('.textarea_copy');

                textarea_copy.value = url;
                textarea_copy.select();
                document.execCommand('copy');
                textarea_copy.remove();

                this.$store.dispatch('sendNotification',
                    {message: 'Текст скопирован.'});
            },
        }
    }
</script>

<style scoped>
    a[class^="share-network-"] {
        flex: none;
        color: #FFFFFF;
        background-color: #333;
        border-radius: 5px;
        overflow: hidden;
        display: flex;
        flex-direction: row;
        align-content: center;
        align-items: center;
        cursor: pointer;
        text-decoration: none;
        width: 100%;
    }

    a[class^="share-network-"] .share-icon {
        background-color: rgba(0, 0, 0, 0.2);
        padding: 10px;
        flex: 0 1 auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    a[class^="share-network-"] .bkt-dropdown__menu-text {
        padding: 5px 10px;
        flex: 1 1;
        font-weight: 600;
        font-family: "Gilroy", sans-serif;
        color: #FFFFFF;
    }
</style>
