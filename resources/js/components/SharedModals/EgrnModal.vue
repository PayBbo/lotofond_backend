<template>
    <bkt-modal :id="'egrnModal'" title="Выписка ЕГРН" modal_class="bkt-filters-modal bkt-purchase"
               left_button_class="d-none" @right_action="buy" :loading="loading"
               right_button="Купить - 70 ₽"
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
                        <h4 class="bkt-card__title">Выписка ЕГРН</h4>
                        <h5 class="bkt-card__subtitle">Официальная справка с информацией о собственнике и характеристиках объекта, наличии или отсутствии ограничений и обременений.</h5>
                    </div>
                    <hr class="d-lg-none w-100 m-0">
                    <h3 class="bkt-purchase__service__price">70 ₽</h3>
                </div>
                <bkt-input
                    v-model="service.email"
                    :name="'egrn_email'"
                    type="email"
                    label="email <span class='bkt-text-red'>*</span>"
                    label_class="bkt-form__label"
                    field_name="Email"
                    :rules="'required'"
                    placeholder="pochta@gmail.com"
                    icon_name="Email"
                    :disabled="loading"
                />
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    import CardImageCategory from "../CardImageCategory";

    export default {
        name: "EgrnModal",
        components: {CardImageCategory},
        data() {
            return {
                loading: false,
                service: {
                    email: '',
                    lotId: 0,
                    cadastralNumber: '',
                    answerFormat: "pdf"
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
            buy() {
                this.loading = true;
                let data = JSON.parse(JSON.stringify(this.service));
                data.lotId = this.selected_lot.id;
                data.cadastralNumber = this.selected_lot.cadastralData.cadastralNumber;
                console.log(data.cadastralNumber)
                axios.post('/api/send/receipt/egrn', data)
                    .then(resp => {
                        this.loading = false;
                        // this.$store.dispatch('sendNotification',
                        //     {self: this, message: 'Инструкция успешно преобретена'});
                        this.service.lotId = 0;
                        this.$store.commit('closeModal', '#egrnModal');
                        window.location.replace(resp.data.redirectUrl)
                    })
                    .catch(error => {
                        this.loading = false;
                        this.$store.dispatch('sendNotification',
                            {self: this, type: 'error', message: 'Произошла ошибка, попробуйте позже'});
                    })
            },
            navigate(path) {
                this.$store.commit('closeModal', '#egrnModal');
                if (this.$router.currentRoute.path != path) {
                    this.$router.push(path)
                }
            },
        }
    }
</script>

<style scoped>

</style>
