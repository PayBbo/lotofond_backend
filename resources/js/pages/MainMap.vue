<template>
    <div class="bkt-page bkt-container">
        <h1 class="bkt-page__title">Карта</h1>
        <div class="bkt-card bkt-card__body">
            <bkt-map v-if="coordinates.length>0" :zoom="3" :points="coordinates" main_view/>
            <div v-if="loading" class="bkt-wrapper align-items-center justify-content-center">
                <div
                    style="color: #2953ff;border-width: 2px;"
                    class="spinner-border"
                    role="status"
                ></div>
            </div>
        </div>
    </div>
</template>

<script>
    import BktMap from "../components/Map";
    export default {
        name: "MainMap",
        components: {
            BktMap
        },
        data() {
            return {
                coordinates:[],
                loading: false
            };
        },
        created() {
            this.getMapCoordinates();
        },
        methods: {
            async getMapCoordinates() {
                this.loading = true;
                await axios.get('api/trades/for-map').then(resp => {
                    this.coordinates = resp.data;
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
                })
            },
        }
    }
</script>

<style scoped>

</style>
