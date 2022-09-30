<template>
    <div>
        <div class="bkt-dropdown dropdown" v-for="action in actions"
             v-if="!action.condition || (action.condition && item[action.status]==true)"
        >
            <button
                :class="['bkt-button'+button_type, item[action.status] ? 'bkt-bg-'+action.color : main_bg,
                 action.color ? 'bkt-hover-'+action.color : 'bkt-hover-'+main_bg, action.class]"
                @click="makeAction(action.method, action.method_params)"
                :id="action.dropdown_id ? action.dropdown_id : 'button-dropdown-'+action.icon"
                :data-bs-toggle="action.dropdown_id && ((action.status && item[action.status]) || !action.status) ? 'dropdown' : ''"
                :disabled="in_process.indexOf(action.icon)>=0"
            >
                <span v-if="in_process.indexOf(action.icon)>=0"
                      class="spinner-border spinner-border-sm flex-shrink-0" role="status">
                </span>
                <!--                <template v-if="action.status_icon">-->
                <!--                    <bkt-icon v-show="in_process.indexOf(action.icon)<0 && item[action.status]"-->
                <!--                              class="bkt-button__icon" :name="action.status_icon"-->
                <!--                              :color="type==='menu' && !item[action.status] ? action.color : 'white'">-->
                <!--                    </bkt-icon>-->
                <!--                    <bkt-icon v-show="in_process.indexOf(action.icon)<0 && !item[action.status]"-->
                <!--                              class="bkt-button__icon" :name="action.icon"-->
                <!--                              :color="type==='menu' && !item[action.status] ? action.color : 'white'">-->
                <!--                        -->
                <!--                    </bkt-icon>-->
                <!--                </template>-->
                <!--                <template v-else>-->
                <!--                    <bkt-icon v-show="in_process.indexOf(action.icon)<0"-->
                <!--                              class="bkt-button__icon" :name="action.icon"-->
                <!--                              :color="type==='menu' && !item[action.status] ? action.color : 'white'">-->
                <!--                    </bkt-icon>-->
                <!--                </template>-->
                <bkt-icon v-if="in_process.indexOf(action.icon)<0 "
                          class="bkt-button__icon"
                          :name="item[action.status] && action.status_icon ? action.status_icon : action.icon"
                          :color="type==='menu' && !item[action.status] ? action.color : (item[action.status] ? 'white' : icon_color)">
                </bkt-icon>
                <!--                    <bkt-icon v-show="in_process.indexOf(action.icon)<0 && !action.status_icon"-->
                <!--                              class="bkt-button__icon" :name="action.icon"-->
                <!--                              :color="type==='menu' && !item[action.status] ? action.color : 'white'">-->
                <!--                    </bkt-icon>-->

                <span v-if="type==='menu'">
                    {{item[action.status] && action.status_icon ? action.status_label : action.label}}
                </span>
            </button>
            <div v-show="action.dropdown_id && ((action.status && item[action.status]) || !action.status)"
                 class="dropdown-menu dropdown-menu-end dropdown-menu-right bkt-dropdown__menu bkt-dropdown__menu_pointed bkt-dropdown__menu_neutral"
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
                    <skeleton :count="networks.length" v-if="!item.id" height="38px" skeleton_class="mb-1"></skeleton>
                    <div class="bkt-dropdown__menu-item bkt-wrapper-between bkt-cursor-pointer mb-1"
                         v-for="network in networks" v-else
                    >
                        <ShareNetwork
                            :network="network.network"
                            :key="network.network"
                            :style="{backgroundColor: network.color}"
                            :url="'https://lotofond.ru/lot/'+item.id"
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
                            {{ network.name }}
                        </div>
                        </ShareNetwork>
                    </div>
                </template>
            </div>
        </div>
        <div class="dropdown">
            <button :class="['bkt-hover-red bkt-button'+button_type, item.isHide ? 'bkt-bg-red' : '']"
                    @click="changeStatus({icon:'Hide', type:'hide',  status:'isHide'})">
                <span v-show="in_process.indexOf('Hide')>=0"
                      class="spinner-border spinner-border-sm mx-auto"
                      role="status"></span>
                <bkt-icon v-if="in_process.indexOf('Hide')<0" class="bkt-button__icon mx-auto"
                          :name="item.isHide ? 'Unhide' : 'Hide'" :color="item.isHide ? icon_color : 'red'"></bkt-icon>
            </button>
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
        },
        created() {
            this.actions = this.actions.filter(item => item.place === 'all' || item.place === this.place);
        },
        data() {
            return {
                loading: false,
                // button_type: '',
                in_process: [],
                actions: [
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
                        place: 'all',
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
                        place: 'all',
                        class: ''
                    },
                    {
                        icon: 'Target',
                        label: "В мониторинге",
                        color: 'red',
                        code: '',
                        status: 'inMonitoring',
                        method: this.navigate,
                        method_params: {icon: 'Target', path: '/monitoring'},
                        place: 'all',
                        class: '',
                        condition: true
                    },
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
                    {
                        icon: 'Bell',
                        label: "Уведомления",
                        color: 'green',
                        code: '',
                        status: 'hasNotSeenNotification',
                        method: this.navigate,
                        method_params: {icon: 'Bell', path: '/messages'},
                        place: 'all',
                        class: '',
                        condition: true
                    },
                    {
                        icon: 'Pin',
                        status_icon: 'Unpin',
                        label: "Закрепить",
                        status_label: "Открепить",
                        color: 'pink',
                        code: '',
                        status: 'isPinned',
                        method: this.changeStatus,
                        method_params: {type: 'pin', icon: 'Pin', status: 'isPinned'},
                        place: 'all',
                        class: ''
                    },
                    {
                        icon: 'Share',
                        label: "Поделиться",
                        color: 'orange',
                        code: '',
                        status: '',
                        method: '',
                        method_params: {icon: 'Share'},
                        place: 'lot-card',
                        dropdown_id: 'shareDropdown',
                        class: '',
                    },
                    // {
                    //     icon: 'Trash',
                    //     label: "Скрыть",
                    //     color: 'red',
                    //     code: '',
                    //     status: 'no_status',
                    //     method: this.changeStatus,
                    //     method_params: {type: 'hidden', icon: 'Trash'},
                    //     place: 'all'
                    // },
                ],
                sharing: {
                    // url: 'https://news.vuejs.org/issues/180',
                    title: 'Успей купить на Лотофонд',
                    // description: '',
                    hashtags: 'lotofond,trade,lot',
                    // twitterUser: 'youyuxi',
                    media: 'https://lotofond.ru/images/card-image1.png'
                },
                networks: [
                    // { network: 'baidu', name: 'Baidu', icon: 'fas fah fa-lg fa-paw', color: '#2529d8' },
                    {network: 'email', name: 'Email', color: '#2953ff'},
                    // { network: 'line', name: 'Line', icon: 'fab fah fa-lg fa-line', color: '#00c300' },
                    // { network: 'linkedin', name: 'LinkedIn', icon: 'fab fah fa-lg fa-linkedin', color: '#007bb5' },
                    {network: 'odnoklassniki', name: 'Odnoklassniki', color: '#ed812b'},
                    // { network: 'skype', name: 'Skype', icon: 'fab fah fa-lg fa-skype', color: '#00aff0' },
                    // { network: 'sms', name: 'SMS', icon: 'far fah fa-lg fa-comment-dots', color: '#333333' },
                    {network: 'telegram', name: 'Telegram', color: '#0088cc'},
                    {network: 'twitter', name: 'Twitter', color: '#1da1f2'},
                    {network: 'viber', name: 'Viber', color: '#59267c'},
                    {network: 'vk', name: 'Vk', color: '#4a76a8'},
                    // { network: 'weibo', name: 'Weibo', icon: 'fab fah fa-lg fa-weibo', color: '#e9152d' },
                    {network: 'whatsapp', name: 'WhatsApp', color: '#25d366'},
                    // { network: 'xing', name: 'Xing', icon: 'fab fah fa-lg fa-xing', color: '#026466' },
                ],
                short_description: '',
            }
        },
        computed: {
            current_path() {
                return this.$store.getters.current_path;
            },
            favourites_paths() {
                return this.$store.getters.favourites_paths;
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
        watch: {
            item: function (newVal, oldVal) { // watch it
                this.short_description = '';
                if (this.item.description.length > 0) {
                    this.short_description = this.item.description.slice(0, 100) + '...';
                }
                // console.log('Prop changed: ', newVal, ' | was: ', oldVal)
            }
            // item: {
            //     // handler(newVal) {
            //     //     this.checked = newVal
            //     // },
            //     deep: true
            // }
        },
        methods: {
            makeAction(method, method_params) {
                if (method) {
                    if (this.isLoggedIn) {
                        method(method_params);
                        return;

                    } else {
                        this.$store.dispatch('sendAuthNotification', {self: this})
                    }
                }
            },
            changeStatus(payload) {
                if (this.isLoggedIn) {
                    this.toggleProcess(payload.icon);
                    this.$store.dispatch('changeTradeLotStatus', {lotId: this.item.id, type: payload.type})
                        .then(resp => {
                            this.$store.commit('saveTradeProperty', {
                                id: this.item.id,
                                key: payload.status,
                                value: !this.item[payload.status]
                            })
                            this.$emit('changeStatus', {
                                key: payload.status,
                                value: !this.item[payload.status],
                                lotId: this.item.id
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
                    this.toggleProcess(payload.icon);
                    this.$store.dispatch('addFavourite', {lots: [this.item.id]})
                        .then(resp => {
                            this.$store.commit('saveTradeProperty', {
                                id: this.item.id,
                                key: 'inFavourite',
                                value: !this.item.inFavourite
                            })
                            this.$store.commit('saveTradeProperty', {
                                id: this.item.id,
                                key: 'favouritePaths',
                                value: [this.favourites_paths[0]]
                            })
                            this.$store.dispatch('saveDataProperty', {
                                module_key: 'lots', state_key: 'selected_lot',
                                key: 'favouritePaths',
                                value: [this.favourites_paths[0]]
                            }, {root: true});
                            this.$emit('changeStatus', {key: 'inFavourite', value: !this.item.inFavourite})
                        })
                        .finally(() => {
                            this.toggleProcess(payload.icon)
                        })
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
            getIconColor(action) {

            }
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
