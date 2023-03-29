<template>
    <div class="bkt-card-trade__wrapper w-100"
         :class="{'bkt-shadow-card bkt-shadow-card_white': item && item.trade && item.trade.lotCount>1}">
        <div class="bkt-card-trade bkt-card__row w-100 mx-auto mx-0" @click.self="navigate('mobile')">
            <div class="bkt-wrapper-between bkt-card__heading w-100" v-if="item && item.trade">
                <h5 class="me-auto">торги №
                    <skeleton type_name="spoiler" tag="span" :loading="rules && !rules.trade.externalId">
                        {{item.trade.externalId ? item.trade.externalId : '0'}}
                    </skeleton>
                    <span class="bkt-text-neutral-dark"> • </span>
                    <skeleton type_name="spoiler" tag="span" :loading="rules && !rules.trade.publishDate">
                        <span
                            v-if="item.trade.publishDate">{{item.trade.publishDate | moment('DD MMMM YYYY HH:mm')}}</span>
                    </skeleton>
                </h5>
            </div>
            <div class="col-12 col-lg-11 p-0">
                <div class="row h-100 w-100 mx-auto row-cols-1 row-cols-lg-4 bkt-card-trade__gap">
                    <div class="col-12 col-lg-2 p-0 pe-md-2" @click="navigate('mobile')">
                        <div class="bkt-wrapper-down-lg bkt-nowrap bkt-gap align-items-start">
                            <div class="bkt-card__image-wrapper"
                                 :class="{'bkt-gap-none': cadastralData=={}||(cadastralData && !cadastralData.cadastralNumber)}">
                                <div class="position-relative">
                                    <div class="bkt-cursor-pointer" @click="navigate('desktop')"
                                         v-if="item && ((rules && (!rules.categories || !rules.photos)) ||
                                         ((!item.photos || (item.photos && item.photos.length==0))
                                         && item.categories && (!rules || rules && rules.categories)))"
                                    >
                                        <card-image-category :categories="item.categories"></card-image-category>
                                    </div>
                                    <hooper :itemsToShow="1" :centerMode="true" class="bkt-card__image-slider"
                                            v-if="item && item.photos && item.photos.length>0
                                            && ((rules && rules.photos) || !rules)"
                                    >
                                        <slide v-for="photo in item.photos" :key="photo.id">
                                            <img v-lazy="photo.preview" class="bkt-card__image bkt-cursor-pointer"
                                                 @click="navigate('desktop')"/>
                                        </slide>
                                        <hooper-navigation slot="hooper-addons"></hooper-navigation>
                                    </hooper>
                                    <div class="bkt-card__image-status bkt-cursor-pointer" v-if="item.isWatched">
                                        Просмотрено
                                    </div>
                                </div>
                                <button
                                    class="bkt-button bkt-card-trade__button bkt-card-trade__button_egrn d-none d-lg-block"
                                    @click="buyEgrn" v-if="cadastralData && cadastralData.cadastralNumber"
                                    :disabled="loading"
                                >
                                    <span v-show="loading" class="spinner-border spinner-border-sm"
                                          role="status"></span>
                                    Отчёт ЕГРН
                                </button>
                            </div>
                            <div class="bkt-wrapper-column d-lg-none">
                                <div class="bkt-wrapper-between bkt-gap-large bkt-gap-down-sm bkt-nowrap">
                                    <router-link :to="'/lot/'+item.id" class="bkt-card__title bkt-text-truncate-1"
                                                 style="word-break: break-all">
                                        {{item && item.description ? item.description:'Некоторое название торгов'}}
                                    </router-link>
                                    <div class="d-flex bkt-gap-small">
                                        <bkt-icon class="bkt-card-trade__icon"
                                                  v-if="item.favouritePaths && item.favouritePaths.length>0"
                                                  :name="'Star'"
                                                  :color="item.favouritePaths[0].color ? item.favouritePaths[0].color : 'yellow'"
                                        >
                                        </bkt-icon>
                                        <bkt-icon class="bkt-card-trade__icon" v-if="item.isPinned" :name="'Pin'"
                                                  :color="'primary'">
                                        </bkt-icon>
                                    </div>
                                </div>
                                <div class="d-flex bkt-gap-small"
                                     v-if="(item.location && item.location.length>0) || (rules && !rules.location)"
                                >
                                    <bkt-icon :name="'Location'" :color="'neutral'" :width="'14px'" :height="'14px'">
                                    </bkt-icon>
                                    <h5 class="bkt-card__text">
                                        <skeleton type_name="spoiler" tag="div" :loading="rules && !rules.location">
                                            {{item.location && item.location[0] ? $t('regions.'+item.location[0].code) :
                                            ''}}
                                        </skeleton>
                                    </h5>

                                </div>
                                <div class="d-flex bkt-gap-small">
                                    <bkt-icon :name="'Gavel'" :color="'neutral'" :width="'14px'"
                                              :height="'14px'"></bkt-icon>
                                    <h5 class="bkt-card__text">
                                        <skeleton type_name="spoiler" tag="span" :loading="rules && !rules.trade.type">
                                            {{item.trade && item.trade.type ? $t('trades.type.'+item.trade.type) : ''}}
                                        </skeleton>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-5 p-0 px-lg-2" @click="navigate('mobile')">
                        <div class="bkt-card__head d-none d-lg-block">
                            <router-link :to="'/lot/'+item.id" class="bkt-card__title bkt-text-truncate-1">
                                {{item && item.description ? item.description:'Некоторое название торгов'}}
                            </router-link>
                        </div>
                        <div class="bkt-card-trade__gap bkt-wrapper-column">
                            <div class="bkt-card__feature"
                                 v-if="item.descriptionExtracts && item.descriptionExtracts.length>1">
                                <h6 class="bkt-card__subtitle">объектов недвижимости</h6>
                                <h5 class="bkt-card__text bkt-text-700">
                                    {{item.descriptionExtracts.length}}
                                </h5>
                            </div>
                            <div class="bkt-card__features d-none d-sm-flex"
                                 v-if="item.descriptionExtracts && cadastralData">
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
                            <button
                                class="bkt-button bkt-card-trade__button bkt-card-trade__button_more d-none d-lg-block"
                                @click="navigate('desktop')"
                            >
                                Подробнее о лоте
                            </button>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 p-0">
                        <div class="bkt-card-trade__gap bkt-wrapper-column bkt-wrapper-down-md-column-reverse">
                            <div class="bkt-gap-small bkt-wrapper-between bkt-nowrap align-items-end">
                                <div
                                    class="bkt-wrapper-column bkt-bg-body bkt-card-trade__price-info bkt-wrapper-down-lg-column-reverse"
                                    @click="navigate('mobile')"
                                >
<!--                                    <div class="d-flex align-items-end bkt-nowrap bkt-gap-small">-->
<!--                                        <div class="bkt-card__feature">-->
<!--                                            <h6 class="bkt-card__subtitle">текущая цена</h6>-->
<!--                                            <h5 class="bkt-text-700 d-flex align-items-center bkt-gap-mini bkt-card-trade__price"-->
<!--                                                :class="{-->
<!--                                                    'bkt-text-red': (!rules || (rules && rules.currentPriceState))-->
<!--                                                    && item.currentPriceState==='up',-->
<!--                                                    'bkt-text-green':(!rules || (rules && rules.currentPriceState))-->
<!--                                                    && item.currentPriceState==='down'-->
<!--                                                }"-->
<!--                                            >-->
<!--                                                <skeleton type_name="spoiler" tag="div"-->
<!--                                                          :loading="rules && !rules.currentPrice"-->
<!--                                                >-->
<!--                                                    {{item && item.currentPrice ? item.currentPrice : '0' |-->
<!--                                                    priceFormat}} ₽-->
<!--                                                </skeleton>-->
<!--                                                <skeleton type_name="spoiler_mini" tag="div"-->
<!--                                                          :loading="rules && !rules.currentPriceState"-->
<!--                                                          v-if="(item.currentPriceState!=='hold'-->
<!--                                                          && (!rules || (rules && rules.currentPriceState)))-->
<!--                                                          ||(rules && !rules.currentPriceState)"-->
<!--                                                >-->
<!--                                                    <span>-->
<!--                                                        <bkt-icon :name="'ArrowTriple'" :width="'22px'" :height="'22px'"-->
<!--                                                                  :color="item.currentPriceState==='down' ? 'green' : 'red'"-->
<!--                                                                  :class="{'bkt-rotate-180': item.currentPriceState==='down'}"-->
<!--                                                        >-->
<!--                                                        </bkt-icon>-->
<!--                                                    </span>-->
<!--                                                </skeleton>-->
<!--                                            </h5>-->
<!--                                        </div>-->
<!--                                        <div class="bkt-card-trade__price-arrow"-->
<!--                                             :class="{'bkt-rotate-180' : item.trade && (item.trade.type!=='ClosePublicOffer' && item.trade.type!=='PublicOffer')}">-->
<!--                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"-->
<!--                                                 xmlns="http://www.w3.org/2000/svg">-->
<!--                                                <path-->
<!--                                                    d="M5.24982 9.47727L4.26119 8.49716L6.85636 5.90199H0.775391V4.46165H6.85636L4.26119 1.87074L5.24982 0.886364L9.54528 5.18182L5.24982 9.47727Z"-->
<!--                                                    fill="black"/>-->
<!--                                            </svg>-->
<!--                                        </div>-->
<!--                                        &lt;!&ndash;                                        <template v-if="item && item.trade && item.trade.type">&ndash;&gt;-->
<!--                                        <div class="bkt-card__feature"-->
<!--                                             v-if="((item.minPrice && item.minPrice>=0) && item && item.trade && item.trade.type &&-->
<!--                                         (item.trade.type==='ClosePublicOffer' || item.trade.type==='PublicOffer')-->
<!--                                         && (!rules || rules && rules.minPrice))||(rules && !rules.minPrice)"-->
<!--                                        >-->
<!--                                            <h6 class="bkt-card__subtitle">-->
<!--                                                минимальная цена-->
<!--                                            </h6>-->
<!--                                            <h5 class="bkt-card__text bkt-text-700 bkt-card-trade__price d-flex flex-wrap">-->
<!--                                                <skeleton type_name="spoiler" :loading="rules && !rules.minPrice">-->
<!--                                                    {{ item.minPrice | priceFormat}} ₽-->
<!--                                                    <div class="bkt-badge bkt-bg-green" v-if="priceInfo.percent > 0">-->
<!--                                                        -{{priceInfo.percent | priceFormat}} %-->
<!--                                                    </div>-->
<!--                                                </skeleton>-->
<!--                                            </h5>-->
<!--                                        </div>-->
<!--                                        <div class="bkt-card__feature"-->
<!--                                             v-if="((item.startPrice && item.startPrice>=0) && item && item.trade && item.trade.type &&-->
<!--                                         (item.trade.type!=='ClosePublicOffer' && item.trade.type!=='PublicOffer')-->
<!--                                         && (!rules || rules && rules.startPrice))||(rules && !rules.startPrice)"-->
<!--                                        >-->
<!--                                            <h6 class="bkt-card__subtitle">-->
<!--                                                начальная цена-->
<!--                                            </h6>-->
<!--                                            <h5 class="bkt-card__text bkt-text-700 bkt-card-trade__price d-flex flex-wrap">-->
<!--                                                <skeleton type_name="spoiler" :loading="rules && !rules.startPrice">-->
<!--                                                    {{ item.startPrice | priceFormat}} ₽-->
<!--                                                    <span class="bkt-badge bkt-bg-red" v-if="priceInfo.percent > 0">-->
<!--                                                            +{{priceInfo.percent | priceFormat}} %-->
<!--                                                        </span>-->
<!--                                                </skeleton>-->
<!--                                            </h5>-->
<!--                                        </div>-->
<!--                                        &lt;!&ndash;                                        <div class="bkt-badge" v-if="priceInfo.percent !== 0"&ndash;&gt;-->
<!--                                        &lt;!&ndash;                                             :class="item.trade && (item.trade.type!=='ClosePublicOffer' && item.trade.type!=='PublicOffer') ? 'bkt-bg-red' : 'bkt-bg-green'"&ndash;&gt;-->
<!--                                        &lt;!&ndash;                                        >&ndash;&gt;-->
<!--                                        &lt;!&ndash;                                            {{item.trade && (item.trade.type!=='ClosePublicOffer' && item.trade.type!=='PublicOffer')? '+':'-'}}&ndash;&gt;-->
<!--                                        &lt;!&ndash;                                            {{priceInfo.percent | numberFormat}} %&ndash;&gt;-->
<!--                                        &lt;!&ndash;                                        </div>&ndash;&gt;-->
<!--                                        &lt;!&ndash;                                        </template>&ndash;&gt;-->
<!--                                    </div>-->
<!--                                    <div-->
<!--                                        class="bkt-card__features bkt-wrapper-column bkt-wrapper-down-lg-column-reverse bkt bkt-gap-small">-->
<!--                                        <div class="bkt-card__feature"-->
<!--                                             v-if="(item.deposit && (!rules || rules && rules.deposit))||(rules && !rules.deposit)"-->
<!--                                        >-->
<!--                                            <h6 class="bkt-card__subtitle">задаток-->
<!--                                                <span v-if="item && item.trade && item.trade.type">-->
<!--                                                     {{(item.trade.type==='CloseAuction' || item.trade.type==='OpenAuction'-->
<!--                                                || item.trade.type==='OpenConcours' || item.trade.type==='CloseConcours')-->
<!--                                                    ? '(от начальной цены)' : '(от текущей цены)'}}-->
<!--                                                </span>-->
<!--                                            </h6>-->
<!--                                            <h5 class="bkt-card__text bkt-text-700 bkt-card-trade__subprice">-->
<!--                                                <skeleton type_name="spoiler" skeleton_class="bkt-text-main"-->
<!--                                                          :loading="rules && !rules.deposit">-->
<!--                                                    <template v-if="item.deposit">-->
<!--                                                        {{priceInfo.deposit.money | priceFormat}} ₽-->
<!--                                                        <span-->
<!--                                                            class="bkt-text-neutral-dark bkt-card-trade__subprice-percent">-->
<!--                                                            {{priceInfo.deposit.percent | priceFormat}} %-->
<!--                                                        </span>-->
<!--                                                    </template>-->
<!--                                                    <template v-else>-->
<!--                                                        без задатка-->
<!--                                                    </template>-->
<!--                                                    &lt;!&ndash;                                                    {{item.deposit && item.deposit.value ? item.deposit.value : '0' | priceFormat}}&ndash;&gt;-->
<!--                                                    &lt;!&ndash;                                                    {{item.deposit && item.deposit.type=='rubles' ? '₽' : '%'}}&ndash;&gt;-->
<!--                                                </skeleton>-->
<!--                                            </h5>-->
<!--                                        </div>-->
<!--                                        <div class="bkt-card__feature"-->
<!--                                             v-if="(item && item.stepPrice && item.stepPrice.value>0 && item.trade && item.trade.type &&-->
<!--                                         (item.trade.type==='CloseAuction' || item.trade.type==='OpenAuction'-->
<!--                                         || item.trade.type==='OpenConcours' || item.trade.type==='CloseConcours')-->
<!--                                         && (!rules || rules && rules.stepPrice))||(rules && !rules.stepPrice)"-->
<!--                                        >-->
<!--                                            <h6 class="bkt-card__subtitle">шаг аукциона (от начальной цены)</h6>-->
<!--                                            <h5 class="bkt-card__text bkt-text-700 bkt-card-trade__subprice">-->
<!--                                                <skeleton type_name="spoiler" :loading="rules && !rules.stepPrice">-->
<!--                                                    <template v-if="item.stepPrice">-->
<!--                                                        {{priceInfo.auction_step.money | priceFormat}} ₽-->
<!--                                                        <span-->
<!--                                                            class="bkt-text-neutral-dark bkt-card-trade__subprice-percent">-->
<!--                                                            {{priceInfo.auction_step.percent | priceFormat}} %-->
<!--                                                        </span>-->
<!--                                                    </template>-->
<!--                                                    <template v-else>-->
<!--                                                        без шага аукциона-->
<!--                                                    </template>-->
<!--                                                    &lt;!&ndash;                                                    {{item.stepPrice && item.stepPrice.value ? item.stepPrice.value :&ndash;&gt;-->
<!--                                                    &lt;!&ndash;                                                    '0' | priceFormat}}&ndash;&gt;-->
<!--                                                    &lt;!&ndash;                                                    {{item.stepPrice && item.stepPrice.type=='rubles' ? '₽' : '%'}}&ndash;&gt;-->
<!--                                                </skeleton>-->
<!--                                            </h5>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                    <card-price-info :item="item"></card-price-info>
                                    <button
                                        class="bkt-button primary bkt-card-trade__button bkt-card-trade__button_buy d-none d-lg-block"
                                        @click="callPurchaseModal"
                                    >
                                        Купить
                                    </button>
                                </div>
                                <div class="d-lg-none">
                                    <card-actions :item="item" button_type="-ellipse mt-1 mx-0 mb-0" place="dropdown"
                                                  @changeStatus="changeStatus" main_bg="bkt-bg-body"
                                                  icon_color="main"
                                    >
                                    </card-actions>
                                </div>
                            </div>
                            <div class="d-flex bkt-gap d-none d-lg-flex"
                                 v-if="(item.location && item.location.length>0) || (rules && !rules.location)">
                                <bkt-icon :name="'Location'" :color="'neutral'" :width="'14px'" :height="'14px'"/>
                                <h5 class="bkt-card__text">
                                    <skeleton type_name="spoiler" tag="span" :loading="rules && !rules.location">
                                        {{item.location && item.location[0]?$t('regions.'+item.location[0].code):''}}
                                    </skeleton>
                                </h5>
                            </div>
                            <div class="d-flex bkt-gap d-none d-lg-flex">
                                <bkt-icon :name="'Gavel'" :color="'neutral'" :width="'14px'" :height="'14px'"/>
                                <h5 class="bkt-card__text">
                                    <skeleton type_name="spoiler" tag="span" :loading="rules && !rules.trade.type">
                                        {{item.trade && item.trade.type ? $t('trades.type.'+item.trade.type) : ''}}
                                    </skeleton>
                                </h5>
                            </div>
                            <div class="d-flex align-items-center bkt-gap-mini" @click="navigate('mobile')">
                                <bkt-icon name="Stop" v-if="progressColor==='bkt-bg-red'"></bkt-icon>
                                <div class="bkt-wrapper-column bkt-gap-mini">
                                    <div class="bkt-wrapper-between">
                                        <!--                                 v-if="(item.state == 'biddingDeclared' || item.state == 'biddingStart'
                                                                         || item.state == 'applicationSessionStarted') && dateStatus"-->
                                        <h5 class="bkt-card__text">
                                        <span v-if="dateStatus && dateStatus.status === 'application'">
                                            Приём заявок ещё
                                            <skeleton type_name="spoiler"
                                                      :loading="rules && !rules.trade.applicationTime">
                                                {{ dateStatus.days }} {{$tc('trades.days', pluralization( dateStatus.days))}}
                                            </skeleton>
                                        </span>
                                            <span v-else class="bkt-text-700" :class="{'bkt-text-red': item.state==='biddingEnd' || item.state==='finished'}">
                                            <skeleton type_name="spoiler" :loading="rules && !rules.state">
                                                {{item.state ? $t('trades.state.'+item.state) : ''}}
                                            </skeleton>
                                        </span>
                                            <!--                                    <span v-else-if="dateStatus && dateStatus.status === 'bidding-end'">Торги</span>-->
                                            <!--                                    <span v-else-if="dateStatus && dateStatus.status === 'bidding-result'">До объявления результатов торгов</span>-->
                                        </h5>
                                        <h5 class="bkt-card__text">
                                            <skeleton type_name="spoiler" :loading="rules && !rules.trade.applicationTime">
                                            <span>
                                                 <span
                                                     v-if="item.trade.applicationTime && item.trade.applicationTime.end && dateStatus && dateStatus.status === 'application'">
                                                до {{item.trade.applicationTime.end | moment('DD.MM.YYYY')}}
                                            </span>
                                            <span
                                                v-if="item.trade.applicationTime && item.trade.applicationTime.start && (item.state==='BiddingDeclaration' || item.state==='biddingDeclaration')">
                                                приём заявок с {{item.trade.applicationTime.start | moment('DD.MM.YYYY')}}
                                            </span>
                                            </span>
                                            </skeleton>
                                        </h5>
                                    </div>
                                    <div class="bkt-progress-bar" :class="progressColor">
                                        <div v-if="dateStatus && dateStatus.percent && dateStatus.percent>0"
                                             class="bkt-progress-bar__progress"
                                             :style="'width: '+dateStatus.percent+'%;'">
                                        </div>
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
    import CardPriceInfo from "./CardPriceInfo";

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
            CardPriceInfo
        },
        data() {
            return {
                short_description: '',
                // realEstate: false,
                read_more: false,
                loading: false,
            }
        },
        mounted() {
            this.short_description = '';
            if (this.item.description.length > 0 && this.item.description.length > 500) {
                this.short_description = this.item.description.slice(0, 500) + '...';
            }
            // let index = this.item.categories.findIndex( item => item.key === 'realEstate');
            // if(index >= 0) {
            //     this.realEstate = true;
            // }
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
                            if (extracts[index].value > 0) {
                                cadastralData.cadastralDataPrice = extracts[index].value;
                            }
                        }
                        index = extracts.findIndex(item => item.type == 'cadastralDataArea')
                        if (index >= 0) {
                            if (extracts[index].value > 0) {
                                cadastralData.cadastralDataAreaType = tmp.type;
                                cadastralData.cadastralDataArea = extracts[index].value;
                                cadastralData.cadastralDataAreaMeasure = 'кв. м.';
                                if (cadastralData.cadastralDataAreaType === 'landPlot') {
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

                        }
                        index = extracts.findIndex(item => item.type == 'cadastralDataFractionalOwnership')
                        if (index >= 0) {
                            if (extracts[index].value > 0) {
                                cadastralData.cadastralDataFractionalOwnership = extracts[index].value;
                            }
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
                ) {
                    days = this.countDays(this.item.trade.applicationTime.end);
                    if (days > 0) {
                        percent = 100 - days / this.countDays(this.item.trade.applicationTime.end, this.item.trade.applicationTime.start) * 100;
                        return {status: 'application', days: days, percent: percent};
                    }
                } else if (this.item.trade.eventTime && (this.item.state === 'biddingDeclared' || this.item.state === 'biddingStart')) {
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
                let tmp_state = '';
                if (this.item.state) {
                    tmp_state = this.item.state.toLowerCase();
                }

                // if ( tmp_state === 'biddingpause') {
                //     return 'bkt-bg-neutral-lighter'
                // }
                if (tmp_state === 'biddingcanceled' || tmp_state === 'finished' || tmp_state === 'annulment'
                    ||tmp_state === 'biddingfail' || tmp_state === 'biddingpause' || tmp_state === 'biddingcancel') {
                    return 'bkt-bg-red'
                }
                return 'bkt-bg-main-lighter'
            },
            rules() {
                return this.$store.getters.rules
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
            isMobile() {
                return this.$store.getters.isMobile
            }
        },
        methods: {
            sendApplication() {
                this.$store.commit('setSelectedLot', this.item);
                this.$store.commit('openModal', '#applicationModal')
            },
            callPurchaseModal() {
                if (this.isLoggedIn) {
                    this.$store.commit('setSelectedLot', this.item);
                    this.$store.commit('openModal', '#purchaseModal')
                } else {
                    this.$store.dispatch('sendAuthNotification')
                }

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
                    if (end_date) {
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
            navigate(type='desktop') {
                if ((this.isMobile && type === 'mobile') || type === 'desktop') {
                    this.$router.push('/lot/' + this.item.id)
                }
            },
            buyEgrn() {
                this.item.cadastralData = this.cadastralData;
                this.item.cadastralObject = this.item.descriptionExtracts[0];
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
            },
            touchHandler() {
                if (this.isMobile) {
                    console.log('tap', this.item.description)
                }

            }
        }
    };
</script>

<style scoped>
</style>
