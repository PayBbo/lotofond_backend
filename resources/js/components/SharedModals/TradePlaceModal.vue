<template>
    <bkt-modal :id="'tradePlacesModal'" ref="tradePlacesModal" title="Выберите торговые площадки"
               modal_class="bkt-filters-modal" @close-modal="closeModal"
               @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body>
            <bkt-trade-places-control v-model="result"></bkt-trade-places-control>
        </template>
    </bkt-modal>
</template>

<script>
    import BktTradePlacesControl from "../FiltersControls/TradePlacesControl";
    export default {
        name: "TradePlaceModal",
        components: {
            BktTradePlacesControl
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
            };
        },
        computed: {
            filters() {
                return this.$store.getters[this.filter_name]
            },
            // filter: {
            //     get() {
            //         return JSON.parse(JSON.stringify(this.$store.getters[this.filter_name].mainParams.tradePlaces))
            //     },
            //     set(value) {
            //         this.result = value;
            //     }
            // },
        },
        mounted() {
            this.result = this.filters.mainParams.tradePlaces;
        },
        methods: {
            saveFilters() {
                let tmp_filters = JSON.parse(JSON.stringify(this.filters.mainParams));
                tmp_filters.tradePlaces = this.result;
                this.$store.commit('saveFiltersProperty', {key: this.filter_name +'_mainParams', value: tmp_filters});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'mainParams.tradePlaces',
                    value: this.result
                }, {root: true});
                this.$store.commit('closeModal', '#tradePlacesModal');
                this.callMethod();
            },
            clearFilters() {
                let tmp_filters = JSON.parse(JSON.stringify(this.filters.mainParams));
                tmp_filters.tradePlaces = [];
                this.result = [];
                this.$store.commit('saveFiltersProperty', {key: this.filter_name +'_mainParams', value: tmp_filters});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'mainParams.tradePlaces',
                    value: []
                }, {root: true});
                this.$store.commit('closeModal', '#tradePlacesModal');
                this.callMethod();
            },
            closeModal() {
                // let tmp_places = JSON.parse(JSON.stringify(this.filters.mainParams.tradePlaces));
                // this.filter.splice(0);
                // tmp_places.forEach( item => {
                //     this.filter.push(item)
                // })
                this.result = JSON.parse(JSON.stringify(this.filters.mainParams.tradePlaces));
                // Object.assign(this.result, JSON.parse(JSON.stringify(this.filters.mainParams.tradePlaces)))
            },
            callMethod() {
                let tmp_filters = JSON.parse(JSON.stringify(this.filters));
                this.$store.dispatch(this.method_name, {page: 1, filters: tmp_filters});
            }
        }
    }
</script>

<style scoped>

</style>
