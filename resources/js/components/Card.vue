<template>
    <div class="bkt-card-trade bkt-card__row w-100 mx-auto mx-0">
        <div class="bkt-wrapper-between bkt-card__heading w-100" v-if="item && item.trade">
            <h5>торги № {{item && item.trade.externalId ? item.trade.externalId : '0'}}</h5>
            <h5>
                <span v-if="dateIsPast(item.trade.applicationTime.end) && item.trade.applicationTime && item.trade.applicationTime.end">
                дней до окончания приёма заявок: {{ item.trade.applicationTime.end | daysToDate }}
                </span>
                <span v-else-if="item.trade.eventTime && item.trade.eventTime.end">
                    дней до окончания торгов: {{item.trade.eventTime.end | daysToDate}}
                </span>
                <span v-else-if="item.trade.eventTime && item.trade.eventTime.result">
                   дней до объявления результатов торгов: {{item.trade.eventTime.result | daysToDate}}
                </span>
                <span v-else>0 дней</span>
                <span class="bkt-card__icon d-inline-block">
                    <bkt-icon :name="'Alarm'" :color="'green'" :width="'14px'" :height="'14px'"></bkt-icon>
                </span>
            </h5>
        </div>
        <div class="col-12 col-lg-11 p-0">
            <div class="row h-100 w-100 mx-auto row-cols-1 row-cols-md-2 row-cols-lg-3 bkt-card-trade__wrapper">
                <div class="col p-0 px-sm-2 order-2 order-lg-1">
                    <div class="bkt-card-image-wrapper">
                        <card-image-category
                            v-if="(!item.photos || item.photos.length==0) && item && item.categories.length>0"
                            :categories="item.categories"></card-image-category>
                        <!--                        <img v-lazy="'/images/card-image1.png'" class="bkt-card__image"-->
                        <!--                             v-if="!item.photos || item.photos.length==0"/>-->
                        <hooper :itemsToShow="1" :centerMode="true" class="bkt-card__image-slider"
                                v-if="item.photos.length>0">
                            <slide v-for="photo in item.photos" :key="photo.id">
                                <img v-lazy="photo.main" class="bkt-card__image"/>
                            </slide>
                            <hooper-navigation slot="hooper-addons"></hooper-navigation>
                        </hooper>
                        <div class="bkt-wrapper-between bkt-card-ecp-wrapper">
                            <!--                            <router-link custom v-slot="{ navigate }" to="/without-ecp">-->
                            <button @click="sendApplication" class="bkt-button primary bkt-card-ecp w-100">
                                Купить без <br>ЭЦП
                            </button>
                            <!--                            </router-link>-->
                            <router-link custom v-slot="{ navigate }" to="/agent">
                                <button @click="navigate" class="bkt-button primary bkt-card-ecp w-100">
                                    Купить через <br>агента
                                </button>
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 p-0 px-sm-2 order-1 order-lg-2">
                    <div class="bkt-wrapper-between bkt-card__head bkt-nowrap">
                        <router-link :to="'/lot/'+item.id" class="bkt-card__title bkt-text-truncate">
                            {{item && item.description ? item.description:'Некоторое название торгов'}}
                        </router-link>
                        <div class="dropdown d-block d-lg-none">
                            <button class="bkt-button bkt-bg-primary-lighter bkt-card-menu-button" type="button"
                                    id="dropdownMenuClickableOutside" data-bs-toggle="dropdown" data-bs-offset="10,20"
                                    data-bs-display="static" data-bs-auto-close="outside" aria-expanded="false"
                            >
                                <bkt-icon :name="'More'"></bkt-icon>
                            </button>
                            <div class="bkt-card-menu m-0 dropdown-menu dropdown-menu-end position-absolute"
                                 aria-labelledby="dropdownMenuClickableOutside"
                            >
                                <card-actions :item="item" class="bkt-card-menu-inner" type="menu"></card-actions>
                            </div>
                        </div>
                        <!--                        <button class="bkt-button bkt-bg-primary-lighter bkt-card-menu-button">-->
                        <!--                            <bkt-icon :name="'More'"></bkt-icon>-->
                        <!--                        </button>-->
                    </div>
                    <div class="d-none d-lg-block">
                        <template v-if="item.location && item.location.length>0">
                            <div class="bkt-card__feature" v-for="location in item.location.slice(0, 3)">
                                <h6 class="bkt-card__subtitle">регион {{location.isDebtorRegion ? 'должника' :
                                    'объекта'}}</h6>
                                <h5 class="bkt-card__text">{{$t('regions.'+location.code)}}</h5>
                            </div>
                        </template>

                        <div class="bkt-card__feature">
                            <h6 class="bkt-card__subtitle">тип торгов</h6>
                            <h5 class="bkt-card__text">
                                {{item.trade && item.trade.type ? $t('trades.type.'+item.trade.type) : ''}}
                            </h5>
                        </div>
                        <div class="bkt-card__feature">
                            <h6 class="bkt-card__subtitle">статус торгов</h6>
                            <h5 class="bkt-card__text">{{item.state ? $t('trades.state.'+item.state) : ''}}</h5>
                        </div>
                        <!--                        <div class="bkt-card__feature">-->
                        <!--                            <bkt-icon :name="'More'" :width="'22px'" :height="'22px'"></bkt-icon>-->
                        <!--                        </div>-->
                    </div>
                </div>
                <div class="col order-3 p-0 px-sm-2">
                    <div class="bkt-card-trade__wrapper bkt-wrapper-column">
                        <div class="bkt-wrapper-column bkt-gap-small">
                            <div class="bkt-card-trade__price-wrapper bkt-button w-100"
                                 :class="{'bkt-bg-red': item.currentPriceState=='down',
                                  'bkt-bg-green': item.currentPriceState=='up',
                                  'bkt-bg-primary-lighter': item.currentPriceState=='hold'}">
                                <h2 class="bkt-card-trade__price text-truncate"
                                    :class="{'bkt-text-primary': item.currentPriceState=='hold'}"
                                >
                                    {{item && item.currentPrice ? item.currentPrice : '0' | priceFormat}} ₽
                                </h2>

                                <div class="bkt-card-trade__price-icon" v-if="item.currentPriceState!=='hold'"
                                     :class="{'bkt-bg-red-light': item.currentPriceState=='down',
                                              'bkt-bg-green-light': item.currentPriceState=='up'}"
                                >
                                    <bkt-icon :name="'ArrowTriple'" :width="'22px'" :height="'22px'"
                                              :class="{'bkt-rotate-180': item.currentPriceState=='down'}"
                                    >
                                    </bkt-icon>
                                </div>
                            </div>
                            <div class="bkt-card-infographics bkt-wrapper-between bkt-nowrap">
                                <div class="bkt-card outline">
                                    <div class="bkt-card__feature text-center w-100 mt-0">
                                        <h5 class="bkt-card__subtitle">шаг аукциона</h5>
                                        <h4 class="bkt-card__title bkt-text-primary">
                                            {{item.stepPrice && item.stepPrice.value ? item.stepPrice.value : '0' |
                                            priceFormat}}
                                            {{item.stepPrice && item.stepPrice.type=='rubles' ? '₽' : '%'}}
                                        </h4>
                                    </div>
                                </div>
                                <div class="bkt-card outline">
                                    <div class="bkt-card__feature text-center w-100 mt-0">
                                        <h5 class="bkt-card__subtitle">задаток</h5>
                                        <h4 class="bkt-card__title bkt-text-red">
                                            {{item.deposit && item.deposit.value ? item.deposit.value : '0' |
                                            priceFormat}}
                                            {{item.deposit && item.deposit.type=='rubles' ? '₽' : '%'}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bkt-card-trade__periods">
                            <div class="bkt-card-period" v-if="item.trade && item.trade.applicationTime
                                 && (item.trade.applicationTime.start || item.trade.applicationTime.end)"
                            >
                                <div class="bkt-card__category bkt-bg-primary-lighter">
                                    <bkt-icon :name="'Date'" :color="'primary'" :width="'16px'"
                                              :height="'16px'"></bkt-icon>
                                </div>
                                <div class="bkt-card_feature">
                                    <h6><strong>прием заявок</strong></h6>
                                    <h6 v-if="item.trade.applicationTime.start"> с {{item.trade.applicationTime.start |
                                        moment('DD MMMM YYYY')}}
                                        <span class="bkt-text-blue">{{item.trade.applicationTime.start| moment('HH:mm')}}</span>
                                    </h6>
                                    <h6 v-if="item.trade.applicationTime.end">до {{item.trade.applicationTime.end |
                                        moment('DD MMMM YYYY')}}
                                        <span
                                            class="bkt-text-blue">{{item.trade.applicationTime.end | moment('HH:mm')}}</span>
                                    </h6>
                                </div>
                            </div>
                            <div class="bkt-card-period"
                                 v-if="item.trade && item.trade.eventTime && (item.trade.eventTime.start ||item.trade.eventTime.end)"
                            >
                                <div class="bkt-card__category bkt-bg-primary-lighter">
                                    <bkt-icon :name="'Alarm'" :color="'primary'" :width="'16px'"
                                              :height="'16px'"></bkt-icon>
                                </div>
                                <div class="bkt-card_feature">
                                    <h6><strong>{{item.trade.eventTime.result ? 'объявление результатов торгов' : 'проведение торгов'}}</strong></h6>
                                    <div>
                                        <h6 v-if="item.trade.eventTime.start">
                                            с {{item.trade.eventTime.start | moment('DD MMMM YYYY')}}
                                            <span class="bkt-text-yellow">
                                    {{item.trade.eventTime.start | moment('HH:mm')}}
                                </span>
                                        </h6>
                                        <h6 v-if="item.trade.eventTime.end">до
                                            {{item.trade.eventTime.end | moment('DD MMMM YYYY')}}
                                            <span class="bkt-text-yellow">
                                    {{item.trade.eventTime.end | moment('HH:mm')}}
                                </span>
                                        </h6>
                                        <h6 v-if="item.trade.eventTime.result">
                                            {{item.trade.eventTime.result | moment('DD MMMM YYYY')}}
                                            <span class="bkt-text-yellow">
                                                {{item.trade.eventTime.result | moment('HH:mm')}}
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-12 p-0 px-sm-2 order-4 align-self-end" v-if="cadastralData">
                    <div class="bkt-wrapper-between bkt-card-trade__cadastral-info">
                        <div class="bkt-card__row outline bkt-wrapper-between align-items-center"
                             v-if="cadastralData.cadastralDataArea">
                            <div class="bkt-card__feature">
                                <h4 class="bkt-card__title">{{cadastralData.cadastralDataArea | priceFormat}} кв. м.</h4>
                                <h6 class="bkt-card__subtitle">земельный участок</h6>
                            </div>
                            <span class="bkt-card__icon">
                            <bkt-icon :name="'Tree'"></bkt-icon>
                        </span>
                        </div>
                        <div class="bkt-card__row outline bkt-wrapper-between align-items-center"
                             v-if="cadastralData.cadastralDataPrice">
                            <div class="bkt-card__feature">
                                <h4 class="bkt-card__title">{{cadastralData.cadastralDataPrice | priceFormat}} ₽</h4>
                                <h6 class="bkt-card__subtitle">кадастровая стоимость</h6>
                            </div>
                            <span class="bkt-card__icon">
                            <bkt-icon :name="'File'"></bkt-icon>
                        </span>
                        </div>
                        <div class="bkt-card__row outline bkt-wrapper-between align-items-center"
                             v-if="cadastralData.cadastralDataFractionalOwnership">
                            <div class="bkt-card__feature">
                                <h4 class="bkt-card__title">{{cadastralData.cadastralDataFractionalOwnership}}%</h4>
                                <h6 class="bkt-card__subtitle">доля в собственности</h6>
                            </div>
                            <span class="bkt-card__icon">
                                <bkt-icon :name="'Pie'"></bkt-icon>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2 col-lg-1 p-0 d-none d-lg-block">
            <card-actions :item="item" class="bkt-card bkt-bg-main vertical m-0" button_type="-ellipse"></card-actions>
            <!--            <div class="bkt-card bkt-bg-main vertical m-0">-->
            <!--                <button class="bkt-button-ellipse main-light">-->
            <!--                    <bkt-icon class="bkt-button__icon" :name="'Eye'" :width="'20px'" :height="'18px'"></bkt-icon>-->
            <!--                </button>-->
            <!--                <button class="bkt-button-ellipse main-light">-->
            <!--                    <bkt-icon class="bkt-button__icon" :name="'Pencil'"></bkt-icon>-->
            <!--                </button>-->
            <!--                <button class="bkt-button-ellipse main-light">-->
            <!--                    <bkt-icon class="bkt-button__icon" :name="'Target'"></bkt-icon>-->
            <!--                </button>-->
            <!--                <button class="bkt-button-ellipse main-light">-->
            <!--                    <bkt-icon class="bkt-button__icon" :name="'Star'"></bkt-icon>-->
            <!--                </button>-->
            <!--                <button class="bkt-button-ellipse main-light">-->
            <!--                    <span class="info"></span>-->
            <!--                    <bkt-icon class="bkt-button__icon" :name="'Bell'"></bkt-icon>-->
            <!--                </button>-->
            <!--                <button class="bkt-button-ellipse main-light">-->
            <!--                    <bkt-icon class="bkt-button__icon" :name="'Clip'" :width="'15px'" :height="'19px'"></bkt-icon>-->
            <!--                </button>-->
            <!--                <button class="bkt-button-ellipse">-->
            <!--                    <bkt-icon class="bkt-button__icon" :name="'Trash'"></bkt-icon>-->
            <!--                </button>-->
            <!--            </div>-->
        </div>
    </div>
</template>

<script>
    import {
        Hooper,
        Slide,
        Navigation as HooperNavigation
    } from 'hooper';
    import 'hooper/dist/hooper.css';
    import CardActions from "./CardActions";
    import CardImageCategory from "./CardImageCategory";

    export default {
        props: {
            item: {
                type: Object,
            },
            in_process: {
                type: Array,
                default: function () {
                    return [];
                }
            }
        },
        components: {
            Hooper,
            Slide,
            HooperNavigation,
            CardActions,
            CardImageCategory
        },
        data() {
            return {}
        },
        computed: {
            cadastralData() {
                if (this.item.descriptionExtracts && this.item.descriptionExtracts.length > 0) {
                    if (this.item.descriptionExtracts[0].extracts.length > 0) {
                        let extracts = this.item.descriptionExtracts[0].extracts;
                        let cadastralData = {};
                        let index = extracts.findIndex(item => item.type == 'cadastralDataPrice')
                        if (index >= 0) {
                            cadastralData.cadastralDataPrice = extracts[index].value;
                        }
                        index = extracts.findIndex(item => item.type == 'cadastralDataArea')
                        if (index >= 0) {
                            cadastralData.cadastralDataArea = extracts[index].value;
                        }
                        index = extracts.findIndex(item => item.type == 'cadastralDataFractionalOwnership')
                        if (index >= 0) {
                            cadastralData.cadastralDataFractionalOwnership = extracts[index].value;
                        }
                        return cadastralData == {} ? null : cadastralData
                    }


                }
                return null;
            }
        },
        methods: {
            sendApplication() {
                this.$store.commit('setSelectedLot', this.item);
                this.$store.commit('openModal', '#applicationModal')
            },
            dateIsPast(date) {
                return this.$moment(date).isAfter(this.$moment())
            }
        }
    };
</script>

<style scoped>
</style>
