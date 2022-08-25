<template>
    <bkt-modal :id="'editMonitoringModal'" :modal_class="'bkt-monitoring-modal bkt-region-modal bkt-filters-modal'"
               title="Редактировать  мониторинг"
               :loading="loading" @left_action="cancel" @right_action="save">
        <template #body="{ invalid }">
            <bkt-input v-model="monitoring.name"
                       rules="required" name="edit_monitoring_name" no_group_item label_class="bkt-form__label"
                       label="название мониторинга" placeholder="Введите название мониторинга"
            ></bkt-input>
            <div class="bkt-monitoring-field__input bkt-monitoring-field__filter text-left mb-3 bkt-input">
                <button @click="selectedFilter = 1" class="bkt-button"
                        :class="[selectedFilter == 1 ? 'shadow green' : 'bkt-text-main']">По категории
                </button>
                <button @click="selectedFilter = 2" class="bkt-button"
                        :class="[selectedFilter == 2 ? 'shadow green' : 'bkt-text-main']">По дате торгов
                </button>
                <button @click="selectedFilter = 3" class="bkt-button"
                        :class="[selectedFilter == 3 ? 'shadow green' : 'bkt-text-main']">По региону
                </button>
                <button @click="selectedFilter = 4" class="bkt-button"
                        :class="[selectedFilter == 4 ? 'shadow green' : 'bkt-text-main']">По параметрам
                </button>
                <button @click="selectedFilter = 5" class="bkt-button"
                        :class="[selectedFilter == 5 ? 'shadow green' : 'bkt-text-main']">По цене
                </button>
                <button @click="selectedFilter = 6" class="bkt-button"
                        :class="[selectedFilter == 6 ? 'shadow green' : 'bkt-text-main']">По доп.параметрам
                </button>
            </div>
            <div v-if="selectedFilter === 1" class="bkt-monitoring-category">
                <bkt-categories-control v-model="monitoring.filters.categories"></bkt-categories-control>
            </div>
            <div v-if="selectedFilter === 2" class="bkt-monitoring-date">
                <bkt-dates-control v-model="monitoring.filters.dates"></bkt-dates-control>
            </div>
            <div v-if="selectedFilter === 3" class="bkt-monitoring-region">
                <bkt-regions-control v-model="monitoring.filters.regions"></bkt-regions-control>
            </div>
            <div v-if="selectedFilter === 4" class="bkt-monitoring-debtor">
                <bkt-params-control v-model="monitoring.filters.mainParams"></bkt-params-control>
            </div>
            <div v-if="selectedFilter === 5" class="bkt-monitoring-price text-left">
                <bkt-prices-control v-model="monitoring.filters.prices"></bkt-prices-control>
            </div>
            <div v-if="selectedFilter === 6" class="bkt-monitoring-price text-left">
                <bkt-options-control v-model="monitoring.filters.extraOptions"></bkt-options-control>
            </div>
            <div>
                <label class="bkt-form__label bkt-input__label">
                    Периодичность уведомлений
                </label>
                <bkt-checkbox label="Каждый час" v-model="monitoring.notificationTime"
                              val="hourly" name="notificationTime1" type="radio"
                              :disabled="loading"></bkt-checkbox>
                <bkt-checkbox label="Раз в день" v-model="monitoring.notificationTime"
                              val="daily" name="notificationTime2" type="radio"
                              :disabled="loading"></bkt-checkbox>
                <bkt-checkbox label="Раз в неделю" v-model="monitoring.notificationTime"
                              val="weekly" name="notificationTime3" type="radio"
                              :disabled="loading"></bkt-checkbox>
            </div>
            <bkt-color-pallet v-model="monitoring.color"></bkt-color-pallet>
        </template>
    </bkt-modal>
</template>

<script>
    import BktCategoriesControl from "../../components/FiltersControls/CategoriesControl";
    import BktDatesControl from "../../components/FiltersControls/DatesControl";
    import BktRegionsControl from "../../components/FiltersControls/RegionsControl";
    import BktPricesControl from "../../components/FiltersControls/PricesControl";
    import BktParamsControl from "../../components/FiltersControls/ParamsControl";
    import BktOptionsControl from "../../components/FiltersControls/OptionsControl";
    import BktColorPallet from "../../components/ColorPallet";

    export default {
        name: "EditMonitoringModal",
        components: {
            BktRegionsControl,
            BktColorPallet,
            BktPricesControl,
            BktCategoriesControl,
            BktDatesControl,
            BktParamsControl,
            BktOptionsControl
        },
        data() {
            return {
                loading: false,
                selectedFilter: 1,
                edit_monitoring: {
                    name: '',
                    // pathId: 0,
                    color: 'yellow',
                    notificationTime: "hourly",
                    filters: {
                        categories: [],
                        regions: [],
                        prices: {
                            currentPrice: {
                                min: '',
                                max: ''
                            },
                            startPrice: {
                                min: '',
                                max: ''
                            },
                            minPrice: {
                                min: '',
                                max: ''
                            },
                            percentageReduction: {
                                min: '',
                                max: ''
                            }
                        },
                        dates: {
                            eventTimeStart: {
                                start: "",
                                end: ""
                            },
                            eventTimeEnd: {
                                start: "",
                                end: ""
                            },
                            applicationTimeStart: {
                                start: "",
                                end: ""
                            },
                            applicationTimeEnd: {
                                start: "",
                                end: ""
                            }
                        },
                        extraOptions: {
                            debtorCategories: [],
                            debtors: [],
                            organizers: [],
                            arbitrManagers: [],
                            other: {
                                period: 'periodAll',
                                hasPhotos: false,
                                isStopped: false,
                                isCompleted: false,
                                isHidden: false,
                                organizer: false
                            },
                        },
                        mainParams: {
                            excludedWords: '',
                            includedWords: '',
                            tradePlaces: [],
                            tradeType: '',
                        },
                    }
                },
                template: {
                    name: '',
                    // pathId: 0,
                    color: 'yellow',
                    notificationTime: "hourly",
                    filters: {
                        categories: [],
                        regions: [],
                        prices: {
                            currentPrice: {
                                min: '',
                                max: ''
                            },
                            startPrice: {
                                min: '',
                                max: ''
                            },
                            minPrice: {
                                min: '',
                                max: ''
                            },
                            percentageReduction: {
                                min: '',
                                max: ''
                            }
                        },
                        dates: {
                            eventTimeStart: {
                                start: "",
                                end: ""
                            },
                            eventTimeEnd: {
                                start: "",
                                end: ""
                            },
                            applicationTimeStart: {
                                start: "",
                                end: ""
                            },
                            applicationTimeEnd: {
                                start: "",
                                end: ""
                            }
                        },
                        extraOptions: {
                            debtorCategories: [],
                            debtors: [],
                            organizers: [],
                            arbitrManagers: [],
                            other: {
                                period: 'periodAll',
                                hasPhotos: false,
                                isStopped: false,
                                isCompleted: false,
                                isHidden: false,
                                organizer: false
                            },
                        },
                        mainParams: {
                            excludedWords: '',
                            includedWords: '',
                            tradePlaces: [],
                            tradeType: '',
                        },
                    }
                }
            };
        },
        computed: {
            current_path() {
                let path = this.$store.getters.monitoring_current_path;
                let index = this.paths.findIndex(item => item.pathId === path);
                if (index >= 0) {
                    this.monitoring = JSON.parse(JSON.stringify(this.paths[index]));
                } else {
                    this.monitoring = JSON.parse(JSON.stringify(this.template));
                }
                return path
            },
            monitoring: {
                get() {
                    let index = this.paths.findIndex(item => item.pathId === this.current_path);
                    if (index >= 0) {
                        return JSON.parse(JSON.stringify(this.paths[index]));
                    } else {
                        return JSON.parse(JSON.stringify(this.template));
                    }
                },
                set(value) {
                    this.edit_monitoring = value;
                }
            },
            paths() {
                return this.$store.getters.monitorings_paths;
            },
            regions_loading() {
                return this.$store.getters.regions_loading
            },
            categories_loading() {
                return this.$store.getters.categories_loading
            },
        },
        methods: {
            cancel() {
                this.loading = true;
                this.$store.dispatch('removeMonitoringPath', this.current_path)
                    .then(resp => {
                        this.loading = false;
                        this.$store.commit('closeModal', '#editMonitoringModal');
                    })
                    .catch(err => {
                        this.loading = false;
                    });
            },
            save() {
                this.loading = true;
                this.$store.dispatch('editMonitoringPath', this.monitoring)
                    .then(resp => {
                        this.loading = false;
                        this.$store.commit('closeModal', '#editMonitoringModal');
                    })
                    .catch(err => {
                        this.loading = false;
                    });

            },
            toggleRegion(region) {
                let item_index = this.monitoring.filters.regions.findIndex(el => el == region);
                if (item_index < 0) {
                    this.monitoring.filters.regions.push(region);
                } else {
                    this.monitoring.filters.regions.splice(item_index, 1);
                }
            },
            toggleCategory(subcategory) {
                let item_index = this.monitoring.filters.categories.findIndex(el => el == subcategory);
                if (item_index < 0) {
                    this.monitoring.filters.categories.push(subcategory);
                } else {
                    this.monitoring.filters.categories.splice(item_index, 1);
                }
            },
        }
    }
</script>

<style scoped>

</style>
