<template>
    <bkt-modal :id="'purchaseModal'" ref="purchaseModal" modal_class="bkt-filters-modal bkt-purchase"
               :loading="loading" no_footer
    >
        <template #body="{ invalid }">
            <div class="bkt-form row-cols-1 row-cols-lg-1">
                <div class="col-12">
                    <div class="bkt-card bkt-purchase__card_primary h-100">
                        <div class="bkt-form">
                            <div class="col-12 col-lg-6">
                                <div class="bkt-purchase__card-info">
                                    <h3 class="bkt-card__title">Проведение торгов, юридическая консультация и другое</h3>
                                    <h5 class="bkt-card__text">Воспользуйтесь нашим опытом побед, чтобы избежать ошибок и
                                        сэкономить время, деньги и нервы</h5>
                                    <button class="bkt-button w-100 bkt-button_yellow bkt-purchase__button"
                                            @click="sendApplication('ECP')">
                                        Купить лот
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="bkt-purchase__card-features">
                                    <div class="bkt-purchase__card-feature">
                                        <div class="check_mark bkt-bg-pink">&#10003;</div>
                                        <span>ЭЦП не нужна</span>
                                    </div>
                                    <div class="bkt-purchase__card-feature">
                                        <div class="check_mark bkt-bg-blue-dark">&#10003;</div>
                                        <span>Аккредитация не нужна</span>
                                    </div>
                                    <div class="bkt-purchase__card-feature">
                                        <div class="check_mark bkt-bg-blue-light">&#10003;</div>
                                        <span>Заполнять документы не нужно</span>
                                    </div>
                                    <div class="bkt-purchase__card-feature">
                                        <div class="check_mark bkt-bg-teal">&#10003;</div>
                                        <span>Гарантируем допуск к торгам</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="bkt-card bkt-purchase__card h-100">
                        <h3 class="bkt-card__title">Инструкция для самостоятельной покупки лота</h3>
                        <h5 class="bkt-card__text">Инструкция для проведения торгов по выбранному лоту</h5>
                        <button class="bkt-button w-100 primary mt-auto bkt-purchase__button" @click="sendInstruction">
                            Купить
                        </button>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="bkt-card bkt-purchase__card h-100">
                        <h3 class="bkt-card__title">Оценка ликвидности, юридическая консультация и другое</h3>
                        <h5 class="bkt-card__text">Узнайте подробнее о прочих услугах</h5>
                        <button class="bkt-button w-100 primary mt-auto bkt-purchase__button" @click="sendApplication('services')">
                            Подробнее о прочих услугах
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "PurchaseModal",
        data() {
            return {
                loading: false,
            }
        },
        methods: {
            sendApplication(mode) {
                this.$store.commit('closeModal', '#purchaseModal');
                if(this.$parent.$refs.applicationModal) {
                    this.$parent.$refs.applicationModal.changeMode(mode);
                }
                this.$store.commit('openModal', '#applicationModal');
            },
            sendInstruction() {
                this.$store.commit('closeModal', '#purchaseModal');
                this.$store.commit('openModal', '#instructionModal');
            },
        }
    }
</script>

<style scoped>

</style>
