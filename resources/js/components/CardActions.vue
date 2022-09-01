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
                :data-bs-toggle="action.dropdown_id && item[action.status] ? 'dropdown' : ''"
                :disabled="in_process.indexOf(action.icon)>=0"
            >
                <span v-if="in_process.indexOf(action.icon)>=0" style="margin-right: 12px;"
                      class="spinner-border spinner-border-sm" role="status">
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
                              class="bkt-button__icon" :name="item[action.status] && action.status_icon ? action.status_icon : action.icon"
                              :color="type==='menu' && !item[action.status] ? action.color : 'white'">
                    </bkt-icon>
<!--                    <bkt-icon v-show="in_process.indexOf(action.icon)<0 && !action.status_icon"-->
<!--                              class="bkt-button__icon" :name="action.icon"-->
<!--                              :color="type==='menu' && !item[action.status] ? action.color : 'white'">-->
<!--                    </bkt-icon>-->

                <span v-if="type==='menu'">{{item[action.status] && action.status_icon ? action.status_label : action.label}}
                </span>
            </button>
            <div v-show="action.dropdown_id && item[action.status]"
                 class="dropdown-menu dropdown-menu-end dropdown-menu-right bkt-dropdown__menu bkt-dropdown__menu_pointed bkt-dropdown__menu_neutral"
                 aria-labelledby="dropdownMenuClickableOutside"
            >
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
            </div>
        </div>
        <div class="dropdown">
            <button :class="['bkt-hover-red bkt-button'+button_type, item.isHide ? 'bkt-bg-red' : '']"
                    @click="changeStatus({icon:'Hide', type:'hidden',  status:'isHide'})">
                <span v-show="in_process.indexOf('Hide')>=0"
                      class="spinner-border spinner-border-sm mx-auto"
                      role="status"></span>
                <bkt-icon v-if="in_process.indexOf('Hide')<0" class="bkt-button__icon mx-auto"
                          :name="item.isHide ? 'Unhide' : 'Hide'" :color="item.isHide ? 'white' : 'red'"></bkt-icon>
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
                    {
                        icon: 'Bookmark',
                        label: "Добавить метку",
                        color: 'orange',
                        code: '',
                        status: 'no_status',
                        method: this.addMark,
                        method_params: {icon: 'Bookmark'},
                        place: 'lot-card',
                        class: ''
                    },
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
                        method_params: {type: 'fixed', icon: 'Pin', status: 'isPinned'},
                        place: 'all',
                        class: ''
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
                if (this.isLoggedIn) {
                    if (method) {
                        method(method_params);
                        return;
                    }
                } else {
                    this.$store.dispatch('sendAuthNotification', {self: this})
                }
            },
            changeStatus(payload) {
                if (this.isLoggedIn) {
                    this.toggleProcess(payload.icon);
                    this.$store.dispatch('changeTradeLotStatus', {lot_id: this.item.id, type: payload.type})
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
            }
        }
    }
</script>

<style scoped>
</style>
