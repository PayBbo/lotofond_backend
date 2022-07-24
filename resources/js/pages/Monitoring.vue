<template>
    <div class="bkt-page bkt-monitoring bkt-container">
        <add-new-monitoring/>
        <h1 class="bkt-page__title">Мониторинг лотов</h1>
        <div class="row w-100 mx-auto">
            <div class="col-12 col-md-9 col-lg-10 d-md-block d-none">
                <div class="bkt-monitoring__paths-list">
                    <slick v-bind="settings">
<!--                        <div>-->
<!--                            <div-->
<!--                                @click="setCurrentMonitoringPath(0)"-->
<!--                                class="bkt-monitoring__path"-->
<!--                                :class="current_path === 0 ? 'bkt-bg-primary bkt-text-white' : 'bkt-bg-white bkt-text-main'"-->
<!--                            >-->
<!--                                Все-->
<!--                            </div>-->
<!--                        </div>-->
                        <div v-for="(path, index) in items_paths" :key="index">
                            <div
                                @click="setCurrentMonitoringPath(path.pathId)"
                                class="bkt-monitoring__path"
                                :class="[current_path === path.pathId && path.color ? 'bkt-bg-'+path.color : '',
                            {'bkt-bg-primary': current_path === path.pathId && !path.color,
                            'bkt-bg-white bkt-text-main': current_path !== path.pathId}]"
                            >
                                <span v-if="path.pathId === 0">{{path.name}}</span>
                                <div class="d-flex bkt-gap align-items-center" v-if="path.pathId !== 0">
                                    <span>{{path.name}}</span>
                                    <span class="bkt-badge"
                                          :class="[
                                          path.color ? 'bkt-text-'+path.color : 'bkt-text-primary',
                                          current_path !== path.pathId && path.color ? 'bkt-bg-'+path.color+'-lighter' : '',
                                          {
                                              'bkt-bg-white': current_path === path.pathId,
                                              'bkt-bg-primary-lighter': current_path !== path.pathId && !path.color
                                          }
                                      ]"
                                    >
                                    {{path.lotCount ? path.lotCount : '0'}}
                                </span>
                                </div>
                                <div class="bkt-icon-frame-small bkt-bg-primary-lighter" v-if="path.pathId !== 0">
                                    <bkt-icon :name="'Settings'" :color="'primary'" class="bkt-icon"></bkt-icon>
                                </div>
                            </div>
                        </div>
                        <template #prevArrow="arrowOption">
                            <svg
                                width="8"
                                height="12"
                                viewBox="0 0 8 12"
                                fill="#ffc515"
                            >
                                <path
                                    d="M8 1.42L3.42 6L8 10.59L6.59 12L0.59 6L6.59 1.23266e-07L8 1.42Z"
                                ></path>
                            </svg>
                        </template>
                        <template #nextArrow="arrowOption">
                            <svg
                                fill="#ffc515"
                                width="8"
                                height="12"
                                viewBox="0 0 8 12"
                            >
                                <path
                                    d="M0 10.5801L4.58 6.00012L0 1.41012L1.41 0.00012207L7.41 6.00012L1.41 12.0001L0 10.5801Z"
                                ></path>
                            </svg>
                        </template>
                    </slick>
                </div>
            </div>
            <div class="col px-0">
                <button class="bkt-button__new-monitoring bkt-button primary bkt-w-md-100"
                        @click="openModal"
                >
                    Новый мониторинг
                </button>
            </div>
        </div>
        <div class="bkt-wrapper align-items-start bkt-nowrap d-flex d-md-none w-100" v-if="items_paths.length>0">
            <bkt-collapse id="collapseMonitoringPaths" main_class="bkt-monitoring__paths-collapse"
                          :header_class="current_path_object.color ? 'bkt-bg-'+current_path_object.color : 'bkt-bg-primary'"
                          :collapse_button_class="paths.length>1 ? 'bkt-bg-white' : 'd-none'"
            >
                <template #title v-if="items_paths.length>0">
                    <h6 class="mx-auto">
                        {{current_path_object.name}}
                        <span class="bkt-badge bkt-bg-white"
                              :class="current_path_object.color ? 'bkt-text-'+current_path_object.color : 'bkt-text-primary'"
                        >
                            {{current_path_object.lotCount ? current_path_object.lotCount : '0'}}
                        </span>
                    </h6>
                </template>
                <template #collapse v-if="items_paths.length>0">
                    <div class="bkt-wrapper-column bkt-gap">
                        <button v-for="(path, index) in items_paths" :key="index"
                                @click="setCurrentMonitoringPath(path.pathId)"
                                v-if="path.pathId !== current_path"
                                class="w-100 bkt-button bkt-button_plump text-uppercase bkt-bg-white bkt-text-main text-center"
                        >
                            {{path.name}}
                            <span class="bkt-badge"
                                  :class="path.color ? 'bkt-bg-'+path.color+'-lighter bkt-text-'+path.color
                                      : 'bkt-text-primary bkt-bg-primary-lighter'"
                            >
                                    {{path.lotCount ? path.lotCount : '0'}}
                                </span>
                        </button>
                    </div>
                </template>
            </bkt-collapse>
            <button class="bkt-button-icon bkt-bg-primary-lighter">
                <bkt-icon :name="'Settings'" :color="'primary'" class=""></bkt-icon>
            </button>
        </div>
        <bkt-card-list :current_component="'BktCard'" :items="items" :loading="loading"
                       :pagination_data="pagination_data" @change-page="getData"
                       :infinite="items_paths.length>1" method_name="getMonitorings" :method_params="method_params">
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
                },
                path_object: {pathId: 0, name: 'All', color: 'primary'},
                paths: [
                    {pathId: 0, name: 'All', color: 'primary'},
                    {pathId: 1, name: 'МОНИТОРИНГ №1', color: 'yellow'},
                    {pathId: 2, name: 'КВАРТИРЫ', color: 'yellow'},
                    {pathId: 3, name: 'TEst3', color: 'yellow'},
                    {pathId: 4, name: 'TEst4', color: 'yellow'},
                    {pathId: 5, name: 'TEst5', color: 'yellow'},
                    {pathId: 6, name: 'TEst6', color: 'yellow'},
                    {pathId: 7, name: 'TEst7', color: 'yellow'},
                    {pathId: 1, name: 'TEst', color: 'yellow'},
                    {pathId: 1, name: 'TEst', color: 'yellow'},
                    {pathId: 1, name: 'TEst', color: 'yellow'},
                    {pathId: 1, name: 'TEst', color: 'yellow'},
                    {pathId: 1, name: 'TEst', color: 'yellow'},
                    {pathId: 1, name: 'TEst', color: 'yellow'},
                    {pathId: 1, name: 'TEst', color: 'yellow'},
                    {pathId: 1, name: 'TEst', color: 'yellow'},
                ]
            }
        },
        created() {
            this.getMonitoringPaths();
        },
        mounted() {
            // this.getData();
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
                let monitorings_paths =  this.$store.getters.monitorings_paths;
                monitorings_paths.unshift({pathId: 0, name:'Все', color: 'primary'});
                return monitorings_paths
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
            method_params() {
                return {
                    pathId: this.current_path
                }
            }
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
                    if (this.items_paths.length > 0) {
                        this.$store.dispatch('getMonitorings', {page: 1, pathId: this.current_path})
                            .finally(() => {
                                this.loading = false;
                            });
                    }
                }).catch(err => {
                    this.loading = false;
                });
            },
            async setCurrentMonitoringPath(value) {
                this.loading = true;
                await this.$store.dispatch('setCurrentMonitoringPath', value)
                    .finally(() => {
                        this.loading = false;
                    });
            },
            async removeMonitoringPath() {
                await this.$store.dispatch('removeMonitoringPath', this.current_path)
                    .then(resp => {
                        this.setCurrentMonitoringPath(this.items_paths[0].pathId)
                    });
            }

        },
    }
</script>

<style scoped>

</style>
