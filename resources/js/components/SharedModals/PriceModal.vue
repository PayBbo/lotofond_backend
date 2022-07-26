<template>
    <bkt-modal :id="'priceModal'" ref="priceModal" title="Выберите стоимость объекта" modal_class="bkt-filters-modal"
               @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body>
            <bkt-prices-control v-model="filter"></bkt-prices-control>
        </template>
    </bkt-modal>
</template>

<script>
    import BktPricesControl from "../FiltersControls/PricesControl";
    export default {
        name: "PriceModal",
        components: {BktPricesControl},
        props: {
            filter_name: {
                type: String,
                default: 'filters'
            },
            method_name: {
                type: String,
                default: 'getFilteredTrades'
            }
        },
        data() {
            return {
                loading: false,
                prices: null,
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
            filters() {
                return this.$store.getters[this.filter_name]
            },
            filter: {
                get() {
                    return JSON.parse(JSON.stringify(this.$store.getters[this.filter_name].prices))
                },
                set(value) {
                    this.prices = value;
                }
            },
        },
        methods: {
            saveFilters() {
                // this.$store.commit('saveFiltersProperty', {key: 'prices', value: this.filter});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'prices',
                    value: this.filter
                }, {root: true});
                this.$store.commit('closeModal', '#priceModal');
                this.$store.dispatch(this.method_name, {page: 1, filters: this.filters});
            },
            clearFilters() {
                // this.$store.commit('saveFiltersProperty', {key: 'prices', value: this.template});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'prices',
                    value: this.template
                }, {root: true});
                this.$store.commit('closeModal', '#priceModal');
                this.$store.dispatch(this.method_name, {page: 1, filters: this.filters});
            }
        }
    }
</script>

<style scoped>

</style>
