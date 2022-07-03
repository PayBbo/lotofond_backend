<template>
    <bkt-modal :id="'paramsModal'" title="Выберите основные параметры" modal_class="bkt-filters-modal"
               @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body>
            <div class="bkt-form wide w-100 mx-auto align-items-start">
                <div class="col-12">
                    <bkt-input v-model="filter.excludedWords"
                               type="text"
                               field_name="'Cлова-исключения'"
                               label="cлова-исключения"
                               label_class="bkt-form__label"
                               name="exception_words" icon_name="Check"
                               :group_item_class="filter.excludedWords ? 'bkt-bg-green': 'bkt-bg-white'"
                               :icon_color="filter.excludedWords ? 'white': 'main-lighter'"
                    >
                    </bkt-input>
                </div>
                <div class="col-12">
                    <!--                    <div class="bkt-form m-0">-->
                    <!--                        <div class="col-lg-8 col-12 p-0">-->
                    <bkt-select
                        v-model="filter.tradePlaces"
                        multiple
                        name="tradePlaces"
                        label="выбранные площадки"
                        label_class="bkt-form__label"
                        :option_label="'name'"
                        :options="trade_places"
                        :pagination="trade_places_pagination"
                        :reduce="item => item.id"
                        :method_name="'getTradePlaces'"
                    ></bkt-select>
                    <!--                    <h5 class="bkt-form__label bkt-text-neutral-dark">выбранные площадки</h5>-->

                    <!--                        </div>-->
                    <!--                        <div class="col-12 col-lg-4 p-0">-->
                    <!--                            <div class="bkt-check__list">-->
                    <!--                                <div class="bkt-check__wrapper">-->
                    <!--                                    <div class="bkt-check">-->
                    <!--                                        <div class="bkt-check__input">-->
                    <!--                                            <input class="" type="checkbox">-->
                    <!--                                            <div class="bkt-check__input-check"></div>-->
                    <!--                                        </div>-->
                    <!--                                        <label class="bkt-check__label">-->
                    <!--                                            Банкротство-->
                    <!--                                        </label>-->
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                                <div class="bkt-check__wrapper">-->
                    <!--                                    <div class="bkt-check">-->
                    <!--                                        <div class="bkt-check__input">-->
                    <!--                                            <input class="" type="checkbox">-->
                    <!--                                            <div class="bkt-check__input-check"></div>-->
                    <!--                                        </div>-->
                    <!--                                        <label class="bkt-check__label">-->
                    <!--                                            TorgiGov-->
                    <!--                                        </label>-->
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                                <div class="bkt-check__wrapper">-->
                    <!--                                    <div class="bkt-check">-->
                    <!--                                        <div class="bkt-check__input">-->
                    <!--                                            <input class="" type="checkbox">-->
                    <!--                                            <div class="bkt-check__input-check"></div>-->
                    <!--                                        </div>-->
                    <!--                                        <label class="bkt-check__label">-->
                    <!--                                            Залоговое-->
                    <!--                                        </label>-->
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                                <div class="bkt-check__wrapper">-->
                    <!--                                    <div class="bkt-check">-->
                    <!--                                        <div class="bkt-check__input">-->
                    <!--                                            <input class="" type="checkbox">-->
                    <!--                                            <div class="bkt-check__input-check"></div>-->
                    <!--                                        </div>-->
                    <!--                                        <label class="bkt-check__label">-->
                    <!--                                            Коммерческое-->
                    <!--                                        </label>-->
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>
                <div class="col-12 p-0">
                    <div class="bkt-form m-0">
                        <div class="col-12 col-lg-2">
                            <h5 class="bkt-form__label">вид торгов</h5>
                        </div>
                        <div class="col-12 col-lg-10">
                            <div class="bkt-form bkt-wrapper bkt-auctions-types">
                                <div class="bkt-auctions-type" v-for="item in auctionTypes">
                                    <button class="bkt-auctions-type__card bkt-auctions-type__title bkt-bg-body"
                                            @click="filter.tradeType=item.title"
                                            :class="[filter.tradeType===item.title ? 'bkt-border-primary': 'bkt-border-body']">
                                        {{item.description}}
                                    </button>
                                    <h6 class="bkt-auctions-type__subtitle">что это?</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    import BktSelect from "../../components/Select";

    export default {
        name: "ParamsModal",
        components: {
            BktSelect
        },
        data() {
            return {
                loading: false,
                template: {
                    excludedWords: '',
                    includedWords:'',
                    tradePlaces: [],
                    tradeType:'',
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
                //mock
                // trade_places: [],
                // trade_places_pagination: {},
                // selected_trade_places:[],
            };
        },
        computed: {
            filters() {
                return this.$store.getters.filters
            },
            filter: {
                get() {
                    return JSON.parse(JSON.stringify(this.$store.getters.filters_params))
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
                this.$store.commit('saveFiltersProperty', {key: 'mainParams', value: this.filter});
                this.$store.commit('closeModal', '#paramsModal');
                this.$store.dispatch('getFilteredTrades', {page: 1, filters: this.filters});
            },
            clearFilters() {
                this.$store.commit('saveFiltersProperty', {key: 'mainParams', value: this.template});
                this.$store.commit('closeModal', '#paramsModal');
                this.$store.dispatch('getFilteredTrades', {page: 1, filters: this.filters});
            },
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
