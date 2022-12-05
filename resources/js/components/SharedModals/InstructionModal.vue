<template>
    <bkt-modal :id="'instructionModal'" title="Покупка инструкции" modal_class="bkt-filters-modal bkt-purchase"
               left_button_class="d-none" @right_action="buyInstruction" :loading="loading"
               right_button="Купить - 3 000 ₽"
    >
        <template #body>
            <div class="bkt-form bkt-wrapper-column bkt-promo__form p-0 w-100">
                <div v-if="selected_lot" class="bkt-promo__lot-wrapper">
                    <div class="bkt-wrapper bkt-gap bkt-nowrap bkt-cursor-pointer" @click="navigate('/lot/'+selected_lot.id)">
                        <card-image-category :no_multiple="true"
                                             v-if="(!selected_lot.photos || selected_lot.photos.length==0) && selected_lot && selected_lot.categories"
                                             :categories="selected_lot.categories"></card-image-category>
                        <img v-if="selected_lot.photos.length>0" v-lazy="selected_lot.photos[0].preview"
                             class="bkt-card__image"
                        />
                        <div class="bkt-wrapper-column bkt-gap bkt-gap-down-sm-mini">
                            <h4 class="bkt-promo__lot-title">Торги №
                                {{selected_lot && selected_lot.trade && selected_lot.trade.externalId ?
                                selected_lot.trade.externalId : ''}}
                                (лот {{selected_lot && selected_lot.lotNumber ? selected_lot.lotNumber : '0'}})
                            </h4>
                            <h5 class="bkt-promo__lot-subtitle bkt-text-truncate-5 bkt-text-truncate-down-sm-4">
                                {{selected_lot.description}}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="bkt-card__row bkt-purchase__service bkt-wrapper-down-lg-column">
                    <div class="bkt-purchase__service__text-wrapper bkt-w-down-lg-100">
                        <h4 class="bkt-card__title">Инструкция для самостоятельной покупки лота</h4>
                        <h5 class="bkt-card__subtitle">Инструкция для проведения торгов по выбранному лоту</h5>
                    </div>
                    <hr class="d-lg-none w-100 m-0">
                    <h3 class="bkt-purchase__service__price">3 000 ₽</h3>
                </div>
                <bkt-input
                    v-model="service.email"
                    :name="'instruction_email'"
                    type="email"
                    label="email <span class='bkt-text-red'>*</span>"
                    label_class="bkt-form__label"
                    field_name="Email"
                    :rules="'required'"
                    placeholder="pochta@gmail.com"
                    icon_name="Email"
                />
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    import CardImageCategory from "../CardImageCategory";

    export default {
        name: "InstructionModal",
        components: {CardImageCategory},
        data() {
            return {
                loading: false,
                service: {
                    email: '',
                    lotId: 0,
                },
            }
        },
        computed: {
            selected_lot() {
                return this.$store.getters.selected_lot;
            },
            user() {
                return this.$store.getters.auth_user
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
        watch: {
            isLoggedIn: function (newVal, oldVal) {
                if (oldVal == false && newVal == true && this.user) {
                    this.service.email = this.user.email;
                }
                else if (oldVal == true && newVal == false) {
                    this.service.email = '';
                }
            },
            user: function (newVal, oldVal) {
                if (newVal !== null) {
                    this.service.email = this.user.email;
                }
            }
        },
        mounted() {
            if(this.user && this.isLoggedIn) {
                this.service.email = this.user.email;
            }
        },
        methods: {
            buyInstruction() {
                this.loading = true;
                let data = JSON.parse(JSON.stringify(this.service));
                data.lotId = this.selected_lot.id;
                axios.post('/api/send/purchase/instructions', data)
                    .then(resp => {
                        this.loading = false;
                        // this.$store.dispatch('sendNotification',
                        //     {self: this, message: 'Инструкция успешно преобретена'});
                        this.service.lotId = 0;
                        this.$store.commit('closeModal', '#instructionModal');
                        window.location.replace(resp.data.redirectUrl)
                    })
                    .catch(error => {
                        this.loading = false;
                        this.$store.dispatch('sendNotification',
                            {self: this, type: 'error', message: 'Произошла ошибка, попробуйте позже'});
                    })
            },
            navigate(path) {
                this.$store.commit('closeModal', '#instructionModal');
                if (this.$router.currentRoute.path != path) {
                    this.$router.push(path)
                }
            },
        }
    }
</script>

<style scoped>

</style>
