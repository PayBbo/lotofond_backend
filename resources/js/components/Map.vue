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
                    :settings="{ coordinates: point.coordinates, onClick: () => $emit('marker-click', point),
                    hideOutsideViewport: true, popup: main_view ? { position: 'top',  hidesMarker: true } : null
                }"
                    :key="index"
                >
                <template #popup="{ close }" v-if="main_view">
                    <div class="marker-popup bkt-wrapper bkt-nowrap bkt-gap-small">
                        <a class="link-primary" :href="'/lot/'+point.lot_id">Перейти в карточку лота</a>
                        <div title="Закрыть" class="bkt-cursor-pointer" @click="close()">
                            <bkt-icon name="Cancel" color="red" width="10px"/>
                        </div>
                    </div>
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
