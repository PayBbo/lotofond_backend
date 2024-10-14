<template>
    <div class="bkt-page bkt-container bkt-tariffs">
        <h1 class="bkt-page__title">Тарифы</h1>
        <div class="bkt-card bkt-card__body">
            <div class="bkt-form mx-auto w-100">
                <div class="col-12 col-lg-6">
                    <div class="bkt-card bkt-card__body bkt-bg-body bkt-tariffs__services">
                        <h3 class="bkt-card__title">
                            Оформите подписку и получите доступ к дополнительным возможностям
                        </h3>
                        <template v-if="!loading">
                            <div class="d-flex bkt-gap align-items-center"
                                 v-if="available_tariffs.length >0 && available_tariffs[choice] && available_tariffs[choice].description"
                                 v-for="detail in available_tariffs[choice].description.includedDetails">
                                <bkt-icon name="Check" color="green" height="16px" width="16px"></bkt-icon>
                                <h4 class="bkt-card__text">
                                    {{detail}}
                                </h4>
                            </div>
                        </template>
                        <template v-if="loading">
                            <div class="d-flex bkt-gap align-items-center" v-for="n in 4">
                                <skeleton height="16px" width="16px"></skeleton>
                                <skeleton type_name="text" height="16px"></skeleton>
                            </div>
                        </template>

                        <!--                        <div class="d-flex bkt-gap align-items-center">-->
                        <!--                            <bkt-icon name="Check" color="green" height="16px" width="16px"></bkt-icon>-->
                        <!--                            <h4 class="bkt-card__text">-->
                        <!--                                Вся информация о лоте-->
                        <!--                            </h4>-->
                        <!--                        </div>-->
                        <!--                        <div class="d-flex bkt-gap align-items-center">-->
                        <!--                            <bkt-icon name="Check" color="green" height="16px" width="16px"></bkt-icon>-->
                        <!--                            <h4 class="bkt-card__text">-->
                        <!--                                Просмотр фото лота-->
                        <!--                            </h4>-->
                        <!--                        </div>-->
                        <!--                        <div class="d-flex bkt-gap align-items-center">-->
                        <!--                            <bkt-icon name="Check" color="green" height="16px" width="16px"></bkt-icon>-->
                        <!--                            <h4 class="bkt-card__text">-->
                        <!--                                Неограниченное количество лотов в Мониторинге-->
                        <!--                            </h4>-->
                        <!--                        </div>-->
                        <!--                        <div class="d-flex bkt-gap align-items-center">-->
                        <!--                            <bkt-icon name="Check" color="green" height="16px" width="16px"></bkt-icon>-->
                        <!--                            <h4 class="bkt-card__text">-->
                        <!--                                Возможность добавить лот в Избранное-->
                        <!--                            </h4>-->
                        <!--                        </div>-->
                    </div>
                </div>
                <div class="col-12 col-lg-6">
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
                                <skeleton circle height="20px" width="20px"></skeleton>
                                <div class="bkt-wrapper-between w-100">
                                    <div
                                        class="bkt-wrapper-down-sm-between bkt-gap-down-sm-column bkt-w-down-sm-100 bkt-gap-row-mini">
                                        <skeleton type_name="text" heigth="16px"></skeleton>
                                        <skeleton skeleton_class="bkt-badge" width="50px"></skeleton>
                                    </div>
                                    <skeleton type_name="text" heigth="26px"></skeleton>
                                </div>
                            </div>
                        </template>

                        <!--                        <div class="bkt-card__row outline bkt-tariffs__item" :class="{'active': choice==1}">-->
                        <!--                            <bkt-checkbox type="radio" v-model="choice" :val="1"-->
                        <!--                                          wrapper_class="bkt-check_radio-check"></bkt-checkbox>-->
                        <!--                            <div-->
                        <!--                                class="bkt-wrapper-between w-100 bkt-wrapper-down-sm-column bkt-gap-down-sm-none align-items-start">-->
                        <!--                                <h4 class="bkt-card__text">1 месяц</h4>-->
                        <!--                                <h3 class="bkt-card__title">999 ₽ <span class="bkt-card__subtitle"> / 30 дней</span>-->
                        <!--                                </h3>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                        <div class="bkt-card__row outline bkt-tariffs__item" :class="{'active': choice==3}">-->
                        <!--                            <bkt-checkbox type="radio" v-model="choice" :val="3"-->
                        <!--                                          wrapper_class="bkt-check_radio-check"></bkt-checkbox>-->
                        <!--                            <div class="bkt-wrapper-between w-100">-->
                        <!--                                <div-->
                        <!--                                    class="bkt-wrapper-down-sm-between bkt-gap-down-sm-column bkt-w-down-sm-100 bkt-gap-row-mini">-->
                        <!--                                    <h4 class="bkt-card__text">3 месяца</h4>-->
                        <!--                                    <div class="bkt-badge">Выгода 6,9 %</div>-->
                        <!--                                </div>-->
                        <!--                                <h3 class="bkt-card__title">2 790 ₽ <span class="bkt-card__subtitle"> / 90 дней</span>-->
                        <!--                                </h3>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                        <div class="bkt-card__row outline bkt-tariffs__item" :class="{'active': choice==6}">-->
                        <!--                            <bkt-checkbox type="radio" v-model="choice" :val="6"-->
                        <!--                                          wrapper_class="bkt-check_radio-check"></bkt-checkbox>-->
                        <!--                            <div class="bkt-wrapper-between w-100">-->
                        <!--                                <div-->
                        <!--                                    class="bkt-wrapper-down-sm-between bkt-gap-down-sm-column bkt-w-down-sm-100 bkt-gap-row-mini">-->
                        <!--                                    <h4 class="bkt-card__text">6 месяцев</h4>-->
                        <!--                                    <div class="bkt-badge">Выгода 8,4 %</div>-->
                        <!--                                </div>-->
                        <!--                                <h3 class="bkt-card__title">5 490 ₽ <span class="bkt-card__subtitle"> / 180 дней</span>-->
                        <!--                                </h3>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                        <div class="bkt-card__row outline bkt-tariffs__item" :class="{'active': choice==12}">-->
                        <!--                            <bkt-checkbox type="radio" v-model="choice" :val="12"-->
                        <!--                                          wrapper_class="bkt-check_radio-check"></bkt-checkbox>-->
                        <!--                            <div class="bkt-wrapper-between w-100">-->
                        <!--                                <div-->
                        <!--                                    class="bkt-wrapper-down-sm-between bkt-gap-down-sm-column bkt-w-down-sm-100 bkt-gap-row-mini">-->
                        <!--                                    <h4 class="bkt-card__text">12 месяцев</h4>-->
                        <!--                                    <div class="bkt-badge">Выгода 16,7 %</div>-->
                        <!--                                </div>-->
                        <!--                                <h3 class="bkt-card__title">9 990 ₽ <span class="bkt-card__subtitle"> / 365 дней</span>-->
                        <!--                                </h3>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
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
</template>

<script>
    export default {
        name: "Tariffs",
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
            }
        },
        mounted() {
            if (this.tariffs.length === 0) {
                this.getTariffs();
            }
        },
        methods: {
            async getTariffs() {
                this.loading = true;
                await this.$store.dispatch('getTariffs')
                    .finally(() => {
                        this.loading = false;
                    })
            },
            getBenefit(tariff) {
                let benefit = (100 - (tariff.price * 100 / (this.tariffs[0].price * (tariff.period / this.tariffs[0].period).toFixed())))
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
                            window.location.replace(resp.data.redirectUrl);
                        })
                        .catch(error => {
                            this.tariff_loading = false;
                            this.$store.dispatch('sendNotification',
                                {self: this, type: 'error', message: 'Произошла ошибка, попробуйте позже'});
                        })
                }
                else {
                    this.$store.commit('openModal', '#authModal')
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
