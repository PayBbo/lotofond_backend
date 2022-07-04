<template>
    <div>
        <button v-for="action in actions"
                :class="['bkt-button'+button_type, item[action.status] ? 'bkt-bg-'+action.color : main_bg,
                 action.color ? 'bkt-hover-'+action.color : 'bkt-hover-'+main_bg]"
                @click="makeAction(action.method, action.method_params)"
        >
             <span v-if="in_process.indexOf(el => el == action.icon)>=0"
                   class="spinner-border spinner-border-sm"
                   role="status"></span>
            <bkt-icon v-else class="bkt-button__icon" :name="action.icon"
                      :color="type=='menu' ? action.color : 'white'"></bkt-icon>
            <span v-if="type=='menu'">{{action.label}}</span>
        </button>
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
        <!--        <button :class="['bkt-button'+button_type, item.inFavourites ? 'bkt-bg-yellow' : main_bg, 'bkt-hover-'+getHover('Star')]">-->
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
            }
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
                        method_params: {type: 'seen', icon: 'Eye'},
                    },
                    {
                        icon: 'Pencil',
                        label: "Добавить заметку",
                        color: 'blue',
                        code: '',
                        status: 'no_status',
                        method: '',
                        method_params: {icon: 'Pencil'}
                    },
                    {
                        icon: 'Target',
                        label: "Следить за лотом",
                        color: 'red',
                        code: '',
                        status: 'inMonitoring',
                        method: this.addToMonitoring,
                        method_params: {icon: 'Target'}
                    },
                    {
                        icon: 'Star',
                        label: "В избранное",
                        color: 'yellow',
                        code: '',
                        status: 'inFavourites',
                        method: this.addToFavorites,
                        method_params: {icon: 'Star'}
                    },
                    {
                        icon: 'Bell',
                        label: "Уведомления",
                        color: 'green',
                        code: '',
                        status: 'no_status',
                        method: '',
                        method_params: {icon: 'Bell'}
                    },
                    {
                        icon: 'Clip',
                        label: "Закрепить",
                        color: 'pink',
                        code: '',
                        status: 'isPinned',
                        method: this.changeStatus,
                        method_params: {type: 'fixed', icon: 'Clip'},
                    },
                    {
                        icon: 'Trash',
                        label: "Скрыть",
                        color: 'red',
                        code: '',
                        status: 'no_status',
                        method: this.changeStatus,
                        method_params: {type: 'hidden', icon: 'Trash'},
                    },
                ],
            }
        },
        mounted() {
        },
        watch: {
            item: {
                // handler(newVal) {
                //     this.checked = newVal
                // },
                deep: true
            }
        },
        methods: {
            makeAction(method, method_params) {
                if (method) {
                    method(method_params);
                    return;
                }
            },
            changeStatus(payload) {
                this.toggleProcess(payload.icon)
                this.$store.dispatch('changeTradeLotStatus', {lot_id: this.item.id, type: payload.type})
                    .finally(() => {
                        this.toggleProcess(payload.icon)
                    })
            },
            addToFavorites() {
                // this.toggleProcess(payload.icon)
                // this.$store.dispatch('addToFavorites', {lot_id: this.item.id, type: payload.type})
                //     .finally(() => {
                //         this.toggleProcess(payload.icon)
                //     })
            },
            addToMonitoring() {

            },
            getColor(icon) {
                if (this.type == 'menu') {
                    let index = this.actions.indexOf(item => item.icon == icon);
                    if (index >= 0) {
                        return this.actions[index].color
                    }
                }
                return 'white'
            },
            getHover(icon) {
                let index = this.actions.indexOf(item => item.icon == icon);
                if (index >= 0) {
                    return this.actions[index].color
                }
                return 'main-dark'
            },
            addProcess(icon) {
                if (this.in_process.indexOf(item => item == icon) < 0) {
                    this.in_process.push(icon);
                }
            },
            removeProcess(icon) {
                let index = this.in_process.indexOf(item => item == icon);
                if (index >= 0) {
                    this.in_process.splice(index, 1);
                }
            },
            toggleProcess(icon) {
                let index = this.in_process.indexOf(item => item == icon);
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
