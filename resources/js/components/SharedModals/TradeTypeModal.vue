<template>
    <bkt-modal :id="'tradeTypesModal'" ref="tradeTypesModal" title="Выберите виды торгов"
               modal_class="bkt-filters-modal" @close-modal="closeModal"
               @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body>
            <bkt-trade-types-control v-model="filter"></bkt-trade-types-control>
        </template>
    </bkt-modal>
</template>

<script>
    import BktTradeTypesControl from "../FiltersControls/TradeTypesControl";
    export default {
        name: "TradeTypeModal",
        components: {
            BktTradeTypesControl
        },
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
                result: [],
                method_params: {
                    type:'filters'
                },
                signal: null,
                controller: null,
            };
        },
        computed: {
            filters() {
                return this.$store.getters[this.filter_name]
            },
            filter: {
                get() {
                    return JSON.parse(JSON.stringify(this.$store.getters[this.filter_name].mainParams.tradeTypes))
                },
                set(value) {
                    this.result = value;
                }
            },
        },
        methods: {
            saveFilters() {
                let tmp_filters = JSON.parse(JSON.stringify(this.filters.mainParams));
                tmp_filters.tradeTypes = this.result;
                this.$store.commit('saveFiltersProperty', {key: this.filter_name +'_mainParams', value: tmp_filters});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'mainParams.tradeTypes',
                    value: this.result
                }, {root: true});
                this.$store.commit('closeModal', '#tradeTypesModal');
                this.callMethod();
            },
            clearFilters() {
                let tmp_filters = JSON.parse(JSON.stringify(this.filters.mainParams));
                tmp_filters.tradeTypes = [];
                this.filter = [];
                this.$store.commit('saveFiltersProperty', {key: this.filter_name +'_mainParams', value: tmp_filters});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'mainParams.tradeTypes',
                    value: []
                }, {root: true});
                this.$store.commit('closeModal', '#tradeTypesModal');
                this.callMethod();
            },
            closeModal() {
                let tmp_places = JSON.parse(JSON.stringify(this.filters.mainParams.tradeTypes));
                this.filter.splice(0);
                tmp_places.forEach( item => {
                    this.filter.push(item)
                })
            },
            callMethod() {
                let tmp_filters = JSON.parse(JSON.stringify(this.filters));
                if (this.signal) {
                    this.controller.abort();
                }
                setTimeout(() => {
                    this.controller = new AbortController();
                    this.signal = this.controller.signal;
                    this.$store.dispatch(this.method_name, {page: 1, filters: tmp_filters, signal:this.signal});
                }, 100);
            }
        }
    }
</script>

<style scoped>

</style>
