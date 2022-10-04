<template>
    <div class="container bkt-main bkt-page bkt-container">
        <bkt-date-modal></bkt-date-modal>
        <bkt-price-modal></bkt-price-modal>
        <bkt-options-modal></bkt-options-modal>
        <bkt-params-modal></bkt-params-modal>
        <bkt-category-modal></bkt-category-modal>
        <bkt-region-modal></bkt-region-modal>
        <bkt-trade-place-modal></bkt-trade-place-modal>
        <bkt-trade-type-modal></bkt-trade-type-modal>
        <div class="bkt-page__title">
            <h1>Единый реестр имущественных торгов</h1>
            <h4 class="bkt-text-neutral-dark">банкротство залоги аресты государство неликвид конфискат</h4>
        </div>

        <!--        <bkt-search v-model="searchString" method_name="searchTrades" :method_params="{}" immediate_search-->
        <!--                    @selected="selectSearchLot" infinite dropdown_class="pt-0"-->
        <!--        >-->
        <!--            <template #dropdown-block-header="{pagination}">-->
        <!--                <div class="d-flex w-100 mx-auto align-items-center mb-2 bkt-gap-mini">-->
        <!--                    <bkt-icon name="Search" width="12px" height="12px" color="primary"></bkt-icon>-->
        <!--                    <h5 class="bkt-text-primary font-weight-bold">найдено лотов: {{pagination.total}}</h5>-->
        <!--                </div>-->
        <!--                <div class="row w-100 mx-auto align-items-center justify-content-center mb-2 d-none d-md-flex">-->
        <!--                    <div class="col-2 pl-0">-->
        <!--                        <h6 class="bkt-text-neutral-dark">фото</h6>-->
        <!--                    </div>-->
        <!--                    <div class="col-3">-->
        <!--                        <h6 class="bkt-text-neutral-dark">описание лота</h6>-->
        <!--                    </div>-->
        <!--                    <div class="col-2">-->
        <!--                        <h6 class="bkt-text-neutral-dark">цена</h6>-->
        <!--                    </div>-->
        <!--                    <div class="col-2">-->
        <!--                        <h6 class="bkt-text-neutral-dark">даты торгов</h6>-->
        <!--                    </div>-->
        <!--                    <div class="col-3">-->
        <!--                        <h6 class="bkt-text-neutral-dark">ЭТП и организатор</h6>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </template>-->
        <!--            <template #dropdown-item="{item}">-->
        <!--                <mini-trade-card :item="item" class="bkt-card-trade-short"></mini-trade-card>-->
        <!--            </template>-->
        <!--        </bkt-search>-->
        <div class="bkt-wrapper bkt-nowrap bkt-gap">
            <bkt-search v-model="filters.searchString" no_dropdown :loading="loading" simple @runSearch="runSearch" clearable
                        class="w-100"
            >
            </bkt-search>
            <button class="bkt-button-icon p-2 flex-shrink-0" @click="filters_mode = !filters_mode"
                    :class="filters_mode ? 'bkt-bg-primary': ''"
            >
                <bkt-icon name="Filters" :color="filters_mode ? 'white': 'primary'"></bkt-icon>
            </button>
        </div>
        <transition-group name="fade" tag="div" class="bkt-main-instruments">
            <template v-if="filters_mode">
                <div key="bkt-main-categories" class="bkt-main-categories bkt-card__list">
                    <bkt-filter-card
                        :icon="{name:'Category', color:'green'}" category_class="bkt-bg-green-lighter"
                        title="Категории" :count="filters.categories" modal_name="#categoryModal"
                    >
                    </bkt-filter-card>
                    <bkt-filter-card
                        :icon="{name:'Location'}" category_class="bkt-bg-red-lighter"
                        title="Регионы" :count="filters.regions" modal_name="#regionModal"
                    >
                    </bkt-filter-card>
                    <bkt-filter-card
                        :icon="{name:'Options', color:'pink'}" category_class="bkt-bg-pink-lighter"
                        title="Ключевые слова и слова-исключения" :count="filters.mainParams"
                        modal_name="#paramsModal"
                    >
                    </bkt-filter-card>
                    <bkt-filter-card
                        :icon="{name:'Wallet'}" category_class="bkt-bg-yellow-lighter"
                        title="Стоимость объекта" :count="filters.prices"
                        modal_name="#priceModal"
                    >
                    </bkt-filter-card>
                    <bkt-filter-card
                        :icon="{name:'Date', color:'blue'}" category_class="bkt-bg-blue-lighter"
                        title="Дата торгов" :count="filters.dates"
                        modal_name="#dateModal"
                    >
                    </bkt-filter-card>
                    <bkt-filter-card
                        :icon="{name:'Clone'}" category_class="bkt-bg-primary-lighter"
                        title="Доп. параметры" :count="filters.extraOptions"
                        modal_name="#optionsModal"
                    >
                    </bkt-filter-card>
                    <bkt-filter-card
                        :icon="{name:'ClipboardList', color:'purple'}" category_class="bkt-bg-purple-lighter"
                        title="Торговые площадки" :count="filters.mainParams.tradePlaces"
                        modal_name="#tradePlacesModal"
                    >
                    </bkt-filter-card>
                    <bkt-filter-card
                        :icon="{name:'Clipboard', color:'teal'}" category_class="bkt-bg-teal-lighter"
                        title="Вид торгов" :count="filters.mainParams.tradeTypes"
                        modal_name="#tradeTypesModal"
                    >
                    </bkt-filter-card>
                </div>
                <div key="bkt-main-statistic" class="bkt-main-statistic bkt-card__list">
                    <div class="bkt-card__row bkt-bg-red-light position-relative">
                        <h5 class="bkt-card__text">Всего лотов</h5>
                        <h1 class="bkt-card__title">{{ lots_statistic.allLotsCount | priceFormat}}</h1>
                        <div class="bkt-card bkt-card__background-figure-1">
                        </div>
                        <div class="bkt-card bkt-card__background-figure-2 bkt-bg-red-light">
                        </div>
                    </div>
                    <div class="bkt-card__row bkt-bg-yellow position-relative">
                        <h5 class="bkt-card__text">Активных лотов</h5>
                        <h1 class="bkt-card__title">{{ lots_statistic.activeLotsCount | priceFormat}}</h1>
                        <div class="bkt-card bkt-card__background-figure-1">
                        </div>
                        <div class="bkt-card bkt-card__background-figure-2 bkt-bg-yellow">
                        </div>
                    </div>
                    <div class="bkt-card__row bkt-bg-blue position-relative">
                        <h5 class="bkt-card__text">Добавлено сегодня</h5>
                        <h1 class="bkt-card__title">{{lots_statistic.newLotsCount | priceFormat}}</h1>
                        <div class="bkt-card bkt-card__background-figure-1">
                        </div>
                        <div class="bkt-card bkt-card__background-figure-2 bkt-bg-blue">
                        </div>
                    </div>
                </div>
                <div key="bkt-main-filters" class="bkt-main-filters bkt-row">
                    <div class="col-12 col-md-4">
                        <!--                        <div class="bkt-wrapper bkt-nowrap w-100 mx-auto justify-content-around dropdown bkt-dropdown">-->
                        <bkt-select
                            v-model="filters_sort.type"
                            class="w-100"
                            select_class="form-floating body"
                            name="sort"
                            subtitle="сортировать по"
                            :option_label="'title'"
                            :options="sort"
                            :reduce="item => item.value"
                            :clearable="false"
                            @input="getData(1)"
                        >
                        </bkt-select>
                        <!--                            <button class="bkt-button-ellipse bkt-bg-body d-none d-md-block"-->
                        <!--                                    :class="{'bkt-mirror-vertical' : filters_sort.direction =='desc'}"-->
                        <!--                                    @click="toggleDirection"-->
                        <!--                            >-->
                        <!--                                <bkt-icon name="Bars"></bkt-icon>-->
                        <!--                            </button>-->
                        <!--                            <button class="bkt-button-ellipse bkt-bg-body d-md-none" id="filterDropdownMenu"-->
                        <!--                                    data-bs-toggle="dropdown"-->
                        <!--                                    data-bs-auto-close="outside" data-bs-offset="0, 10" data-bs-reference="parent"-->
                        <!--                            >-->
                        <!--                                <bkt-icon name="Funnel" :width="'18px'" :height="'18px'"></bkt-icon>-->
                        <!--                            </button>-->

                        <!--                            <div-->
                        <!--                                class="d-md-none dropdown-menu bkt-dropdown__menu bkt-dropdown__menu_list bkt-dropdown__menu_main"-->
                        <!--                                aria-labelledby="filterDropdownMenu"-->
                        <!--                            >-->
                        <!--                                <bkt-select-->
                        <!--                                    v-model="filters_other.period"-->
                        <!--                                    select_class="form-floating body"-->
                        <!--                                    name="period"-->
                        <!--                                    subtitle="показывать за период"-->
                        <!--                                    :option_label="'title'"-->
                        <!--                                    :options="periods"-->
                        <!--                                    :reduce="item => item.value"-->
                        <!--                                    :clearable="false"-->
                        <!--                                    @input="getData(1)"-->
                        <!--                                >-->
                        <!--                                </bkt-select>-->
                        <!--                                <div class="bkt-wrapper">-->
                        <!--                                    <div class="bkt-check__list">-->
                        <!--                                        <bkt-checkbox v-model="filters_other.hasPhotos"-->
                        <!--                                                      label="только с фото"-->
                        <!--                                                      name="hasPhotos"-->
                        <!--                                                      @input="getData(1)"-->
                        <!--                                        >-->
                        <!--                                        </bkt-checkbox>-->
                        <!--                                        <bkt-checkbox v-model="filters_other.isHidden"-->
                        <!--                                                      label="скрытые"-->
                        <!--                                                      name="isHidden"-->
                        <!--                                                      @input="getData(1)"-->
                        <!--                                        >-->
                        <!--                                        </bkt-checkbox>-->
                        <!--                                        &lt;!&ndash;                                <bkt-checkbox v-model="filters_other.hasAnswer"&ndash;&gt;-->
                        <!--                                        &lt;!&ndash;                                              label="получен ответ организатора"&ndash;&gt;-->
                        <!--                                        &lt;!&ndash;                                              name="hasAnswer"&ndash;&gt;-->
                        <!--                                        &lt;!&ndash;                                              @input="getData(1)"&ndash;&gt;-->
                        <!--                                        &lt;!&ndash;                                >&ndash;&gt;-->
                        <!--                                        &lt;!&ndash;                                </bkt-checkbox>&ndash;&gt;-->
                        <!--                                        <bkt-checkbox v-model="filters_other.isCompleted"-->
                        <!--                                                      label="завершённые"-->
                        <!--                                                      name="isCompleted"-->
                        <!--                                                      @input="getData(1)"-->
                        <!--                                                      wrapper_class="bkt-check__wrapper-inline"-->
                        <!--                                        >-->
                        <!--                                        </bkt-checkbox>-->
                        <!--                                        <bkt-checkbox v-model="filters_other.isStopped"-->
                        <!--                                                      label="приостановленные"-->
                        <!--                                                      name="isStopped"-->
                        <!--                                                      @input="getData(1)"-->
                        <!--                                                      wrapper_class="bkt-check__wrapper-inline"-->
                        <!--                                        >-->
                        <!--                                        </bkt-checkbox>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                    <div class="col-12 col-md-4 px-md-1">
                        <bkt-select
                            v-model="filters_sort.direction"
                            class="w-100"
                            select_class="form-floating body"
                            name="sort"
                            subtitle="направление сортировки"
                            :option_label="'title'"
                            :options="sort_directions"
                            :reduce="item => item.value"
                            :clearable="false"
                            @input="getData(1)"
                        >
                        </bkt-select>
                    </div>
                    <div class="col-12 col-md-4">
                        <bkt-select
                            v-model="filters_other.period"
                            select_class="form-floating body"
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
                    <!--                    <div class="col-md-12 col-lg-5 d-none d-md-block">-->
                    <!--                        <div class="d-flex">-->
                    <!--                            <div class="bkt-check__list">-->
                    <!--                                <bkt-checkbox v-model="filters_other.hasPhotos"-->
                    <!--                                              label="только с фото"-->
                    <!--                                              name="hasPhotos"-->
                    <!--                                              @input="getData(1)"-->
                    <!--                                >-->
                    <!--                                </bkt-checkbox>-->
                    <!--                                <bkt-checkbox v-model="filters_other.isHidden"-->
                    <!--                                              label="скрытые"-->
                    <!--                                              name="isHidden"-->
                    <!--                                              @input="getData(1)"-->
                    <!--                                >-->
                    <!--                                </bkt-checkbox>-->
                    <!--                            </div>-->
                    <!--                            <div class="bkt-check__list">-->
                    <!--                                &lt;!&ndash;                        <bkt-checkbox v-model="filters_other.hasAnswer"&ndash;&gt;-->
                    <!--                                &lt;!&ndash;                                      label="получен ответ организатора"&ndash;&gt;-->
                    <!--                                &lt;!&ndash;                                      name="hasAnswer"&ndash;&gt;-->
                    <!--                                &lt;!&ndash;                                      @input="getData(1)"&ndash;&gt;-->
                    <!--                                &lt;!&ndash;                        >&ndash;&gt;-->
                    <!--                                &lt;!&ndash;                        </bkt-checkbox>&ndash;&gt;-->
                    <!--                                <bkt-checkbox v-model="filters_other.isCompleted"-->
                    <!--                                              label="завершённые"-->
                    <!--                                              name="isCompleted"-->
                    <!--                                              @input="getData(1)"-->
                    <!--                                              wrapper_class="bkt-check__wrapper-inline"-->
                    <!--                                >-->
                    <!--                                </bkt-checkbox>-->
                    <!--                                <bkt-checkbox v-model="filters_other.isStopped"-->
                    <!--                                              label="приостановленные"-->
                    <!--                                              name="isStopped"-->
                    <!--                                              @input="getData(1)"-->
                    <!--                                              wrapper_class="bkt-check__wrapper-inline"-->
                    <!--                                >-->
                    <!--                                </bkt-checkbox>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>
            </template>

        </transition-group>

        <bkt-card-list ref="cardList" :current_component="'BktCard'" :items="items" :loading="loading"
                       :pagination_data="pagination_data" @change-page="getData" @changeStatus="changeStatus">
        </bkt-card-list>
        <div v-if="!isLoggedIn && !loading" class="bkt-shadow-card bkt-shadow-card_primary mt-3">
            <div class="bkt-shadow-card__inner bkt-gap-large">
                <h4 class="bkt-shadow-card__title bkt-text-white">
                    Чтобы продолжить просмотр лотов <br>
                    <span>войдите или зарегистрируйтесь</span>
                </h4>
                <button class="bkt-button bkt-bg-white bkt-text-primary mx-auto bkt-button_plump"
                        style="max-width: 320px"
                        data-bs-toggle="modal" data-bs-target="#authModal"
                >
                    Вход и регистрация
                </button>
                <div class="bkt-shadow-card__shadow-1">
                </div>
                <div class="bkt-shadow-card__shadow-2">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BktDateModal from "../components/SharedModals/DateModal";
    import BktPriceModal from "../components/SharedModals/PriceModal";
    import BktOptionsModal from "../components/SharedModals/OptionsModal";
    import BktParamsModal from "../components/SharedModals/ParamsModal";
    import BktRegionModal from "../components/SharedModals/RegionModal";
    import BktCategoryModal from "../components/SharedModals/CategoryModal";
    import BktTradePlaceModal from "../components/SharedModals/TradePlaceModal";
    import BktTradeTypeModal from "../components/SharedModals/TradeTypeModal";
    import BktSelect from "../components/Select";
    import BktFilterCard from "../components/FilterCard";
    import MiniTradeCard from "../components/MiniTradeCard";

    export default {
        name: "Main",
        components: {
            BktDateModal, BktPriceModal, BktOptionsModal,
            BktParamsModal, BktRegionModal, BktCategoryModal,
            BktTradePlaceModal, BktTradeTypeModal,
            BktSelect, BktFilterCard, MiniTradeCard
        },
        data() {
            return {
                in_process: [],
                periods: [
                    {title: 'Все', value: "periodAll"},
                    {title: 'Сутки', value: "periodDay"},
                    {title: '7 дней', value: "periodWeek"},
                    {title: '30 дней', value: "periodMonth"},
                ],
                sort: [
                    {title: 'Дате добавления', value: "publishDate"},
                    {title: 'Цене', value: "currentPrice"},
                    {title: 'Дате начала торгов', value: "eventStart"},
                    {title: 'Дате окончания торгов', value: "eventEnd"},
                    {title: 'Дате начала приема заявок', value: "applicationStart"},
                    {title: 'Дате окончания приема заявок', value: "applicationEnd"},
                ],
                sort_directions: [
                    {title: 'По возрастанию', value: "asc"},
                    {title: 'По убыванию', value: "desc"},
                ],
                searchString: '',
                filters_mode: false
            };
        },
        created() {
            this.$store.dispatch('getLotsStatistic');
        },
        mounted() {
            if (this.items.length == 0) {
                let page = 1;
                if (sessionStorage.getItem('main_page')) {
                    page = sessionStorage.getItem('main_page')
                }
                this.getData(page);
            }
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
                    this.$store.commit('saveFilterProperty', {filter: 'extraOptions', key: 'other', value: value});
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
            },
            lots_statistic() {
                return this.$store.getters.lots_statistic;
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
        watch: {
            isLoggedIn: function (newVal, oldVal) {
                // if (oldVal == false && newVal == true) {
                // if (this.pagination_data && this.pagination_data.currentPage) {
                //     this.getData(this.pagination_data.currentPage);
                // } else {
                    this.getData(1);
                // }
                // }
            }
        },
        methods: {
            async getData(page = 1) {
                sessionStorage.setItem('main_page', page + '');
                await this.$store.dispatch('getFilteredTrades', {
                    page: page,
                    filters: this.filters
                });
            },
            runSearch(search) {
                this.getData();
                let el = document.querySelector(".bkt-main-filters");
                if(el) {
                    el.scrollIntoView({ block: 'start', scrollBehavior: 'smooth' });
                }
            },
            toggleDirection() {
                if (this.filters_sort.direction == 'asc') {
                    this.filters_sort.direction = 'desc';
                } else {
                    this.filters_sort.direction = 'asc';
                }
                this.getData(1)
            },
            selectSearchLot(lot) {
                this.$router.push('/lot/' + lot.id)
            },
            changeStatus(payload) {
                if (payload.key === 'isHide') {
                    let page = null;
                    if (payload.page) {
                        page = payload.page
                    }
                    this.getData(page)
                }

            }
        }
    }
</script>

<style scoped>
    .fade-enter-active,
    .fade-leave-active
    {
        opacity: 0;
        transition: opacity 0.5s ease;
    }
    .fade-enter-to,
    .fade-leave-from {
        transition: opacity 0.5s ease-in;
        opacity: 0.9;
    }
    .fade-enter-from,
    .fade-leave-to {
        opacity: 0;
    }
</style>
