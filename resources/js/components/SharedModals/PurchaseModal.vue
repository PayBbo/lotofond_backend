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
                                    <skeleton :loading="loading&&!buyBlock&&!buyBlock[0]">
                                        <h3 class="bkt-card__title">
                                            {{buyBlock&&buyBlock[0]&&buyBlock[0].header ? buyBlock[0].header : 'Проведение торгов, выкуп лота'}}
                                        </h3>
                                    </skeleton>
                                    <skeleton :loading="loading&&!buyBlock&&!buyBlock[0]">
                                        <h5 class="bkt-card__text">
                                            {{buyBlock&&buyBlock[0]&&buyBlock[0].value ? buyBlock[0].value : 'Воспользуйтесь нашим опытом побед, чтобы избежать ошибок и сэкономить время, деньги и нервы'}}
                                        </h5>
                                    </skeleton>
                                    <button class="bkt-button w-100 bkt-button_yellow bkt-purchase__button"
                                            @click="sendApplication('ECP')">
                                        Купить лот
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="bkt-purchase__card-features" v-if="!loading&&buyBlock&&buyBlock[0]">
                                    <div class="bkt-purchase__card-feature" v-for="(point, index) in buyBlock[0].points">
                                        <div class="check_mark" :class="'bkt-bg-'+colors[index % colors.length]">&#10003;</div>
                                        <span>{{point}}</span>
                                    </div>
                                </div>
                                <skeleton v-if="loading" :loading="loading" :count="4" :type_name="'item'"
                                          height="14px" width="14px"
                                >
                                </skeleton>
                            </div>
                        </div>
                    </div>
                </div>
<!--                <div class="col-12 col-lg-6">-->
<!--                    <div class="bkt-card bkt-purchase__card h-100">-->
<!--                        <skeleton :loading="loading&&!buyBlock&&!buyBlock[1]">-->
<!--                            <h3 class="bkt-card__title">-->
<!--                                {{buyBlock&&buyBlock[1]&&buyBlock[1].header ? buyBlock[1].header : 'Инструкция для самостоятельной покупки лота'}}-->
<!--                            </h3>-->
<!--                        </skeleton>-->
<!--                        <skeleton :loading="loading&&!buyBlock&&!buyBlock[1]">-->
<!--                            <h5 class="bkt-card__text">-->
<!--                                {{buyBlock&&buyBlock[1]&&buyBlock[1].value ? buyBlock[1].value : 'Инструкция для проведения торгов по выбранному лоту'}}-->
<!--                            </h5>-->
<!--                        </skeleton>-->
<!--                        <button class="bkt-button w-100 primary mt-auto bkt-purchase__button" @click="sendInstruction">-->
<!--                            Купить-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-12 col-lg-6">-->
<!--                    <div class="bkt-card bkt-purchase__card h-100">-->
<!--                        <skeleton :loading="loading&&!buyBlock&&!buyBlock[2]">-->
<!--                            <h3 class="bkt-card__title">-->
<!--                                {{buyBlock&&buyBlock[2]&&buyBlock[2].header ? buyBlock[2].header : 'Оценка ликвидности, юридическая консультация и другое'}}-->
<!--                            </h3>-->
<!--                        </skeleton>-->
<!--                        <skeleton :loading="loading&&!buyBlock&&!buyBlock[2]">-->
<!--                            <h5 class="bkt-card__text">-->
<!--                                {{buyBlock&&buyBlock[2]&&buyBlock[2].value ? buyBlock[2].value : 'Узнайте подробнее о прочих услугах'}}-->
<!--                            </h5>-->
<!--                        </skeleton>-->
<!--                        <button class="bkt-button w-100 primary mt-auto bkt-purchase__button" @click="sendApplication('services')">-->
<!--                            Подробнее о прочих услугах-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "PurchaseModal",
        data() {
            return {
                loading: true,
                colors: ['pink', 'blue-dark', 'blue-light', 'teal'],
            }
        },
        computed: {
            buyBlock() {
                return this.$store.getters.buyBlock;
            }
        },
        created() {
           this.getBuyBlock();
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
            async getBuyBlock() {
                this.loading = true;
                await this.$store.dispatch('getBuyBlock')
                    .then(resp => {
                        this.loading = false;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
