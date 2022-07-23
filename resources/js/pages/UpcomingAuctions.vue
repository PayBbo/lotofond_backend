<template>
    <div class="bkt-page bkt-auctions bkt-container">
        <bkt-category-modal/>
        <bkt-region-modal/>
        <bkt-params-modal/>
        <bkt-price-modal/>
        <bkt-date-modal/>
        <bkt-options-modal/>
        <h1 class="bkt-page__title">
            Ближайшие торги
        </h1>
        <div class="bkt-auctions__content p-5 mb-2 d-lg-block d-none">
            <div class="bkt-content__buttons d-flex justify-content-between mb-5">
                <div class="bkt-button" style="background: #effbf1">
                    <bkt-icon :name="'Home'" :color="'green'" :width="'30px'" :height="'30px'"></bkt-icon>
                </div>
                <div class="bkt-button bkt-bg-blue-lighter">
                    <bkt-icon :name="'Cow'" :color="'blue'" :width="'30px'" :height="'30px'"></bkt-icon>
                </div>
                <div class="bkt-button bkt-bg-red-lighter">
                    <bkt-icon :name="'Gear'" :color="'red'" :width="'30px'" :height="'30px'"></bkt-icon>
                </div>
                <div class="bkt-button bkt-bg-yellow-lighter">
                    <bkt-icon :name="'Wrench'" :color="'yellow'" :width="'30px'" :height="'30px'"></bkt-icon>
                </div>
                <div class="bkt-button" style="background: #eef2fe">
                    <bkt-icon :name="'Percentage'" :color="'primary'" :width="'30px'" :height="'30px'"></bkt-icon>
                </div>
                <div class="bkt-button" style="background: #fff0fb">
                    <bkt-icon :name="'MechanicalArm'" :color="'purple'" :width="'30px'" :height="'30px'"></bkt-icon>
                </div>
                <div class="bkt-button" style="background: #f5eefd">
                    <bkt-icon :name="'Building'" :color="'purple'" :width="'30px'" :height="'30px'"></bkt-icon>
                </div>
                <div class="bkt-button" style="background: #edfcf7">
                    <bkt-icon :name="'File'" :color="'green'" :width="'30px'" :height="'30px'"></bkt-icon>
                </div>
                <div class="bkt-button bkt-bg-neutral-light">
                    <bkt-icon :name="'More'" :color="'main'" :width="'30px'" :height="'30px'"></bkt-icon>
                </div>
            </div>
            <div class="bkt-content__data">
                <div class="row align-items-baseline text-left bkt-data__item mb-3">
                    <div class="col-12 col-lg-2">
                        <h5 class="bkt-form__label">регион</h5>
                    </div>
                    <div class="col-12 col-lg-10">
                        <bkt-select multiple name="regions" :option_label="'shortName'" :reduce="item => item.id"

                        ></bkt-select>
                    </div>
                </div>
                <div class="row bkt-data__item mb-3">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <div class="bkt-selected-region float-left d-flex">
                            <div class="bkt-region__item bkt-bg-item-rounded bkt-item-rounded mr-2">
                                <div class="mb-1 p-2 w-100 pl-4 pr-4 text-left">
                                    <span class="bkt-item-rounded__text mr-2">Хабаровский край</span>
                                    <span class="bkt-cursor-pointer">
                    <bkt-icon :name="'Cross'"></bkt-icon>
                  </span>
                                </div>
                            </div>
                            <div class="bkt-region__item bkt-bg-item-rounded bkt-item-rounded mr-2">
                                <div class="mb-1 p-2 w-100 pl-4 pr-4 text-left">
                                    <span class="bkt-item-rounded__text mr-2">Бурятия</span>
                                    <span class="bkt-cursor-pointer">
                   <bkt-icon :name="'Cross'"></bkt-icon>
                  </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-baseline text-left bkt-data__item mb-3">
                    <div class="col-2">
                        <label class="bkt-form__label">торговые площадки</label>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <bkt-select multiple name="trading_platform" :option_label="'shortName'"
                                            :reduce="item => item.id"
                                ></bkt-select>
                            </div>
                            <div class="col-12 col-md-9">
                                <div
                                    class="bkt-marketplace-checkboxes d-flex h-100 align-items-center justify-content-end">
                                    <bkt-checkbox label="Банкротство" name="bankrot" class="mr-3"></bkt-checkbox>
                                    <bkt-checkbox label="TorgiGov" name="torgiGov" class="mr-3"></bkt-checkbox>
                                    <bkt-checkbox label="Залоговое" name="zalog" class="mr-3"></bkt-checkbox>
                                    <bkt-checkbox label="Коммерческое" name="commerce"></bkt-checkbox>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row text-left bkt-data__item mb-3">
                    <div class="col-lg-2">
                        <label class="bkt-form__label">виды торгов</label>
                    </div>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-4 text-center">
                                <div class="bkt-block-btn bkt-input text-center">
                                    Аукцион
                                </div>
                                <a href="#"><span class="bkt-what-is">что это?</span></a>
                            </div>
                            <div class="col-4 text-center">
                                <div class="bkt-block-btn bkt-input text-center">
                                    Публичное предложение
                                </div>
                                <a href="#"><span class="bkt-what-is">что это?</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bkt-auction-price text-left bkt-data__item mb-3">
                    <div class="row mb-2" v-for="(price, index) in pricing">
                        <div class="col-12 col-md-2 d-flex align-items-center">
                            <span class="bkt-auction-price__label">{{ price.title }}</span>
                        </div>
                        <div class="col-12 col-md-5">
                            <bkt-input class="bkt-input-price bkt-input-price__min bkt-auction-price__input"
                                       v-model="price.minPrice"
                                       :name="'minPrice-'+index" type="text">
                                <template #group-item-inner>
                                    <button
                                        class="bkt-btn-price-done btn bkt-btn-icon position-absolute bkt-bg-white bkt-border-rounded"
                                        style="height: 50px; width: 50px; right: 8px"
                                        :class="{'active': price.minPrice.length > 0}">
                                        <bkt-icon :name="'Check'" :color="'neutral'" class="bkt-icon"></bkt-icon>
                                    </button>
                                </template>
                            </bkt-input>
                        </div>
                        <div class="col-12 col-md-5">
                            <bkt-input class="bkt-input-price bkt-input-price__max" v-model="price.maxPrice"
                                       :name="'maxPrice-'+index"
                                       type="text">
                                <template #group-item-inner>
                                    <button
                                        class="bkt-btn-price-done btn bkt-btn-icon position-absolute bkt-bg-white bkt-border-rounded"
                                        style="height: 50px; width: 50px; right: 8px"
                                        :class="{'active': price.maxPrice.length > 0}">
                                        <bkt-icon :name="'Check'" :color="'neutral'" class="bkt-icon"></bkt-icon>
                                    </button>
                                </template>
                            </bkt-input>
                        </div>
                    </div>
                </div>

                <div class="bkt-auctions-footer bkt-wrapper-between">

                    <button type="button"
                            class="btn bkt-btn bkt-button bkt-modal-delete bkt-bg-red-lighter bkt-border-rounded">
              <span class="left_button_inner">
                <bkt-icon :name="'Trash'" :width="'22px'" :height="'22px'"></bkt-icon>
              </span>
                    </button>

                    <div class="left-block d-flex">
                        <div class="block-checkboxes d-flex align-items-center mr-5">
                            <bkt-checkbox label="с ближайших" :value="true" name="near"></bkt-checkbox>
                            <span class="ml-5 mr-3 bkt-text-neutral">окончание торгов</span>
                            <bkt-checkbox label="окончание приёма заявок" name="applicationTime"></bkt-checkbox>
                        </div>
                        <button type="button" class="bkt-button primary bkt-button_plump">
                            <span role="status"></span>
                            Сохранить
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bkt-auctions__content bkt-bg-transparent p-3 mb-2 d-lg-none d-block">
            <div class="bkt-content__button-category d-flex justify-content-between align-items-center"
                 @click="openCategoryModal">
                <div class="d-flex left-data align-items-center">
                    <div class="align-items-center bkt-border-rounded d-flex justify-content-center">
                        <bkt-icon :name="'Category'" :color="'green'" width="25px" height="25px"></bkt-icon>
                    </div>
                    <span>Категории</span>
                </div>
                <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
            </div>
            <div class="bkt-content__button-category d-flex justify-content-between align-items-center"
                 @click="openRegionModal">
                <div class="d-flex left-data align-items-center">
                    <div class="align-items-center bkt-border-rounded d-flex justify-content-center bkt-bg-red-lighter">
                        <bkt-icon :name="'Location'" :color="'red'" width="25px" height="25px"></bkt-icon>
                    </div>
                    <span>Регион</span>
                </div>
                <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
            </div>
            <div class="bkt-content__button-category d-flex justify-content-between align-items-center"
                 @click="openParamsModal">
                <div class="d-flex left-data align-items-center">
                    <div
                        class="align-items-center bkt-border-rounded d-flex justify-content-center bkt-bg-purple-lighter">
                        <bkt-icon :name="'Options'" :color="'purple'" width="25px" height="25px"></bkt-icon>
                    </div>
                    <span>Параметры объекта</span>
                </div>
                <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
            </div>
            <div class="bkt-content__button-category d-flex justify-content-between align-items-center"
                 @click="openPriceModal">
                <div class="d-flex left-data align-items-center">
                    <div
                        class="align-items-center bkt-border-rounded d-flex justify-content-center bkt-bg-yellow-lighter">
                        <bkt-icon :name="'Wallet'" :color="'yellow'" width="25px" height="25px"></bkt-icon>
                    </div>
                    <span>Стоимость объекта</span>
                </div>
                <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
            </div>
            <div class="bkt-content__button-category d-flex justify-content-between align-items-center"
                 @click="openDateModal">
                <div class="d-flex left-data align-items-center">
                    <div
                        class="align-items-center bkt-border-rounded d-flex justify-content-center bkt-bg-blue-lighter">
                        <bkt-icon :name="'Date'" :color="'blue'" width="25px" height="25px"></bkt-icon>
                    </div>
                    <span>Дата торгов</span>
                </div>
                <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
            </div>
            <div class="bkt-content__button-category d-flex justify-content-between align-items-center"
                 @click="openOptionsModal">
                <div class="d-flex left-data align-items-center">
                    <div
                        class="align-items-center bkt-border-rounded d-flex justify-content-center bkt-bg-primary-lighter">
                        <bkt-icon :name="'Clone'" :color="'primary'" width="25px" height="25px"></bkt-icon>
                    </div>
                    <span>Доп. параметры</span>
                </div>
                <bkt-icon class="arrow bkt-rotate-270" :name="'ArrowDown'"></bkt-icon>
            </div>

            <div class="bkt-footer-mobile mt-3 p-3">
                <bkt-checkbox label="с ближайших" :value="true"></bkt-checkbox>
                <div class="d-flex mt-4">
                    <span class="ml-5 mr-3 bkt-text-neutral">окончание торгов</span>
                    <bkt-checkbox label="окончание приёма заявок"></bkt-checkbox>
                </div>

                <div class="btn-actions d-flex justify-content-between mt-4">
                    <div class="left-button">
                        <button type="button"
                                class="align-items-center bkt-bg-red-lighter bkt-border-rounded bkt-btn bkt-modal-delete btn d-flex h-100">
              <span class="left_button_inner">
                <bkt-icon :name="'Trash'" :width="'22px'" :height="'22px'"></bkt-icon>
              </span>
                        </button>
                    </div>
                    <div class="d-flex">
                        <div class="right-button bkt-bg-primary bkt-border-rounded pr-4 pl-4 d-flex align-items-center">
                            <button type="button" class="btn bkt-btn bkt-modal-save">
                                <span role="status"></span>
                                Сохранить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bkt-auctions__find text-center p-3">
            <span>НАЙДЕНО {{pagination_data ? pagination_data.total : '0'}} ЛОТОВ</span>
            <bkt-icon name="ArrowDown" color="primary"></bkt-icon>
        </div>
        <bkt-card-list :current_component="'BktCard'" :items="items" :loading="loading"
                       :pagination_data="pagination_data" @change-page="getData">
        </bkt-card-list>
    </div>
</template>

<script>
import BktDateModal from "./Main/DateModal";
import BktPriceModal from "./Main/PriceModal";
import BktOptionsModal from "./Main/OptionsModal";
import BktParamsModal from "./Main/ParamsModal";
import BktRegionModal from "./Main/RegionModal";
import BktCategoryModal from "./Main/CategoryModal";
import BktCardList from "../components/CardList";

export default {
    name: "UpcomingAuctions",
    components: {
        BktDateModal, BktPriceModal, BktOptionsModal,
        BktParamsModal, BktRegionModal, BktCategoryModal, BktCardList
    },
    data() {
        return {
            pricing: [{title: "начальная цена, ₽", minPrice: '', maxPrice: ''},
                {title: "текущая цена, ₽", minPrice: '', maxPrice: ''},
                {title: "минимальная цена, ₽", minPrice: '', maxPrice: ''},
                {title: "процент снижения, %", minPrice: '', maxPrice: ''}],
        };
    },
    mounted() {
        this.getData();
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
            return this.$store.getters.nearest_trades;
        },
        pagination_data() {
            return this.$store.getters.nearest_trades_pagination;
        },
        loading() {
            return this.$store.getters.nearest_trades_loading;
        },
    },
    methods: {
        async getData(page = 1) {
            await this.$store.dispatch('getNearestTrades', {page: page, filters: this.filters});
        },
        toggleDirection() {
            if (this.filters_sort.direction == 'asc') {
                this.filters_sort.direction = 'desc';
            } else {
                this.filters_sort.direction = 'asc';
            }
        },
        openCategoryModal() {
            this.$store.commit('openModal', '#categoryModal');
        },
        openRegionModal() {
            this.$store.commit('openModal', '#regionModal');
        },
        openParamsModal() {
            this.$store.commit('openModal', '#paramsModal');
        },
        openPriceModal() {
            this.$store.commit('openModal', '#priceModal');
        },
        openDateModal() {
            this.$store.commit('openModal', '#dateModal');
        },
        openOptionsModal() {
            this.$store.commit('openModal', '#optionsModal');
        },
    },
}
</script>

<style scoped>

</style>
