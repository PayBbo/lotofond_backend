<template>
    <div class="bkt-page bkt-container">
        <bkt-category-modal filter_name="nearest_filters" method_name="getNearestTrades"/>
        <bkt-region-modal filter_name="nearest_filters" method_name="getNearestTrades"/>
        <bkt-params-modal filter_name="nearest_filters" method_name="getNearestTrades"/>
        <bkt-price-modal filter_name="nearest_filters" method_name="getNearestTrades"/>
        <bkt-date-modal filter_name="nearest_filters" method_name="getNearestTrades"/>
        <bkt-options-modal filter_name="nearest_filters" method_name="getNearestTrades"/>
        <bkt-trade-place-modal filter_name="nearest_filters" method_name="getNearestTrades"/>
        <bkt-trade-type-modal filter_name="nearest_filters" method_name="getNearestTrades"/>
        <h1 class="bkt-page__title">
            Ближайшие торги
        </h1>
        <section class="bkt-auctions">
            <div class="bkt-wrapper-column bkt-gap bkt-gap-down-sm-small">
                <div class="bkt-auctions__filters bkt-wrapper-column bkt-gap-small d-lg-none d-flex">
                    <div class="bkt-card__row bkt-auctions__filters-card" @click="openModal('category')">
                        <div class="bkt-auctions__filters-card-header">
                            <div class="bkt-icon-frame bkt-bg-green-lighter">
                                <bkt-icon :name="'Category'" :color="'green'" width="25px" height="25px"></bkt-icon>
                            </div>
                            <h6 class="bkt-card__title">
                                Категории
                                <span class="bkt-badge bkt-bg-green-lighter bkt-text-green">
                                    {{total(filters.categories)}}
                                </span>
                            </h6>
                        </div>
                        <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
                    </div>
                    <div class="bkt-card__row bkt-auctions__filters-card" @click="openModal('region')">
                        <div class="bkt-auctions__filters-card-header">
                            <div class="bkt-icon-frame bkt-bg-red-lighter">
                                <bkt-icon :name="'Location'" :color="'red'" width="25px" height="25px"></bkt-icon>
                            </div>
                            <h6 class="bkt-card__title">
                                Регион
                                <span class="bkt-badge bkt-bg-red-lighter bkt-text-red">
                                    {{total(filters.regions)}}
                                </span>
                            </h6>
                        </div>
                        <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
                    </div>
                    <div class="bkt-card__row bkt-auctions__filters-card" @click="openModal('params')">
                        <div class="bkt-auctions__filters-card-header">
                            <div class="bkt-icon-frame bkt-bg-pink-lighter">
                                <bkt-icon :name="'Options'" :color="'pink'" width="25px" height="25px"></bkt-icon>
                            </div>
                            <h6 class="bkt-card__title">
                                Ключевые слова и слова-исключения
                                <span class="bkt-badge bkt-bg-pink-lighter bkt-text-pink">
                                    {{total(filters.mainParams)}}
                                </span>
                            </h6>
                        </div>
                        <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
                    </div>
                    <div class="bkt-card__row bkt-auctions__filters-card" @click="openModal('price')">
                        <div class="bkt-auctions__filters-card-header">
                            <div class="bkt-icon-frame bkt-bg-yellow-lighter">
                                <bkt-icon :name="'Wallet'" :color="'yellow'" width="25px" height="25px"></bkt-icon>
                            </div>
                            <h6 class="bkt-card__title">
                                Стоимость объекта
                                <span class="bkt-badge bkt-bg-yellow-lighter bkt-text-yellow">
                                     {{total(filters.prices)}}
                                </span>
                            </h6>
                        </div>
                        <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
                    </div>
                    <div class="bkt-card__row bkt-auctions__filters-card" @click="openModal('date')">
                        <div class="bkt-auctions__filters-card-header">
                            <div class="bkt-icon-frame bkt-bg-blue-lighter">
                                <bkt-icon :name="'Date'" :color="'blue'" width="25px" height="25px"></bkt-icon>
                            </div>
                            <h6 class="bkt-card__title">
                                Дата торгов
                                <span class="bkt-badge bkt-bg-blue-lighter bkt-text-blue">
                                    {{total(filters.dates)}}
                                </span>
                            </h6>
                        </div>
                        <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
                    </div>
                    <div class="bkt-card__row bkt-auctions__filters-card" @click="openModal('options')">
                        <div class="bkt-auctions__filters-card-header">
                            <div class="bkt-icon-frame bkt-bg-primary-lighter">
                                <bkt-icon :name="'Clone'" :color="'primary'" width="25px" height="25px"></bkt-icon>
                            </div>
                            <h6 class="bkt-card__title">
                                Доп. параметры
                                <span class="bkt-badge bkt-bg-primary-lighter bkt-text-primary">
                                    {{total(filters.extraOptions)}}
                                </span>
                            </h6>
                        </div>
                        <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
                    </div>
                    <div class="bkt-card__row bkt-auctions__filters-card" @click="openModal('tradePlaces')">
                        <div class="bkt-auctions__filters-card-header">
                            <div class="bkt-icon-frame bkt-bg-purple-lighter">
                                <bkt-icon :name="'ClipboardList'" :color="'purple'" width="25px"
                                          height="25px"></bkt-icon>
                            </div>
                            <h6 class="bkt-card__title">
                                Торговые площадки
                                <span class="bkt-badge bkt-bg-purple-lighter bkt-text-purple">
                                    {{total(filters.mainParams.tradePlaces)}}
                                </span>
                            </h6>
                        </div>
                        <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
                    </div>
                    <div class="bkt-card__row bkt-auctions__filters-card" @click="openModal('tradeTypes')">
                        <div class="bkt-auctions__filters-card-header">
                            <div class="bkt-icon-frame bkt-bg-teal-lighter">
                                <bkt-icon :name="'Clipboard'" :color="'teal'" width="25px" height="25px"></bkt-icon>
                            </div>
                            <h6 class="bkt-card__title">
                                Вид торгов
                                <span class="bkt-badge bkt-bg-teal-lighter bkt-text-teal">
                                    {{total(filters.mainParams.tradeTypes)}}
                                </span>
                            </h6>
                        </div>
                        <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
                    </div>
                </div>
                <div class="bkt-card bkt-card__body bkt-auctions__filters">
                    <div class="bkt-card__header bkt-auctions__filters-header d-lg-flex d-none">
                        <template v-for="(category, index) in categories">
                            <button class="bkt-button" v-tooltip="category.label" :key="index"
                                    :class="[isCategoryChecked(category.key) ? 'bkt-border-primary' : 'bkt-border-'+categories_colors[category.key]+'-lighter',
                                'bkt-bg-'+categories_colors[category.key]+'-lighter']"
                                    @click="toggleCategory(category.key)" :disabled="categories_loading"
                            >
                                <bkt-icon :key="'icon'+index" :name="'categories/'+category.key" v-if="category.key"
                                          :color="categories_colors[category.key]" :width="'30px'" :height="'30px'"
                                >
                                </bkt-icon>
                            </button>
                        </template>
                    </div>
                    <div class="bkt-auctions__filters-content d-lg-flex d-none">
                        <div class="row align-items-center bkt-gap-row">
                            <div class="col-12 col-lg-2">
                                <h5 class="bkt-form__label">регион</h5>
                            </div>
                            <div class="col-12 col-lg-10">
                                <bkt-select name="regions"
                                            v-model="current_region"
                                            :options="region_options"
                                            option_label="label"
                                            :reduce="option => option.value"
                                            :method_name="'getRegions'"
                                            :loading="regions_loading"
                                            @input="getData(1)"
                                >
                                </bkt-select>
                            </div>
                            <div class="col-2"></div>
                            <div class="col-10">
                                <div class="bkt-selected-region bkt-tag__list">
                                    <div class="bkt-region__item bkt-tag justify-content-between flex-fill"
                                         v-for="(item, index) in filters.regions">
                                        <span class="bkt-item-rounded__text mr-2">{{ $t('regions.' + item) }}</span>
                                        <span class="bkt-tag__icon bkt-cursor-pointer" @click="removeRegion(item)">
                                            <bkt-icon name="Cancel" color="red"></bkt-icon>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center bkt-gap-row">
                            <div class="col-2">
                                <label class="bkt-form__label">торговые площадки</label>
                            </div>
                            <div class="col-10">
                                <bkt-select v-model="current_trade_place" name="trading_platform"
                                            :option_label="'name'"
                                            :options="trade_places"
                                            :method_name="'getFiltersTradePlaces'"
                                            :searchable="true"
                                            :loading="trade_places_loading"
                                            @input="getData(1)"
                                ></bkt-select>
                                <!--                        <div class="row">-->
                                <!--                            <div class="col-12 col-md-3">-->
                                <!--                                <bkt-select v-model="current_trade_place" name="trading_platform"-->
                                <!--                                            :option_label="'name'"-->
                                <!--                                            :options="trade_places"-->
                                <!--                                            :pagination="trade_places_pagination"-->
                                <!--                                            :reduce="item => item.id"-->
                                <!--                                            :method_name="'getTradePlaces'"-->
                                <!--                                            :searchable="true"-->
                                <!--                                            :loading="trade_places_loading"-->
                                <!--                                ></bkt-select>-->
                                <!--                            </div>-->
                                <!--                            <div class="col-12 col-md-9">-->
                                <!--                                <div-->
                                <!--                                    class="bkt-marketplace-checkboxes d-flex h-100 align-items-center justify-content-end">-->
                                <!--                                    <bkt-checkbox label="Банкротство" name="bankrot" class="mr-3"></bkt-checkbox>-->
                                <!--                                    <bkt-checkbox label="TorgiGov" name="torgiGov" class="mr-3"></bkt-checkbox>-->
                                <!--                                    <bkt-checkbox label="Залоговое" name="zalog" class="mr-3"></bkt-checkbox>-->
                                <!--                                    <bkt-checkbox label="Коммерческое" name="commerce"></bkt-checkbox>-->
                                <!--                                </div>-->
                                <!--                            </div>-->
                                <!--                        </div>-->
                            </div>
                            <div class="col-2"></div>
                            <div class="col-10">
                                <div class="bkt-selected-region bkt-tag__list">
                                    <div class="bkt-region__item bkt-tag justify-content-between flex-fill"
                                         v-for="(item, index) in selected_trade_places">
                                        <span class="bkt-item-rounded__text mr-2">{{ item.name }}</span>
                                        <span class="bkt-tag__icon bkt-cursor-pointer"
                                              @click="removeTradePlace(item.id)">
                                            <bkt-icon name="Cancel" color="red"></bkt-icon>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="bkt-form__label bkt-form__label_column">виды торгов</label>
                            </div>
                            <div class="col-lg-10">
                                <div class="bkt-form bkt-wrapper bkt-auctions-types">
                                    <div class="bkt-auctions-type flex-fill" v-for="item in auctionTypes">
                                        <button
                                            class="bkt-block-btn bkt-auctions-type__card bkt-auctions-type__title bkt-bg-body w-100"
                                            @click="toggleAuctionType(item.title)"
                                            :class="[filters.mainParams.tradeTypes.includes(item.title) ? 'bkt-border-primary': 'bkt-border-body']">
                                            {{item.description}}
                                        </button>
                                        <!--                                <h6 class="bkt-auctions-type__subtitle">что это?</h6>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <bkt-prices-control v-model="filters.prices" label_column="col-12 col-md-2 p-0"
                                            content_column="col-12 col-lg-10" @input="inputPrice"
                        >
                        </bkt-prices-control>
                    </div>
                    <div class="bkt-card__footer bkt-auctions__filters-footer">
                        <button class="bkt-button bkt-button_delete order-2 order-lg-1 me-auto d-lg-flex d-none"
                                @click="clearFilters"
                        >
                            <bkt-icon :name="'Trash'" :width="'22px'" :height="'22px'"></bkt-icon>
                        </button>
                        <div
                            class="bkt-auctions__filters-checkboxes bkt-wrapper-down-lg-column order-1 order-lg-2 bkt-w-lg-100">
                            <bkt-checkbox label="с ближайших" v-model="sort_direction" name="near"></bkt-checkbox>
                            <div class="bkt-auctions__filters-switch">
                                <span class="bkt-auctions__filters-switch-label text-end"
                                      :class="{'bkt-text-neutral-dark': sort_type == true}"
                                >
                                    окончание торгов
                                </span>
                                <bkt-switch v-model="sort_type"></bkt-switch>
                                <span class="bkt-auctions__filters-switch-label text-start"
                                      :class="{'bkt-text-neutral-dark': sort_type == false}"
                                >
                                    окончание приёма заявок
                                </span>
                            </div>
                        </div>
                        <!--                        <button class="bkt-button primary bkt-button_plump order-3 order-lg-3 d-lg-flex d-none">-->
                        <!--                            Сохранить-->
                        <!--                        </button>-->
                    </div>
                </div>
                <div class="bkt-card bkt-auctions__find" v-if="!loading && pagination_data">
                    НАЙДЕНО {{pagination_data && pagination_data.total ? pagination_data.total : 0}} ЛОТОВ
                    <bkt-icon name="ArrowDown" color="primary"></bkt-icon>
                </div>
            </div>
            <div>
                <bkt-card-list :current_component="'BktCard'" :items="items" :loading="loading"
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
        </section>
    </div>
</template>

<script>
    import BktCard from "../components/Card";
    import BktDateModal from "../components/SharedModals/DateModal";
    import BktPriceModal from "../components/SharedModals/PriceModal";
    import BktOptionsModal from "../components/SharedModals/OptionsModal";
    import BktParamsModal from "../components/SharedModals/ParamsModal";
    import BktRegionModal from "../components/SharedModals/RegionModal";
    import BktCategoryModal from "../components/SharedModals/CategoryModal";
    import BktTradeTypeModal from "../components/SharedModals/TradeTypeModal";
    import BktTradePlaceModal from "../components/SharedModals/TradePlaceModal";
    import BktCardList from "../components/CardList";
    import BktPricesControl from "../components/FiltersControls/PricesControl";
    import BktSwitch from "../components/Switch";
    import _ from 'lodash';

    export default {
        name: "UpcomingAuctions",
        components: {
            BktDateModal, BktPriceModal, BktOptionsModal,
            BktParamsModal, BktRegionModal, BktCategoryModal,
            BktTradeTypeModal, BktTradePlaceModal,
            BktCardList, BktPricesControl,
            BktSwitch, BktCard
        },
        data() {
            return {
                selected_regions: [],
                selected_trade_places: [],
                auctionTypes: [
                    {description: 'Открытый аукцион', title: 'OpenAuction'},
                    {description: 'Открытый конкурс', title: 'OpenConcours'},
                    {description: 'Публичное предложение', title: 'PublicOffer'},
                    {description: 'Закрытый аукцион', title: 'CloseAuction'},
                    {description: 'Закрытый конкурс', title: 'CloseConcours'},
                    {description: 'Закрытое публичное предложение', title: 'ClosePublicOffer'}
                ],
                nearest_filters_template: {
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
                        arbitrationManagers: [],
                        other: {
                            period: 'periodAll',
                            hasPhotos: false,
                            isStopped: false,
                            isCompleted: false,
                            isHidden: false
                        },
                    },
                    mainParams: {
                        excludedWords: '',
                        includedWords: '',
                        tradePlaces: [],
                        tradeTypes: []
                    },
                    sort: {
                        direction: "desc",
                        type: "applicationEnd"
                    }
                },
                categories_colors: {
                    "realEstate": "green",
                    "other": "main",
                    "equipment": "red",
                    "transportAndEquipment": "orange",
                    "agriculturaProperty": "blue",
                    "tangibles": "yellow",
                    "productionLines": "purple",
                    "obligations": "teal",
                    "accountsReceivable": "primary",
                },
            };
        },
        mounted() {
            let page = 1;
            if (sessionStorage.getItem('nearest_page')) {
                page = sessionStorage.getItem('nearest_page')
            }
            this.getData(page);
        },
        computed: {
            items() {
                return this.$store.getters.nearest_trades;
            },
            pagination_data() {
                return this.$store.getters.nearest_trades_pagination;
            },
            loading() {
                return this.$store.getters.nearest_trades_loading;
            },
            filters: {
                // return this.$store.getters.nearest_filters;
                get() {
                    return this.$store.getters.nearest_filters;
                },
                set(value) {
                    this.$store.dispatch('saveDataProperty', {
                        module_key: 'filters',
                        key: 'nearest_filters',
                        value: value
                    });
                }
            },
            current_trade_place: {
                get: function () {
                    return null;
                },
                set: function (newValue) {
                    let index = this.selected_trade_places.map(item => item.id)
                        .indexOf(newValue.id);
                    if (index < 0) {
                        this.selected_trade_places.push(newValue);
                        this.filters.mainParams.tradePlaces.push(newValue.id);
                    }
                }
            },
            trade_places() {
                let places = this.$store.getters.filters_data.tradePlaces.data;
                this.selected_trade_places = places
                    .filter(item => this.filters.mainParams.tradePlaces.includes(item.id))
                return places
            },
            trade_places_loading() {
                return this.$store.getters.filters_data.tradePlaces.loading
            },
            current_region: {
                get: function () {
                    return null;
                },
                set: function (newValue) {
                    let index = this.filters.regions.indexOf(newValue);
                    if (index < 0) {
                        this.filters.regions.push(newValue);
                    }
                }
            },
            categories() {
                return this.$store.getters.categories
            },
            categories_loading() {
                return this.$store.getters.categories_loading
            },
            region_options() {
                let tmp = [].concat.apply([], this.$store.getters.regions.map(item => item.regions));
                let result =[];
                tmp.forEach(item => {
                    result.push({label: this.$t('regions.'+item), value: item});
                });
                return result.sort((a, b) => a.label.localeCompare(b.label))
            },
            regions() {
                return this.$store.getters.regions
            },
            regions_loading() {
                return this.$store.getters.regions_loading
            },
            sort_direction: {
                get: function () {
                    if (this.filters.sort.direction == 'desc') {
                        return true;
                    }
                    return false;
                },
                set: function (newValue) {
                    if (newValue) {
                        this.filters.sort.direction = 'desc';
                    } else {
                        this.filters.sort.direction = 'asc';
                    }
                    this.getData(1)
                }
            },
            sort_type: {
                get: function () {
                    return this.filters.sort.type == 'applicationEnd';

                },
                set: function (newValue) {
                    if (newValue) {
                        this.filters.sort.type = 'applicationEnd';
                    } else {
                        this.filters.sort.type = 'eventEnd';
                    }
                    this.getData(1);
                }
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
        watch: {
            isLoggedIn: function (newVal, oldVal) {
                this.getData(1);
            }
        },
        methods: {
            async getData(page = 1) {
                this.$store.commit('saveFiltersProperty',
                    {key: 'nearest_filters_mainParams', value: this.filters.mainParams});
                this.$store.commit('saveFiltersProperty',
                    {key: 'nearest_filters_prices', value: this.filters.prices});
                this.$store.commit('saveFiltersProperty',
                    {key: 'nearest_filters_regions', value: this.filters.regions});
                this.$store.commit('saveFiltersProperty',
                    {key: 'nearest_filters_categories', value: this.filters.categories});
                sessionStorage.setItem('nearest_page', page + '');
                await this.$store.dispatch('getNearestTrades', {
                    page: page,
                    filters: this.filters
                });
            },
            openModal(name) {
                this.$store.commit('openModal', '#' + name+'Modal');
            },
            toggleCategory(category) {
                let index = this.categories.findIndex(item => item.key === category);
                if (index >= 0) {
                    let subcategories = this.categories[index].subcategories.map(item => item.key);
                    if (subcategories.length > 0) {
                        let some_checked = subcategories.some(v => this.filters.categories.includes(v));
                        if (some_checked) {
                            subcategories.forEach(item => {
                                let item_index = this.filters.categories.findIndex(el => el == item);
                                if (item_index >= 0) {
                                    this.filters.categories.splice(item_index, 1)
                                }
                            });
                        } else {
                            subcategories.forEach(item => {
                                let item_index = this.filters.categories.findIndex(el => el == item);
                                if (item_index < 0) {
                                    this.filters.categories.push(item)
                                }
                            })
                        }
                    } else {
                        let item_index = this.filters.categories.findIndex(el => el == category);
                        if (item_index >= 0) {
                            this.filters.categories.splice(item_index, 1)
                        } else {
                            this.filters.categories.push(category)
                        }
                    }
                    this.getData(1);
                }
            },
            isCategoryChecked(category) {
                let index = this.categories.findIndex(item => item.key === category);
                if (index >= 0) {
                    if (this.categories[index].subcategories.length > 0) {
                        return this.categories[index].subcategories.map(item => item.key).every(v => this.filters.categories.includes(v))
                    } else {
                        return this.filters.categories.includes(category)
                    }
                }
            },
            removeRegion(region) {
                let index = this.filters.regions.indexOf(region);
                if (index >= 0) {
                    this.filters.regions.splice(index, 1);
                }
                this.getData(1);
            },
            removeTradePlace(id) {
                let index = this.selected_trade_places.findIndex(el => el.id == id);
                if (index >= 0) {
                    this.selected_trade_places.splice(index, 1);
                }
                index = this.filters.mainParams.tradePlaces.findIndex(el => el == id);
                if (index >= 0) {
                    this.filters.mainParams.tradePlaces.splice(index, 1);
                }
                this.getData(1);
            },
            total(filter) {
                let total = JSON.parse(JSON.stringify(filter));
                if (total.other) {
                    total.other.period = null
                }
                if (total.tradeTypes) {
                    total.tradeTypes = null
                }
                if (total.tradePlaces) {
                    total.tradePlaces = null
                }
                if (Array.isArray(total)) {
                    return total.length
                }
                return Object.values(total)
                    .reduce((r, o) => {
                        if (typeof o === 'object') {
                            if (o != null) {
                                Object.values(o).forEach(item => {
                                    if (item) {
                                        r++;
                                    }
                                });
                            }
                        }
                        if (typeof o === 'string') {
                            if (o !== '') {
                                r++;
                            }
                        }
                        return r;
                    }, 0);
            },
            clearFilters() {
                this.$store.commit('resetFilters', 'nearest_');
                this.getData(1);
            },
            toggleAuctionType(title) {
                let item_index = this.filters.mainParams.tradeTypes.findIndex(el => el == title);
                if (item_index < 0) {
                    this.filters.mainParams.tradeTypes.push(title);
                } else {
                    this.filters.mainParams.tradeTypes.splice(item_index, 1);
                }
                this.getData(1)
            },
            inputPrice: _.debounce(function (e) {
                this.getData(1)
            }, 700),
            changeStatus(payload) {
                if (payload.key === 'isHide') {
                    let page = null;
                    if (payload.page) {
                        page = payload.page
                    }
                    this.getData(page)
                }
            },
        },
    }
</script>

<style scoped>

</style>
