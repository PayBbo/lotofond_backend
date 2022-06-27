<template>
    <div class="container bkt-main bkt-container">
        <bkt-date-modal></bkt-date-modal>
        <bkt-price-modal></bkt-price-modal>
        <bkt-options-modal></bkt-options-modal>
        <bkt-params-modal></bkt-params-modal>
        <h1 class="bkt-main-title text-center">Электронные торги по банкротству</h1>
        <div class="bkt-search position-relative bg-white">
            <input class="w-100 bkt-search__input" type="text" placeholder="Введите нужное слово или фразу">
            <button class="bkt-button green bkt-search__button">
                <span class="d-none d-md-block">Найти</span>
                <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
            </button>
        </div>
        <div class="bkt-main-categories bkt-card__list">
            <div class="bkt-card__row">
                <div class="col-10">
                    <h4 class="bkt-card__title">Выберите<br> нужные категории</h4>
                    <h5 class="bkt-card__subtitle bkt-text-green">выбрано 4</h5>
                    <button class="bkt-button primary-lighter" data-bs-toggle="modal" data-bs-target="#bkt-modal">
                        Изменить
                    </button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bkt-bg-green ms-auto">
                        <span class="bkt-card__category-icon">
                            <bkt-icon :name="'Category'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card__row">
                <div class="col-10">
                    <h4 class="bkt-card__title">Выберите<br> регион</h4>
                    <h5 class="bkt-card__subtitle">ничего не выбрано</h5>
                    <button class="bkt-button primary">Выбрать</button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bkt-bg-red-lighter ms-auto">
                        <span class="bkt-card__category-icon">
                             <bkt-icon :name="'Location'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card__row">
                <div class="col-10">
                    <h4 class="bkt-card__title">Выберите основные<br> параметры объекта</h4>
                    <h5 class="bkt-card__subtitle" :class="{'bkt-text-green': filters_params>0}">
                        {{filters_params>0 ?'' : 'ничего не'}} выбрано {{filters_params>0 ? filters_params : ''}}
                    </h5>
                    <button class="bkt-button" :class="[filters_params>0 ? 'primary-lighter': 'primary']"
                            data-bs-toggle="modal" data-bs-target="#paramsModal"
                    >
                        {{filters_params>0 ? 'Изменить' : 'Выбрать'}}
                    </button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bkt-bg-purple-lighter  ms-auto">
                        <span class="bkt-card__category-icon">
                             <bkt-icon :name="'Options'" :color="'purple'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card__row">
                <div class="col-10">
                    <h4 class="bkt-card__title">Выберите<br> стоимость объекта</h4>
                    <h5 class="bkt-card__subtitle" :class="{'bkt-text-green': filters_prices>0}">
                        {{filters_prices>0 ?'' : 'ничего не'}} выбрано {{filters_prices>0 ? filters_prices : ''}}
                    </h5>
                    <button class="bkt-button" :class="[filters_prices>0 ? 'primary-lighter': 'primary']"
                            data-bs-toggle="modal" data-bs-target="#priceModal"
                    >
                        {{filters_prices>0 ? 'Изменить' : 'Выбрать'}}
                    </button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bkt-bg-yellow-lighter ms-auto">
                        <span class="bkt-card__category-icon">
                            <bkt-icon :name="'Wallet'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card__row">
                <div class="col-10">
                    <h4 class="bkt-card__title">Выберите<br> дату торгов</h4>
                    <h5 class="bkt-card__subtitle" :class="{'bkt-text-green': filters_dates>0}">
                        {{filters_dates>0 ?'' : 'ничего не'}} выбрано {{filters_dates>0 ? filters_dates : ''}}
                    </h5>
                    <button class="bkt-button" :class="[filters_dates>0 ? 'primary-lighter': 'primary']"
                            data-bs-toggle="modal" data-bs-target="#dateModal"
                    >
                        {{filters_dates>0 ? 'Изменить' : 'Выбрать'}}
                    </button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bkt-bg-blue ms-auto">
                        <span class="bkt-card__category-icon">
                            <bkt-icon :name="'Date'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card__row">
                <div class="col-10">
                    <h4 class="bkt-card__title">Выберите<br> доп. параметры</h4>
                    <h5 class="bkt-card__subtitle" :class="{'bkt-text-green': filters_extra_options>0}">
                        {{filters_extra_options>0 ?'' : 'ничего не'}} выбрано {{filters_extra_options>0 ?
                        filters_extra_options : ''}}
                    </h5>
                    <button class="bkt-button primary" :class="[filters_extra_options>0 ? 'primary-lighter': 'primary']"
                            data-bs-toggle="modal" data-bs-target="#optionsModal"
                    >
                        {{filters_extra_options>0 ? 'Изменить' : 'Выбрать'}}
                    </button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bkt-bg-primary-lighter ms-auto">
                        <span class="bkt-card__category-icon">
                            <bkt-icon :name="'Clone'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
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
            <div class="col-12 col-md-6 col-lg-4">
                <div class="d-flex w-100 mx-auto justify-content-around">
                    <div class="form-floating bkt-select__wrapper main">
                        <select class="form-select bkt-select" id="sortSelect" aria-label="">
                            <option selected>ключевому слову</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <label class="bkt-select__subtitle" for="sortSelect">сортировать по</label>
                    </div>
                    <button class="bkt-button-ellipse main d-none d-md-block">
                        <bkt-icon name="Bars"></bkt-icon>
                    </button>
                    <button class="bkt-button-ellipse main d-md-none">
                        <bkt-icon name="Funnel" :width="'18px'" :height="'18px'"></bkt-icon>
                    </button>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 d-none d-md-block">
                <bkt-select
                    v-model="filters_main_params.period"
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
<!--                <div class="form-floating bkt-select__wrapper main">-->
<!--                    <select class="form-select bkt-select" v-model="filters_main_params.period" @input="getData(1)" id="periodSelect" aria-label="">-->
<!--                        <option selected value="all">все</option>-->
<!--                        <option value="day">сутки</option>-->
<!--                        <option value="7 days">7 дней</option>-->
<!--                        <option value="30 days">30 дней</option>-->
<!--                    </select>-->
<!--                    <label class="bkt-select__subtitle" for="periodSelect">показывать за период</label>-->
<!--                </div>-->
            </div>
            <div class="col-md-12 col-lg-5 d-none d-md-block">
                <div class="d-flex">
                    <div class="bkt-check__list">
                        <bkt-checkbox v-model="filters_main_params.isWithPhotos"
                                   label="только с фото"
                                   name="isWithPhotos"
                                      @input="getData(1)"
                        >
                        </bkt-checkbox>
                        <bkt-checkbox v-model="filters_main_params.isDeleted"
                                      label="удалённые"
                                      name="isDeleted"
                                      @input="getData(1)"
                        >
                        </bkt-checkbox>
                    </div>
                    <div class="bkt-check__list">
<!--                        <bkt-checkbox v-model="filters_main_params."-->
<!--                                      label="завершённые"-->
<!--                                      name="получен ответ организатора"-->
<!--                                      @input="getData(1)"-->
<!--                        >-->
<!--                        </bkt-checkbox>-->
                        <bkt-checkbox v-model="filters_main_params.isCompleted"
                                      label="завершённые"
                                      name="isCompleted"
                                      @input="getData(1)"
                                      wrapper_class="bkt-check__wrapper-inline"
                        >
                        </bkt-checkbox>
                        <bkt-checkbox v-model="filters_main_params.isStopped"
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
    import BktSelect from "../../components/Select";

    export default {
        name: "Main",
        components: {
            BktDateModal, BktPriceModal, BktOptionsModal,
            BktParamsModal, BktRegionModal, BktSelect
        },
        async mounted() {
            await this.getData()
        },
        data() {
            return {
                in_process: [],
                periods: [
                    { title:'Все', value:"all"},
                    { title:'Сутки', value:"day"},
                    { title:'7 дней', value:"7 days"},
                    { title:'30 дней', value:"30 days"},
                ]
            };
        },
        computed: {
            filters() {
                return this.$store.getters.filters;
            },
            filters_dates() {
                return this.total(this.$store.getters.filters_dates);
            },
            filters_prices() {
                return this.total(this.$store.getters.filters_prices);
            },
            filters_extra_options() {
                return this.total(this.$store.getters.filters_extra_options);
            },
            filters_params() {
                return this.total(this.$store.getters.filters_params);
            },
            filters_main_params: {
                get() {
                    return this.$store.getters.filters_params;
                },
                set(value) {
                    this.$store.commit('saveFiltersProperty', {key: 'mainParams', value: value});
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
            total(filter) {
                return Object.values(filter)
                    .reduce((r, o) => {
                        // if(r && o) {
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
                        // if (Array.isArray(o)) {
                        //     o.forEach(item => {
                        //         if (item) {
                        //             r++;
                        //         }
                        //         console.log('item', r, item)
                        //     });
                        // }
                        return r;
                        // }
                        // return 0;
                    }, 0);
            }
        }
    }
</script>

<style scoped>

</style>
