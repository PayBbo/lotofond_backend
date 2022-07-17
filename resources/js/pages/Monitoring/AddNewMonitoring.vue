<template>
    <bkt-modal :id="'monitoringEditModal'" ref="monitoringEditModal" :modal_class="'bkt-monitoring-modal'"
               :title="'Новый мониторинг'" :loading="loading">
        <template #body="{ invalid }">
            <div>
                <div class="bkt-monitoring-field text-left mb-5">
                    <label class="bkt-monitoring-field__text" for="name_monitoring">название мониторинга</label>
                    <input class="bkt-monitoring-field__input bkt-input pl-4 pr-4" type="text" id="name_monitoring"
                           name="name_monitoring" placeholder="Введите название мониторинга">
                </div>

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
                            :class="[selectedFilter == 4 ? 'shadow green' : 'bkt-text-main']">По должнику
                    </button>
                    <button @click="selectedFilter = 5" class="bkt-button"
                            :class="[selectedFilter == 5 ? 'shadow green' : 'bkt-text-main']">По цене
                    </button>
                </div>
            </div>

            <div v-if="selectedFilter === 1" class="bkt-monitoring-category">
                {{ selectedCategory }}
                <div class="bkt-monitoring-field text-left mb-2">
                    <bkt-select name="monitoringCategory" :option_label="'label'"
                                :reduce="item => item.id" :options="items_categories"
                    ></bkt-select>
                </div>
                <div class="bkt-monitoring-field text-left mb-4">
                    <bkt-select multiple name="monitoringSubcategory" :option_label="'name'" :options="[]"
                    ></bkt-select>
                </div>

                <div class="bkt-monitoring-field bkt-monitoring__items text-left d-flex">
                    <div class="bkt bkt-border-primary-dark bkt-border-rounded p-2 pl-4 pr-4 mr-2"><span>BMW</span>
                    </div>
                    <div class="bkt bkt-border-primary-dark bkt-border-rounded p-2 pl-4 pr-4 mr-2"><span>Ford</span>
                    </div>
                    <div class="bkt bkt-border-primary-dark bkt-border-rounded p-2 pl-4 pr-4 mr-2"><span>Toyota</span>
                    </div>
                    <div class="bkt bkt-border-primary-dark bkt-border-rounded p-2 pl-4 pr-4 mr-2"><span>Audi</span>
                    </div>
                    <div class="bkt bkt-border-primary-dark bkt-border-rounded p-2 pl-4 pr-4"><span>Lexus</span></div>
                </div>
            </div>

            <div v-if="selectedFilter === 2" class="bkt-monitoring-date text-left">
                <div class="row mb-2" v-for="(date, index) in trading_date">
                    <div class="col-12 col-md-2 d-flex align-items-center">
                        <span class="bkt-monitoring-date__label">{{ date.title }}</span>
                    </div>
                    <div class="col-12 col-md-5 bkt-monitoring-date__input">
                        <bkt-datepicker field_name="dateStart" name="dateStart"
                                        v-model="date['date_start']"></bkt-datepicker>
                    </div>
                    <div class="col-12 col-md-5 bkt-monitoring-date__input">
                        <bkt-datepicker field_name="dateEnd" name="dateEnd" v-model="date['date_end']"></bkt-datepicker>
                    </div>
                </div>
            </div>

            <div v-if="selectedFilter === 3" class="bkt-monitoring-region bkt-region-modal">
                <div class="bkt-search position-relative bg-white bkt-bg-item-neutral">
                    <input class="w-100 bkt-search__input" type="text" :placeholder="'Введите нужное слово или фразу'">
                    <button class="bkt-button green bkt-search__button">
                        <span class="d-none d-md-block">Найти</span>
                        <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
                    </button>
                </div>
                <div class="bkt-regions-tabs d-lg-block d-none" v-if="!loading && selectedRegion">
                    <div class="bkt-form">
                        <div class="col-5 p-0">
                            <div class="bkt-regions-tabs__nav text-center">
                                <div v-for="(group, index) in regionGroups" @click="selectedRegion = group"
                                     :class="{'active bkt-bg-item-neutral': selectedRegion.regionGroup == group.regionGroup}"
                                     class="bkt-regions-tabs__nav-item"
                                >
                                    {{ $t('region_groups.' + group.regionGroup) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-7 p-0">
                            <div class="bkt-regions-tabs__content bkt-bg-body"
                                 :class="{
                                        'bkt-rounded-left-top-none': regionGroups[0].regionGroup == selectedRegion.regionGroup,
                                        'bkt-rounded-left-bottom-none': regionGroups[regionGroups.length-1].regionGroup == selectedRegion.regionGroup
                                     }"
                            >
                                <div class="bkt-tag__wrapper" v-for="(item, index) in selectedRegion.regions"
                                     :key="index">
                                    <div class="bkt-tag w-100 text-left bkt-bg-item-rounded"
                                         :class="{'bkt-bg-green bkt-text-white': result.findIndex(el => el === item)>=0}"
                                    >
                                        {{ $t('regions.' + item) }}
                                    </div>
                                    <div class="bkt-tag__icon" @click="toggleRegion(item)">
                                        <bkt-icon name="Cancel" color="red"
                                                  v-show="result.findIndex(data => data === item)>=0"
                                        ></bkt-icon>
                                        <bkt-icon name="Plus" color="green"
                                                  v-show="result.findIndex(data => data === item)<0"
                                        ></bkt-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-lg-none bkt-wrapper-column bkt-gap-small" v-if="!loading  && selectedRegion">
                    <bkt-collapse :id="'region-collapse-'+index" v-for="(group, index) in regionGroups" :key="index"
                                  main_class="bkt-collapse_check"
                                  collapse_button_class="bkt-bg-white"
                    >
                        <template #title>
                            <div class="bkt-collapse__title-wrapper">
                                <bkt-checkbox
                                    :label="''"
                                    :name="'bkt-region-group-checkbox-'+index"
                                    :id="'bkt-region-group-checkbox-'+index"
                                    v-model="group.status"
                                    @input="selectAll(index)"
                                    :indeterminate="isIndeterminate(index)"
                                ></bkt-checkbox>
                                <h5 class="bkt-regions-tabs__title" data-bs-toggle="collapse"
                                    :data-bs-target="'#region-collapse-'+index">
                                    {{ $t('region_groups.' + group.regionGroup) }}
                                </h5>
                            </div>
                        </template>
                        <template #collapse>
                            <div class="bkt-gap-mini" v-for="(region,index) in group.regions">
                                <div class="bkt-collapse__title-wrapper">
                                    <bkt-checkbox :label="''"
                                                  :name="'bkt-region-checkbox-'+index"
                                                  :id="'bkt-region-checkbox-'+index"
                                                  v-model="result"
                                                  :val="region"
                                    ></bkt-checkbox>
                                    <h6 class="bkt-regions-tabs__subtitle">
                                        {{ $t('regions.' + region) }}
                                    </h6>
                                </div>
                            </div>
                        </template>
                    </bkt-collapse>
                </div>
                <div class="bkt-region-selected" v-if="result.length>0 && !loading">
                    <h5 class="bkt-region-selected__title text-left mb-2">
                        <span class="text-muted">выбранные регионы</span>
                    </h5>
                    <div class="bkt-tag__list">
                        <div class="bkt-region__item bkt-tag justify-content-between flex-fill"
                             v-for="(item, index) in result">
                            <span class="bkt-item-rounded__text mr-2">{{ $t('regions.' + item) }}</span>
                            <span class="bkt-tag__icon bkt-cursor-pointer" @click="toggleRegion(item)">
                                    <bkt-icon name="Cancel" color="red"></bkt-icon>
                                </span>
                        </div>
                    </div>
                </div>
                <div v-if="loading" class="d-flex w-100 justify-content-center my-5">
                    <slot name="loading">
                        <div
                            style="color: #2953ff;border-width: 2px;"
                            class="spinner-border"
                            role="status"
                        ></div>
                    </slot>
                </div>
            </div>

            <div v-if="selectedFilter === 4" class="bkt-monitoring-debtor">
                <input class="bkt-monitoring-field__input bkt-input pl-4 pr-4" type="text" id="debtor"
                       name="debtor" placeholder="Введите данные должника">
            </div>

            <div v-if="selectedFilter === 5" class="bkt-monitoring-price text-left">
                <div class="bkt-form mx-auto align-items-start">
                    <div class="col-12 col-lg-3 p-0">
                        <h5 class="bkt-form__label">начальная цена, ₽</h5>
                    </div>
                    <div class="bkt-form col-12 col-lg-9 m-0">
                        <div class="col-12 col-lg-6">
                            <bkt-input v-model="filter.startPrice.min"
                                       type="number"
                                       field_name="'Начальная цена от'"
                                       name="startPriceMin" icon_name="Check"
                                       :group_item_class="filter.startPrice.min ? 'bkt-bg-green': 'bkt-bg-white'"
                                       :icon_color="filter.startPrice.min ? 'white': 'main-lighter'">
                                <template #group-text>
                                    от
                                </template>
                            </bkt-input>
                        </div>
                        <div class="col-12 col-lg-6">
                            <bkt-input v-model="filter.startPrice.max"
                                       type="number"
                                       field_name="'Начальная цена до'"
                                       name="startPriceMax" icon_name="Check"
                                       :group_item_class="filter.startPrice.max ? 'bkt-bg-green': 'bkt-bg-white'"
                                       :icon_color="filter.startPrice.max ? 'white': 'main-lighter'"
                            >
                                <template #group-text>
                                    до
                                </template>
                            </bkt-input>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 p-0">
                        <h5 class="bkt-form__label">текущая цена, ₽</h5>
                    </div>
                    <div class="bkt-form col-12 col-lg-9 m-0">
                        <div class="col-12 col-lg-6">
                            <bkt-input v-model="filter.currentPrice.min"
                                       type="number"
                                       field_name="'Текущая цена от'"
                                       name="currentPriceMin" icon_name="Check"
                                       :group_item_class="filter.currentPrice.min ? 'bkt-bg-green': 'bkt-bg-white'"
                                       :icon_color="filter.currentPrice.min ? 'white': 'main-lighter'"
                            >
                                <template #group-text>
                                    от
                                </template>
                            </bkt-input>
                        </div>
                        <div class="col-12 col-lg-6">
                            <bkt-input v-model="filter.currentPrice.max"
                                       type="number"
                                       field_name="'Текущая цена до'"
                                       name="currentPriceMax" icon_name="Check"
                                       :group_item_class="filter.currentPrice.max ? 'bkt-bg-green': 'bkt-bg-white'"
                                       :icon_color="filter.currentPrice.max ? 'white': 'main-lighter'"
                            >
                                <template #group-text>
                                    до
                                </template>
                            </bkt-input>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 p-0">
                        <h5 class="bkt-form__label">минимальная цена, ₽</h5>
                    </div>
                    <div class="bkt-form col-12 col-lg-9 m-0">
                        <div class="col-12 col-lg-6">
                            <bkt-input v-model="filter.minPrice.min"
                                       type="number"
                                       field_name="'Минимальная цена от'"
                                       name="minPriceMin" icon_name="Check"
                                       :group_item_class="filter.minPrice.min ? 'bkt-bg-green': 'bkt-bg-white'"
                                       :icon_color="filter.minPrice.min ? 'white': 'main-lighter'"
                            >
                                <template #group-text>
                                    от
                                </template>
                            </bkt-input>
                        </div>
                        <div class="col-12 col-lg-6">
                            <bkt-input v-model="filter.minPrice.max"
                                       field_name="'Минимальная цена до'"
                                       name="minPriceMax" icon_name="Check"
                                       :group_item_class="filter.minPrice.max ? 'bkt-bg-green': 'bkt-bg-white'"
                                       :icon_color="filter.minPrice.max ? 'white': 'main-lighter'"
                            >
                                <template #group-text>
                                    до
                                </template>
                            </bkt-input>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 p-0">
                        <h5 class="bkt-form__label">процент снижения, %</h5>
                    </div>
                    <div class="bkt-form col-12 col-lg-9 m-0">
                        <div class="col-12 col-lg-6">
                            <bkt-input v-model="filter.percentageReduction.min"
                                       field_name="'Процент снижения от'"
                                       name="percentageReductionMin" icon_name="Check"
                                       :group_item_class="filter.percentageReduction.min ? 'bkt-bg-green': 'bkt-bg-white'"
                                       :icon_color="filter.percentageReduction.min ? 'white': 'main-lighter'"
                            >
                                <template #group-text>
                                    от
                                </template>
                            </bkt-input>
                        </div>
                        <div class="col-12 col-lg-6">
                            <bkt-input v-model="filter.percentageReduction.max"
                                       field_name="'Процент снижения до'"
                                       name="percentageReductionMax" icon_name="Check"
                                       :group_item_class="filter.percentageReduction.max ? 'bkt-bg-green': 'bkt-bg-white'"
                                       :icon_color="filter.percentageReduction.max ? 'white': 'main-lighter'"
                            >
                                <template #group-text>
                                    до
                                </template>
                            </bkt-input>
                        </div>
                    </div>
                </div>

                <div v-if="false" class="row mb-2" v-for="(price, index) in pricing">
                    <div class="col-12 col-md-2 d-flex align-items-center">
                        <span class="bkt-monitoring-price__label">{{ price.title }}</span>
                    </div>
                    <div class="col-12 col-lg-5">
                        <bkt-input class="bkt-input-price bkt-input-price__min bkt-monitoring-price__input"
                                   v-model="price.minPrice"
                                   :name="'minPrice-'+index" type="text">
                            <template #group-item-inner>
                                <button
                                    class="bkt-btn-price-done btn bkt-btn-icon position-absolute bkt-bg-white bkt-border-rounded"
                                    style="height: 50px; width: 50px; right: 8px" :class="{'active': price.minActive}"
                                    @click="price.minActive = !price.minActive">
                                    <bkt-icon :name="'Done'" :color="'neutral'" class="bkt-icon"></bkt-icon>
                                </button>
                            </template>
                        </bkt-input>
                    </div>
                    <div class="col-12 col-lg-5">
                        <bkt-input class="bkt-input-price bkt-input-price__max" v-model="price.maxPrice"
                                   :name="'maxPrice-'+index"
                                   type="text">
                            <template #group-item-inner>
                                <button
                                    class="bkt-btn-price-done btn bkt-btn-icon position-absolute bkt-bg-white bkt-border-rounded"
                                    style="height: 50px; width: 50px; right: 8px" :class="{'active': price.maxActive}"
                                    @click="price.maxActive = !price.maxActive">
                                    <bkt-icon :name="'Done'" :color="'neutral'" class="bkt-icon"></bkt-icon>
                                </button>
                            </template>
                        </bkt-input>
                    </div>
                </div>
            </div>

            <bkt-color-folder/>
        </template>
    </bkt-modal>
</template>

<script>
//import ColorFolder from "../../components/ColorFolder";

import Select from "../../components/Select";
import RegionModal from "../Main/RegionModal";
import BktCollapse from '../../components/Collapse.vue';

export default {
    name: "AddNewMonitoring",
    components: {
        RegionModal,
        'bkt-select': Select,
        'bkt-collapse': BktCollapse
        //  'bkt-color-folder': ColorFolder
    },
    data() {
        return {
            // loading: false,
            trading_date: [{title: "начало торгов", date_start: '', date_end: ''},
                {title: "начало приёма заявок", date_start: '', date_end: ''},
                {title: "окончание приёма заявок", date_start: '', date_end: ''},
                {title: "окончание торгов", date_start: '', date_end: ''}],
            pricing: [{title: "начальная цена, ₽", minPrice: '', maxPrice: '', minActive: false, maxActive: false},
                {title: "текущая цена, ₽", minPrice: '', maxPrice: '', minActive: false, maxActive: false},
                {title: "минимальная цена, ₽", minPrice: '', maxPrice: '', minActive: false, maxActive: false},
                {title: "процент снижения, %", minPrice: '', maxPrice: '', minActive: false, maxActive: false}],
            selectedFilter: 1,
            regionGroups: [], selectedRegion: null, result: [], result_categories: [], items_categories: [],
            selectedCategory: '',
        }
    },
    created() {
        this.getRegions();
        this.result = JSON.parse(JSON.stringify(this.$store.getters.filters_regions));
        this.getCategories();
        this.result = JSON.parse(JSON.stringify(this.$store.getters.filters_categories))
    },
    computed: {
        filter: {
            get() {
                return JSON.parse(JSON.stringify(this.$store.getters.filters_prices))
            },
            set(value) {
                this.prices = value;
            }
        },
        filters_regions() {
            return this.$store.getters.filters_regions
        },
        filters() {
            return this.$store.getters.filters
        },
        regions() {
            return this.$store.getters.regions
        },

        filters_categories() {
            return this.$store.getters.filters_categories
        },
        categories() {
            return this.$store.getters.categories
                .sort(function (one, other) {
                    return other.subcategories.length - one.subcategories.length;
                });
        },
        subcategories() {
            return this.$store.getters.categories.filter(item => item.subcategories);
        },
        loading() {
            return this.$store.getters.regions_loading
        },
    },
    methods: {
        toggleRegion(region) {
            let item_index = this.result.findIndex(el => el == region);
            if (item_index < 0) {
                this.result.push(region);
            } else {
                this.result.splice(item_index, 1);
            }
        },
        selectAll(index) {
            if (this.regionGroups[index].status) {
                this.regionGroups[index].regions.forEach(item => {
                    let item_index = this.result.findIndex(el => el == item);
                    if (item_index < 0) {
                        this.result.push(item)
                    }
                })
            } else {
                this.regionGroups[index].regions.forEach(item => {
                    let item_index = this.result.findIndex(el => el == item);
                    if (item_index >= 0) {
                        this.result.splice(item_index, 1)
                    }
                });
            }
        },
        allChecked(arr, target) {
            return target.every(v => arr.includes(v))
        },
        isIndeterminate(index) {
            let all_checked = this.allChecked(this.result, this.regionGroups[index].regions);
            let some_checked = this.regionGroups[index].regions.some(v => this.result.includes(v));
            if (all_checked) {
                this.regionGroups[index].status = true;
            } else {
                this.regionGroups[index].status = false;
            }
            return !all_checked && some_checked;
        },
        async getRegions() {
            await this.$store.dispatch('getRegions').then(resp => {
                this.regionGroups = JSON.parse(JSON.stringify(this.regions));
                this.selectedRegion = this.regionGroups[0];
            });
        },
        async getCategories() {
            await this.$store.dispatch('getCategories').then(resp => {
                this.items_categories = JSON.parse(JSON.stringify(this.categories));
            });
        },
    },
}
</script>

<style scoped>

</style>
