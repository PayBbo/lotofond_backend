<template>
    <bkt-modal :id="'priceModal'" ref="priceModal" title="Выберите стоимость объекта" modal_class="bkt-filters-modal"
               @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body>
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
                                   :icon_color="filter.startPrice.min ? 'white': 'main-lighter'"
                        >
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
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "PriceModal",
        data() {
            return {
                loading: false,
                price: '',
                priceRange: '',
                template: {
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
            };
        },
        computed: {
            filters_prices() {
                this.filter = JSON.parse(JSON.stringify(this.$store.getters.filters_prices));
                return this.$store.getters.filters_prices
            },
            filters() {
                return this.$store.getters.filters
            },
            filter: {
                get() {
                    return this.filters_prices
                },
                set(value) {
                    this.$store.commit('saveFiltersProperty', {key: 'prices', value: value})
                }
            },
        },
        methods: {
            saveFilters() {
                this.$store.commit('closeModal', '#priceModal');
                this.$store.dispatch('getFilteredTrades', {page: 1, filters: this.filters});
            },
            clearFilters() {
                this.$store.commit('saveFiltersProperty', {key: 'prices', value: this.template});
                this.$store.commit('closeModal', '#priceModal');
                this.$store.dispatch('getFilteredTrades', {page: 1, filters: this.filters});
            }
        }
    }
</script>

<style scoped>

</style>
