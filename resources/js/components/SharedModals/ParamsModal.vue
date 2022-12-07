<template>
    <bkt-modal :id="'paramsModal'" title="Выберите основные параметры" modal_class="bkt-filters-modal"
               @left_action="clearFilters" @right_action="saveFilters" @close-modal="closeModal"
    >
        <template #body>
            <bkt-params-control v-model="filter"></bkt-params-control>
        </template>
    </bkt-modal>
</template>

<script>
   import BktParamsControl from "../FiltersControls/ParamsControl";

    export default {
        name: "ParamsModal",
        components: {
            BktParamsControl
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
                template: {
                    excludedWords: '',
                    includedWords:'',
                    tradePlaces: [],
                    tradeTypes:[]
                },
                auctionTypes: [
                    {description: 'Открытый аукцион', title: 'OpenAuction'},
                    {description: 'Открытый конкурс', title: 'OpenConcours'},
                    {description: 'Публичное предложение', title: 'PublicOffer'},
                    {description: 'Закрытый аукцион', title: 'CloseAuction'},
                    {description: 'Закрытый конкурс', title: 'CloseConcours'},
                    {description: 'Закрытое публичное предложение', title: 'ClosePublicOffer'},
                ],
                params: null,
            };
        },
        computed: {
            filters() {
                return this.$store.getters[this.filter_name]
            },
            filter: {
                get() {
                    return JSON.parse(JSON.stringify(this.$store.getters[this.filter_name].mainParams))
                },
                set(value) {
                    this.params = value;
                }
            },
            // current_platform: {
            //     get: function() {
            //         return this.filter.tradePlaces;
            //     },
            //     set: function(newValue) {
            //         let removeIndex = this.trade_places
            //             .map(item => item.code)
            //             .indexOf(newValue.code);
            //         this.trade_places.splice(removeIndex, 1);
            //         this.selected_trade_places.push(newValue);
            //     }
            // },
            trade_places() {
                return this.$store.getters.trade_places
            },
            trade_places_pagination() {
                return this.$store.getters.trade_places_pagination
            },
        },
        methods: {
            saveFilters() {
                this.$store.commit('saveFiltersProperty', {key: this.filter_name +'_mainParams', value: this.filter});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'mainParams',
                    value: this.filter
                }, {root: true});
                this.$store.commit('closeModal', '#paramsModal');
                this.callMethod();
            },
            clearFilters() {
                this.$store.commit('saveFiltersProperty', {key: this.filter_name +'_mainParams', value: this.template});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'mainParams',
                    value: this.template
                }, {root: true});
                this.$store.commit('closeModal', '#paramsModal');
                this.callMethod();
            },
            closeModal() {
                Object.assign(this.filter, JSON.parse(JSON.stringify(this.filters.mainParams)))
            },
            callMethod() {
                let tmp_filters = JSON.parse(JSON.stringify(this.filters));
                this.$store.dispatch(this.method_name, {page: 1, filters: tmp_filters});
            }
            // removePlatform(platform) {
            //     let removeIndex = this.selected_trade_places
            //         .map(item => item.code)
            //         .indexOf(platform.code);
            //     this.selected_trade_places.splice(removeIndex, 1);
            //     this.options.push(platform);
            // },
        }
    }
</script>

<style scoped>

</style>
