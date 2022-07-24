<template>
    <div class="row w-100 mx-auto bkt-row outline bkt-card-trade-mini">
        <div class="col-12 col-md-2 ps-0 bkt-card-trade-mini__image">
            <hooper :itemsToShow="1" :centerMode="true" class="w-100 h-100" style="min-height: 159px">
                <slide v-if="!item.photos || item.photos.length==0">
                    <img v-lazy="'/images/card-image1.png'" class="bkt-card__image"/>
                </slide>
                <slide v-for="photo in item.photos" :key="photo.id">
                    <img v-lazy="photo.main" class="bkt-card__image"/>
                </slide>
                <hooper-navigation slot="hooper-addons"></hooper-navigation>
            </hooper>
        </div>
        <div class="col-12 col-md-3 bkt-card-trade-mini__description">
            <h6 class="bkt-card__subtitle">
                № {{item.trade.externalId}}, лот {{item.lotNumber}}
            </h6>
            <h5 class="bkt-text-truncate">
                <router-link :to="'/lot/'+item.id">
                {{item.description}}
                </router-link>
            </h5>
        </div>
        <div class="col-12 col-md-2 bkt-card-trade-mini__price">
            <h6 class="bkt-card__subtitle d-md-none">цена</h6>
            <h4 class="bkt-card__title bkt-text-primary">
                {{item.currentPrice | priceFormat}} ₽</h4>
        </div>
        <div class="col-12 col-md-2 bkt-card-trade-mini__dates">
            <h6 class="bkt-card__subtitle d-md-none">даты торгов</h6>
            <div
                v-if="item.trade && item.trade.eventTime &&
                                        (item.trade.eventTime.start || item.trade.eventTime.end)">
                <h6 v-if="item.trade.eventTime.start">
                    с {{item.trade.eventTime.start | moment('DD MMMM YYYY HH:mm')}}
                </h6>
                <h6 v-if="item.trade.eventTime.end">до
                    {{item.trade.eventTime.end | moment('DD MMMM YYYY HH:mm')}}
                </h6>
            </div>
            <h6 v-else>не указано</h6>
        </div>
        <div class="col-12 col-md-3 bkt-card-trade-mini__organizer">
            <h6 class="bkt-card__subtitle d-md-none">ЭТП и организатор</h6>
            <h6 class="bkt-card__title bkt-text-main text-uppercase" v-if="item.trade && item.trade.tradePlace">
                {{item.trade && item.trade.tradePlace
                && item.trade.tradePlace.name ?
                item.trade.tradePlace.name : ''}}
            </h6>
            <h6 v-else-if="item.tradePlaceSite">{{item.tradePlaceSite}}</h6>
            <h5 class="" v-if="item.trade.organizer">
                <span v-if="item.trade.organizer.type=='person'">
                    <template
                        v-for="(value, key, index) in item.trade.organizer.person">
                         {{value ? value+' ' : ''}}
                    </template>
                </span>
                <span v-else>
                    {{item.trade.organizer.company.shortName ?
                    item.trade.organizer.company.shortName :
                    item.trade.organizer.company.fullName}}
                </span>
            </h5>
            <h5 v-else-if="item.organizer">
                <span v-if="item.organizer.type=='person'">
                    <template
                        v-for="(value, key, index) in item.organizer.person">
                         {{value ? value+' ' : ''}}
                    </template>
                </span>
                <span v-else>
                    {{item.organizer.company.shortName ?
                    item.organizer.company.shortName :
                    item.organizer.company.fullName}}
                </span>
            </h5>
        </div>
    </div>
</template>

<script>
    import {
        Hooper,
        Slide,
        Navigation as HooperNavigation
    } from 'hooper';
    export default {
        name: "MiniTradeCard",
        props: ['item'],
        components: {
            Hooper,
            Slide, HooperNavigation
        }
    }
</script>

<style scoped>

</style>
