<template>
    <div>
        <div class="bkt-form" v-if="!loading">
            <div class="col-12">
                <h5 class="bkt-form__label">регионы</h5>
            </div>
            <div class="col-12">
                <div class="bkt-wrapper-column bkt-gap-small">
                    <bkt-select name="regions"
                                v-model="current_region"
                                :options="region_options"
                                option_label="label"
                                :reduce="option => option.value"
                                :method_name="'getRegions'"
                                :loading="loading"
                    >
                    </bkt-select>
                    <div class="bkt-selected-region bkt-tag__list">
                        <template v-for="(item, index) in bot_filters.regions">
                            <div class="flex-fill">
                                <div class="bkt-region__item bkt-tag justify-content-between" :key="item+'_'+index">
                                    <span class="bkt-item-rounded__text mr-2">{{ $t('regions.' + item) }}</span>
                                    <span class="bkt-tag__icon bkt-cursor-pointer" @click="removeRegion(item)">
                                        <bkt-icon name="Cancel" color="red"/>
                                    </span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h5 class="bkt-form__label">категории</h5>
            </div>
            <div class="col-12">
                <bkt-categories-control v-model="bot_filters.categories" :show_selected="false"
                                        :custom_categories="categories"/>
            </div>
            <div class="col-12">
                <h5 class="bkt-form__label">цена лота, ₽</h5>
            </div>
            <div class="col-12">
                <div class="bkt-form">
                    <div class="col-12 col-lg-6">
                        <bkt-input v-model="bot_filters.prices.currentPrice.min"
                                   type="number"
                                   field_name="'Текущая цена от'"
                                   name="currentPriceMin" icon_name="Check"
                                   :group_item_class="bot_filters.prices.currentPrice.min ? 'bkt-bg-green': 'bkt-bg-white'"
                                   :icon_color="bot_filters.prices.currentPrice.min ? 'white': 'main-lighter'"
                        >
                            <template #group-text>
                                от
                            </template>
                        </bkt-input>
                    </div>
                    <div class="col-12 col-lg-6">
                        <bkt-input v-model="bot_filters.prices.currentPrice.max"
                                   type="number"
                                   field_name="'Текущая цена до'"
                                   name="currentPriceMax" icon_name="Check"
                                   :group_item_class="bot_filters.prices.currentPrice.max ? 'bkt-bg-green': 'bkt-bg-white'"
                                   :icon_color="bot_filters.prices.currentPrice.max ? 'white': 'main-lighter'"
                        >
                            <template #group-text>
                                до
                            </template>
                        </bkt-input>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h5 class="bkt-form__label">вид торгов</h5>
            </div>
            <div class="col-12">
                <div class="bkt-wrapper bkt-nowrap bkt-auctions-types bkt-gap-small">
                    <div class="bkt-auctions-type flex-fill" v-for="type in auctionTypes">
                        <button class="bkt-auctions-type__card bkt-auctions-type__title bkt-bg-body"
                                @click="toggleAuctionType(type.types)"
                                :class="[type.types.every(item => bot_filters.mainParams.tradeTypes.includes(item)) ? 'bkt-border-primary': 'bkt-border-body']">
                            {{type.description}}
                        </button>
                    </div>
                </div>
            </div>
            <div class="bkt-wrapper bkt-nowrap bkt-w-100 bkt-gap-small">
                <button class="bkt-button primary px-2 bkt-w-100" :disabled="is_loading" @click="saveFilters">Сохранить
                </button>
                <button class="bkt-button primary px-2 bkt-w-100" :disabled="is_loading" v-if="show_cancel" @click="cancel"
                        data-bs-dismiss="offcanvas">Закрыть</button>
            </div>
        </div>
        <div v-if="loading" class="d-flex w-100 justify-content-center my-5">
            <slot name="loading">
                <div
                    style="color: #2953ff;border-width: 2px;"
                    class="spinner-border"
                    role="status"
                ></div>
            </slot>
        </div>
    </div>
</template>

<script>
    import BktCategoriesControl from "../components/FiltersControls/CategoriesControl";
    export default {
        name: "Filters",
        components: {
            BktCategoriesControl
        },
        props: {
            filter_name: {
                type: String,
                default: 'filters'
            },
            method_name: {
                type: String,
                default: 'getFilteredTrades'
            },
            show_cancel: {
                type:Boolean,
                default: true
            }
        },
        data() {
            return {
                bot_filters: {
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
                    mainParams: {
                        tradeTypes: []
                    },
                    sort: {
                        direction: "desc",
                        type: "publishDate"
                    },
                },
                regionGroups: [],
                selectedRegion: null,
                result: null,
                selectedAuctionType: null,
                auctionTypes: [
                    {
                        key: 'down',
                        description: 'На понижение',
                        types: ['PublicOffer', 'ClosePublicOffer', 'PPZ', "PPU"]
                    },
                    {
                        key: 'up',
                        description: 'На повышение',
                        types: [
                            'OpenAuction', 'OpenConcours', 'CloseAuction', 'CloseConcours',
                            "EA", "BOC", "EK", "SA", "IPS", "SMP", "PrP", "PA", "BC", "PK", "IO", "OIP", "GHP", "BCU"
                        ]
                    },

                ],
                categories: [
                    {
                        "label": "Недвижимость",
                        "key": "realEstate",
                        "subcategories": [
                            {
                                "label": "Земельные участки",
                                "key": "land"
                            },
                            {
                                "label": "Недвижимость жилая",
                                "key": "residentialProperty"
                            },
                            {"label": "Недвижимость коммерческая", "key": "commercialRealEstate"}],
                        "status": false
                    },
                    {
                        "label": "Транспорт и техника",
                        "key": "transportAndEquipment",
                        "subcategories": [],
                        "items": [
                            "airTransport", "waterTransport",
                            "freightTransport", "commercialTransport",
                            "passengerTransport", "mototechnics", "specialEquipment", 'transportAndEquipment'
                        ],
                        "status": false
                    },
                    {
                        "label": "Прочее",
                        "key": "other",
                        "subcategories": [],
                        items:[
                            "other",
                            "otherEquipment","metalworkingEquipment", "foodEquipment", "industrialEquipment",
                            "storageEquipment", "constructionEquipment", "shopEquipment", 'equipment',
                            "animalsAndLivestock","buildingsAndConstructions", "agriculturalComplex",  "agriculturaProperty",
                            'accountsReceivable',"productionLines", "tangibles", "obligations", 'torgi'
                        ],
                        "status": false
                    },
                ],
                is_loading: false
            }
        },
        created() {
            this.bot_filters = JSON.parse(JSON.stringify(this.filters));
        },
        computed: {
            filters() {
                return this.$store.getters.bot_filters
            },
            regions() {
                return this.$store.getters.regions
            },
            region_options() {
                let tmp = [].concat.apply([], this.$store.getters.regions.map(item => item.regions));
                let result = [];
                tmp.forEach(item => {
                    result.push({label: this.$t('regions.' + item), value: item});
                });
                return result.sort((a, b) => a.label.localeCompare(b.label))
            },
            current_region: {
                get: function () {
                    return null;
                },
                set: function (newValue) {
                    let index = this.bot_filters.regions.indexOf(newValue);
                    if (index < 0) {
                        this.bot_filters.regions.push(newValue);
                    }
                }
            },
            loading() {
                return this.$store.getters.regions_loading
            },
        },
        methods: {
            saveFilters() {
                this.is_loading = true;
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters',
                    key: 'bot_filters',
                    value: this.bot_filters
                }, {root: true});
                let tmp_filters = JSON.parse(JSON.stringify(this.filters));
                this.$store.dispatch('saveUserFilters', tmp_filters).then(resp => {
                    this.is_loading = false;
                }).catch(error => {
                    this.is_loading = false;
                });
                this.$emit('save');
                this.$store.dispatch(this.method_name, {page: 1, filters: tmp_filters});
            },
            cancel() {
                this.bot_filters = JSON.parse(JSON.stringify(this.filters));
                this.$emit('cancel');
            },
            removeRegion(region) {
                let index = this.bot_filters.regions.indexOf(region);
                if (index >= 0) {
                    this.bot_filters.regions.splice(index, 1);
                }
            },
            toggleAuctionType(types) {
                if (types.every(item => this.bot_filters.mainParams.tradeTypes.includes(item))) {
                    types.forEach(item => {
                        let item_index = this.bot_filters.mainParams.tradeTypes.findIndex(el => el === item);
                        if (item_index >= 0) {
                            this.bot_filters.mainParams.tradeTypes.splice(item_index, 1)
                        }
                    });
                } else {
                    types.forEach(item => {
                        let item_index = this.bot_filters.mainParams.tradeTypes.findIndex(el => el === item);
                        if (item_index < 0) {
                            this.bot_filters.mainParams.tradeTypes.push(item)
                        }
                    })
                }
            }
        },
    }
</script>

<style scoped>

</style>
