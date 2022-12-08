<template>
    <div class="bkt-card-trade__wrapper w-100" :class="{'bkt-shadow-card bkt-shadow-card_white': item && item.trade && item.trade.lotCount>1}">
        <div class="bkt-card-trade bkt-card__row w-100 mx-auto mx-0">
            <div class="bkt-wrapper-between bkt-card__heading w-100" v-if="item && item.trade">
                <h5 class="me-auto">торги № {{item.trade.externalId ? item.trade.externalId : '0'}}
                    <span class="bkt-text-neutral-dark"> • </span>
                    <span v-if="item.trade.publishDate">  {{item.trade.publishDate | moment('DD MMMM YYYY HH:mm')}}</span>
                </h5>
            </div>
            <div class="col-12 col-lg-11 p-0">
                <div class="row h-100 w-100 mx-auto row-cols-1 row-cols-lg-4 bkt-card-trade__gap">
                    <div class="col-12 col-lg-2 p-0 pe-md-2">
                        <div class="bkt-wrapper-down-lg bkt-nowrap bkt-gap align-items-start">
                            <div class="bkt-card__image-wrapper" :class="{'bkt-gap-none': !realEstate}">
                                <div class="position-relative">
                                    <div class="bkt-cursor-pointer" @click="navigate"
                                         v-if="item && (!item.photos || item.photos.length==0) && item.categories"
                                    >
                                        <card-image-category :categories="item.categories"></card-image-category>
                                    </div>
                                    <hooper :itemsToShow="1" :centerMode="true" class="bkt-card__image-slider"
                                            v-if="item.photos.length>0">
                                        <slide v-for="photo in item.photos" :key="photo.id">
                                            <img v-lazy="photo.preview" class="bkt-card__image bkt-cursor-pointer"
                                                 @click="navigate"/>
                                        </slide>
                                        <hooper-navigation slot="hooper-addons"></hooper-navigation>
                                    </hooper>
                                    <div class="bkt-card__image-status bkt-cursor-pointer" v-if="item.isWatched">
                                        Просмотрено
                                    </div>
                                </div>

                                <button class="bkt-button bkt-card-trade__button bkt-card-trade__button_egrn d-none d-lg-block"
                                        @click="buyEgrn" v-if="realEstate && cadastralData && cadastralData.cadastralNumber"
                                        :disabled="loading"
                                >
                                    <span v-show="loading" class="spinner-border spinner-border-sm"
                                          role="status"></span>
                                    Выписка ЕГРН
                                </button>
                            </div>
                            <div class="bkt-wrapper-column d-lg-none">
                                <div class="bkt-wrapper-between bkt-gap-large bkt-gap-down-sm bkt-nowrap">
                                    <router-link :to="'/lot/'+item.id" class="bkt-card__title bkt-text-truncate-1" style="word-break: break-all">
                                        {{item && item.description ? item.description:'Некоторое название торгов'}}
                                    </router-link>
                                    <div class="d-flex bkt-gap-small">
                                        <bkt-icon class="bkt-card-trade__icon" v-if="item.favouritePaths && item.favouritePaths.length>0" :name="'Star'"
                                                  :color="item.favouritePaths[0].color ? item.favouritePaths[0].color : 'yellow'"
                                        >
                                        </bkt-icon>
                                        <bkt-icon class="bkt-card-trade__icon" v-if="item.isPinned" :name="'Pin'" :color="'primary'">
                                        </bkt-icon>
                                    </div>
                                </div>
                                <div class="d-flex bkt-gap-small" v-if="item.location && item.location.length>0">
                                    <bkt-icon :name="'Location'" :color="'neutral'" :width="'14px'" :height="'14px'">
                                    </bkt-icon>
                                    <h5 class="bkt-card__text">{{$t('regions.'+item.location[0].code)}}</h5>
                                </div>
                                <div class="d-flex bkt-gap-small">
                                    <bkt-icon :name="'Gavel'" :color="'neutral'" :width="'14px'" :height="'14px'"></bkt-icon>
                                    <h5 class="bkt-card__text">{{item.trade && item.trade.type ? $t('trades.type.'+item.trade.type) : ''}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-5 p-0 px-lg-2">
                        <div class="bkt-card__head d-none d-lg-block">
                            <router-link :to="'/lot/'+item.id" class="bkt-card__title bkt-text-truncate-1">
                                {{item && item.description ? item.description:'Некоторое название торгов'}}
                            </router-link>
                        </div>
                        <div class="bkt-card-trade__gap bkt-wrapper-column">
                            <div class="bkt-card__feature" v-if="item.descriptionExtracts && item.descriptionExtracts.length>1">
                                <h6 class="bkt-card__subtitle">объектов недвижимости</h6>
                                <h5 class="bkt-card__text bkt-text-700">
                                    {{item.descriptionExtracts.length}}
                                </h5>
                            </div>
                            <div class="bkt-card__features d-none d-sm-flex" v-if="cadastralData">
                                <div class="bkt-card__feature" v-if="cadastralData.cadastralNumber">
                                    <h6 class="bkt-card__subtitle">кадастровый номер</h6>
                                    <h5 class="bkt-card__text bkt-text-700">
                                        {{cadastralData.cadastralNumber}}
                                    </h5>
                                </div>
                                <div class="bkt-card__feature" v-if="cadastralData.cadastralDataArea">
                                    <h6 class="bkt-card__subtitle">площадь</h6>
                                    <h5 class="bkt-card__text bkt-text-700">
                                        {{cadastralData.cadastralDataArea | priceFormat}}
                                        {{cadastralData.cadastralDataAreaMeasure}}
                                    </h5>
                                </div>
                                <div class="bkt-card__feature" v-if="cadastralData.cadastralDataPrice">
                                    <h6 class="bkt-card__subtitle">кадастровая стоимость</h6>
                                    <h5 class="bkt-card__text bkt-text-700">
                                        {{cadastralData.cadastralDataPrice | priceFormat}} ₽
                                    </h5>
                                </div>
                                <div class="bkt-card__feature" v-if="cadastralData.cadastralDataFractionalOwnership">
                                    <h6 class="bkt-card__subtitle">доля в собственности</h6>
                                    <h5 class="bkt-card__text bkt-text-700">
                                        {{cadastralData.cadastralDataFractionalOwnership}} %
                                    </h5>
                                </div>
                            </div>
                            <div class="bkt-card__feature" v-if="item.description">
                                <h6 class="bkt-card__subtitle d-none d-sm-block">описание</h6>
                                <h5 class="bkt-card__text bkt-text-truncate-8">
                                    {{item.description}}
                                </h5>
                            </div>
                            <button class="bkt-button bkt-card-trade__button bkt-card-trade__button_more d-none d-lg-block"
                                    @click="navigate"
                            >
                                Подробнее о лоте
                            </button>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 p-0">
                        <div class="bkt-card-trade__gap bkt-wrapper-column">
                            <div class="d-flex bkt-gap d-none d-lg-flex" v-if="item.location && item.location.length>0">
                                <bkt-icon :name="'Location'" :color="'neutral'" :width="'14px'" :height="'14px'">
                                </bkt-icon>
                                <h5 class="bkt-card__text">{{$t('regions.'+item.location[0].code)}}</h5>
                            </div>
                            <div class="d-flex bkt-gap d-none d-lg-flex">
                                <bkt-icon :name="'Gavel'" :color="'neutral'" :width="'14px'" :height="'14px'"></bkt-icon>
                                <h5 class="bkt-card__text">{{item.trade && item.trade.type ? $t('trades.type.'+item.trade.type) : ''}}</h5>
                            </div>
                            <div class="bkt-wrapper-column bkt-gap-mini">
                                <div class="bkt-wrapper-between">
                                    <!--                                 v-if="(item.state == 'biddingDeclared' || item.state == 'biddingStart'
                                                                     || item.state == 'applicationSessionStarted') && dateStatus"-->
                                    <h5 class="bkt-card__text">
                                        <span v-if="dateStatus && dateStatus.status === 'application'">
                                            Приём заявок ещё {{ dateStatus.days }} {{$tc('trades.days', pluralization( dateStatus.days))}}
                                        </span>
                                        <span v-else>
                                            {{item.state ? $t('trades.state.'+item.state) : ''}}
                                        </span>
                                        <!--                                    <span v-else-if="dateStatus && dateStatus.status === 'bidding-end'">Торги</span>-->
                                        <!--                                    <span v-else-if="dateStatus && dateStatus.status === 'bidding-result'">До объявления результатов торгов</span>-->
                                    </h5>
                                    <h5 class="bkt-card__text">
                                        <span v-if="item.trade.applicationTime.end && dateStatus && dateStatus.status === 'application'">
                                            до {{item.trade.applicationTime.end | moment('DD.MM.YYYY')}}
                                        </span>
                                        <span v-if="item.trade.applicationTime.start && (item.state==='BiddingDeclaration' || item.state==='biddingDeclaration')">
                                            приём заявок с {{item.trade.applicationTime.start | moment('DD.MM.YYYY')}}
                                        </span>
                                    </h5>
                                </div>
                                <div class="bkt-progress-bar" :class="progressColor">
                                    <div v-if="dateStatus && dateStatus.percent && dateStatus.percent>0" class="bkt-progress-bar__progress"
                                         :style="'width: '+dateStatus.percent+'%;'">
                                    </div>
                                </div>
                            </div>
                            <div class="bkt-card__features-wrapper">
                                <div class="bkt-card__features">
                                    <div class="bkt-card__feature" v-if="item.minPrice && item.trade.type!=='CloseAuction' && item.trade.type!=='OpenAuction'">
                                        <h6 class="bkt-card__subtitle">минимальная цена</h6>
                                        <h5 class="bkt-card__text bkt-text-700">
                                            {{ item.minPrice | priceFormat}} ₽
                                        </h5>
                                    </div>
                                    <div class="bkt-card__feature"
                                         v-if="item&&item.trade&&(item.trade.type==='CloseAuction' || item.trade.type==='OpenAuction')"
                                    >
                                        <h6 class="bkt-card__subtitle">шаг аукциона</h6>
                                        <h5 class="bkt-card__text bkt-text-700">
                                            {{item.stepPrice && item.stepPrice.value ? item.stepPrice.value : '0' |
                                            priceFormat}}
                                            {{item.stepPrice && item.stepPrice.type=='rubles' ? '₽' : '%'}}
                                        </h5>
                                    </div>
                                    <div class="bkt-card__feature" v-if="item.deposit">
                                        <h6 class="bkt-card__subtitle">задаток</h6>
                                        <h5 class="bkt-card__text bkt-text-red bkt-text-700">
                                            {{item.deposit && item.deposit.value ? item.deposit.value : '0' |
                                            priceFormat}}
                                            {{item.deposit && item.deposit.type=='rubles' ? '₽' : '%'}}
                                        </h5>
                                    </div>
                                </div>
                                <div class="bkt-wrapper-between bkt-nowrap bkt-gap-small">
                                    <div class="bkt-card__feature w-100 mt-0">
                                        <h6 class="bkt-card__subtitle">текущая цена</h6>
                                        <h3 class="bkt-text-700 d-flex align-items-center bkt-gap-mini bkt-card-trade__price"
                                            :class="{'bkt-text-red': item.currentPriceState=='down',
                                'bkt-text-green':item.currentPriceState=='up'} "
                                        >
                                            {{item && item.currentPrice ? item.currentPrice : '0' | priceFormat}} ₽
                                            <bkt-icon  v-if="item.currentPriceState!=='hold'"
                                                       :name="'ArrowTriple'" :width="'22px'" :height="'22px'"
                                                       :color="item.currentPriceState=='down' ? 'red' : 'green'"
                                                       :class="{'bkt-rotate-180': item.currentPriceState=='down'}"
                                            >
                                            </bkt-icon>
                                        </h3>
                                    </div>
                                    <button class="bkt-button primary bkt-card-trade__button bkt-card-trade__button_buy d-none d-lg-block"
                                            @click="callPurchaseModal"
                                    >
                                        Купить
                                    </button>
                                    <div class="d-lg-none">
                                        <card-actions :item="item"  button_type="-ellipse m-0" place="dropdown"
                                                      @changeStatus="changeStatus" main_bg="bkt-bg-body" icon_color="main"
                                        >
                                        </card-actions>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2 col-lg-1 p-0 d-none d-lg-block">
                <card-actions :item="item" class="bkt-card vertical m-0 gap-0 py-0" button_type="-ellipse"
                              @changeStatus="changeStatus" main_bg="bkt-bg-body" icon_color="main"
                >
                </card-actions>
            </div>
            <div class="bkt-shadow-card__shadow-1">
            </div>
            <div class="bkt-shadow-card__shadow-2">
            </div>
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
                realEstate: false,
                read_more: false,
                loading: false,
            }
        },
        mounted() {
            this.short_description = '';
            if (this.item.description.length > 0 && this.item.description.length > 500) {
                this.short_description = this.item.description.slice(0, 500) + '...';
            }
            let index = this.item.categories.findIndex( item => item.key === 'realEstate');
            if(index >= 0) {
                this.realEstate = true;
            }
        },
        computed: {
            cadastralData() {
                if (this.item.descriptionExtracts && this.item.descriptionExtracts.length == 1) {
                    // let tmp = this.item.descriptionExtracts.filter(el => {
                    //     if (el.extracts.length > 0) {
                    //         let index_price = el.extracts.findIndex(item => item.type == 'cadastralDataPrice' && item.value && item.value != 0);
                    //         let index_area = el.extracts.findIndex(item => item.type == 'cadastralDataArea' && item.value && item.value != 0)
                    //         if (index_price >= 0 && index_area >= 0) {
                    //             return true
                    //         }
                    //     }
                    //     return false
                    // })
                    let tmp = this.item.descriptionExtracts[0];
                    if (tmp.extracts.length > 0) {
                        let extracts = tmp.extracts;
                        let cadastralData = {};
                        let index = extracts.findIndex(item => item.type == 'cadastralDataPrice')
                        if (index >= 0) {
                            cadastralData.cadastralDataPrice = extracts[index].value;
                        }
                        index = extracts.findIndex(item => item.type == 'cadastralDataArea')
                        if (index >= 0) {
                            cadastralData.cadastralDataAreaType = tmp.type;
                            cadastralData.cadastralDataArea = extracts[index].value;
                            cadastralData.cadastralDataAreaMeasure = 'кв. м.';
                            if( cadastralData.cadastralDataAreaType === 'landPlot')
                            {
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
                        }
                        index = extracts.findIndex(item => item.type == 'cadastralDataFractionalOwnership')
                        if (index >= 0) {
                            cadastralData.cadastralDataFractionalOwnership = extracts[index].value;
                        }
                        index = extracts.findIndex(item => item.type == 'cadastralNumber')
                        if (index >= 0) {
                            cadastralData.cadastralNumber = extracts[index].value;
                        }
                        return cadastralData == {} ? null : cadastralData
                    }
                }
                return null;
            },
            dateStatus() {
                let days = 0;
                let percent = 0;
                if (this.item.state === 'applicationSessionStarted' && this.item.trade.applicationTime
                    && this.item.trade.applicationTime.end && this.dateIsFuture(this.item.trade.applicationTime.end)
                )
                {
                    days = this.countDays(this.item.trade.applicationTime.end);
                    if (days > 0) {
                        percent = 100 - days/this.countDays(this.item.trade.applicationTime.end,this.item.trade.applicationTime.start)*100;
                        return {status: 'application', days: days, percent: percent};
                    }
                }
                else if (this.item.trade.eventTime && (this.item.state === 'biddingDeclared' || this.item.state === 'biddingStart')) {
                    if (this.item.trade.eventTime.end && this.dateIsFuture(this.item.trade.eventTime.end)) {
                        days = this.countDays(this.item.trade.eventTime.end);
                        if (days > 0) {
                            // percent = 100 - days/this.countDays(this.item.trade.eventTime.end,this.item.trade.eventTime.start)*100;
                            return {status: 'bidding-end', days: days, percent: 0};
                        }
                    } else if (this.item.trade.eventTime.result && this.dateIsFuture(this.item.trade.eventTime.result)) {
                        days = this.countDays(this.item.trade.eventTime.result);
                        if (days > 0) {
                            return {status: 'bidding-result', days: days};
                        }
                    }
                }
                return null;
            },
            progressColor() {
                let tmp_state = this.item.state.toLowerCase();
                if(tmp_state === 'biddingcanceled' || tmp_state === 'finished' || tmp_state === 'annulment' || tmp_state === 'biddingpause')
                {
                    return 'bkt-bg-neutral-lighter'
                }
                if(tmp_state === 'biddingfail') {
                    return 'bkt-bg-red-lighter'
                }
                return 'bkt-bg-main-lighter'
            }
        },
        methods: {
            sendApplication() {
                this.$store.commit('setSelectedLot', this.item);
                this.$store.commit('openModal', '#applicationModal')
            },
            callPurchaseModal() {
                this.$store.commit('setSelectedLot', this.item);
                this.$store.commit('openModal', '#purchaseModal')
            },
            dateIsFuture(date) {
                if (date) {
                    const start = this.$moment(date);
                    const end = this.$moment();
                    return start.isAfter(end);
                }
                return false
            },
            countDays(start_date, end_date) {
                if (start_date) {
                    const start = this.$moment(start_date);
                    let end = this.$moment();
                    if(end_date) {
                        end = this.$moment(end_date);
                    }
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
            },
            buyEgrn() {
                this.item.cadastralData = this.cadastralData;
                this.$store.commit('setSelectedLot', this.item);
                this.$store.commit('openModal', '#egrnModal')
                // this.loading = true;
                // let data = {
                //     cadastralNumber: this.cadastralData.cadastralNumber,
                //     lotId: this.item.id
                // }
                // axios.post('/api/send/receipt/egrn', data)
                //     .then(resp => {
                //         this.loading = false;
                //         window.location.replace(resp.data.redirectUrl)
                //     })
                //     .catch(error => {
                //         this.loading = false;
                //         this.$store.dispatch('sendNotification',
                //             {self: this, type: 'error', message: 'Произошла ошибка, попробуйте позже'});
                //     })
            }
        }
    };
</script>

<style scoped>
</style>
