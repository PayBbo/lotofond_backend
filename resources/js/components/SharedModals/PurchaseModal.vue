<template>
    <bkt-modal :id="'purchaseModal'" ref="purchaseModal" modal_class="bkt-filters-modal bkt-purchase"
               :loading="loading" no_footer
    >
        <template #body="{ invalid }">
            <div class="bkt-form row-cols-1 row-cols-lg-2">
                <div class="col-12 col-lg-6">
                    <div class="bkt-card bkt-purchase__card_primary h-100">
                        <h3 class="bkt-card__title">Проведение торгов, юридическая консультация и другое</h3>
                        <h5 class="bkt-card__text">Воспользуйтесь нашим опытом побед, чтобы избежать ошибок и сэкономить время, деньги и нервы</h5>
                        <button class="bkt-button w-100 bkt-button_yellow bkt-purchase__button" @click="sendApplication">
                            Подробнее об услугах
                        </button>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="bkt-card bkt-purchase__card h-100">
                        <h3 class="bkt-card__title">Инструкция для самостоятельной покупки лота</h3>
                        <h5 class="bkt-card__text">Инструкция для проведения торгов по выбранному лоту</h5>
                        <button class="bkt-button w-100 primary mt-auto bkt-purchase__button" @click="sendInstruction">
                            Купить - 3 000 ₽
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
            sendApplication() {
                this.$store.commit('closeModal', '#purchaseModal');
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
