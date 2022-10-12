<template>
    <div class="bkt-main bkt-page bkt-lot bkt-container">
        <bkt-move-favourite-modal v-if="isLoggedIn"/>
        <bkt-note-modal v-if="isLoggedIn"/>
        <bkt-application-modal/>
        <bkt-add-mark-modal></bkt-add-mark-modal>
        <nav class="bkt-wrapper bkt-nowrap m-0 bkt-breadcrumb" aria-label="breadcrumb">
            <button class="bkt-button-icon bg-white" style="margin-right:20px" @click="goBack">
                <bkt-icon :name="'ArrowDown'" class="bkt-button__icon bkt-rotate-90"></bkt-icon>
            </button>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item bkt-breadcrumb__item">
                    <router-link to="/" class="bkt-text-neutral-dark">главная</router-link>
                </li>
                <li class="breadcrumb-item bkt-breadcrumb__item">торги</li>
                <li class="breadcrumb-item bkt-breadcrumb__item active" aria-current="page">
                    торги № {{item && item.trade && item.trade.externalId ? item.trade.externalId : ''}} (лот
                    {{item && item.lotNumber ? item.lotNumber : '0'}})
                </li>
            </ol>
        </nav>

        <div class="bkt-row bkt-bg-main bkt-wrapper-between bkt-lot__card-actions d-none d-lg-flex">
            <h5 class="bkt-trading-number">
                торги № {{item && item.trade && item.trade.externalId ? item.trade.externalId : ''}} (лот
                {{item && item.lotNumber ? item.lotNumber : '0'}})
            </h5>
            <bkt-card-actions :item="item" class="bkt-actions" button_type="-icon" place="lot-card"
                              @changeStatus="changeStatus"
            ></bkt-card-actions>
        </div>
        <div class="row bkt-lot__cards w-100 p-0">
            <div class="col-12 col-lg-7 order-2 order-lg-1 ps-lg-0">
                <div class="bkt-wrapper-column bkt-lot__cards">
                    <div class="bkt-card bkt-lot__card" v-if="!loading">
                        <div class="bkt-card__body">
<!--                            <div class="d-none d-lg-block">-->
<!--                                <h3 class="bkt-card__title bkt-text-truncate">-->
<!--                                    <skeleton :type_name="'title'">{{item && item.description ? short_description:''}}-->
<!--                                    </skeleton>-->
<!--                                </h3>-->
<!--                            </div>-->
                            <div v-if="item && item.description">
                                <h5 class="bkt-card__text">
                                    {{read_more && short_description ? item.description : short_description}}
                                    {{!short_description ? item.description : ''}}
                                </h5>
                                <button class="bkt-button bkt-text-primary float-end px-0 text-uppercase"
                                        @click="read_more = !read_more" v-if="short_description">
                                    {{read_more ? 'Скрыть' : 'Подробнее'}}
                                    <bkt-icon name="ArrowDown" color="primary" height="14px"
                                              :class="read_more ? 'bkt-rotate-180' : ''"></bkt-icon>
                                </button>
                            </div>
                            <ul class="bkt-contents" v-if="isLoggedIn">
                                <li v-if="item.trade && item.trade.type">
                                    <div class="bkt-contents__heading">
                                        <span class="bkt-contents__heading">тип торгов</span>
                                    </div>
                                    <div class="bkt-contents__answer">
                                        <span>{{ $t('trades.type.'+item.trade.type)}}</span>
                                    </div>
                                </li>
                                <li v-if="item.trade && item.trade.publishDate">
                                    <div class="bkt-contents__heading">
                                        <span class="bkt-contents__heading">дата размещения</span>
                                    </div>
                                    <div class="bkt-contents__answer">
                                        <span>{{item.trade.publishDate | moment('DD MMMM YYYY HH:mm')}}</span>
                                    </div>
                                </li>
                                <li v-if="item.state">
                                    <div class="bkt-contents__heading">
                                        <span class="bkt-contents__heading">статус торгов</span>
                                    </div>
                                    <div class="bkt-contents__answer">
                                        <span>{{$t('trades.state.'+item.state)}}</span>
                                    </div>
                                </li>
                                <li v-if="item.trade && item.trade.priceOfferForm">
                                    <div class="bkt-contents__heading">
                                        <span class="bkt-contents__heading">форма подачи предложения о цене</span>
                                    </div>
                                    <div class="bkt-contents__answer">
                                        <span>{{$t('trades.priceOfferForm.'+item.trade.priceOfferForm)}}</span>
                                    </div>
                                </li>
                                <template v-for="(category, index) in item.categories" v-if="item.categories.length>0">
                                    <li>
                                        <div class="bkt-contents__heading">
                                            <span class="bkt-contents__heading">категория объекта</span>
                                        </div>
                                        <div class="bkt-contents__answer">
                                            <!--                                        <span>{{$t('categories.'+category.key)}}</span>-->
                                            <span>{{category.label}}</span>
                                        </div>
                                    </li>
                                    <li v-for="subcategory in category.subcategories">
                                        <div class="bkt-contents__heading">
                                            <span class="bkt-contents__heading">подкатегория объекта</span>
                                        </div>
                                        <div class="bkt-contents__answer">
                                            <!--                                        <span>{{$t('categories.'+subcategory)}}</span>-->
                                            <span>{{subcategory.label}}</span>
                                        </div>
                                    </li>
                                </template>
                                <template v-if="item.location">
                                    <li v-for="location in item.location">
                                        <div class="bkt-contents__heading">
                                            <span class="bkt-contents__heading">
                                                регион {{location.isDebtorRegion ? 'должника' : 'объекта'}}
                                            </span>
                                        </div>
                                        <div class="bkt-contents__answer">
                                            <span>{{$t('regions.'+location.code)}}</span>
                                        </div>
                                    </li>
                                </template>
                                <template v-for="(subject, index) in item.descriptionExtracts">
                                    <li v-if="subject.tradeSubject">
                                        <div class="bkt-contents__heading">
                                        <span class="bkt-contents__heading text-lowercase">
                                            объект {{item.descriptionExtracts.length>1 ? index+1 : ''}}
                                        </span>
                                        </div>
                                        <div class="bkt-contents__answer">
                                            <span>{{subject.tradeSubject}}</span>
                                        </div>
                                    </li>
                                    <li v-if="subject.type">
                                        <div class="bkt-contents__heading">
                                        <span class="bkt-contents__heading text-lowercase">
                                           тип объекта {{item.descriptionExtracts.length>1 ? index+1 : ''}}
                                        </span>
                                        </div>
                                        <div class="bkt-contents__answer">
                                            <span>{{$t('trades.tradeSubjectType.'+subject.type)}}</span>
                                        </div>
                                    </li>
                                    <template v-if="subject.extracts.length>0" v-for="extract in subject.extracts">
                                        <li v-if="extract.value && extract.value != 0">
                                            <div class="bkt-contents__heading">
                                                <span
                                                    class="bkt-contents__heading text-lowercase">{{extract.title}}</span>
                                            </div>
                                            <div class="bkt-contents__answer"><span>{{extract.value}}</span>
                                            </div>
                                        </li>
                                    </template>
                                </template>
                            </ul>
                            <div class="bkt-row outline bkt-wrapper-between align-items-center"
                                 v-if="cadastralData && cadastralData.cadastralDataArea">
                                <div class="bkt-row__feature">
                                    <h4 class="bkt-row__feature-title">{{cadastralData.cadastralDataArea | priceFormat}}
                                        {{cadastralData.cadastralDataAreaMeasure}}
                                    </h4>
                                    <h6 class="bkt-row__feature-subtitle text-lowercase">
                                        {{$t('trades.tradeSubjectType.'+cadastralData.cadastralDataAreaType)}}
                                    </h6>
                                </div>
                                <span class="bkt-row__icon">
                            <bkt-icon :name="'Tree'"></bkt-icon>
                        </span>
                            </div>
                            <div class="bkt-row outline bkt-wrapper-between align-items-center"
                                 v-if="cadastralData && cadastralData.cadastralDataPrice">
                                <div class="bkt-row__feature">
                                    <h4 class="bkt-row__feature-title">
                                        {{cadastralData.cadastralDataPrice | priceFormat}} ₽
                                    </h4>
                                    <h6 class="bkt-row__feature-subtitle">кадастровая стоимость</h6>
                                </div>
                                <span class="bkt-row__icon">
                            <bkt-icon :name="'File'"></bkt-icon>
                        </span>
                            </div>
                            <div class="bkt-row outline bkt-wrapper-between align-items-center"
                                 v-if="cadastralData && cadastralData.cadastralDataFractionalOwnership">
                                <div class="bkt-row__feature">
                                    <h4 class="bkt-row__feature-title">
                                        {{cadastralData.cadastralDataFractionalOwnership}}%</h4>
                                    <h6 class="bkt-row__feature-subtitle">доля в собственности</h6>
                                </div>
                                <span class="bkt-row__icon">
                                <bkt-icon :name="'Pie'"></bkt-icon>
                            </span>
                            </div>
                        </div>
<!--                        <div class="bkt-card__footer d-flex flex-wrap bkt-gap" v-if="item && !loading">-->
<!--                            <ShareNetwork-->
<!--                                v-for="network in networks"-->
<!--                                :network="network.network"-->
<!--                                :key="network.network"-->
<!--                                :style="{backgroundColor: network.color}"-->
<!--                                :url="'https://lotofond.ru/lot/'+item.id"-->
<!--                                :title="sharing.title"-->
<!--                                :description="short_description"-->
<!--                                :hashtags="sharing.hashtags"-->
<!--                            >-->
<!--                                <span class="share-icon h-100">-->
<!--                                      <bkt-icon :name="network.name" width="18px" height="18px"-->
<!--                                                color="white"></bkt-icon>-->
<!--                                </span>-->
<!--                                <span>{{ network.name }}</span>-->
<!--                            </ShareNetwork>-->
<!--                        </div>-->
                    </div>
                    <div class="bkt-card bkt-lot__card" v-if="loading">
                        <div class="bkt-card__body">
                            <div class="d-none d-lg-block">
                                <h3 class="bkt-card__title bkt-text-truncate">
                                    <skeleton :type_name="'title'" :count="2"></skeleton>
                                </h3>
                            </div>
                            <ul class="bkt-contents">
                                <li v-for="(n,index) in 7">
                                    <skeleton :type_name="'answer'" skeleton_class="bkt-contents__answer ms-0"
                                              width="80px"></skeleton>
                                    <div class="bkt-contents__answer">
                                        <span><skeleton :type_name="'answer'"></skeleton></span>
                                    </div>
                                </li>
                            </ul>
                            <h5 class="bkt-card__text">
                                <skeleton :type_name="'text'" :count="5"></skeleton>
                            </h5>
                            <div class="bkt-row outline bkt-wrapper-between align-items-center" v-for="(n,index) in 3">
                                <div class="bkt-row__feature">
                                    <skeleton :type_name="'text'" width="90px"></skeleton>
                                    <skeleton :type_name="'text'" width="55px" height="8px"></skeleton>
                                </div>
                                <skeleton :type_name="'item'" width="25px" height="25px" circle></skeleton>
                            </div>
                        </div>
<!--                        <div class="bkt-card__footer d-flex flex-wrap bkt-gap">-->
<!--                            <skeleton width="120px" height="38px" :count="7"></skeleton>-->
<!--                        </div>-->
                    </div>
                    <div v-if="!isLoggedIn" class="bkt-shadow-card bkt-shadow-card_primary">
                        <div class="bkt-shadow-card__inner bkt-gap-large">
                            <h4 class="bkt-shadow-card__title bkt-text-white">
                                Чтобы посмотреть полную информацию <br>
                                <span>войдите или зарегистрируйтесь</span>
                            </h4>
                            <button class="bkt-button bkt-bg-white bkt-text-primary mx-auto bkt-button_plump"
                                    style="max-width: 320px"
                                    data-bs-toggle="modal" data-bs-target="#authModal"
                            >
                                Вход и регистрация
                            </button>
                            <div class="bkt-shadow-card__shadow-1">
                            </div>
                            <div class="bkt-shadow-card__shadow-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5 order-1 order-lg-2 pe-lg-0">
                <div class="bkt-card bkt-lot__card bkt-lot-card bkt-lot__card" v-if="!loading">
                    <div class="bkt-card__body">
                        <div class="bkt-wrapper-between bkt-card__head bkt-nowrap d-flex d-lg-none">
                            <h5 class="bkt-card__title bkt-text-truncate">
                                {{item && item.description ? item.description:'Некоторое название торгов'}}
                            </h5>
                            <div class="dropdown d-block d-lg-none">
                                <button class="bkt-button bkt-bg-primary-lighter bkt-card-menu-button" type="button"
                                        id="dropdownMenuClickableOutside" data-bs-toggle="dropdown"
                                        data-bs-offset="10,20" data-bs-display="static"
                                        data-bs-auto-close="outside" aria-expanded="false">
                                    <bkt-icon :name="'More'"></bkt-icon>
                                </button>
                                <div class="bkt-card-menu m-0 dropdown-menu dropdown-menu-end position-absolute"
                                     aria-labelledby="dropdownMenuClickableOutside"
                                >
                                    <bkt-card-actions :item="item" type="menu" place="lot-card"
                                                      @changeStatus="changeStatus"
                                                      class="bkt-card-menu-inner"></bkt-card-actions>
                                </div>
                            </div>
                            <!--                        <button class="bkt-button bkt-bg-primary-lighter bkt-card-menu-button">-->
                            <!--                            <bkt-icon :name="'More'"></bkt-icon>-->
                            <!--                        </button>-->
                        </div>
                        <div class="bkt-card__image-wrapper">
                            <bkt-card-image-category :categories="item.categories"
                                                     v-if="(!item.photos || item.photos.length==0) && item.categories"
                            >
                            </bkt-card-image-category>
                            <!--                            <div class="bkt-card__image-category" v-if="!item.photos || item.photos.length==0">-->
                            <!--                                <bkt-icon name="Cow" color="neutral-dark"></bkt-icon>-->
                            <!--                            </div>-->
                            <hooper :itemsToShow="1" :centerMode="true" class="bkt-card__image-slider"
                                    v-if="item.photos && item.photos.length>0">
                                <slide v-for="photo in item.photos" :key="photo.id">
                                    <img v-lazy="photo.main" class="bkt-card__image"/>
                                </slide>
                                <hooper-navigation slot="hooper-addons"></hooper-navigation>
                            </hooper>
                            <div class="bkt-wrapper-between bkt-card-ecp-wrapper">
                                <button @click="sendApplication" class="bkt-button primary bkt-card-ecp w-100">
                                    Купить без ЭЦП
                                </button>
                                <!--                                <router-link custom v-slot="{ navigate }" to="/agent">-->
                                <!--                                    <button @click="navigate" class="bkt-button primary bkt-card-ecp w-100">-->
                                <!--                                        Купить через <br>агента-->
                                <!--                                    </button>-->
                                <!--                                </router-link>-->
                            </div>
                        </div>
                        <div class="bkt-card-price bkt-button w-100"
                             :class="{'bkt-bg-red': item.currentPriceState=='down',
                                  'bkt-bg-green': item.currentPriceState=='up',
                                  'bkt-bg-primary-lighter bkt-text-primary': item.currentPriceState=='hold'}"
                        >
                            <div>
                                <h5 class="bkt-card__subtitle">текущая цена</h5>
                                {{item.currentPrice ? item.currentPrice : '0' | priceFormat}} ₽
                            </div>
                            <div class="bkt-card-price-icon" v-if="item.currentPriceState!=='hold'"
                                 :class="{'bkt-bg-red-light': item.currentPriceState=='down',
                                          'bkt-bg-green-light': item.currentPriceState=='up'}"
                            >
                                <bkt-icon :name="'ArrowTriple'" :width="'22px'" :height="'22px'"
                                          :class="{'bkt-rotate-180': item.currentPriceState=='down'}"
                                >
                                </bkt-icon>
                            </div>
                        </div>
                        <div class="bkt-card-infographics bkt-gap bkt-wrapper-between bkt-nowrap">
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
                        <div class="bkt-card-infographics bkt-gap">
                            <div class="bkt-card__row outline bkt-wrapper-between align-items-center">
                                <h5 class="bkt-card__subtitle">начальная цена</h5>
                                <h4 class="bkt-card__title bkt-text-primary">
                                    {{item && item.startPrice ? item.startPrice : '0' | priceFormat}} ₽
                                </h4>
                            </div>
                            <div class="bkt-card__row outline bkt-wrapper-between align-items-center" v-if="item&&item.trade.type!=='OpenAuction'">
                                <h5 class="bkt-card__subtitle">минимальная цена</h5>
                                <h4 class="bkt-card__title bkt-text-red">
                                    {{item && item.minPrice ? item.minPrice : '0' | priceFormat}} ₽
                                </h4>
                            </div>
                        </div>
                    </div>
<!--                    <div class="bkt-card__footer d-flex flex-wrap bkt-gap"-->
<!--                         v-if="item && item.marks && item.marks.length>0 && !loading"-->
<!--                    >-->
<!--                        <div class="bkt-tag bkt-bg-orange-lighter bkt-text-orange py-1 px-3" v-for="mark in item.marks">-->
<!--                            {{mark.title}}-->
<!--                            <span v-if="!marks_in_process.includes(mark.id)" class="bkt-cursor-pointer"-->
<!--                                  @click="removeMark(mark.id)"-->
<!--                            >-->
<!--                                <bkt-icon name="Cancel" color="orange" width="10px" height="10px"></bkt-icon>-->
<!--                            </span>-->
<!--                            <span v-if="marks_in_process.includes(mark.id)"-->
<!--                                  class="spinner-border spinner-border-sm"-->
<!--                                  role="status"></span>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
                <div class="bkt-card bkt-lot__card bkt-lot-card bkt-lot__card" v-if="loading">
                    <div class="bkt-card__body">
                        <div class="bkt-wrapper-between bkt-card__head bkt-nowrap bkt-gap d-flex d-lg-none">
                            <h5 class="bkt-card__title bkt-text-truncate w-100">
                                <skeleton :type_name="'title'" skeleton_class="mb-0"></skeleton>
                            </h5>
                            <div class="dropdown d-block d-lg-none">
                                <skeleton type_name="item" skeleton_class="bkt-button bkt-card-menu-button"></skeleton>
                            </div>
                        </div>
                        <div class="bkt-card__image-wrapper">
                            <skeleton type_name="item" skeleton_class="bkt-card__image-category"></skeleton>
                            <div class="bkt-wrapper-between bkt-card-ecp-wrapper">
                                <skeleton type_name="item" skeleton_class="bkt-button bkt-card-ecp w-100"
                                          height="44px"></skeleton>
                            </div>
                        </div>
                        <skeleton type_name="item" skeleton_class="bkt-card-price bkt-button w-100"></skeleton>
                        <div class="bkt-card-infographics" style="gap: 10px;">
                            <div class="bkt-card__row outline bkt-wrapper-between align-items-center">
                                <h5 class="bkt-card__subtitle">
                                    <skeleton type_name="text"></skeleton>
                                </h5>
                                <h4 class="bkt-card__title bkt-text-primary">
                                    <skeleton type_name="text"></skeleton>
                                </h4>
                            </div>
                            <div class="bkt-card__row outline bkt-wrapper-between align-items-center">
                                <h5 class="bkt-card__subtitle">
                                    <skeleton type_name="text"></skeleton>
                                </h5>
                                <h4 class="bkt-card__title bkt-text-red">
                                    <skeleton type_name="text"></skeleton>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="isLoggedIn" class="col-12 col-lg-12 order-3 px-lg-0">
                <div class="bkt-card bkt-lot__card bkt-lot-tasks" v-if="!loading">
                    <div class="bkt-card__header bkt-wrapper-between bkt-wrapper-up-md-nowrap m-0 bkt-gap-large">
                        <div class="bkt-gap bkt-wrapper-column bkt-wrapper-down-md">
                            <div class="bkt-lot__card-period bkt-wrapper" v-if="item.trade && item.trade.applicationTime
                                 && (item.trade.applicationTime.start || item.trade.applicationTime.end)">
                                <div class="bkt-card__category bkt-bg-blue">
                                    <bkt-icon :name="'Alarm'" :width="'16px'" :height="'16px'"></bkt-icon>
                                </div>
                                <h5 class="bkt-card__text">прием заявок
                                    <span v-if="item.trade.applicationTime.start">
                                            <br class="d-md-none">
                                            с {{item.trade.applicationTime.start | moment('DD MMMM YYYY')}}
                                            <span class="bkt-text-blue">
                                                {{item.trade.applicationTime.start | moment('HH:mm')}}
                                            </span>
                                        </span>
                                    <span v-if="item.trade.applicationTime.end">
                                            <br class="d-md-none">
                                            до {{item.trade.applicationTime.end | moment('DD MMMM YYYY')}}
                                            <span class="bkt-text-blue">
                                                {{item.trade.applicationTime.end | moment('HH:mm')}}
                                            </span>
                                        </span>
                                </h5>
                            </div>
                            <div class="bkt-lot__card-period bkt-wrapper"
                                 v-if="item.trade && item.trade.eventTime
                                 && (item.trade.eventTime.start || item.trade.eventTime.end || item.trade.eventTime.result)"
                            >
                                <div class="bkt-card__category bkt-bg-yellow">
                                    <bkt-icon :name="'Gavel'" :width="'22px'" :height="'22px'"></bkt-icon>
                                </div>
                                <h5 class="bkt-card__text">
                                    {{item.trade.eventTime.result?'объявление результатов торгов':'проведение торгов'}}
                                    <span v-if="item.trade.eventTime.start">
                                        <br class="d-md-none">
                                        с {{item.trade.eventTime.start | moment('DD MMMM YYYY')}}
                                        <span class="bkt-text-yellow">
                                            {{item.trade.eventTime.start | moment('HH:mm')}}
                                        </span>
                                    </span>
                                    <span v-if="item.trade.eventTime.end">
                                        <br class="d-md-none">
                                        до {{item.trade.eventTime.end | moment('DD MMMM YYYY')}}
                                        <span class="bkt-text-yellow">
                                            {{item.trade.eventTime.end | moment('HH:mm')}}
                                        </span>
                                    </span>
                                    <span v-if="item.trade.eventTime.result">
                                        <br class="d-md-none">
                                        {{item.trade.eventTime.result | moment('DD MMMM YYYY')}}
                                        <span class="bkt-text-yellow">
                                            {{item.trade.eventTime.result | moment('HH:mm')}}
                                        </span>
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <a v-if="item.trade && item.trade.tradePlace" :href="item.trade.tradePlace.site"
                           target="_blank" class="bkt-platform-button bkt-wrapper-between bkt-nowrap"
                        >
                            <div>
                                <h5 class="bkt-platform-button-title">ЭТП {{item.trade.tradePlace.name ?
                                    item.trade.tradePlace.name : ''}}
                                </h5>
                                <h6 class="bkt-platform-button-subtitle">{{item.trade.tradePlace.site ?
                                    item.trade.tradePlace.site : ''}}
                                </h6>
                            </div>
                            <span>
                                 <bkt-icon :name="'ArrowDown'" :color="'primary'" height="10px" width="10px"></bkt-icon>
                            </span>
                        </a>
                    </div>
                    <div class="bkt-card__body">
                        <div class="bkt-wrapper-between bkt-nowrap">
                            <div class="bkt-wrapper bkt-nowrap m-0">
                                <div class="bkt-card__category bkt-bg-primary-lighter">
                                    <bkt-icon :name="'Pencil'" :color="'primary'"
                                              class="bkt-card__category-icon"></bkt-icon>
                                </div>
                                <h5 class="bkt-note__title">Заметка по лоту (видите только вы)</h5>
                            </div>
                            <button class="bkt-button-icon primary" v-if="!item.note" @click="callNoteModal">
                                <bkt-icon :name="'Plus'" class="bkt-button__icon"></bkt-icon>
                            </button>
                        </div>
                        <div class="bkt-note__wrapper bkt-wrapper-down-sm-column" v-if="item.note">
                            <div class="bkt-note w-100 bkt-row outline bkt-wrapper-between bkt-gap-medium">
                                <h6 class="bkt-note__text">{{item.note.title}}</h6>
                                <div class="bkt-note__date-wrapper">
                                    <div class="bkt-card__category bkt-bg-blue-lighter">
                                        <bkt-icon :name="'Date'" :width="'16px'"
                                                  :height="'16px'" :color="'blue'"></bkt-icon>
                                    </div>
                                    <h5 class="bkt-note__date">
                                        {{item.note.date | moment('D MMMM YYYY')}}
                                        <span class="bkt-text-blue">{{item.note.date | moment('HH:mm')}}</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="bkt-wrapper-between bkt-nowrap bkt-w-down-sm-100 bkt-gap">
                                <button type="button" class="bkt-button bkt-note__button bkt-note__button_edit ms-auto"
                                        @click="callNoteModal"
                                        :disabled="loading"
                                >
                                    <bkt-icon name="Pencil" color="primary" width="16px" height="16px"/>
                                </button>
                                <button class="bkt-button bkt-note__button bkt-note__button_delete" @click="removeNote">
                                    <bkt-icon v-show="!note_loading" name="Trash" width="16px"/>
                                    <span v-show="note_loading"
                                          class="spinner-border spinner-border-sm bkt-text-red"
                                          role="status"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bkt-card bkt-lot__card bkt-lot-tasks" v-if="loading">
                    <div class="bkt-card__header bkt-wrapper-between bkt-wrapper-up-md-nowrap m-0 bkt-gap-large">
                        <div class="bkt-gap bkt-wrapper-column bkt-wrapper-down-md">
                            <div class="bkt-lot__card-period bkt-wrapper">
                                <skeleton skeleton_class="bkt-card__category"></skeleton>
                                <h5 class="bkt-card__text">
                                    <skeleton type_name="text" width="120px" height="14px"></skeleton>
                                    <skeleton type_name="text" width="55px" height="10px"></skeleton>
                                    <skeleton type_name="text" width="55px" height="10px"></skeleton>
                                </h5>
                            </div>
                            <div class="bkt-lot__card-period bkt-wrapper">
                                <skeleton skeleton_class="bkt-card__category"></skeleton>
                                <h5 class="bkt-card__text">
                                    <skeleton type_name="text" width="120px" height="14px"></skeleton>
                                    <skeleton type_name="text" width="55px" height="10px"></skeleton>
                                    <skeleton type_name="text" width="55px" height="10px"></skeleton>
                                </h5>
                            </div>
                        </div>
                        <div class="bkt-platform-button bkt-wrapper-between bkt-nowrap">
                            <div>
                                <skeleton type_name="text" width="100px" height="14px"></skeleton>
                                <skeleton type_name="text" width="55px" height="10px" skeleton_class="mb-0"></skeleton>
                            </div>
                            <span>
                                 <bkt-icon :name="'ArrowDown'" :color="'neutral'" height="10px" width="10px"></bkt-icon>
                            </span>
                        </div>
                    </div>
                    <div class="bkt-card__body">
                        <div class="bkt-wrapper-between bkt-nowrap bkt-gap">
                            <div class="bkt-wrapper bkt-nowrap m-0">
                                <skeleton skeleton_class="bkt-card__category"></skeleton>
                                <skeleton type_name="text" width="120px" height="14px" skeleton_class="flex-shrink-1"></skeleton>
                            </div>
                            <skeleton skeleton_class="bkt-button-icon flex-shrink-0"></skeleton>
                        </div>
                        <div class="bkt-note__wrapper bkt-wrapper-down-sm-column">
                            <div class="bkt-note w-100 bkt-row outline bkt-wrapper-between bkt-gap-medium">
                                <skeleton type_name="text" skeleton_class="mb-0" height="12px"></skeleton>
                                <div class="bkt-note__date-wrapper">
                                    <skeleton skeleton_class="bkt-card__category"></skeleton>
                                    <skeleton type_name="text" skeleton_class="mb-0" height="14px"
                                              width="100px"></skeleton>
                                </div>
                            </div>
                            <div class="bkt-wrapper-between bkt-nowrap bkt-w-down-sm-100 bkt-gap">
                                <skeleton width="22px" height="22px"></skeleton>
                                <skeleton width="22px" height="22px"></skeleton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="isLoggedIn" class="col-12 col-lg-12 order-3 px-lg-0">
                <bkt-collapse title="Актуальное по лоту" :count="notifications_pagination.total"
                              id="collapseActualInfo" :loading="notifications_loading"
                              :disabled="notifications.length==0&&!notifications_loading"
                              class="bkt-lot__collapse"
                >
                    <template #collapse v-if="notifications.length>0">
                        <div class="row w-100 m-auto bkt-gap">
                            <div class="col-12 px-0">
                                <div
                                    class="bkt-row outline bkt-wrapper-between bkt-nowrap bkt-gap bkt-wrapper-down-sm-column align-items-start mb-1"
                                    v-for="notify in notifications"
                                >
                                    <h5 v-if="notify.type == 'favourite'" class="">
                                        {{notify.dataFavourite ? notify.dataFavourite.detail : ''}}
                                    </h5>
                                    <h5 class="bkt-text-neutral-dark">
                                        {{ notify.date | moment('D MMMM YYYY')}} в {{ notify.date | moment('HH:mm')}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-12 px-0" v-if="notifications_pagination">
                                <bkt-pagination
                                    :limit="1"
                                    :data="notifications_pagination"
                                    @change-page="getLotNotifications"
                                ></bkt-pagination>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>
            </div>
<!--                                    <div class="col-12 col-lg-5 order-3">-->
<!--                                        <div class="bkt-card bkt-card__body bkt-lot-templates">-->
<!--                                            <div class="bkt-card__header"><h3 class="bkt-card__title">Шаблоны запросов</h3></div>-->
<!--                                            <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">-->
<!--                                                <div class="bkt-template-name text-truncate">-->
<!--                                                    <div class="bkt-card__icon">-->
<!--                                                        <bkt-icon :name="'Note'" :color="'pink'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                    </div>-->
<!--                                                    <h5 class="text-truncate">Заявка на участие в торгах</h5>-->
<!--                                                </div>-->
<!--                                                <div class="bkt-card__icon">-->
<!--                                                    <bkt-icon :name="'ArrowDown'" :color="'primary'"-->
<!--                                                              class="bkt-rotate-270"></bkt-icon>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">-->
<!--                                                <div class="bkt-template-name text-truncate">-->
<!--                                                    <div class="bkt-card__icon">-->
<!--                                                        <bkt-icon :name="'Note'" :color="'pink'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                    </div>-->
<!--                                                    <h5 class="text-truncate">Авто</h5>-->
<!--                                                </div>-->
<!--                                                <div class="bkt-card__icon">-->
<!--                                                    <bkt-icon :name="'ArrowDown'" :color="'primary'"-->
<!--                                                              class="bkt-rotate-270"></bkt-icon>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">-->
<!--                                                <div class="bkt-template-name text-truncate">-->
<!--                                                    <div class="bkt-card__icon">-->
<!--                                                        <bkt-icon :name="'Note'" :color="'pink'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                    </div>-->
<!--                                                    <h5 class="text-truncate">Квартира</h5>-->
<!--                                                </div>-->
<!--                                                <div class="bkt-card__icon">-->
<!--                                                    <bkt-icon :name="'ArrowDown'" :color="'primary'"-->
<!--                                                              style="transform: rotate(270deg)"></bkt-icon>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">-->
<!--                                                <div class="bkt-template-name text-truncate">-->
<!--                                                    <div class="bkt-card__icon">-->
<!--                                                        <bkt-icon :name="'Note'" :color="'pink'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                    </div>-->
<!--                                                    <h5 class="text-truncate">Земля</h5>-->
<!--                                                </div>-->
<!--                                                <div class="bkt-card__icon">-->
<!--                                                    <bkt-icon :name="'ArrowDown'" :color="'primary'"-->
<!--                                                              class="bkt-rotate-270"></bkt-icon>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">-->
<!--                                                <div class="bkt-template-name text-truncate">-->
<!--                                                    <div class="bkt-card__icon">-->
<!--                                                        <bkt-icon :name="'Note'" :color="'pink'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                    </div>-->
<!--                                                    <h5 class="text-truncate">Дом с участком</h5>-->
<!--                                                </div>-->
<!--                                                <div class="bkt-card__icon">-->
<!--                                                    <bkt-icon :name="'ArrowDown'" :color="'primary'"-->
<!--                                                              class="bkt-rotate-270"></bkt-icon>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">-->
<!--                                                <div class="bkt-template-name text-truncate">-->
<!--                                                    <div class="bkt-card__icon">-->
<!--                                                        <bkt-icon :name="'Note'" :color="'pink'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                    </div>-->
<!--                                                    <h5 class="text-truncate">Дебиторская задолженность</h5>-->
<!--                                                </div>-->
<!--                                                <div class="bkt-card__icon">-->
<!--                                                    <bkt-icon :name="'ArrowDown'" :color="'primary'"-->
<!--                                                              class="bkt-rotate-270"></bkt-icon>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <button class="bkt-button primary">-->
<!--                                                Загрузить другой шаблон-->
<!--                                            </button>-->
<!--                                        </div>-->
<!--                                        <div class="bkt-card bkt-card__body bkt-lot-sent-requests">-->
<!--                                            <div class="bkt-card__header"><h3 class="bkt-card__title">Отправленные запросы</h3></div>-->
<!--                                            <div class="bkt-card outline">-->
<!--                                                <div class="bkt-card__feature">-->
<!--                                                    <h6 class="bkt-card__subtitle">16 апреля 2022</h6>-->
<!--                                                    <h6 class="bkt-card__title">Запрос документов по торгам</h6>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="bkt-card outline">-->
<!--                                                <div class="bkt-card__feature">-->
<!--                                                    <h6 class="bkt-card__subtitle">17 апреля 2022</h6>-->
<!--                                                    <h6 class="bkt-card__title">Какой-то запрос</h6>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="col-12 col-lg-7 order-3">-->
<!--                                        <div class="bkt-card bkt-card__body bkt-lot-request">-->
<!--                                            <div class="bkt-card__header">-->
<!--                                                <h3 class="bkt-card__title">Запрос организатору торгов</h3>-->
<!--                                            </div>-->
<!--                                            <div class="row align-items-start" style="gap: 10px 0;">-->
<!--                                                <div class="col-4 ps-md-0 d-none d-md-block">-->
<!--                                                    <h5 class="bkt-lot-request-label">шаблон запроса</h5>-->
<!--                                                </div>-->
<!--                                                <div class="col-12 col-md-8 p-md-0">-->
<!--                                                    <div class="bkt-select__wrapper">-->
<!--                                                        <label class="bkt-select__label d-md-none" for="sortSelect">шаблон запроса</label>-->
<!--                                                        <select class="form-select bkt-select" id="sortSelect" aria-label="">-->
<!--                                                            <option selected>Авто</option>-->
<!--                                                            <option value="1">One</option>-->
<!--                                                            <option value="2">Two</option>-->
<!--                                                            <option value="3">Three</option>-->
<!--                                                        </select>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                                <div class="col-4 ps-md-0 d-none d-md-block">-->
<!--                                                    <h5 class="bkt-lot-request-label">от кого</h5>-->
<!--                                                </div>-->
<!--                                                <div class="col-12 col-md-8 p-md-0">-->
<!--                                                    <bkt-input-->
<!--                                                        name="from_email"-->
<!--                                                        type="email"-->
<!--                                                        label="от кого"-->
<!--                                                        :rules="'required|email'"-->
<!--                                                        placeholder="pochta@gmail.com"-->
<!--                                                        :label_class="'d-md-none'"-->
<!--                                                    >-->
<!--                                                    </bkt-input>-->
<!--                                                </div>-->
<!--                                                <div class="col-4 ps-md-0 d-none d-md-block">-->
<!--                                                    <h5 class="bkt-lot-request-label">кому</h5>-->
<!--                                                </div>-->
<!--                                                <div class="col-12 col-md-8 p-md-0">-->
<!--                                                    <bkt-input-->
<!--                                                        name="to_email"-->
<!--                                                        type="email"-->
<!--                                                        label="кому"-->
<!--                                                        :rules="'required|email'"-->
<!--                                                        placeholder="pochta@gmail.com"-->
<!--                                                        :label_class="'d-md-none'"-->
<!--                                                    >-->
<!--                                                    </bkt-input>-->
<!--                                                </div>-->
<!--                                                <div class="col-4 ps-md-0 d-none d-md-block">-->
<!--                                                    <h5 class="bkt-lot-request-label">тема запрос</h5>-->
<!--                                                </div>-->
<!--                                                <div class="col-12 col-md-8 p-md-0">-->
<!--                                                    <bkt-input-->
<!--                                                        name="subject"-->
<!--                                                        type="text"-->
<!--                                                        label="тема запроса"-->
<!--                                                        :rules="'required'"-->
<!--                                                        placeholder=""-->
<!--                                                        :label_class="'d-md-none'"-->
<!--                                                    >-->
<!--                                                    </bkt-input>-->
<!--                                                </div>-->
<!--                                                <div class="col-4 ps-md-0 d-none d-md-block">-->
<!--                                                    <h5 class="bkt-lot-request-label">текст запроса</h5>-->
<!--                                                </div>-->
<!--                                                <div class="col-12 col-md-8 p-md-0">-->
<!--                                                    <bkt-textarea-->
<!--                                                        name="description"-->
<!--                                                        type="text"-->
<!--                                                        label="текст запроса"-->
<!--                                                        :rules="'required'"-->
<!--                                                        placeholder=""-->
<!--                                                        :label_class="'d-md-none'"-->
<!--                                                    ></bkt-textarea>-->
<!--                                                </div>-->

<!--                                                <div class="col-4 ps-md-0 d-none d-md-block"></div>-->
<!--                                                <div class="col-12 col-md-8 p-md-0">-->
<!--                                    <div class="bkt-tag__list">-->
<!--                                        <div class="bkt-tag justify-content-between flex-fill" v-for="(item, index) in question.files">-->
<!--                                            <span class="bkt-text-truncate">{{ item.name }}</span>-->
<!--                                            <h6 class="bkt-text-neutral">{{ item.file_size }}</h6>-->

<!--                                            <span class="bkt-tag__icon bkt-cursor-pointer" @click="removeFile(index)">-->
<!--                                                    <bkt-icon name="Cancel" color="red" width="12px" height="12px"></bkt-icon>-->
<!--                                                </span>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                                    <div class="bkt-lot-request-actions bkt-wrapper-between">-->
<!--                                    <bkt-upload-file v-model="files" ref="upload_file"></bkt-upload-file>-->
<!--                                                        <button class="bkt-button primary" style="flex-grow:1">-->
<!--                                                            Отправить-->
<!--                                                        </button>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="col-12 col-lg-6 order-3">-->
<!--                                        <div class="bkt-card bkt-lot-required-documents">-->
<!--                                            <div class="bkt-card__body">-->
<!--                                                <div class="bkt-card__header">-->
<!--                                                    <h3 class="bkt-card__title">Необходимые документы</h3>-->
<!--                                                </div>-->
<!--                                                <div class="bkt-requred-document">-->
<!--                                                    <div class="bkt-card__row outline w-100 bkt-wrapper-between bkt-nowrap">-->
<!--                                                        <h5 class="text-truncate">Свидетельство о праве собственности</h5>-->
<!--                                                        <div class="bkt-card__icon">-->
<!--                                                            <bkt-icon :name="'Check'" :color="'green'"></bkt-icon>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <button class="bkt-button">-->
<!--                                                        <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>-->
<!--                                                    </button>-->
<!--                                                </div>-->
<!--                                                <div class="bkt-requred-document">-->
<!--                                                    <div class="bkt-card__row outline w-100 bkt-wrapper-between bkt-nowrap">-->
<!--                                                        <h5 class="text-truncate">Правоустанавливающие документы</h5>-->
<!--                                                        <div class="bkt-card__icon">-->
<!--                                                            <bkt-icon :name="'DotsCircle'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <button class="bkt-button">-->
<!--                                                        <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>-->
<!--                                                    </button>-->
<!--                                                </div>-->
<!--                                                <div class="bkt-requred-document">-->
<!--                                                    <div class="bkt-card__row outline w-100 bkt-wrapper-between bkt-nowrap">-->
<!--                                                        <h5 class="text-truncate">Кадастровый паспорт участка</h5>-->
<!--                                                        <div class="bkt-card__icon">-->
<!--                                                            <bkt-icon :name="'Download'" :color="'primary'" :width="'16px'"-->
<!--                                                                      :height="'16px'"></bkt-icon>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <button class="bkt-button">-->
<!--                                                        <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>-->
<!--                                                    </button>-->
<!--                                                </div>-->
<!--                                                <div class="bkt-requred-document">-->
<!--                                                    <div class="bkt-card__row outline  w-100 bkt-wrapper-between bkt-nowrap">-->
<!--                                                        <h5 class="text-truncate">Положение о порядке и сроках реализации имуще...</h5>-->
<!--                                                        <div class="bkt-card__icon">-->
<!--                                                            <bkt-icon :name="'Download'" :color="'primary'" :width="'16px'"-->
<!--                                                                      :height="'16px'"></bkt-icon>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <button class="bkt-button">-->
<!--                                                        <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>-->
<!--                                                    </button>-->
<!--                                                </div>-->
<!--                                                <div class="bkt-requred-document">-->
<!--                                                    <div class="bkt-card__row outline w-100 bkt-wrapper-between bkt-nowrap">-->
<!--                                                        <h5 class="text-truncate">Оценка рыночной стоимости участка</h5>-->
<!--                                                        <div class="bkt-card__icon">-->
<!--                                                            <bkt-icon :name="'Check'" :color="'green'"></bkt-icon>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <button class="bkt-button">-->
<!--                                                        <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>-->
<!--                                                    </button>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="col-12 col-lg-3 order-3">-->
<!--                                        <div class="bkt-card bkt-card__body bkt-lot-document-sets">-->
<!--                                            <div class="bkt-card__header"><h3 class="bkt-card__title">Наборы документов</h3></div>-->
<!--                                            <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">-->
<!--                                                <div class="bkt-card__icon">-->
<!--                                                    <bkt-icon :name="'Note'" :color="'blue'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                </div>-->
<!--                                                <h5 class="text-truncate">Авто</h5>-->
<!--                                            </div>-->
<!--                                            <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">-->
<!--                                                <div class="bkt-card__icon">-->
<!--                                                    <bkt-icon :name="'Note'" :color="'blue'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                </div>-->
<!--                                                <h5 class="text-truncate">Квартира</h5>-->
<!--                                            </div>-->
<!--                                            <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">-->
<!--                                                <div class="bkt-card__icon">-->
<!--                                                    <bkt-icon :name="'Note'" :color="'blue'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                </div>-->
<!--                                                <h5 class="text-truncate">Земля</h5>-->
<!--                                            </div>-->
<!--                                            <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">-->
<!--                                                <div class="bkt-card__icon">-->
<!--                                                    <bkt-icon :name="'Note'" :color="'blue'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                </div>-->
<!--                                                <h5 class="text-truncate">Дом с участком</h5>-->
<!--                                            </div>-->
<!--                                            <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">-->
<!--                                                <div class="bkt-card__icon">-->
<!--                                                    <bkt-icon :name="'Note'" :color="'blue'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                </div>-->
<!--                                                <h5 class="text-truncate">Дебиторская задолженность</h5>-->
<!--                                            </div>-->
<!--                                            <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">-->
<!--                                                <div class="bkt-card__icon">-->
<!--                                                    <bkt-icon :name="'Note'" :color="'blue'" :width="'16px'" :height="'16px'"></bkt-icon>-->
<!--                                                </div>-->
<!--                                                <h5 class="text-truncate">Свой набор</h5>-->
<!--                                            </div>-->
<!--                                            <button class="bkt-button primary">Добавить набор</button>-->
<!--                                        </div>-->
<!--                                    </div>-->
            <div v-if="isLoggedIn" class="col-12 order-3 px-lg-0">
                <bkt-collapse title="График снижения цены" id="priceReduction" :loading="loading"
                              :disabled="loading" class="bkt-lot__collapse"
                >
                    <template #collapse>
                        <div class="bkt-lot-my-files bkt-lot-price-reduction">
<!--                            <div class="bkt-card__header">-->
<!--                                <h3 class="bkt-card__title">График снижения цены</h3>-->
<!--                            </div>-->
                            <div class="bkt-card__inner bkt-wrapper-column bkt-gap">
                                <template v-if="item.priceReduction && item.priceReduction.length>0">
                                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap align-items-center"
                                         v-for="reduction in item.priceReduction">
                                        <h6 class="bkt-text-neutral-dark">{{reduction.time | moment('DD.MM.YYYY HH:mm')}}</h6>
                                        <h5>{{reduction.price | priceFormat}} ₽</h5>
                                        <!--                            :class="{'bkt-text-green': reduction.price > item.startPrice,
                                                                    'bkt-text-primary': reduction.price == item.startPrice,
                                                                    'bkt-text-red': reduction.price < item.startPrice }"-->
                                    </div>
                                </template>
                                <div v-else
                                     class="bkt-wrapper-column my-auto justify-content-center align-items-center text-center"
                                     style="padding-bottom:54px;"
                                >
                                    <bkt-icon name="ArrowDownCircle" color="neutral-light" class="mx-auto" width="80%"
                                              height="200px"></bkt-icon>
                                    <h5 class="bkt-text-neutral">Измений ещё не было</h5>
                                </div>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>
            </div>
<!--            <div v-if="isLoggedIn" class="col-12 col-lg-6 order-3 pe-lg-0">-->
<!--                <bkt-collapse title="Мои файлы" id="myFiles" :loading="files_loading"-->
<!--                              :disabled="files_loading" class="bkt-lot__collapse"-->
<!--                >-->
<!--                    <template #collapse>-->
<!--                        <div class="bkt-lot-my-files">-->
<!--&lt;!&ndash;                            <div class="bkt-card__header">&ndash;&gt;-->
<!--&lt;!&ndash;                                <h3 class="bkt-card__title">Мои файлы</h3>&ndash;&gt;-->
<!--&lt;!&ndash;                            </div>&ndash;&gt;-->
<!--                            &lt;!&ndash;                    user_files&ndash;&gt;-->
<!--                            <div class="bkt-card__inner bkt-wrapper-column justify-content-start bkt-gap">-->
<!--                                <template v-if="user_files.length>0">-->
<!--                                    <bkt-dropdown v-for="(file, index) in user_files" :key="index"-->
<!--                                                  :title="file.name" :subtitle="file.file_size" icon="More"-->
<!--                                                  :dropdown_item_class="['bkt-card__row outline', {'disabled': !file.url}]"-->
<!--                                                  dropdown_icon_class="bkt-rotate-90"-->
<!--                                                  :dropdown_menu_class="['bkt-dropdown__menu_neutral bkt-dropdown__menu_list', {'d-none': !file.url}]"-->
<!--                                    >-->
<!--                                        <template #menu>-->
<!--                                            <a :href="file.url[0]" target="_blank" class="h-100 w-100">-->
<!--                                                <div class="bkt-dropdown__menu-item bkt-wrapper-between bkt-cursor-pointer">-->
<!--                                                    <div class="bkt-dropdown__menu-text">-->
<!--                                                        Скачать-->
<!--                                                    </div>-->
<!--                                                    <div class="bkt-dropdown__menu-icon">-->
<!--                                                        <bkt-icon name="Download" color="blue"></bkt-icon>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </a>-->
<!--                                            <div class="bkt-dropdown__menu-item bkt-wrapper-between bkt-cursor-pointer"-->
<!--                                                 @click="deleteFile(file.id, index)">-->
<!--                                                <div class="bkt-dropdown__menu-text">-->
<!--                                                    Удалить-->
<!--                                                </div>-->
<!--                                                <div class="bkt-dropdown__menu-icon">-->
<!--                                                    <bkt-icon name="Trash" color="red"></bkt-icon>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </template>-->
<!--                                        <template #icon_wrapper v-if="in_process.includes('id'+file.id)">-->
<!--                                      <span role="status" class="spinner-border spinner-border-sm bkt-text-primary">-->
<!--                                      </span>-->
<!--                                        </template>-->
<!--                                    </bkt-dropdown>-->
<!--                                </template>-->
<!--                                <template v-if="new_user_files.length>0">-->
<!--                                    <h5 class="bkt-text-neutral mx-auto">новые незагруженные файлы</h5>-->
<!--                                    <bkt-dropdown v-for="(file, index) in new_user_files" :key="index"-->
<!--                                                  :title="file.name" :subtitle="file.file_size" icon="More"-->
<!--                                                  dropdown_item_class="bkt-card__row outline disabled"-->
<!--                                                  dropdown_icon_class="bkt-rotate-90"-->
<!--                                                  dropdown_menu_class="d-none"-->
<!--                                    >-->
<!--                                        <template #icon_wrapper v-if="!file.url">-->
<!--                                            <div class="d-flex bkt-nowrap bkt-gap">-->
<!--                                                <div class="bkt-dropdown__item-icon" @click="saveFile(index)"-->
<!--                                                     data-bs-toggle="tooltip" data-bs-placement="top" title="Сохранить"-->
<!--                                                     v-show="!in_process.includes(index)"-->
<!--                                                >-->
<!--                                                    <bkt-icon name="Check" color="green" width="22px" height="22px"></bkt-icon>-->
<!--                                                </div>-->
<!--                                                <div class="bkt-dropdown__item-icon" @click="removeFile(index)"-->
<!--                                                     data-bs-toggle="tooltip" data-bs-placement="top" title="Отменить"-->
<!--                                                     v-show="!in_process.includes(index)"-->
<!--                                                >-->
<!--                                                    <bkt-icon name="Cancel" color="red" width="16px" height="16px"></bkt-icon>-->
<!--                                                </div>-->
<!--                                                <span v-if="in_process.includes(index)" role="status"-->
<!--                                                      class="spinner-border spinner-border-sm bkt-text-primary"-->
<!--                                                >-->
<!--                                         </span>-->
<!--                                            </div>-->
<!--                                        </template>-->
<!--                                    </bkt-dropdown>-->
<!--                                </template>-->
<!--                                <div v-if="user_files.length===0 && new_user_files.length===0"-->
<!--                                     class="bkt-wrapper-column my-auto justify-content-center align-items-center text-center">-->
<!--                                    <bkt-icon name="Download" color="neutral-light" class="mx-auto" width="80%"-->
<!--                                              height="200px"></bkt-icon>-->
<!--                                    <h5 class="bkt-text-neutral">Добавьте файлы к лоту</h5>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <bkt-upload-file v-model="new_user_files" ref="upload_file"-->
<!--                                             upload_button_class="bkt-button green w-100">-->
<!--                                <template #upload_button_inner>-->
<!--                                    Добавить файл-->
<!--                                </template>-->
<!--                            </bkt-upload-file>-->
<!--                        </div>-->
<!--                    </template>-->
<!--                </bkt-collapse>-->
<!--            </div>-->
            <div v-if="item && isLoggedIn" class="col-12 col-lg-12 order-3 px-lg-0">
                <bkt-collapse title="Связанные лоты" :count="related_lots_pagination.total"
                              id="collapseRelatedLots" :loading="related_lots_loading"
                              :disabled="related_lots.length==0&&!related_lots_loading"
                              class="bkt-lot__collapse"
                >
                    <template #collapse v-if="related_lots.length>0">
                        <div class="row w-100 m-auto bkt-gap">
                            <div class="col-12 p-0 d-none d-md-block">
                                <div
                                    style="padding-bottom: 10px"
                                    class="row w-100 mx-auto align-items-center justify-content-center"
                                >
                                    <div class="col-2 pl-0">
                                        <h6 class="bkt-text-neutral-dark">фото</h6>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="bkt-text-neutral-dark">описание лота</h6>
                                    </div>
                                    <div class="col-2">
                                        <h6 class="bkt-text-neutral-dark">цена</h6>
                                    </div>
                                    <div class="col-2">
                                        <h6 class="bkt-text-neutral-dark">даты торгов</h6>
                                    </div>
                                    <div class="col-3">
                                        <!--                                        <h6 class="bkt-text-neutral-dark">ЭТП и организатор</h6>-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 px-0" v-for="related_lot in related_lots">
                                <mini-trade-card :item="related_lot" @navigate="getMiniLot"></mini-trade-card>
                            </div>
                            <div class="col-12 px-0" v-if="related_lots_pagination">
                                <bkt-pagination
                                    :limit="1"
                                    :data="related_lots_pagination"
                                    @change-page="getRelatedLots"
                                ></bkt-pagination>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>
            </div>
            <div v-if="item.trade && item.trade.debtor && isLoggedIn" class="col-12 col-lg-12 order-3 px-lg-0">
                <div class="bkt-card bkt-card__body bkt-lot__card">
                    <div class="bkt-card__header bkt-wrapper-between pb-0">
                        <h3 class="bkt-card__title">Информация по должнику</h3>
                        <!--                        <a href="" class="bkt-button next ps-sm-2 py-md-0" style="line-height: 1;">-->
                        <!--                            Сообщения по должнику-->
                        <!--                            <span class="bkt-text-neutral-dark">(0)</span>-->
                        <!--                            <bkt-icon name="ArrowDown"></bkt-icon>-->
                        <!--                        </a>-->
                        <router-link custom v-slot="{navigate}" :to="'/registries/debtor/'+item.trade.debtor.id"
                                     v-if="item.trade && item.trade.debtor"
                        >
                            <button class="bkt-button next" @click="navigate">
                                Подробнее о должнике
                                <bkt-icon name="ArrowDown" color="primary"></bkt-icon>
                            </button>
                        </router-link>
                    </div>
                    <ul class="bkt-contents">
                        <li>
                            <div class="bkt-contents__heading"><span>должник</span></div>
                            <div class="bkt-contents__answer">
                                <span v-if="item.trade.debtor.type=='person'">
                                    <template v-for="(value, key, index) in item.trade.debtor.person">
                                         {{value ? value+' ' : ''}}
                                    </template>
                                </span>
                                <span v-else>
                                    {{item.trade.debtor.company.shortName ? item.trade.debtor.company.shortName : item.trade.debtor.company.fullName}}
                                </span>
                            </div>
                        </li>
                        <!--                        <li>-->
                        <!--                            <div class="bkt-contents__heading"><span>дело №</span></div>-->
                        <!--                            <div class="bkt-contents__answer"><span>1234567890/85</span></div>-->

                        <!--                        </li>-->
                        <!--                        <li>-->
                        <!--                            <div class="bkt-contents__heading"><span>суд</span></div>-->
                        <!--                            <div class="bkt-contents__answer"><span>Арбитражный Суд республики Башкортостан</span>-->
                        <!--                            </div>-->
                        <!--                        </li>-->
                        <li v-if="item.trade.debtor.inn">
                            <div class="bkt-contents__heading"><span>ИНН</span></div>
                            <div class="bkt-contents__answer"><span>{{item.trade.debtor.inn}}</span></div>
                        </li>
                        <!--                        <li>-->
                        <!--                            <div class="bkt-contents__heading"><span>регион</span></div>-->
                        <!--                            <div class="bkt-contents__answer"><span>Республика Башкортостан</span></div>-->
                        <!--                        </li>-->
                        <!--                        <li>-->
                        <!--                            <div class="bkt-contents__heading"><span>адрес должника</span></div>-->
                        <!--                            <div class="bkt-contents__answer"><span>РБ, г. Стерлитамак ул. Фурманова д. 6</span>-->
                        <!--                            </div>-->
                        <!--                        </li>-->
                    </ul>
                </div>
            </div>
            <div v-if="item.trade && item.trade.debtor && isLoggedIn" class="col-12 col-lg-12 order-3 px-lg-0">
                <bkt-collapse title="Другие активные лоты должника" :count="debtor_active_lots_pagination.total"
                              id="collapseDebtorActiveLots" :loading="debtor_active_lots_loading"
                              :disabled="debtor_active_lots.length==0&&!debtor_active_lots_loading"
                              class="bkt-lot__collapse"
                >
                    <template #collapse v-if="debtor_active_lots.length>0">
                        <div class="row w-100 m-auto bkt-gap">
                            <div class="col-12 px-0 d-none d-md-block">
                                <div class="row w-100 mx-auto align-items-center justify-content-center">
                                    <div class="col-2 pl-0">
                                        <h6 class="bkt-text-neutral-dark">фото</h6>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="bkt-text-neutral-dark">описание лота</h6>
                                    </div>
                                    <div class="col-2">
                                        <h6 class="bkt-text-neutral-dark">цена</h6>
                                    </div>
                                    <div class="col-2">
                                        <h6 class="bkt-text-neutral-dark">даты торгов</h6>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="bkt-text-neutral-dark">ЭТП и организатор</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 px-0" v-for="active_lot in debtor_active_lots">
                                <mini-trade-card :item="active_lot" @navigate="getMiniLot"></mini-trade-card>
                            </div>
                            <div class="col-12 px-0" v-if="debtor_active_lots_pagination">
                                <bkt-pagination
                                    :limit="1"
                                    :data="debtor_active_lots_pagination"
                                    @change-page="getDebtorActiveLots"
                                ></bkt-pagination>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>
            </div>
            <div v-if="item.trade && item.trade.debtor && isLoggedIn" class="col-12 col-lg-12 order-3 px-lg-0">
                <bkt-collapse title="Завершённые лоты должника " :count="debtor_completed_lots_pagination.total"
                              id="collapseCompletedLots" :loading="debtor_completed_lots_loading"
                              :disabled="debtor_completed_lots.length==0&&!debtor_completed_lots_loading"
                              class="bkt-lot__collapse"
                >
                    <template #collapse v-if="debtor_completed_lots.length>0">
                        <div class="row w-100 m-auto bkt-gap">
                            <div class="col-12 p-0 d-none d-md-block">
                                <div
                                    style="padding-bottom: 10px"
                                    class="row w-100 mx-auto align-items-center justify-content-center"
                                >
                                    <div class="col-2 pl-0">
                                        <h6 class="bkt-text-neutral-dark">фото</h6>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="bkt-text-neutral-dark">описание лота</h6>
                                    </div>
                                    <div class="col-2">
                                        <h6 class="bkt-text-neutral-dark">цена</h6>
                                    </div>
                                    <div class="col-2">
                                        <h6 class="bkt-text-neutral-dark">даты торгов</h6>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="bkt-text-neutral-dark">ЭТП и организатор</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 px-0" v-for="complete_lot in debtor_completed_lots">
                                <mini-trade-card :item="complete_lot" @navigate="getMiniLot"></mini-trade-card>
                            </div>
                            <div class="col-12 px-0" v-if="debtor_completed_lots_pagination">
                                <bkt-pagination
                                    :limit="1"
                                    :data="debtor_completed_lots_pagination"
                                    @change-page="getDebtorCompletedLots"
                                ></bkt-pagination>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>
            </div>
            <div v-if="item.trade && item.trade.organizer && isLoggedIn" class="col-12 col-lg-8 order-3 ps-lg-0">
                <div class="bkt-card bkt-card__body bkt-lot__card">
                    <div class="bkt-card__header pb-0">
                        <h3 class="bkt-card__title">Информация по организатору</h3>
                        <router-link custom v-slot="{navigate}" :to="'/registries/organizer/'+item.trade.organizer.id"
                                     v-if="item.trade && item.trade.organizer"
                        >
                            <button class="bkt-button next" @click="navigate">
                                Подробнее об организаторе
                                <bkt-icon name="ArrowDown" color="primary"></bkt-icon>
                            </button>
                        </router-link>
                    </div>

                    <ul class="bkt-contents">
                        <li>
                            <div class="bkt-contents__heading"><span>организатор</span></div>
                            <div class="bkt-contents__answer bkt-text-green" v-if="item.trade && item.trade.organizer">
                                <span v-if="item.trade.organizer.type=='person'">
                                    <template v-for="(value, key, index) in item.trade.organizer.person">
                                         {{value ? value+' ' : ''}}
                                    </template>
                                </span>
                                <span v-else>
                                    {{item.trade.organizer.company.shortName ? item.trade.organizer.company.shortName : item.trade.organizer.company.fullName}}
                                </span>
                            </div>
                            <div v-else class="bkt-contents__answer">
                                не указано
                            </div>
                        </li>
                        <li v-if="item.trade && item.trade.organizer">
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">ИНН</span>
                            </div>
                            <div class="bkt-contents__answer"><span>{{item.trade.organizer.inn}}</span>
                            </div>
                        </li>
                        <!--                        <li>-->
                        <!--                            <div class="bkt-contents__heading">-->
                        <!--                                <span class="bkt-contents__heading">телефон</span>-->
                        <!--                            </div>-->
                        <!--                            <div class="bkt-contents__answer kt-text-primary"><span>+7 (919) 333 44-55</span>-->
                        <!--                            </div>-->
                        <!--                        </li>-->
                        <!--                        <li>-->
                        <!--                            <div class="bkt-contents__heading">-->
                        <!--                                <span class="bkt-contents__heading">почта</span>-->
                        <!--                            </div>-->
                        <!--                            <div class="bkt-contents__answer"><span>pochta@mail.ru</span>-->
                        <!--                            </div>-->
                        <!--                        </li>-->
                    </ul>
                    <!--                    <div class="bkt-wrapper-between align-items-center">-->
                    <!--                        <button class="bkt-button next">-->
                    <!--                            мои победы-->
                    <!--                            <span class="bkt-text-red" style="text-transform: initial"> (добавьте ИНН)  </span>-->
                    <!--                            <bkt-icon name="ArrowDown" color="green"></bkt-icon>-->
                    <!--                        </button>-->
                    <!--                        <div class="bkt-rating text-center">-->
                    <!--                            <h6>3,3 / 5</h6>-->
                    <!--                            <star-rating :show-rating="false" :rating="3.3" :read-only="true" :star-size="16"-->
                    <!--                                         :increment="0.01" :rounded-corners="false"></star-rating>-->
                    <!--                        </div>-->
                    <!--                        <button class="bkt-button bkt-bg-body text-uppercase bkt-text-main">-->
                    <!--                            оценить организатора-->
                    <!--                            <bkt-icon name="ArrowDown" color="primary" class="bkt-rotate-270"></bkt-icon>-->
                    <!--                        </button>-->
                    <!--                    </div>-->
                </div>
            </div>
            <div v-if="isLoggedIn && item.trade && item.trade.arbitrationManager"
                 class="col-12 col-lg-4 order-3 pe-lg-0">
                <div class=" bkt-card bkt-card__body bkt-lot__card">
                    <div class="bkt-card__header pb-0">
                        <h3 class="bkt-card__title bkt-lot__card-title">Информация по арбитражному управляющему</h3>
                        <router-link custom v-slot="{navigate}"
                                     :to="'/registries/arbitrationManager/'+item.trade.arbitrationManager.id"
                                     v-if="item.trade && item.trade.arbitrationManager"
                        >
                            <button class="bkt-button next" @click="navigate">
                                Подробнее об управляющем
                                <bkt-icon name="ArrowDown" color="primary"></bkt-icon>
                            </button>
                        </router-link>
                    </div>
                    <ul class="bkt-contents">
                        <li>
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">арбитражный управляющий</span>
                            </div>
                            <div class="bkt-contents__answer">
                                <span v-if="item.trade.arbitrationManager.type =='person'">
                                    <template v-for="(value, key, index) in item.trade.arbitrationManager.person">
                                         {{value ? value+' ' : ''}}
                                    </template>
                                </span>
                                <span v-else>
                                    {{item.trade.arbitrationManager.company.shortName ? item.trade.arbitrationManager.company.shortName : item.trade.arbitrationManager.company.fullName}}
                                </span>
                            </div>
                        </li>
                        <li v-if="item.trade.arbitrationManager.inn">
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">ИНН</span>
                            </div>
                            <div class="bkt-contents__answer"><span>{{item.trade.arbitrationManager.inn}}</span>
                            </div>
                        </li>
                        <li v-if="item.trade.arbitrationManager.sro">
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">СРО</span>
                            </div>
                            <div class="bkt-contents__answer" style="font-size: 12px; font-weight:600">
                                <span>{{item.trade.arbitrationManager.sro}}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div v-if="isLoggedIn" class="col-12 col-lg-12 order-3 px-lg-0">
                <bkt-collapse title="Документы по торгам" :count="files.length" class="bkt-lot__collapse"
                              id="collapseDocuments" :loading="files_loading" :disabled="files.length==0"
                >
                    <template #collapse v-if="files.length>0">
                        <div class="row w-100 row-cols-2 g-2 align-items-stretch mx-auto">
                            <div class="col-12 col-md-6" v-for="file in files">
                                <a :href="file.url" target="_blank" class="h-100">
                                    <div class="row bkt-row outline align-items-start bkt-nowrap h-100">
                                        <div class="col p-0" style="max-width: 28px;">
                                            <bkt-icon name="Note" color="red" width="16px" height="16px"
                                                      class="d-flex"></bkt-icon>
                                        </div>
                                        <div class="col">
                                            <h6>{{file.title}}</h6>
                                        </div>
                                        <!--                                    <div class="col-7 col-md-8 px-1">-->
                                        <!--                                        <h6>{{file}}</h6>-->
                                        <!--                                    </div>-->
                                        <!--                                    <div class="col p-0">-->
                                        <!--                                        <h6 class="bkt-text-blue">jpg</h6>-->
                                        <!--                                    </div>-->
                                        <!--                                    <div class="col p-0">-->
                                        <!--                                        <h6 class="bkt-text-neutral-dark">23.1 Mb</h6>-->
                                        <!--                                    </div>-->
                                    </div>
                                </a>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>
            </div>
            <div v-if="isLoggedIn && item.biddingInfo" class="col-12 col-lg-12 order-3 px-lg-0">
                <bkt-collapse title="Информация о торгах" class="bkt-lot__collapse"
                              id="biddingInfo"
                >
                    <template #collapse>
                        <h5 class="bkt-card__text">
                            {{item.biddingInfo}}
                        </h5>
                    </template>
                </bkt-collapse>
            </div>
<!--            <div v-if="isLoggedIn && item.applicationRules" class="col-12 col-lg-12 order-3 px-lg-0">-->
<!--                <bkt-collapse title="Правила подачи заявок" class="bkt-lot__collapse"-->
<!--                              id="applicationRules"-->
<!--                >-->
<!--                    <template #collapse>-->
<!--                        <h5 class="bkt-card__text">-->
<!--                            {{item.applicationRules}}-->
<!--                        </h5>-->
<!--                    </template>-->
<!--                </bkt-collapse>-->
<!--            </div>-->
            <div v-if="isLoggedIn && item.requirementsForParticipants" class="col-12 col-lg-12 order-3 px-lg-0">
                <bkt-collapse title="Требования к участникам" class="bkt-lot__collapse"
                              id="requirementsForParticipants"
                >
                    <template #collapse>
                        <h5 class="bkt-card__text">
                            {{item.requirementsForParticipants}}
                        </h5>
                    </template>
                </bkt-collapse>
            </div>
<!--            <div v-if="isLoggedIn && item.paymentInfo" class="col-12 col-lg-12 order-3 px-lg-0">-->
<!--                <bkt-collapse title="Информация об оплате" class="bkt-lot__collapse"-->
<!--                              id="paymentInfo"-->
<!--                >-->
<!--                    <template #collapse>-->
<!--                        <h5 class="bkt-card__text">-->
<!--                            {{item.paymentInfo}}-->
<!--                        </h5>-->
<!--                    </template>-->
<!--                </bkt-collapse>-->
<!--            </div>-->
<!--            <div v-if="isLoggedIn && item.saleAgreement" class="col-12 col-lg-12 order-3 px-lg-0">-->
<!--                <bkt-collapse title="Порядок и срок заключения договора купли-продажи" class="bkt-lot__collapse"-->
<!--                              id="saleAgreement"-->
<!--                >-->
<!--                    <template #collapse>-->
<!--                        <h5 class="bkt-card__text">-->
<!--                            {{item.saleAgreement}}-->
<!--                        </h5>-->
<!--                    </template>-->
<!--                </bkt-collapse>-->
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
    import StarRating from 'vue-star-rating'
    import BktCollapse from '../components/Collapse.vue'
    import BktCardActions from '../components/CardActions.vue'
    import BktCardImageCategory from "../components/CardImageCategory";
    import MiniTradeCard from "../components/MiniTradeCard";
    import BktDropdown from "../components/Dropdown";
    import BktUploadFile from "../components/UploadFile";
    import MoveFavouriteModal from "./Favourites/MoveFavouriteModal";
    import NoteModal from "../components/SharedModals/NoteModal";
    import BktApplicationModal from "../components/SharedModals/ApplicationModal";
    import AddMarkModal from "./LotCard/AddMarkModal";
    import Skeleton from "../components/Skeleton";

    export default {
        name: "LotCard",
        components: {
            AddMarkModal,
            MiniTradeCard,
            Hooper,
            Slide,
            HooperNavigation,
            StarRating,
            BktCollapse,
            BktCardActions,
            BktCardImageCategory,
            BktDropdown,
            BktUploadFile,
            'bkt-move-favourite-modal': MoveFavouriteModal,
            'bkt-add-mark-modal': AddMarkModal,
            'bkt-note-modal': NoteModal, BktApplicationModal,
            Skeleton
        },
        data() {
            return {
                loading: false,
                note_loading: false,
                // item: {},
                files: [],
                user_files: [],
                new_user_files: [],
                in_process: [],
                files_loading: false,
                user_files_loading: false,
                debtor_active_lots: [],
                debtor_active_lots_loading: false,
                debtor_active_lots_pagination: {},
                debtor_completed_lots: [],
                debtor_completed_lots_loading: false,
                debtor_completed_lots_pagination: {},
                related_lots: [],
                related_lots_loading: false,
                related_lots_pagination: {},
                notifications: [],
                notifications_loading: false,
                notifications_pagination: {},
                marks: [],
                marks_in_process: [],
                sharing: {
                    // url: 'https://news.vuejs.org/issues/180',
                    title: 'Успей купить на Лотофонд',
                    // description: '',
                    hashtags: 'lotofond,trade,lot',
                    // twitterUser: 'youyuxi',
                    media: 'https://lotofond.ru/images/card-image1.png'
                },
                networks: [
                    // { network: 'baidu', name: 'Baidu', icon: 'fas fah fa-lg fa-paw', color: '#2529d8' },
                    {network: 'email', name: 'Email', color: '#2953ff'},
                    // { network: 'line', name: 'Line', icon: 'fab fah fa-lg fa-line', color: '#00c300' },
                    // { network: 'linkedin', name: 'LinkedIn', icon: 'fab fah fa-lg fa-linkedin', color: '#007bb5' },
                    {network: 'odnoklassniki', name: 'Odnoklassniki', color: '#ed812b'},
                    // { network: 'skype', name: 'Skype', icon: 'fab fah fa-lg fa-skype', color: '#00aff0' },
                    // { network: 'sms', name: 'SMS', icon: 'far fah fa-lg fa-comment-dots', color: '#333333' },
                    {network: 'telegram', name: 'Telegram', color: '#0088cc'},
                    {network: 'twitter', name: 'Twitter', color: '#1da1f2'},
                    {network: 'viber', name: 'Viber', color: '#59267c'},
                    {network: 'vk', name: 'Vk', color: '#4a76a8'},
                    // { network: 'weibo', name: 'Weibo', icon: 'fab fah fa-lg fa-weibo', color: '#e9152d' },
                    {network: 'whatsapp', name: 'WhatsApp', color: '#25d366'},
                    // { network: 'xing', name: 'Xing', icon: 'fab fah fa-lg fa-xing', color: '#026466' },
                ],
                short_description: '',
                read_more: false,
            };
        },
        computed: {
            trades: function () {
                return this.$store.getters.trades;
            },
            auth_user: function () {
                return this.$store.getters.auth_user;
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
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
                                // cadastralData.cadastralDataAreaMeasure = 'сотки';
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
            item() {
                if (this.loading) {
                    return {}
                }
                return this.$store.getters.selected_lot
            }
        },
        watch: {
            isLoggedIn: function (newVal, oldVal) {
                if (oldVal == false && newVal == true) {
                    this.getLot();
                    this.getLotFiles();
                    this.getLotNotifications();
                    // this.getLotMarks();
                    this.makeWatched();
                }
            }
        },
        async mounted() {
            this.getLot();
            if (this.isLoggedIn) {
                this.getLotFiles();
                this.getLotNotifications();
                // this.getLotMarks();
                this.makeWatched();
            }
        },
        methods: {
            goBack() {
                this.$router.push('/')
                // window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/');
                // setTimeout(() => {
                //     if (this.$route.params.id && this.item && this.$route.params.id != this.item.id) {
                //         this.$nextTick(() => {
                //             console.log('here', this.$route.params.id, this.item.id)
                //             this.getMiniLot();
                //         })
                //     }
                // }, 100)
            },
            async getLot() {
                this.loading = true;
                this.clear();
                // if (this.trades.length > 0) {
                //     let trade = this.trades.findIndex(item => item.id == this.$route.params.id);
                //     if (trade >= 0) {
                //         this.item = JSON.parse(JSON.stringify(this.trades[trade]));
                //     }
                //     this.loading = false;
                // } else {
                await this.$store.dispatch('getTradeLot', this.$route.params.id)
                    .then(resp => {
                        // this.item = resp.data;
                        this.short_description = '';
                        if(resp.data.description.length>0 && resp.data.description.length>1000) {
                            this.short_description = resp.data.description.slice(0, 1000) + '...';
                        }

                        this.$store.commit('setSelectedLot', resp.data);
                        this.loading = false;
                        this.getRelatedLots();
                        this.getDebtorActiveLots();
                        this.getDebtorCompletedLots();
                    })
                    .catch(error => {
                        this.loading = false;
                    });
                // }
            },
            async getLotFiles() {
                this.files_loading = true;
                await this.$store.dispatch('getLotFiles', this.$route.params.id)
                    .then(resp => {
                        this.files = [];
                        resp.data.files.forEach(item => {
                            let str = item;
                            let n = item.lastIndexOf('/');
                            let result = str.substring(n + 1);
                            this.files.push({title: result, url: item})
                        })
                        resp.data.allUserFiles.forEach(item => {
                            let str = item.url[0];
                            let n = item.url[0].lastIndexOf('/');
                            let title = str.substring(n + 1);
                            item.name = title;
                            if (!title) {
                                item.name = 'Файл №' + item.id
                            }
                            this.user_files.push(item)
                        })
                        // this.user_files = resp.data.userFiles;

                    }).catch(error => {

                    }).finally(() => {
                        this.files_loading = false;
                    })
            },
            async getDebtorActiveLots(page = 1) {
                this.debtor_active_lots_loading = true;
                await this.$store.dispatch('getBidderLots', {
                    type: 'active',
                    bidderType: 'debtor',
                    bidderId: this.item.trade.debtor.id,
                    exceptionLotId: this.item.id,
                    page: page
                })
                    .then(resp => {
                        if (resp.data.data) {
                            this.debtor_active_lots = resp.data.data;
                        } else {
                            this.debtor_active_lots = resp.data;
                        }
                        if (resp.data.pagination) {
                            this.debtor_active_lots_pagination = resp.data.pagination;
                        }
                    }).catch(error => {

                    }).finally(() => {
                        this.debtor_active_lots_loading = false;
                    })
            },
            async getDebtorCompletedLots(page = 1) {
                this.debtor_completed_lots_loading = true;
                await this.$store.dispatch('getBidderLots', {
                    type: 'inactive',
                    bidderType: 'debtor',
                    bidderId: this.item.trade.debtor.id,
                    exceptionLotId: this.item.id,
                    page: page
                })
                    .then(resp => {
                        if (resp.data.data) {
                            this.debtor_completed_lots = resp.data.data;
                        } else {
                            this.debtor_completed_lots = resp.data;
                        }
                        if (resp.data.pagination) {
                            this.debtor_completed_lots_pagination = resp.data.pagination;
                        }
                    }).catch(error => {

                    }).finally(() => {
                        this.debtor_completed_lots_loading = false;
                    })
            },
            async getRelatedLots(page = 1) {
                this.related_lots_loading = true;
                await this.$store.dispatch('getTradeLots', {
                    auctionId: this.item.trade.id,
                    page: page
                })
                    .then(resp => {
                        if (resp.data.data) {
                            this.related_lots = resp.data.data;
                        } else {
                            this.related_lots = resp.data;
                        }
                        if (resp.data.pagination) {
                            this.related_lots_pagination = resp.data.pagination;
                        }
                        this.related_lots_loading = false;
                    }).catch(error => {
                        this.related_lots_loading = false;
                    })
            },
            async getLotNotifications(page = 1) {
                this.notifications_loading = true;
                this.$store.dispatch('getLotNotifications', {id: this.$route.params.id, page: page}).then(resp => {
                    if (resp.data.data) {
                        this.notifications = resp.data.data;
                    } else {
                        this.notifications = resp.data;
                    }
                    if (resp.data.pagination) {
                        this.notifications_pagination = resp.data.pagination;
                    }
                    this.notifications_loading = false;
                }).catch(error => {
                    this.notifications_loading = false;
                });
            },
            async getLotMarks() {
                this.$store.dispatch('getLotMarks', this.$route.params.id).then(resp => {
                    this.marks = resp.data;
                }).catch(error => {

                });
            },
            getMiniLot() {
                this.getLot();
                if (this.isLoggedIn) {
                    this.getLotFiles();
                    this.getLotNotifications();
                    // this.getLotMarks();
                    this.makeWatched();
                }
            },
            changeStatus(payload) {
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'lots', state_key: 'selected_lot',
                    key: payload.key,
                    value: payload.value
                }, {root: true});
                // Vue.set(this.item, payload.key, payload.value)
            },
            callNoteModal() {
                this.$store.commit('openModal', '#noteModal')
            },
            removeNote() {
                this.note_loading = true;
                this.$store.dispatch('removeLotNote', {noteId: this.item.note.id})
                    .then(resp => {
                        this.$store.dispatch('saveDataProperty', {
                            module_key: 'lots', state_key: 'selected_lot',
                            key: 'note',
                            value: null
                        }, {root: true});
                        this.$store.commit('saveTradeProperty', {
                            id: this.$route.params.id,
                            key: 'note',
                            value: null
                        });
                        this.note_loading = false;
                    }).catch(error => {
                    this.note_loading = false;
                });
            },
            removeMark(id) {
                this.marks_in_process.push(id);
                let index = this.marks_in_process.indexOf(mark_id => mark_id == id);
                this.$store.dispatch('removeLotMark', {markId: id, lotId: this.$route.params.id})
                    .then(resp => {
                        let tmp_marks = JSON.parse(JSON.stringify(this.item.marks));
                        let mark_index = tmp_marks.findIndex(mark => mark.id == id);
                        if (mark_index >= 0) {
                            tmp_marks.splice(mark_index, 1);
                        }
                        this.$store.dispatch('saveDataProperty', {
                            module_key: 'lots', state_key: 'selected_lot',
                            key: 'marks',
                            value: tmp_marks
                        }, {root: true});
                        this.$store.commit('saveTradeProperty', {
                            id: this.$route.params.id,
                            key: 'marks',
                            value: tmp_marks
                        });
                        if (index >= 0) {
                            this.marks_in_process.splice(index, 1);
                        }
                    }).catch(error => {
                    if (index >= 0) {
                        this.marks_in_process.splice(index, 1);
                    }
                });
            },
            sendApplication() {
                this.$store.commit('openModal', '#applicationModal')
            },
            makeWatched() {
                if (!this.item.isWatched) {
                    this.$store.dispatch('changeTradeLotStatus', {lotId: this.$route.params.id, type: 'seen'})
                        .then(resp => {
                            this.$store.dispatch('saveDataProperty', {
                                module_key: 'lots', state_key: 'selected_lot',
                                key: 'isWatched',
                                value: true
                            });
                            this.$store.commit('saveTradeProperty', {
                                id: this.$route.params.id,
                                key: 'isWatched',
                                value: true
                            });
                        })
                }
            },
            saveFile(index) {
                this.in_process.push(index);
                let formData = new FormData();
                formData.append('lotId', this.item.id);
                formData.append("file", this.new_user_files[index]);
                formData.append('fileType', this.new_user_files[index].fileType);
                let file_index = this.in_process.indexOf(index);
                this.$store.dispatch('addLotFile', formData)
                    .then(resp => {
                        // this.user_files = resp.data.userFiles;
                        resp.data.allUserFiles.forEach(item => {
                            if (this.user_files.findIndex(file => file.id == item.id) < 0) {
                                let str = item.url[0];
                                let n = item.url[0].lastIndexOf('/');
                                let title = str.substring(n + 1);
                                item.name = title;
                                if (!title) {
                                    item.name = 'Файл №' + item.id
                                }
                                this.user_files.push(item)
                            }
                        });
                        if (file_index >= 0) {
                            this.in_process.splice(file_index, 1);
                        }
                        this.removeFile(index);
                        this.$store.dispatch('sendNotification',
                            {self: this, message: 'Файл успешно загружен'})
                    }).catch(error => {
                    if (file_index >= 0) {
                        this.in_process.splice(file_index, 1);
                    }
                })
            },
            deleteFile(id, index) {
                this.in_process.push('id' + id);
                let file_index = this.in_process.indexOf('id' + id);
                this.$store.dispatch('removeLotFile', id)
                    .then(resp => {
                        if (file_index >= 0) {
                            this.in_process.splice(file_index, 1);
                        }
                        this.user_files.splice(index, 1);
                        this.$store.dispatch('sendNotification',
                            {self: this, message: 'Файл успешно удалён'})
                    }).catch(error => {
                    if (file_index >= 0) {
                        this.in_process.splice(file_index, 1);
                    }
                })
            },
            removeFile(index) {
                this.$refs.upload_file.removeFile(index);
            },
            pluralization(choice, choicesLength=4) {
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
            clear() {
                this.files=[];
                this.user_files=[];
                this.new_user_files=[];
                this.in_process=[];
                this.debtor_active_lots=[];
                this.debtor_active_lots_pagination={};
                this.debtor_completed_lots=[];
                this.debtor_completed_lots_pagination={};
                this.related_lots=[];
                this.related_lots_pagination={};
                this.notifications=[];
                this.notifications_pagination={};
                this.marks=[];
                this.short_description = '';
                this.read_more = false;
            }
        }
    }
</script>

<style lang="scss" scoped>
</style>
