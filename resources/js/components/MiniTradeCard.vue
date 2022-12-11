<template>
    <div class="bkt-form w-100 mx-auto bkt-row outline bkt-card-trade-mini">
        <div class="col-12 col-lg-2 ps-sm-0 bkt-card-trade-mini__image">
            <div @click="navigate" class="bkt-cursor-pointer"
                 v-if="item && (!item.photos || item.photos.length==0) && item.categories"
            >
                <card-image-category :categories="item.categories"></card-image-category>
            </div>
            <slick v-bind="settings" class="w-100 bkt-card__image-slider" v-if="item && item.photos.length>0">
                <div v-for="photo in item.photos" :key="photo.id">
                    <img v-lazy="photo.preview" class="bkt-card__image bkt-cursor-pointer" @click="navigate"/>
                </div>
                <template #prevArrow="arrowOption">
                    <div class="custom-arrow">
                        <bkt-icon name="ArrowDown" class="bkt-rotate-90"></bkt-icon>
                    </div>
                </template>
                <template #nextArrow="arrowOption">
                    <div class="custom-arrow">
                        <bkt-icon name="ArrowDown" class="bkt-rotate-270"></bkt-icon>
                    </div>
                </template>
            </slick>
        </div>
        <div class="col-12 col-lg-3 bkt-card-trade-mini__description">
            <h6 class="bkt-card__subtitle">
                №
                <skeleton type_name="spoiler" tag="span" :loading="rules && !rules.trade.externalId">{{item.trade.externalId}}</skeleton>
                , лот <skeleton type_name="spoiler_mini" tag="span" :loading="rules && !rules.trade.lotNumber">{{item.lotNumber}}</skeleton>
            </h6>
            <h5 class="bkt-text-truncate bkt-card-trade-mini__title bkt-cursor-pointer" @click="navigate">
                {{item.description}}
            </h5>
        </div>
        <div class="col-12 col-lg-2 bkt-card-trade-mini__price">
            <h6 class="bkt-card__subtitle d-md-none">цена</h6>
            <h4 class="bkt-card__title bkt-text-primary">
                <skeleton type_name="spoiler" tag="span" :loading="rules && !rules.currentPrice">
                    {{item.currentPrice | priceFormat}} ₽
                </skeleton>
            </h4>
        </div>
        <div class="col-12 col-lg-2 bkt-card-trade-mini__dates">
            <h6 class="bkt-card__subtitle d-md-none">даты торгов</h6>
            <skeleton type_name="spoiler" tag="h6" :loading="rules && !rules.trade.eventTime">
                <div v-if="item.trade && item.trade.eventTime &&
                     (item.trade.eventTime.start || item.trade.eventTime.end)"
                >
                    <h6 v-if="item.trade.eventTime.start">
                        с {{item.trade.eventTime.start | moment('DD MMMM YYYY HH:mm')}}
                    </h6>
                    <h6 v-if="item.trade.eventTime.end">до
                        {{item.trade.eventTime.end | moment('DD MMMM YYYY HH:mm')}}
                    </h6>
                </div>
                <h6 v-else>не указано</h6>
            </skeleton>
        </div>
        <div class="col-12 col-lg-3 bkt-card-trade-mini__organizer">
            <h6 class="bkt-card__subtitle d-md-none">ЭТП и организатор</h6>
            <skeleton type_name="spoiler" tag="h6" :loading="rules && !rules.trade.tradePlace">
                <h6 class="bkt-card__title bkt-text-main text-uppercase" v-if="item.trade && item.trade.tradePlace">
                    {{item.trade && item.trade.tradePlace
                    && item.trade.tradePlace.name ?
                    item.trade.tradePlace.name : ''}}
                </h6>
                <h6 v-else-if="item.tradePlaceSite">{{item.tradePlaceSite}}</h6>
            </skeleton>
            <skeleton type_name="spoiler" tag="h5" :loading="rules && !rules.trade.organizer">
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
            </skeleton>
        </div>
    </div>
</template>

<script>
    import CardImageCategory from "./CardImageCategory";
    export default {
        name: "MiniTradeCard",
        props: ['item'],
        components: {
            CardImageCategory
        },
        data() {
            return {
                settings: {
                    "dots": false,
                    "edgeFriction": 0.35,
                    "infinite": false,
                    "slidesToShow": 1,
                    "slidesToScroll": 1
                }
            }
        },
        computed: {
            rules() {
                if(this.$store.getters.auth_user)
                {
                    return this.auth_user.contentDisplayRules.lot
                    // return {
                    //     trade: {
                    //         externalId: false,
                    //         type: false,
                    //         publishDate: false,
                    //         eventTime: false,
                    //         applicationTime: false,
                    //         priceOfferForm: false,
                    //         organizer: false,
                    //         arbitrationManager: false,
                    //         debtor: false,
                    //         tradePlace: false,
                    //         lotCount: false
                    //     },
                    //     lotNumber: false,
                    //     photos: false,
                    //     categories: false,
                    //     state: false,
                    //     location: false,
                    //     startPrice: false,
                    //     stepPrice: false,
                    //     deposit: false,
                    //     priceReduction: false,
                    //     currentPrice: false,
                    //     minPrice: false,
                    //     currentPriceState: false,
                    //     efrsbLink: false,
                    //     descriptionExtracts: false
                    // }
                }
                return null
            }
        },
        methods: {
            navigate() {
                this.$emit('navigate', this.item.id);
                this.$router.push('/lot/'+this.item.id);
            },
        }
    }
</script>

<style scoped>

</style>
