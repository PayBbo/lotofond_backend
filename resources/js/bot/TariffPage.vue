<template>
    <div>
        <div class="bkt-page bkt-container bkt-tariffs">
            <div  v-if="!loading && !auth_user_loading && (!isLoggedIn || !auth_user || !auth_user.botTariff)" class="bkt-shadow-card bkt-shadow-card_primary mt-3 mb-4">
                <div class="bkt-shadow-card__inner bkt-gap-large">
                    <h4 class="bkt-shadow-card__title bkt-text-white">
                        Пробный период закончился<br>
                        <span>Купите подписку, чтобы продолжить просмотр лотов</span>
                    </h4>
                    <div class="bkt-shadow-card__shadow-1">
                    </div>
                    <div class="bkt-shadow-card__shadow-2">
                    </div>
                </div>
            </div>
            <h1 class="bkt-page__title">Тарифы подписки</h1>
            <div class="bkt-card bkt-card__body">
                <div class="bkt-form mx-auto w-100">
                    <div class="col-12">
                        <div class="bkt-wrapper-column bkt-gap">
                            <template v-if="!loading">
                                <template v-if="user_tariff">
                                    <div class="bkt-card bkt-tariffs__item active">
                                        <h4 class="bkt-card__title">Текущий тариф</h4>
                                        <div class="d-flex bkt-gap-small">
                                            <h4 class="bkt-card__text">{{user_tariff.title}}</h4>
                                            <div class="bkt-badge bkt-bg-green">
                                                Активен до {{user_tariff.expiredAt}}
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="w-100 m-0">
                                </template>
                                <div v-for="(tariff, index) in available_tariffs"
                                     class="bkt-card__row outline bkt-tariffs__item"
                                     :class="{'current': choice==index}" @click="chooseTariff(index)"
                                >
                                    <bkt-checkbox v-if="!tariff.isUserTariff" :name="'tariff_'+index" type="radio" v-model="choice" :val="index"
                                                  wrapper_class="bkt-check_radio-check"></bkt-checkbox>
                                    <bkt-checkbox v-else :name="'tariff_'+index" :value="true" disabled
                                                  wrapper_class="bkt-check_radio-check"></bkt-checkbox>
                                    <div class="bkt-wrapper-between w-100">
                                        <div
                                            class="bkt-wrapper-down-sm-between bkt-gap-down-sm-column bkt-w-down-sm-100 bkt-gap-row-mini">
                                            <h4 class="bkt-card__text">{{tariff.title}}</h4>
                                            <div class="bkt-badge" v-if="index>0 && !tariff.isUserTariff">
                                                Выгода {{getBenefit(tariff)}} %
                                            </div>
                                            <div class="bkt-badge" v-if="tariff.isUserTariff">Активен</div>
                                        </div>
                                        <h3 class="bkt-card__title">{{tariff.price}} ₽
                                            <span class="bkt-card__subtitle"> / {{tariff.period}} дней</span>
                                        </h3>
                                    </div>
                                </div>
                            </template>
                            <template v-if="loading">
                                <div v-for="n in 4" class="bkt-card__row outline bkt-tariffs__item">
                                    <skeleton circle height="20px" width="20px"/>
                                    <div class="bkt-wrapper-between w-100">
                                        <div
                                            class="bkt-wrapper-down-sm-between bkt-gap-down-sm-column bkt-w-down-sm-100 bkt-gap-row-mini">
                                            <skeleton type_name="text" heigth="16px"/>
                                            <skeleton skeleton_class="bkt-badge" width="50px"/>
                                        </div>
                                        <skeleton type_name="text" heigth="26px"/>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex">
                            <button
                                class="bkt-button primary bkt-tariffs__button bkt-w-down-sm-100 mx-auto ms-lg-auto me-lg-0"
                                :disabled="tariff_loading" v-if="!loading" @click="buyTariff"
                            >
                                <span v-show="tariff_loading" class="spinner-border spinner-border-sm" role="status"></span>
                                Купить
                            </button>
                            <skeleton v-if="loading" type_name="button"
                                      skeleton_class="bkt-button bkt-tariffs__button bkt-w-down-sm-100 mx-auto ms-lg-auto me-lg-0"></skeleton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TariffPage",
        data() {
            return {
                choice: '0',
                loading: false,
                tariff_loading: false,
            }
        },
        computed: {
            tariffs() {
                return this.$store.getters.tariffs
            },
            available_tariffs() {
                return this.tariffs.filter(item => item.isUserTariff === false);
            },
            user_tariff() {
                let index = this.tariffs.findIndex(item => item.isUserTariff === true);
                if (index >= 0) {
                    let tmp = this.tariffs[index];
                    tmp.expiredAt = this.$moment(this.tariffs[index].expiredAt, 'DD.MM.YYYY HH:mm:ss').format('DD.MM.YYYY HH:mm')
                    return tmp;
                }
                return null;
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
            auth_user() {
                return this.$store.getters.auth_user
            },
            auth_user_loading() {
                return this.$store.getters.auth_user_loading
            },
        },
        mounted() {
            if (this.tariffs.length === 0) {
                this.getTariffs();
            }
        },
        methods: {
            async getTariffs() {
                this.loading = true;
                await this.$store.dispatch('getTariffs', {type: 'bot_tariff'}).then(resp => {
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
                });
            },
            getBenefit(tariff) {
                let benefit = (100 - (tariff.price * 100 / (this.tariffs[0].price * (tariff.period / this.tariffs[0].period).toFixed())));
                if (Number.isInteger(benefit)) {
                    return benefit
                } else {
                    return benefit.toFixed(1)
                }
            },
            buyTariff() {
                if (this.isLoggedIn) {
                    this.tariff_loading = true;
                    axios.post('/api/payment', {tariffId: this.available_tariffs[this.choice].id})
                        .then(resp => {
                            this.tariff_loading = false;
                            let redirect_url = resp.data.redirectUrl;
                            let path = redirect_url.replace('pay-answer', 'bot/pay-answer');
                            window.location.replace(path);
                        })
                        .catch(error => {
                            this.tariff_loading = false;
                            this.$store.dispatch('sendNotification',
                                {self: this, type: 'error', message: 'Произошла ошибка, попробуйте позже'});
                        })
                }
                else {
                    // this.$store.commit('openModal', '#authModal')
                }
            },
            chooseTariff(index) {
                if (!this.available_tariffs[index].isUserTariff) {
                    this.choice = index;
                }
            }
        }
    }
</script>

<style scoped>

</style>
