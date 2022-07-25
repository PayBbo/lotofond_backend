<template>
    <div>
        <div class="bkt-dropdown dropdown" v-for="action in actions">
            <button
                :class="['bkt-button'+button_type, item[action.status] ? 'bkt-bg-'+action.color : main_bg,
                 action.color ? 'bkt-hover-'+action.color : 'bkt-hover-'+main_bg]"
                @click="makeAction(action.method, action.method_params)"
                :id="action.dropdown_id ? action.dropdown_id : 'button-dropdown-'+action.icon"
                :data-bs-toggle="action.dropdown_id && item[action.status] ? 'dropdown' : ''"
                :disabled="in_process.indexOf(action.icon)>=0"
            >
                <span v-show="in_process.indexOf(action.icon)>=0" class="spinner-border spinner-border-sm"
                      role="status"></span>
                <bkt-icon v-show="in_process.indexOf(action.icon)<0" class="bkt-button__icon" :name="action.icon"
                          :color="type=='menu' && !item[action.status] ? action.color : 'white'"></bkt-icon>
                <span v-if="type=='menu'">{{action.label}}</span>
            </button>
            <div v-if="action.dropdown_id && item[action.status]"
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
                    @click="changeStatus({icon:'Trash', type:'hidden',  status:'isHide'})">
                <span v-show="in_process.indexOf('Trash')>=0"
                      class="spinner-border spinner-border-sm"
                      role="status"></span>
                <bkt-icon v-show="in_process.indexOf('Trash')<0" class="bkt-button__icon mx-auto" :name="'Trash'"
                          :color="item.isHide ? 'white' : 'red'"></bkt-icon>
            </button>
        </div>


        <!--        <button :class="['bkt-button'+button_type, main_bg, 'bkt-hover-'+getHover('Eye')]" @click="makeAction('seen')">-->
        <!--            <bkt-icon class="bkt-button__icon" :name="'Eye'" :color="getColor('Eye')"></bkt-icon>-->
        <!--            <span v-if="type=='menu'">Инфо о должнике</span>-->
        <!--        </button>-->
        <!--        <button :class="['bkt-button'+button_type, main_bg, 'bkt-hover-'+getHover('Pencil')]">-->
        <!--            <bkt-icon class="bkt-button__icon" :name="'Pencil'" :color="getColor('Pencil')"></bkt-icon>-->
        <!--            <span v-if="type=='menu'">Добавить заметку</span>-->
        <!--        </button>-->
        <!--        <button :class="['bkt-button'+button_type, item.inMonitoring ? 'bkt-bg-red' : main_bg, 'bkt-hover-'+getHover('Target')]">-->
        <!--            <bkt-icon class="bkt-button__icon" :name="'Target'" :color="getColor('Target')"></bkt-icon>-->
        <!--            <span v-if="type=='menu'">Следить за лотом</span>-->
        <!--        </button>-->
        <!--        <button :class="['bkt-button'+button_type, item.inFavourite ? 'bkt-bg-yellow' : main_bg, 'bkt-hover-'+getHover('Star')]">-->
        <!--            <bkt-icon class="bkt-button__icon" :name="'Star'" :color="getColor('Star')"></bkt-icon>-->
        <!--            <span v-if="type=='menu'">В избранное</span>-->
        <!--        </button>-->
        <!--        <button :class="['bkt-button'+button_type, main_bg, 'bkt-hover-'+getHover('Bell')]">-->
        <!--            <span class="info"></span>-->
        <!--            <bkt-icon class="bkt-button__icon" :name="'Bell'" :color="getColor('Bell')"></bkt-icon>-->
        <!--            <span v-if="type=='menu'">Уведомления</span>-->
        <!--        </button>-->
        <!--        <button :class="['bkt-button'+button_type, item.isPinned ? 'bkt-bg-pink' : main_bg, 'bkt-hover-'+getHover('Clip')]"-->
        <!--                @click="makeAction('fixed')"-->
        <!--        >-->
        <!--            <bkt-icon class="bkt-button__icon" :name="'Clip'" :color="getColor('Clip')"></bkt-icon>-->
        <!--            <span v-if="type=='menu'">Закрепить</span>-->
        <!--        </button>-->
        <!--        <button :class="'bkt-button'+button_type" @click="makeAction('hidden')">-->
        <!--            <bkt-icon class="bkt-button__icon mx-auto" :name="'Trash'"></bkt-icon>-->
        <!--        </button>-->
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
                        icon: 'Eye',
                        label: "В просмотренное",
                        color: 'primary',
                        code: '',
                        status: 'isWatched',
                        method: this.changeStatus,
                        method_params: {type: 'seen', icon: 'Eye', status: 'isWatched'},
                        place: 'all'
                    },
                    {
                        icon: 'Bookmark',
                        label: "Добавить метку",
                        color: 'blue',
                        code: '',
                        status: 'no_status',
                        method: '',
                        method_params: {icon: 'Bookmark'},
                        place: 'lot-card'
                    },
                    {
                        icon: 'Pencil',
                        label: "Добавить заметку",
                        color: 'blue',
                        code: '',
                        status: 'no_status',
                        method: '',
                        method_params: {icon: 'Pencil'},
                        place: 'card'
                    },
                    {
                        icon: 'Target',
                        label: "Следить за лотом",
                        color: 'red',
                        code: '',
                        status: 'inMonitoring',
                        method: '',
                        method_params: {icon: 'Target'},
                        place: 'all'
                    },
                    {
                        icon: 'Star',
                        label: "В избранное",
                        color: 'yellow',
                        code: '',
                        status: 'inFavourite',
                        method: this.addToFavourites,
                        method_params: {icon: 'Star'},
                        place: 'all',
                        dropdown_id: 'inFavourite'
                    },
                    {
                        icon: 'Bell',
                        label: "Уведомления",
                        color: 'green',
                        code: '',
                        status: 'no_status',
                        method: '',
                        method_params: {icon: 'Bell'},
                        place: 'all'
                    },
                    {
                        icon: 'Clip',
                        label: "Закрепить",
                        color: 'pink',
                        code: '',
                        status: 'isPinned',
                        method: this.changeStatus,
                        method_params: {type: 'fixed', icon: 'Clip', status: 'isPinned'},
                        place: 'all'
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
                if(this.isLoggedIn)
                {
                    if (method) {
                        method(method_params);
                        return;
                    }
                }
                else {
                    this.$store.dispatch('sendAuthNotification', {self: this})
                }
            },
            changeStatus(payload) {
                this.toggleProcess(payload.icon)
                this.$store.dispatch('changeTradeLotStatus', {lot_id: this.item.id, type: payload.type})
                    .then(resp => {
                        this.$store.commit('saveTradeProperty', {
                            id: this.item.id,
                            key: payload.status,
                            value: !this.item[payload.status]
                        })
                        this.$emit('changeStatus', {key: payload.status, value: !this.item[payload.status]})
                    })
                    .finally(() => {
                        this.toggleProcess(payload.icon)
                    })
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
            addToMonitoring() {

            },
            getColor(icon) {
                if (this.type == 'menu') {
                    let index = this.actions.findIndex(item => item.icon == icon);
                    if (index >= 0) {
                        return this.actions[index].color
                    }
                }
                return 'white'
            },
            getHover(icon) {
                let index = this.actions.findIndex(item => item.icon == icon);
                if (index >= 0) {
                    return this.actions[index].color
                }
                return 'main-dark'
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
