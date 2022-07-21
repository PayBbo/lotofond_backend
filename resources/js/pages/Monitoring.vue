<template>
    <div class="container bkt-monitoring bkt-container">
        <add-new-monitoring/>
        <div class="bkt-monitoring__title">
            <h1 class="bkt-page__title">Мониторинг лотов</h1>
        </div>
        <div class="bkt-monitoring__menu d-flex justify-content-between">
            <div class="bkt-monitoring__menu-buttons d-md-block d-none">
                <button :class="{'active bkt-bg-primary shadow': selBtn == 1}" @click="selBtn = 1"
                        class="bkt-button bkt-button-menu bkt-button-all bkt-card__text d-inline-flex align-items-center mr-2 pt-4 pb-4">
                    ВСЕ
                    <span class="bkt-count bkt-text-primary p-1 rounded-pill">32</span>
                </button>
                <button :class="{'active shadow': selBtn == 2}" @click="selBtn = 2"
                        class="bkt-button bkt-button-menu bkt-menu-button bkt-menu-button__monitoring bkt-card__text d-inline-flex
                        align-items-center position-relative mr-2 pr-5">
                    <span>МОНИТОРИНГ №1</span>
                    <div class="bkt-count p-1 ml-2 mr-4">
                        <span class="p-1">1</span>
                    </div>
                    <button class="btn bkt-btn-icon position-absolute" style="height: 42px; right: 8px">
                        <bkt-icon :name="'Settings'" :color="'primary'" class="bkt-icon"></bkt-icon>
                    </button>
                </button>
                <button :class="{'active shadow': selBtn == 3}" @click="selBtn = 3"
                        class="bkt-button bkt-button-menu bkt-menu-button bkt-menu-button__flats bkt-bg-white bkt-card__text
                         position-relative d-inline-flex align-items-center mr-2 pr-5">
                    <span>КВАРТИРЫ</span>
                    <div class="bkt-count p-1 ml-2 mr-4">
                        <span class="">32</span>
                    </div>
                    <button class="btn bkt-btn-icon position-absolute" style="height: 42px; right: 8px">
                        <bkt-icon :name="'Settings'" :color="'primary'" class="bkt-icon"></bkt-icon>
                    </button>
                </button>
            </div>

            <div class="d-flex d-md-none">
                <div class="mr-2 w-100" style="margin-right: 0.5rem">
                    <button class="d-flex position-relative bkt-btn-monitoring w-100 bkt-button green
                  p-4 align-items-center justify-content-between"
                            :class="{'bkt-border-bottom-rounded-none': showMonitoring}">
                        <div class="d-flex justify-content-center">
                            <span class="d-flex align-items-center p-1">МОНИТОРИНГ №1</span>
                            <div class="bkt-bg-white bkt-text-green rounded-pill p-1">
                                <span class="p-1" style="padding-right: 0.5rem !important;">1</span>
                            </div>
                        </div>
                        <div class="bkt-arrow bkt-bg-white rounded position-absolute"
                             :class="{'bkt-rotate-180': showMonitoring}" @click="showMonitoring = !showMonitoring">
                            <bkt-icon :name="'ArrowDown'" :color="'primary'" class=""></bkt-icon>
                        </div>
                    </button>

                    <div class="bkt-menu-monitoring bkt-bg-white shadow" :class="{'d-none': !showMonitoring}">
                        <ul class="list-inline bkt-menu-monitoring-list">
                            <li class="bkt-menu-monitoring-list__item">
                                <div class="d-flex justify-content-center">
                                    <span class="d-flex align-items-center p-1 text-uppercase">Квартиры</span>
                                    <div class="bkt-bg-blue-lighter bkt-text-blue rounded-pill p-1">
                                        <span class="p-1">2</span>
                                    </div>
                                </div>
                            </li>
                            <li class="bkt-menu-monitoring-list__item">
                                <div class="d-flex justify-content-center">
                                    <span class="d-flex align-items-center p-1 text-uppercase">Долги</span>
                                    <div class="bkt-bg-red-lighter bkt-text-red rounded-pill p-1">
                                        <span class="p-1">2</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                    <button class="bkt-button bkt-bg-main-lighter"
                            style="width: 44px; height: 44px; justify-content: center; display: grid;">
                        <bkt-icon :name="'Settings'" :color="'primary'" class=""></bkt-icon>
                    </button>
                </div>
            </div>
            <button class="bkt-button__new-monitoring bkt-button primary pt-4 pb-4" @click="openModal">
                Новый мониторинг
            </button>
        </div>

        <bkt-card-list :current_component="'BktCard'" :items="items" :loading="loading"
                       :pagination_data="pagination_data" @change-page="getData">
        </bkt-card-list>
    </div>
</template>

<script>

    import AddNewMonitoring from "./Monitoring/AddNewMonitoring";

    export default {
        name: "Monitoring",
        components: {AddNewMonitoring},
        data() {
            return {
                selBtn: 1, showMonitoring: false,
                loading: false,
                settings: {
                    "dots": false,
                    "infinite": false,
                    "centerMode": false,
                    "centerPadding": "20px",
                    "slidesToShow": 1,
                    "slidesToScroll": 1,
                    "variableWidth": true
                }
            }
        },
        created() {
            this.getMonitoringPaths();
        },
        mounted() {
            this.getData();
        },
        computed: {
            filters() {
                return this.$store.getters.filters;
            },
            items() {
                return this.$store.getters.current_monitorings;
            },
            pagination_data() {
                return this.$store.getters.monitorings_pagination;
            },
            items_paths() {
                return this.$store.getters.monitorings_paths;
            },
            current_path() {
                return this.$store.getters.monitoring_current_path;
            },
            current_path_object() {
                let index = this.items_paths.findIndex(item => item.pathId == this.current_path)
                if (index >= 0) {
                    return this.items_paths[index];
                }
                return {}
            },
        },
        methods: {
            async getData(page = 1, pathId = 0) {
                await this.$store.dispatch('getMonitorings', {page: page, pathId: pathId})
            },

            openModal() {
                this.$store.commit('openModal', '#monitoringEditModal');
            },
            async getMonitoringPaths() {
                this.loading = true;
                await this.$store.dispatch('getMonitoringPaths').then(response => {
                    // this.$store.commit('setMonitoringPaths', response.data)
                    // this.$store.commit('setCurrentPath', response.data[0].pathId)
                    // this.getData(1, this.current_path)
                    this.$store.dispatch('getMonitorings', {page: 1, pathId: this.current_path})
                        .finally(() => {
                            this.loading = false;
                        });

                }).catch(err => {
                    this.loading = false;
                });
            },
            async setCurrentPath(value) {
                this.loading = true;
                await this.$store.dispatch('setCurrentPath', value)
                    .finally(() => {
                        this.loading = false;
                    });
            },
            async removeMonitoringPath() {
                await this.$store.dispatch('removeMonitoringPath', this.current_path)
                    .then(resp => {
                        this.setCurrentPath(this.items_paths[0].pathId)
                    });
            }

        },
    }
</script>

<style scoped>

</style>
