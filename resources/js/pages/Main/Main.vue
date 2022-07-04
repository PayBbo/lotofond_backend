<template>
    <div class="container bkt-main bkt-page bkt-container">
        <bkt-date-modal></bkt-date-modal>
        <bkt-price-modal></bkt-price-modal>
        <bkt-options-modal></bkt-options-modal>
        <bkt-params-modal></bkt-params-modal>
        <bkt-category-modal></bkt-category-modal>
        <bkt-region-modal></bkt-region-modal>
        <h1 class="bkt-page__title">Электронные торги по банкротству</h1>
        <div class="bkt-search position-relative bg-white">
            <input class="w-100 bkt-search__input" type="text" placeholder="Введите нужное слово или фразу">
            <button class="bkt-button green bkt-search__button">
                <span class="d-none d-md-block">Найти</span>
                <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
            </button>
        </div>
        <div class="bkt-main-categories bkt-card__list">
            <bkt-filter-card
                :icon="{name:'Category'}" category_class="bkt-bg-green"
                title="Выберите<br> нужные категории" :count="filters.categories" modal_name="#categoryModal"
            >
            </bkt-filter-card>
            <bkt-filter-card
                :icon="{name:'Location'}" category_class="bkt-bg-red-lighter"
                title="Выберите<br> регион" :count="filters.regions" modal_name="#regionModal"
            >
            </bkt-filter-card>
            <bkt-filter-card
                :icon="{name:'Options', color:'pink'}" category_class="bkt-bg-pink-lighter"
                title="Выберите основные<br> параметры объекта" :count="filters.mainParams" modal_name="#paramsModal"
            >
            </bkt-filter-card>
            <bkt-filter-card
                :icon="{name:'Wallet'}" category_class="bkt-bg-yellow-lighter"
                title="Выберите<br> стоимость объекта" :count="filters.prices"
                modal_name="#priceModal"
            >
            </bkt-filter-card>
            <bkt-filter-card
                :icon="{name:'Date'}" category_class="bkt-bg-blue"
                title="Выберите<br> дату торгов" :count="filters.dates"
                modal_name="#dateModal"
            >
            </bkt-filter-card>
            <bkt-filter-card
                :icon="{name:'Clone'}" category_class="bkt-bg-primary-lighter"
                title="Выберите<br> доп. параметры" :count="filters.extraOptions"
                modal_name="#optionsModal"
            >
            </bkt-filter-card>
        </div>
        <div class="bkt-main-statistic bkt-card__list">
            <div class="bkt-card__row bkt-bg-red-light position-relative">
                <h5 class="bkt-card__text">Всего лотов</h5>
                <h1 class="bkt-card__title">58 961</h1>
                <div class="bkt-card bkt-card__background-figure-1">
                </div>
                <div class="bkt-card bkt-card__background-figure-2 bkt-bg-red-light">
                </div>
            </div>
            <div class="bkt-card__row bkt-bg-yellow position-relative">
                <h5 class="bkt-card__text">Активных лотов</h5>
                <h1 class="bkt-card__title">4 372</h1>
                <div class="bkt-card bkt-card__background-figure-1">
                </div>
                <div class="bkt-card bkt-card__background-figure-2 bkt-bg-yellow">
                </div>
            </div>
            <div class="bkt-card__row bkt-bg-blue position-relative">
                <h5 class="bkt-card__text">Добавлено сегодня</h5>
                <h1 class="bkt-card__title">64</h1>
                <div class="bkt-card bkt-card__background-figure-1">
                </div>
                <div class="bkt-card bkt-card__background-figure-2 bkt-bg-blue">
                </div>
            </div>
        </div>
        <div class="bkt-main-filters bkt-row bkt-bg-main">
            <div class="col-12 col-md-6 pe-1 col-lg-4">
                <div class="d-flex w-100 mx-auto justify-content-around">
                    <bkt-select
                        v-model="filters_sort.type"
                        select_class="form-floating main"
                        name="sort"
                        subtitle="сортировать по"
                        :option_label="'title'"
                        :options="sort"
                        :reduce="item => item.value"
                        :clearable="false"
                        @input="getData(1)"
                    >
                    </bkt-select>
                    <button class="bkt-button-ellipse main d-none d-md-block" @click="toggleDirection">
                        <bkt-icon name="Bars"></bkt-icon>
                    </button>
                    <button class="bkt-button-ellipse main d-md-none">
                        <bkt-icon name="Funnel" :width="'18px'" :height="'18px'"></bkt-icon>
                    </button>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 d-none d-md-block">
                <bkt-select
                    v-model="filters_other.period"
                    select_class="form-floating main"
                    name="period"
                    subtitle="показывать за период"
                    :option_label="'title'"
                    :options="periods"
                    :reduce="item => item.value"
                    :clearable="false"
                    @input="getData(1)"
                >
                </bkt-select>
            </div>
            <div class="col-md-12 col-lg-5 d-none d-md-block">
                <div class="d-flex">
                    <div class="bkt-check__list">
                        <bkt-checkbox v-model="filters_other.hasPhotos"
                                   label="только с фото"
                                   name="hasPhotos"
                                      @input="getData(1)"
                        >
                        </bkt-checkbox>
                        <bkt-checkbox v-model="filters_other.isHidden"
                                      label="удалённые"
                                      name="isHidden"
                                      @input="getData(1)"
                        >
                        </bkt-checkbox>
                    </div>
                    <div class="bkt-check__list">
<!--                        <bkt-checkbox v-model="filters_other."-->
<!--                                      label="получен ответ организатора"-->
<!--                                      name="organizer"-->
<!--                                      @input="getData(1)"-->
<!--                        >-->
<!--                        </bkt-checkbox>-->
                        <bkt-checkbox v-model="filters_other.isCompleted"
                                      label="завершённые"
                                      name="isCompleted"
                                      @input="getData(1)"
                                      wrapper_class="bkt-check__wrapper-inline"
                        >
                        </bkt-checkbox>
                        <bkt-checkbox v-model="filters_other.isStopped"
                                      label="приостановленные"
                                      name="isStopped"
                                      @input="getData(1)"
                                      wrapper_class="bkt-check__wrapper-inline"
                        >
                        </bkt-checkbox>
                    </div>
                </div>
            </div>
        </div>
        <bkt-card-list :current_component="'BktCard'" :items="items" :loading="loading"
                       :pagination_data="pagination_data" @change-page="getData">
        </bkt-card-list>
    </div>
</template>

<script>
    import BktDateModal from "./DateModal";
    import BktPriceModal from "./PriceModal";
    import BktOptionsModal from "./OptionsModal";
    import BktParamsModal from "./ParamsModal";
    import BktRegionModal from "./RegionModal";
    import BktCategoryModal from "./CategoryModal";
    import BktSelect from "../../components/Select";
    import BktFilterCard from "../../components/FilterCard";
    export default {
        name: "Main",
        components: {
            BktDateModal, BktPriceModal, BktOptionsModal,
            BktParamsModal, BktRegionModal, BktCategoryModal, BktSelect, BktFilterCard
        },
        mounted() {
            this.getCategories();
            this.getData();
        },
        data() {
            return {
                in_process: [],
                periods: [
                    { title:'Все', value:"all"},
                    { title:'Сутки', value:"day"},
                    { title:'7 дней', value:"7 days"},
                    { title:'30 дней', value:"30 days"},
                ],
                sort: [
                    { title:'Дате добавления', value:"publishDate"},
                    { title:'Цене', value:"currentPrice"},
                    { title:'Дате начала торгов', value:"eventStart"},
                    { title:'Дате окончания торгов', value:"eventEnd"},
                    { title:'Дате начала приема заявок', value:"applicationStart"},
                    { title:'Дате окончания приема заявок', value:"applicationEnd"},
                ]
            };
        },
        computed: {
            filters() {
                return this.$store.getters.filters;
            },
            filters_other: {
                get() {
                    return this.$store.getters.filters_other;
                },
                set(value) {
                    this.$store.commit('saveFiltersProperty', {key: 'other', value: value});
                }
            },
            filters_sort: {
                get() {
                    return this.$store.getters.filters_sort;
                },
                set(value) {
                    this.$store.commit('saveFiltersProperty', {key: 'sort', value: value});
                }
            },
            items() {
                return this.$store.getters.trades;
            },
            pagination_data() {
                return this.$store.getters.trades_pagination;
            },
            loading() {
                return this.$store.getters.trades_loading;
            }
        },
        methods: {
            async getData(page = 1) {
                await this.$store.dispatch('getFilteredTrades', {page: page, filters: this.filters});
            },
            async getCategories() {
                await this.$store.dispatch('getCategories');
            },
            toggleDirection() {
                if(this.filters_sort.direction == 'asc') {
                    this.filters_sort.direction = 'desc';
                }
                else {
                    this.filters_sort.direction = 'asc';
                }
            }
        }
    }
</script>

<style scoped>

</style>
