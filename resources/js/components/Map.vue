<template>
    <yandex-map
        v-if="POINTS.length > 0"
        :height="'500px'"
        :width="'100%'"
        :settings="{ location: LOCATION }"
    >
        <yandex-map-default-scheme-layer/>
        <yandex-map-default-features-layer/>
        <yandex-map-controls :settings="{ position: 'right' }">
            <yandex-map-zoom-control/>
        </yandex-map-controls>


        <yandex-map-clusterer
            v-model="clusterer"
            :grid-size="64"
            zoom-on-cluster-click
        >
            <template
                v-for="(point, index) in POINTS"
            >
                <yandex-map-default-marker
                    :settings="{ coordinates: point.coordinates,
                    onClick: () => $emit('marker-click', point),
                    zIndex: 1,
                    hideOutsideViewport: true, popup: main_view ? { position: 'top',  hidesMarker: true } : null
                }"
                    :key="index"
                >
                    <bkt-icon :name="'categories/realEstate'" :color="'cornflower-blue'" width="25px" height="25px"/>
                <template #popup="{ close }" v-if="main_view">
                        <div class="lot-preview bkt-wrapper-column">
                            <div class="bkt-wrapper bkt-gap-small bkt-nowrap">
                                <div class="lot-image bkt-bg-cornflower-blue-lighter">
                                    <bkt-icon :name="'categories/realEstate'" :color="'cornflower-blue'" width="25px" height="25px"/>
                                </div>
                                <h5 class="bkt-text-truncate-3">{{ point.title }}</h5>
                            </div>

                            <div class="bkt-wrapper bkt-nowrap bkt-gap-small bkt-w-100">
                                <div class="bkt-card__feature mt-0" v-if="point.tradeType">
                                    <h6 class="bkt-card__subtitle" style="font-size: 8px">тип</h6>
                                    <h5 class="bkt-text-700" style="font-size: 10px">
                                        {{ point.tradeType ? $t('trades.type.'+point.tradeType) : ''}}
                                    </h5>
                                </div>
                                <div class="bkt-card__feature mt-0" v-if="point.status">
                                    <h6 class="bkt-card__subtitle" style="font-size: 8px">статус</h6>
                                    <h5 class="bkt-text-700" style="font-size: 10px">
                                        {{ point.status }}
                                    </h5>
                                </div>
                            </div>

                            <div class="bkt-card__feature mt-0">
                                <h6 class="bkt-card__subtitle">текущая цена</h6>
                                <h5 class="bkt-text-700">
                                    {{ point.start_price | priceFormat}} ₽
                                </h5>
                            </div>

                            <div class="bkt-wrapper-between bkt-nowrap bkt-w-100">
                                <div class="bkt-text-red lot-btn" @click="close()">
                                    Закрыть
                                </div>
                                <router-link :to="`/lot/${point.lot_id}`" class="lot-link lot-btn">
                                    Перейти к лоту →
                                </router-link>
                            </div>

                        </div>
<!--                    <div class="marker-popup bkt-wrapper bkt-nowrap bkt-gap-small">-->
<!--                        <a class="link-primary" :href="'/lot/'+point.lot_id">Перейти в карточку лота</a>-->
<!--                        <div title="Закрыть" class="bkt-cursor-pointer" @click="close()">-->
<!--                            <bkt-icon name="Cancel" color="red" width="10px"/>-->
<!--                        </div>-->
<!--                    </div>-->
                </template>
                </yandex-map-default-marker>
            </template>
            <template #cluster="{ length }">
                <div class="cluster fade-in">
                    {{ length }}
                </div>
            </template>
        </yandex-map-clusterer>
    </yandex-map>
</template>

<script>
    import {
        YandexMap,
        YandexMapClusterer,
        YandexMapControlButton,
        YandexMapControls,
        YandexMapDefaultFeaturesLayer,
        YandexMapDefaultMarker,
        YandexMapDefaultSchemeLayer,
        YandexMapMarker,
        YandexMapZoomControl,
    } from 'vue-yandex-maps';
    export default {
        name: "Map",
        components: {
            YandexMap,
            YandexMapClusterer,
            YandexMapControlButton,
            YandexMapControls,
            YandexMapDefaultFeaturesLayer,
            YandexMapDefaultMarker,
            YandexMapDefaultSchemeLayer,
            YandexMapMarker,
            YandexMapZoomControl
        },
        props: {
            // location: {
            //     type: Object,
            //     required: true,
            //     default: null
            // },
            points: {
                type: Array,
                required: true,
                default: () => []
            },
            zoom: {
                type: Number,
                default: 20
            },
            main_view: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                clusterer: null,
                LOCATION: {
                    center: [99.040702, 62.659581], // starting position [lng, lat]
                    zoom: 20, // starting zoom
                },
                POINTS: [
                    // {coordinates: [46.079702, 51.575741]},
                ],
            }
        },
        mounted() {
            this.LOCATION.zoom = this.zoom;
            if(this.points.length > 0) {
                 if(!this.main_view) this.LOCATION.center = this.points[0]['coordinates'];
                this.POINTS = JSON.parse(JSON.stringify(this.points))
            }
        }
    }
</script>

<style scoped>
</style>
