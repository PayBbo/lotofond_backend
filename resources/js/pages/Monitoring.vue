<template>
    <div class="bkt-page bkt-container">
        <add-monitoring-modal/>
        <edit-monitoring-modal/>
        <h1 class="bkt-page__title">Мониторинг лотов</h1>
        <section class="bkt-monitoring">
            <div class="row w-100 mx-auto">
                <div class="col-12 col-md-9 col-lg-10 d-md-block d-none" :class="{'p-0' : items_paths.length==1}">
                    <div class="bkt-wrapper my-0 align-items-center w-100 bkt-nowrap">
                        <div class="p-3" v-show="items_paths.length > 1" @click="showPrev">
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
                        </div>
                        <div class="bkt-monitoring__paths-list"
                             :class="{'p-0' : items_paths.length==1}" v-if="items_paths.length>0">
                            <slick v-bind="settings" ref="carousel" style="overflow: hidden">
                                <div v-for="(path, index) in items_paths" :key="index">
                                    <div
                                        class="bkt-monitoring__path"
                                        :class="[current_path === path.pathId && path.color ? 'bkt-bg-'+path.color : '',
                                                {'bkt-bg-primary': current_path === path.pathId && !path.color,
                                                'bkt-bg-white bkt-text-main': current_path !== path.pathId}]"
                                    >
                                        <span  v-if="path.pathId === 0"
                                              @click="setCurrentMonitoringPath(path.pathId)"
                                               class=" bkt-cursor-pointer"
                                        >
                                            {{path.name}}
                                        </span>
                                        <div class="d-flex bkt-gap h-100 align-items-center bkt-cursor-pointer" v-if="path.pathId !== 0"
                                             @click="setCurrentMonitoringPath(path.pathId)"
                                        >
                                            <span>{{path.name}}</span>
                                        </div>
                                        <div class="bkt-icon-frame-small bkt-bg-primary-lighter bkt-cursor-pointer"
                                             v-if="path.pathId !== 0"
                                             @click="editMonitoringPath(path.pathId)"
                                        >
                                            <bkt-icon :name="'Settings'" :color="'primary'" class="bkt-icon"></bkt-icon>
                                        </div>
                                    </div>
                                </div>
                                <!--                            <template #prevArrow="arrowOption">-->
                                <!--                                <div class="custom-arrow">-->
                                <!--                                    <div v-show="items_paths.length > 1">-->
                                <!--                                        <svg-->
                                <!--                                            width="8"-->
                                <!--                                            height="12"-->
                                <!--                                            viewBox="0 0 8 12"-->
                                <!--                                            fill="#ffc515"-->
                                <!--                                        >-->
                                <!--                                            <path-->
                                <!--                                                d="M8 1.42L3.42 6L8 10.59L6.59 12L0.59 6L6.59 1.23266e-07L8 1.42Z"-->
                                <!--                                            ></path>-->
                                <!--                                        </svg>-->
                                <!--                                    </div>-->
                                <!--                                </div>-->
                                <!--                            </template>-->
                                <!--                            <template #nextArrow="arrowOption">-->
                                <!--                                <div class="custom-arrow">-->
                                <!--                                    <div v-show="items_paths.length > 1">-->
                                <!--                                        <svg-->
                                <!--                                            fill="#ffc515"-->
                                <!--                                            width="8"-->
                                <!--                                            height="12"-->
                                <!--                                            viewBox="0 0 8 12"-->
                                <!--                                        >-->
                                <!--                                            <path-->
                                <!--                                                d="M0 10.5801L4.58 6.00012L0 1.41012L1.41 0.00012207L7.41 6.00012L1.41 12.0001L0 10.5801Z"-->
                                <!--                                            ></path>-->
                                <!--                                        </svg>-->
                                <!--                                    </div>-->

                                <!--                                </div>-->
                                <!--                            </template>-->
                            </slick>

                        </div>
                        <div class="p-3" v-show="items_paths.length > 1" @click="showNext">
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
                        </div>
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
            <div class="bkt-wrapper my-0 bkt-nowrap align-items-start bkt-gap d-md-none w-100"
                 v-if="items_paths.length>0">
                <bkt-collapse id="collapseMonitoringPaths" main_class="bkt-monitoring__paths-collapse"
                              :header_class="current_path_object.color ? 'bkt-bg-'+current_path_object.color : 'bkt-bg-primary'"
                              :collapse_button_class="items_paths.length>1 ? 'bkt-bg-white' : 'd-none'"
                >
                    <template #title v-if="items_paths.length>0">
                        <h6 class="mx-auto">
                            {{current_path_object.name}}
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
                                <!--                            <span class="bkt-badge"-->
                                <!--                                  :class="path.color ? 'bkt-bg-'+path.color+'-lighter bkt-text-'+path.color-->
                                <!--                                      : 'bkt-text-primary bkt-bg-primary-lighter'"-->
                                <!--                            >-->
                                <!--                                    {{path.lotCount ? path.lotCount : '0'}}-->
                                <!--                                </span>-->
                            </button>
                        </div>
                    </template>
                </bkt-collapse>
                <button class="bkt-button-icon bkt-bg-primary-lighter" @click="editMonitoringPath(current_path)">
                    <bkt-icon :name="'Settings'" :color="'primary'" class=""></bkt-icon>
                </button>
            </div>
            <bkt-card-list v-if="items_paths.length>0" :current_component="'BktCard'" :items="items" :loading="loading"
                           :pagination_data="pagination_data" @change-page="getData"
                           :no_pagination="items_paths.length==0"
                            method_name="getMonitorings" :method_params="method_params">
            </bkt-card-list>
        </section>
    </div>
</template>

<script>
    import AddMonitoringModal from "./Monitoring/AddMonitoringModal";
    import EditMonitoringModal from "./Monitoring/EditMonitoringModal";

    export default {
        name: "Monitoring",
        components: {AddMonitoringModal, EditMonitoringModal},
        data() {
            return {
                selBtn: 1, showMonitoring: false,
                loading: false,
                settings: {
                    "arrows": false,
                    "dots": false,
                    "infinite": false,
                    "centerMode": false,
                    "centerPadding": "20px",
                    "slidesToShow": 1,
                    "slidesToScroll": 1,
                    "variableWidth": true
                },
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
                // let monitorings_paths =  this.$store.getters.monitorings_paths;
                // monitorings_paths.unshift({pathId: 0, name:'Все', color: 'primary'});
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
            method_params() {
                return {
                    pathId: this.current_path
                }
            }
        },
        methods: {
            async getData(page = 1, pathId = 0) {
                await this.$store.dispatch('getMonitorings', {page: page, pathId: this.current_path})
            },

            openModal() {
                this.$store.commit('openModal', '#addMonitoringModal');
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
                        if (this.items_paths.length > 0) {
                            this.setCurrentMonitoringPath(this.items_paths[0].pathId)
                        }
                    });
            },
            editMonitoringPath(value) {
                if(!this.loading) {
                    this.setCurrentMonitoringPath(value)
                    this.$store.commit('setCurrentMonitoringPath', value)
                    this.$store.commit('openModal', '#editMonitoringModal');
                }
            },
            showPrev() {
                this.$refs.carousel.prev()
            },
            showNext() {
                this.$refs.carousel.next()
            }
        },
    }
</script>

<style scoped>
    .custom-arrow {
        content: '';
    }

    .custom-arrow:before {
        content: '';
    }
</style>
