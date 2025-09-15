<template>
    <fragment>
        <div v-if="item && main_prices" class="d-flex bkt-nowrap bkt-gap-small bkt-wrapper-down-sm-column-reverse">
            <div class="bkt-card__feature">
                <h6 class="bkt-card__subtitle">текущая цена</h6>
                <h5 class="bkt-text-700 d-flex align-items-center bkt-gap-mini bkt-card-trade__price"
                    :class="{
                    'bkt-text-red': (!rules || (rules && rules.currentPriceState)) && item.currentPriceState==='up',
                    'bkt-text-green':(!rules || (rules && rules.currentPriceState)) && item.currentPriceState==='down'
                    }"
                >
                    <skeleton type_name="spoiler" tag="div" :loading="rules && !rules.currentPrice">
                        {{(item && item.currentPrice ? item.currentPrice : '0') | priceFormat}} ₽
                    </skeleton>
                    <skeleton type_name="spoiler_mini" tag="div"
                              :loading="rules && !rules.currentPriceState"
                              v-if="(item.currentPriceState!=='hold' && (!rules || (rules && rules.currentPriceState)))
                              ||(rules && !rules.currentPriceState)"
                    >
                        <span>
                            <bkt-icon :name="'ArrowTriple'" :width="'22px'" :height="'22px'"
                                      :color="item.currentPriceState==='down' ? 'green' : 'red'"
                                      :class="{'bkt-rotate-180': item.currentPriceState==='down'}"
                            >
                            </bkt-icon>
                        </span>
                    </skeleton>
                </h5>
            </div>
            <div class="bkt-card-trade__price-arrow d-none d-sm-flex align-self-end"
                 v-if="item && item.trade && item.trade.type &&
                 ((item.startPrice && item.startPrice>=0 && !offers.includes(item.trade.type))
                 || (item.minPrice && item.minPrice>=0 && offers.includes(item.trade.type)))"
                 :class="{'bkt-rotate-180' : item.trade && !offers.includes(item.trade.type)}">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5.24982 9.47727L4.26119 8.49716L6.85636 5.90199H0.775391V4.46165H6.85636L4.26119 1.87074L5.24982 0.886364L9.54528 5.18182L5.24982 9.47727Z"
                        fill="black"/>
                </svg>
            </div>
            <!--                                        <template v-if="item && item.trade && item.trade.type">-->
            <div class="bkt-card__feature"
                 v-if="((item.minPrice && item.minPrice>=0) && item && item.trade && item.trade.type &&
                 offers.includes(item.trade.type)
                 && (!rules || rules && rules.minPrice))||(rules && !rules.minPrice)"
            >
                <h6 class="bkt-card__subtitle bkt-text-700">
                    минимальная цена
                </h6>
                <h5 class="bkt-card__text bkt-text-700 bkt-card-trade__price d-flex flex-wrap bkt-text-red">
                    <skeleton type_name="spoiler" :loading="rules && !rules.minPrice">
                        {{ item.minPrice | priceFormat}} ₽
                        <div class="bkt-badge bkt-bg-green" v-if="priceInfo.percent > 0">
                            -{{priceInfo.percent | numberFormat}} %
                        </div>
                    </skeleton>
                </h5>
            </div>
            <div class="bkt-card__feature"
                 v-if="((item.startPrice && item.startPrice>=0) && item && item.trade && item.trade.type
                 && !offers.includes(item.trade.type)
                 && (!rules || rules && rules.startPrice))||(rules && !rules.startPrice)"
            >
                <h6 class="bkt-card__subtitle">
                    начальная цена
                </h6>
                <h5 class="bkt-card__text bkt-text-700 bkt-card-trade__price d-flex flex-wrap">
                    <skeleton type_name="spoiler" :loading="rules && !rules.startPrice">
                        {{ item.startPrice | priceFormat}} ₽
                        <span class="bkt-badge bkt-bg-red" v-if="priceInfo.percent > 0">
                            +{{priceInfo.percent | numberFormat}} %
                        </span>
                    </skeleton>
                </h5>
            </div>
            <!--                                        <div class="bkt-badge" v-if="priceInfo.percent !== 0"-->
            <!--                                             :class="item.trade && (item.trade.type!=='ClosePublicOffer' && item.trade.type!=='PublicOffer') ? 'bkt-bg-red' : 'bkt-bg-green'"-->
            <!--                                        >-->
            <!--                                            {{item.trade && (item.trade.type!=='ClosePublicOffer' && item.trade.type!=='PublicOffer')? '+':'-'}}-->
            <!--                                            {{priceInfo.percent | numberFormat}} %-->
            <!--                                        </div>-->
            <!--                                        </template>-->
        </div>
        <div v-if="item && secondary_prices" class="bkt-card__features bkt-wrapper-column bkt-wrapper-down-lg-column-reverse bkt bkt-gap-small">
            <div class="bkt-card__feature" :class="deposit_class"
                 v-if="(item.deposit && (!rules || rules && rules.deposit))||(rules && !rules.deposit)"
            >
                <h6 class="bkt-card__subtitle">задаток
                    <span v-if="item && item.trade && item.trade.type">
                        {{auctions.includes(item.trade.type) ? '(от начальной цены)' : '(от текущей цены)'}}
                    </span>
                </h6>
                <h5 class="bkt-card__text bkt-text-700 bkt-card-trade__subprice">
                    <skeleton type_name="spoiler" skeleton_class="bkt-text-main"
                              :loading="rules && !rules.deposit">
                        <template v-if="item.deposit">
                            {{priceInfo.deposit.money | priceFormat}} ₽
                            <span class="bkt-text-neutral-dark bkt-card-trade__subprice-percent" v-if="isNumber(priceInfo.deposit.percent)">
                                {{priceInfo.deposit.percent | numberFormat}} %
                            </span>
                        </template>
                        <template v-else>
                            без задатка
                        </template>
                        <!--                                                    {{item.deposit && item.deposit.value ? item.deposit.value : '0' | priceFormat}}-->
                        <!--                                                    {{item.deposit && item.deposit.type=='rubles' ? '₽' : '%'}}-->
                    </skeleton>
                </h5>
            </div>
            <div class="bkt-card__feature" :class="step_class"
                 v-if="(item && item.stepPrice && item.stepPrice.value>0 && item.trade && item.trade.type &&
                 auctions.includes(item.trade.type)
                 && (!rules || rules && rules.stepPrice))||(rules && !rules.stepPrice)"
            >
                <h6 class="bkt-card__subtitle">шаг аукциона (от начальной цены)</h6>
                <h5 class="bkt-card__text bkt-text-700 bkt-card-trade__subprice">
                    <skeleton type_name="spoiler" :loading="rules && !rules.stepPrice">
                        <template v-if="item.stepPrice">
                            {{priceInfo.auction_step.money | priceFormat}} ₽
                            <span class="bkt-text-neutral-dark bkt-card-trade__subprice-percent" v-if="isNumber(priceInfo.auction_step.percent)">
                                {{priceInfo.auction_step.percent | numberFormat}} %
                            </span>
                        </template>
                        <template v-else>
                            без шага аукциона
                        </template>
                        <!--                                                    {{item.stepPrice && item.stepPrice.value ? item.stepPrice.value :-->
                        <!--                                                    '0' | priceFormat}}-->
                        <!--                                                    {{item.stepPrice && item.stepPrice.type=='rubles' ? '₽' : '%'}}-->
                    </skeleton>
                </h5>
            </div>
        </div>
    </fragment>
</template>

<script>
    export default {
        name: "CardPriceInfo",
        props: {
            item: {
                type: Object,
            },
            main_prices: {
                type: Boolean,
                default: true
            },
            secondary_prices: {
                type: Boolean,
                default: true
            },
            deposit_class: {
                type: String,
                default: ''
            },
            step_class: {
                type: String,
                default: ''
            },
        },
        data() {
            return {
                offers: ['ClosePublicOffer', 'PublicOffer', "PPZ", "PPU"],
                auctions: ['CloseAuction', 'OpenAuction', 'EA', 'OpenConcours', 'CloseConcours', "EK", "SA", "PA", "BC", "PK"]
            }
        },
        computed: {
            priceInfo() {
                if (this.item && this.item.trade && this.item.trade.type) {

                    let start_price = Number(this.item.startPrice);
                    let current_price = Number(this.item.currentPrice);
                    let min_price = Number(this.item.minPrice);

                    let prime_price = start_price;

                    let percent = ((current_price - start_price) / start_price) * 100;

                    if (this.offers.includes(this.item.trade.type)) {
                        prime_price = current_price;
                        percent = ((start_price - min_price) / start_price) * 100;
                    }

                    if (percent > 0 && percent <= 0.01) {
                        percent = 0.01;
                    }
                    if (percent >= 99.99 && percent < 100) {
                        percent = 99.99;
                    }

                    let deposit = {money: 0, percent: 0, type: ''};
                    let auction_step = {money: 0, percent: 0, type: ''};
                    if (this.item.deposit) {
                        deposit.type = this.item.deposit.type;
                        if (this.item.deposit.type === 'rubles') {
                            deposit.money = Number(this.item.deposit.value);
                            deposit.percent = deposit.money * 100 / prime_price;
                            if (deposit.percent > 0 && deposit.percent <= 0.01) {
                                deposit.percent = 0.01;
                            }
                            if (deposit.percent >= 99.99 && deposit.percent < 100) {
                                deposit.percent = 99.99;
                            }
                        } else {
                            deposit.percent = Number(this.item.deposit.value);
                            deposit.money = prime_price * deposit.percent / 100;
                        }
                    }
                    if (this.item.stepPrice) {
                        auction_step.type = this.item.stepPrice.type;
                        if (this.item.stepPrice.type === 'rubles') {
                            auction_step.money = this.item.stepPrice.value;
                            auction_step.percent = auction_step.money * 100 / prime_price;
                            if (auction_step.percent > 0 && auction_step.percent <= 0.01) {
                                auction_step.percent = 0.01;
                            }
                            if (auction_step.percent >= 99.99 && auction_step.percent < 100) {
                                auction_step.percent = 99.99;
                            }
                        } else {
                            auction_step.percent = Number(this.item.stepPrice.value);
                            auction_step.money = prime_price * auction_step.percent / 100;
                        }
                    }

                    return {percent: percent, deposit: deposit, auction_step: auction_step}
                }
            },
            rules() {
                return this.$store.getters.rules
            },
        },
        methods: {
            isNumber(value) {
                return typeof value === 'number' && !isNaN(value) && Number.isFinite(value);
            }
        }
    }
</script>

<style scoped lang="scss">
    .bkt-card-trade, .bkt-lot-card {
        &__price-info {
            padding: 8px;
            border-radius: 8px;
            gap: 8px;

            & .bkt-card-trade__price {
                font-family: 'Inter';
                font-style: normal;
                font-weight: 700;
                font-size: 18px !important;
                line-height: 24px;
                text-align: start;

                &-arrow {
                    display: flex;
                    align-items: center;
                    height: 24px;
                    justify-content: center;
                }
            }

            & .bkt-card-trade__subprice {
                font-family: 'Inter';
                font-style: normal;
                font-weight: 700;
                font-size: 14px !important;

                &-percent {
                    font-size: 12px;
                    margin-left: 5px;
                }
            }

            & .bkt-badge {
                max-height: 24px;
                height: 24px;
                line-height: 24px;
                font-family: 'Inter';
                font-style: normal;
                font-weight: 700;
                font-size: 12px;
                padding: 0 4px;
                border-radius: 30px;
            }

            & .bkt-card-trade__button {
                width: fit-content;
            }

            & .bkt-card__feature {
                margin-top: 0;
            }
        }
    }
    .bkt-lot-card {
        & .bkt-card-trade__price-info {
            & .bkt-card-trade__subprice {
                font-family: 'Inter',sans-serif;
                font-style: normal;
                font-weight: 700;
                font-size: 22px !important;

                &-percent {
                    font-size: 22px;
                    margin-left: 5px;
                }
            }
        }
    }
    @media screen and (max-width: 768px) {
        .bkt-card-trade, .bkt-lot-card {
            &__price-info {
                & .bkt-card-trade__price {
                    font-size: 16px !important;
                    line-height: 22px;

                    &-arrow {
                        height: 22px;
                    }
                }

                & .bkt-badge {
                    max-height: 22px;
                    height: 22px;
                    line-height: 22px;
                    font-size: 10px;
                    padding: 0 2px;
                    border-radius: 30px;
                }
            }
        }
    }

    @media screen and (max-width: 568px)
    {
        .bkt-lot-card {
            & .bkt-card-trade__price-info {
                & .bkt-card-trade__subprice {
                    font-size: 16px !important;

                    &-percent {
                        font-size: 16px;
                    }
                }
            }
        }
    }

</style>
