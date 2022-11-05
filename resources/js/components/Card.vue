<template>
    <div class="bkt-card-trade bkt-card__row w-100 mx-auto mx-0">
        <div class="bkt-wrapper-between bkt-card__heading w-100" v-if="item && item.trade">
            <h5 class="me-auto">торги № {{item.trade.externalId ? item.trade.externalId : '0'}} |
                <span v-if="item.trade.publishDate">  {{item.trade.publishDate | moment('DD MMMM YYYY HH:mm')}}</span>
            </h5>
            <div class="d-flex align-items-center bkt-gap-mini"
                 v-if="item.state == 'biddingDeclared' || item.state == 'biddingStart'
                 || item.state == 'applicationSessionStarted'"
            >
                <h5 v-if="dateStatus && dateStatus.status === 'application'">
                    дней до окончания приёма заявок: {{ dateStatus.days }}
                </h5>
                <h5 v-else-if="dateStatus && dateStatus.status === 'bidding-end'">
                    дней до окончания торгов: {{dateStatus.days}}
                </h5>
                <h5 v-else-if="dateStatus && dateStatus.status === 'bidding-result'">
                    дней до объявления результатов торгов: {{dateStatus.days}}
                </h5>
                <!--                <div class="bkt-card__icon" v-if="dateStatus">-->
                <!--                    <bkt-icon :name="'Alarm'" :color="'green'" :width="'14px'" :height="'14px'"></bkt-icon>-->
                <!--                </div>-->
            </div>
        </div>
        <div class="col-12 col-lg-11 p-0">
            <div class="row h-100 w-100 mx-auto row-cols-1 row-cols-md-2 row-cols-lg-3 bkt-card-trade__wrapper">
                <div class="col p-0 px-sm-2 order-2 order-lg-1">
                    <div class="bkt-card__image-wrapper">
                        <div class="bkt-cursor-pointer" @click="navigate"
                             v-if="item && (!item.photos || item.photos.length==0) && item.categories"
                        >
                            <card-image-category :categories="item.categories"></card-image-category>
                        </div>
                        <!--                        <img v-lazy="'/images/card-image1.png'" class="bkt-card__image"-->
                        <!--                             v-if="!item.photos || item.photos.length==0"/>-->
                        <hooper :itemsToShow="1" :centerMode="true" class="bkt-card__image-slider"
                                v-if="item.photos.length>0">
                            <slide v-for="photo in item.photos" :key="photo.id">
                                <img v-lazy="photo.preview" class="bkt-card__image bkt-cursor-pointer"
                                     @click="navigate"/>
                            </slide>
                            <hooper-navigation slot="hooper-addons"></hooper-navigation>
                        </hooper>
                        <div class="bkt-wrapper-between bkt-card-ecp-wrapper d-none d-md-flex">
                            <button @click="sendApplication" class="bkt-button primary bkt-card-ecp w-100">
                                Купить без ЭЦП
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 p-0 px-sm-2 order-1 order-lg-2">
                    <div class="bkt-wrapper-between bkt-card__head bkt-nowrap bkt-gap-small">
                        <router-link :to="'/lot/'+item.id" class="bkt-card__title bkt-text-truncate-3">
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
                                <card-actions :item="item" class="bkt-card-menu-inner" type="menu"
                                              @changeStatus="changeStatus"
                                >
                                </card-actions>
                            </div>
                        </div>
                        <!--                        <button class="bkt-button bkt-bg-primary-lighter bkt-card-menu-button">-->
                        <!--                            <bkt-icon :name="'More'"></bkt-icon>-->
                        <!--                        </button>-->
                    </div>
                    <div class="d-none d-lg-block">
                        <template v-if="item.location && item.location.length>0">
                            <div class="bkt-card__feature" v-for="location in item.location.slice(0, 3)">
                                <h6 class="bkt-card__subtitle">
                                    регион {{location.isDebtorRegion ? 'должника' : 'объекта'}}
                                </h6>
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
                    <!--                    <div class="d-lg-none d-flex flex-wrap bkt-gap-mini">-->
                    <!--                        <template v-if="item.location && item.location.length>0">-->
                    <!--                            <div class="bkt-badge bkt-bg-primary m-0" v-for="location in item.location.slice(0, 3)"-->
                    <!--                            style="font-size: 10px;">-->
                    <!--                               {{$t('regions.'+location.code)}}-->
                    <!--                            </div>-->
                    <!--                        </template>-->

                    <!--                        <div class="bkt-badge bkt-bg-primary m-0" style="font-size: 10px;">-->
                    <!--                            {{item.trade && item.trade.type ? $t('trades.type.'+item.trade.type) : ''}}-->
                    <!--                        </div>-->
                    <!--                        <div class="bkt-badge bkt-bg-primary m-0" style="font-size: 10px;">-->
                    <!--                            {{item.state ? $t('trades.state.'+item.state) : ''}}-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>
                <div class="col order-3 p-0 px-sm-2">
                    <div class="bkt-card-trade__wrapper bkt-wrapper-column">
                        <div class="bkt-wrapper-column bkt-gap-small order-2 order-md-1">
                            <div class="bkt-card-trade__price-wrapper bkt-button w-100"
                                 :class="{'bkt-bg-red': item.currentPriceState=='down',
                                  'bkt-bg-green': item.currentPriceState=='up',
                                  'bkt-bg-primary-lighter': item.currentPriceState=='hold'}">
                                <div class="m-auto" :class="{'bkt-text-primary': item.currentPriceState=='hold'}">
                                    <h5 class="bkt-card__subtitle text-truncate">текущая цена</h5>
                                    <h2 class="bkt-card-trade__price text-truncate">
                                        {{item && item.currentPrice ? item.currentPrice : '0' | priceFormat}} ₽
                                    </h2>
                                </div>

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
                                <div class="bkt-card outline"
                                     v-if="item&&item.trade&&(item.trade.type==='CloseAuction' || item.trade.type==='OpenAuction')"
                                >
                                    <div class="bkt-card__feature text-center w-100 mt-0">
                                        <h5 class="bkt-card__subtitle">шаг аукциона</h5>
                                        <h4 class="bkt-card__title bkt-text-primary">
                                            {{item.stepPrice && item.stepPrice.value ? item.stepPrice.value : '0' |
                                            priceFormat}}
                                            {{item.stepPrice && item.stepPrice.type=='rubles' ? '₽' : '%'}}
                                        </h4>
                                    </div>
                                </div>
                                <div class="bkt-card outline" v-if="item.deposit">
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
                            <button @click="sendApplication" class="bkt-button primary bkt-card-ecp w-100 d-md-none">
                                Купить без ЭЦП
                            </button>
                        </div>
                        <div class="bkt-card-trade__periods order-1 order-md-2">
                            <div class="bkt-form row-cols-2 row-cols-lg-1">
                                <div class="col-12 d-md-none" v-if="item && item.description">
                                    <p class="bkt-card__text mb-0" style="font-size: 10px; text-align: justify;">
                                        {{!short_description ? item.description : short_description}}
                                    </p>
                                    <button class="bkt-button bkt-text-primary float-end px-0 text-uppercase"
                                            @click="navigate" style="padding: 5px; font-size: 11px;">
                                        Подробнее
                                        <bkt-icon name="ArrowDown" color="primary" height="14px"
                                                  class="bkt-rotate-270"></bkt-icon>
                                    </button>
                                </div>
                                <div class="col-12 d-md-none" v-if="cadastralData">
                                    <div class="bkt-wrapper-between bkt-card-trade__cadastral-info">
                                        <div class="bkt-card__row outline bkt-wrapper-between align-items-center"
                                             v-if="cadastralData.cadastralDataArea">
                                            <div class="bkt-card__feature">
                                                <h4 class="bkt-card__title">
                                                    {{cadastralData.cadastralDataArea | priceFormat}}
                                                    {{cadastralData.cadastralDataAreaMeasure}}
                                                </h4>
                                                <h6 class="bkt-card__subtitle text-lowercase">
                                                    {{$t('trades.tradeSubjectType.'+cadastralData.cadastralDataAreaType)}}
                                                </h6>
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
                                <div class="col">
                                    <div class="bkt-card-period bkt-gap-small" v-if="item.trade && item.trade.applicationTime
                                && (item.trade.applicationTime.start || item.trade.applicationTime.end)"
                                    >
                                        <div class="bkt-card__category bkt-bg-primary-lighter">
                                            <bkt-icon :name="'Alarm'" :color="'primary'" :width="'16px'"
                                                      :height="'16px'">
                                            </bkt-icon>
                                        </div>
                                        <div class="bkt-card_feature">
                                            <h6 class="bkt-card__subtitle">прием заявок</h6>
                                            <h6 v-if="item.trade.applicationTime.start" class="bkt-card__text">с
                                                {{item.trade.applicationTime.start | moment('DD MMMM YYYY')}}
                                                <span class="bkt-text-blue">
                                                    {{item.trade.applicationTime.start| moment('HH:mm')}}
                                                </span>
                                            </h6>
                                            <h6 v-if="item.trade.applicationTime.end" class="bkt-card__text">до
                                                {{item.trade.applicationTime.end |moment('DD MMMM YYYY')}}
                                                <span class="bkt-text-blue">
                                                    {{item.trade.applicationTime.end | moment('HH:mm')}}
                                                </span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col" v-if="item.trade && item.trade.eventTime
                                 && (item.trade.eventTime.start || item.trade.eventTime.end)">
                                    <div class="bkt-card-period bkt-gap-small">
                                        <div class="bkt-card__category bkt-bg-primary-lighter">
                                            <bkt-icon :name="'Gavel'" :color="'primary'" :width="'22px'"
                                                      :height="'22px'">
                                            </bkt-icon>
                                        </div>
                                        <div class="bkt-card_feature">
                                            <h6 class="bkt-card__subtitle d-none d-lg-block">
                                                {{item.trade.eventTime.result ? 'объявление результатов торгов' :
                                                'проведение торгов'}}
                                            </h6>
                                            <h6 class="bkt-card__subtitle d-block d-lg-none">
                                                {{item.trade.eventTime.result ? 'результат торгов' :
                                                'провед. торгов'}}
                                            </h6>
                                            <div>
                                                <h6 v-if="item.trade.eventTime.start" class="bkt-card__text">
                                                    с {{item.trade.eventTime.start | moment('DD MMMM YYYY')}}
                                                    <span class="bkt-text-yellow">
                                                {{item.trade.eventTime.start | moment('HH:mm')}}
                                            </span>
                                                </h6>
                                                <h6 v-if="item.trade.eventTime.end" class="bkt-card__text">до
                                                    {{item.trade.eventTime.end | moment('DD MMMM YYYY')}}
                                                    <span class="bkt-text-yellow">
                                                {{item.trade.eventTime.end | moment('HH:mm')}}
                                            </span>
                                                </h6>
                                                <h6 v-if="item.trade.eventTime.result" class="bkt-card__text">
                                                    {{item.trade.eventTime.result | moment('DD MMMM YYYY')}}
                                                    <span class="bkt-text-yellow">
                                                {{item.trade.eventTime.result | moment('HH:mm')}}
                                            </span>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col d-lg-none">
                                    <div class="bkt-card-period bkt-gap-small">
                                        <div class="bkt-card__category bkt-bg-primary-lighter">
                                            <bkt-icon :name="'Hamer'" :color="'primary'" :width="'22px'"
                                                      :height="'22px'">
                                            </bkt-icon>
                                        </div>
                                        <div class="bkt-card__feature">
                                            <h6 class="bkt-card__subtitle">тип торгов</h6>
                                            <h6 class="bkt-card__text">
                                                {{item.trade && item.trade.type ? $t('trades.type.'+item.trade.type) :
                                                ''}}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col d-lg-none">
                                    <div class="bkt-card-period bkt-gap-small">
                                        <div class="bkt-card__category bkt-bg-primary-lighter">
                                            <bkt-icon :name="'Hamer'" :color="'primary'" :width="'22px'"
                                                      :height="'22px'">
                                            </bkt-icon>
                                        </div>
                                        <div class="bkt-card__feature">
                                            <h6 class="bkt-card__subtitle">статус торгов</h6>
                                            <h6 class="bkt-card__text">
                                                {{item.state ? $t('trades.state.'+item.state) : ''}}</h6>
                                        </div>
                                    </div>
                                </div>
                                <template v-if="item.location && item.location.length>0">
                                    <div class="col d-lg-none" v-for="location in item.location.slice(0, 3)">
                                        <div class="bkt-card-period bkt-gap-small">
                                            <div class="bkt-card__category bkt-bg-primary-lighter">
                                                <bkt-icon :name="'Location'" :color="'primary'" :width="'22px'"
                                                          :height="'22px'">
                                                </bkt-icon>
                                            </div>
                                            <div class="bkt-card__feature">
                                                <h6 class="bkt-card__subtitle">
                                                    регион {{location.isDebtorRegion ? 'должника' : 'объекта'}}
                                                </h6>
                                                <h6 class="bkt-card__text">{{$t('regions.'+location.code)}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-12 p-0 px-sm-2 order-4 align-self-end d-none d-md-block" v-if="cadastralData">
                    <div class="bkt-wrapper-between bkt-card-trade__cadastral-info">
                        <div class="bkt-card__row outline bkt-wrapper-between align-items-center"
                             v-if="cadastralData.cadastralDataArea">
                            <div class="bkt-card__feature">
                                <h4 class="bkt-card__title">
                                    {{cadastralData.cadastralDataArea | priceFormat}}
                                    {{cadastralData.cadastralDataAreaMeasure}}
                                </h4>
                                <h6 class="bkt-card__subtitle text-lowercase">
                                    {{$t('trades.tradeSubjectType.'+cadastralData.cadastralDataAreaType)}}
                                </h6>
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
            <card-actions :item="item" class="bkt-card vertical m-0 gap-0" button_type="-ellipse"
                          @changeStatus="changeStatus" main_bg="bkt-bg-body" icon_color="main"
            >
            </card-actions>
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
        },
        components: {
            Hooper,
            Slide,
            HooperNavigation,
            CardActions,
            CardImageCategory,
        },
        data() {
            return {
                short_description: '',
                read_more: false,
            }
        },
        mounted() {
            this.short_description = '';
            if (this.item.description.length > 0 && this.item.description.length > 500) {
                this.short_description = this.item.description.slice(0, 500) + '...';
            }
        },
        computed: {
            cadastralData() {
                if (this.item.descriptionExtracts && this.item.descriptionExtracts.length > 0) {
                    let tmp = this.item.descriptionExtracts.filter(el => {
                        if (el.extracts.length > 0) {
                            let index_price = el.extracts.findIndex(item => item.type == 'cadastralDataPrice' && item.value && item.value != 0);
                            let index_area = el.extracts.findIndex(item => item.type == 'cadastralDataArea' && item.value && item.value != 0)
                            if (index_price >= 0 && index_area >= 0) {
                                return true
                            }
                        }
                        return false
                    })

                    if (tmp.length > 0 && tmp[0].extracts.length > 0) {
                        let extracts = tmp[0].extracts;
                        let cadastralData = {};
                        let index = extracts.findIndex(item => item.type == 'cadastralDataPrice')
                        if (index >= 0) {
                            cadastralData.cadastralDataPrice = extracts[index].value;
                        }
                        index = extracts.findIndex(item => item.type == 'cadastralDataArea')
                        if (index >= 0) {
                            cadastralData.cadastralDataAreaType = tmp[0].type;
                            cadastralData.cadastralDataArea = extracts[index].value;
                            if (extracts[index].value <= 100) {
                                cadastralData.cadastralDataAreaMeasure = 'кв. м.';
                            } else if (extracts[index].value > 100 && extracts[index].value <= 10000) {
                                cadastralData.cadastralDataArea = extracts[index].value / 100;
                                cadastralData.cadastralDataAreaMeasure = this.$tc('trades.ar', this.pluralization(cadastralData.cadastralDataArea));
                            } else {
                                cadastralData.cadastralDataArea = extracts[index].value / 10000;
                                cadastralData.cadastralDataAreaMeasure = 'га';
                            }
                        }
                        index = extracts.findIndex(item => item.type == 'cadastralDataFractionalOwnership')
                        if (index >= 0) {
                            cadastralData.cadastralDataFractionalOwnership = extracts[index].value;
                        }
                        return cadastralData == {} ? null : cadastralData
                    }
                }
                return null;
            },
            dateStatus() {
                let days = 0;
                if (this.item.state === 'applicationSessionStarted' && this.item.trade.applicationTime
                    && this.item.trade.applicationTime.end && this.dateIsFuture(this.item.trade.applicationTime.end)
                ) {
                    days = this.countDays(this.item.trade.applicationTime.end);
                    if (days > 0) {
                        return {status: 'application', days: days};
                    }

                } else if (this.item.trade.eventTime && (this.item.state === 'biddingDeclared' || this.item.state === 'biddingStart')) {
                    if (this.item.trade.eventTime.end && this.dateIsFuture(this.item.trade.eventTime.end)) {
                        days = this.countDays(this.item.trade.eventTime.end);
                        if (days > 0) {
                            return {status: 'bidding-end', days: days};
                        }
                    } else if (this.item.trade.eventTime.result && this.dateIsFuture(this.item.trade.eventTime.result)) {
                        days = this.countDays(this.item.trade.eventTime.result);
                        if (days > 0) {
                            return {status: 'bidding-result', days: days};
                        }
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
            dateIsFuture(date) {
                if (date) {
                    const start = this.$moment(date);
                    const end = this.$moment();
                    return start.isAfter(end);
                }
                return false
            },
            countDays(date) {
                if (date) {
                    const start = this.$moment(date);
                    const end = this.$moment();
                    return start.diff(end, "days");
                }
                return -1
            },
            changeStatus(payload) {
                this.$emit('changeStatus', payload)
            },
            pluralization(choice, choicesLength = 4) {
                if (choice === 0) {
                    return 0
                }

                const teen = choice > 10 && choice < 20
                const endsWithOne = choice % 10 === 1
                if (!teen && endsWithOne) {
                    return 1
                }
                if (!teen && choice % 10 >= 2 && choice % 10 <= 4) {
                    return 2
                }
                //0 соток | {n} сотка | {n} сотки | {n} соток
                return choicesLength < 4 ? 2 : 3
            },
            navigate() {
                this.$router.push('/lot/' + this.item.id)
            }
        }
    };
</script>

<style scoped>
</style>
