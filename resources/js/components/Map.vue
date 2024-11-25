<template>
    <yandex-map
        v-if="POINTS.length > 0"
        :height="'500px'"
                :width="'100%'"
                :settings="{ location: LOCATION }">
        <yandex-map-default-scheme-layer/>
        <yandex-map-default-features-layer/>
        <yandex-map-controls :settings="{ position: 'right' }">
            <yandex-map-zoom-control/>
        </yandex-map-controls>

        <template
            v-for="(point, index) in POINTS"
        >
            <yandex-map-default-marker
                :settings="point"
                :key="index"
            />
        </template>
    </yandex-map>
</template>

<script>
    import {
        YandexMap,
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
            }
        },
        data() {
            return {
                LOCATION: {
                    center: [46.079702, 51.575741], // starting position [lng, lat]
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
                this.LOCATION.center = this.points[0]['coordinates'];
                this.POINTS = JSON.parse(JSON.stringify(this.points))
            }
        }
    }
</script>

<style scoped>

</style>
