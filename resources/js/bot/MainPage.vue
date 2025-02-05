<template>
    <div class="container bkt-container bkt-page">
        <bkt-category-modal/>
        <bkt-region-modal/>
        <bkt-price-modal/>
        <div class="bkt-wrapper bkt-nowrap bkt-gap">
            <bkt-search v-model="filters.searchString" no_dropdown :loading="loading" simple @runSearch="runSearch" clearable
                        class="w-100"
            >
            </bkt-search>
            <button class="bkt-button-icon p-2 flex-shrink-0 position-relative" @click="filters_mode = !filters_mode"
                    :class="filters_mode ? 'bkt-bg-primary': ''"
            >
                <bkt-icon name="Filters" :color="filters_mode ? 'white': 'primary'"/>
                <div class="bkt-badge position-absolute top-0 m-0 bkt-border-primary" v-if="filters_total>0"
                     style="left: 30px; padding: 2px; min-width: 20px; height:20px; line-height: 12px;"
                     :class="filters_mode ? 'bkt-bg-white bkt-text-primary': 'bkt-bg-primary bkt-text-white'"
                >
                    {{filters_total>99 ? '99+' : filters_total}}
                </div>
            </button>
        </div>
        <div class="bkt-main-categories bkt-card__list fade-in" v-if="filters_mode">
            <bkt-filter-card
                :icon="{name:'Category', color:'green'}" category_class="bkt-bg-green-lighter"
                title="Категории" :count="filters.categories" modal_name="#categoryModal"
            />
            <bkt-filter-card
                :icon="{name:'Location'}" category_class="bkt-bg-red-lighter"
                title="Регионы" :count="filters.regions" modal_name="#regionModal"
            />
            <bkt-filter-card
                :icon="{name:'Wallet'}" category_class="bkt-bg-yellow-lighter"
                title="Стоимость лота" :count="filters.prices"
                modal_name="#priceModal"
            />
        </div>

        <bkt-card-list :current_component="'BktCard'" :items="items" :loading="loading"
                       :current_component_attrs="attributes"
                       :pagination_data="pagination_data" @change-page="getData" @changeStatus="changeStatus">
        </bkt-card-list>
        <div v-if="!loading && (!isLoggedIn || !auth_user || !auth_user.botTariff)" class="bkt-shadow-card bkt-shadow-card_primary mt-3">
            <div class="bkt-shadow-card__inner bkt-gap-large">
                <h4 class="bkt-shadow-card__title bkt-text-white">
                    Чтобы продолжить просмотр лотов <br>
                    <span>купите подписку</span>
                </h4>
                <button class="bkt-button bkt-bg-white bkt-text-primary mx-auto bkt-button_plump"
                        style="max-width: 320px" @click="toTariffsPage"
                >
                    Купить подписку
                </button>
                <div class="bkt-shadow-card__shadow-1">
                </div>
                <div class="bkt-shadow-card__shadow-2">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BktFilterCard from "../components/FilterCard";
    import BktRegionModal from "../components/SharedModals/RegionModal";
    import BktCategoryModal from "../components/SharedModals/CategoryModal";
    import BktPriceModal from "../components/SharedModals/PriceModal";

    export default {
        name: "MainPage",
        components: {
            BktFilterCard, BktRegionModal, BktCategoryModal, BktPriceModal
        },
        data() {
            return {
                attributes: {
                    type: 'bot'
                },
                filters_mode: false
            }
        },
        computed: {
            filters() {
                return this.$store.getters.filters;
            },
            items() {
                return this.$store.getters.trades;
            },
            pagination_data() {
                return this.$store.getters.trades_pagination;
            },
            loading() {
                return this.$store.getters.trades_loading;
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
            auth_user() {
                return this.$store.getters.auth_user
            },
            filters_total() {
                let filters = JSON.parse(JSON.stringify(this.filters));
                filters.searchString = null;
                filters.sort = null;
                filters.extraOptions.other.period = null;
                let total = 0;
                if(filters) {
                    Object.keys(filters).forEach(key => {
                        if(filters[key]) {
                            if (Array.isArray(filters[key])) {
                                total += filters[key].length
                            }
                            else {
                                total += Object.values(filters[key])
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
                            }
                        }
                    });
                }

                return total
            },
        },
        mounted() {
            if (this.items.length === 0) {
                let page = 1;
                if (sessionStorage.getItem('main_page')) {
                    page = sessionStorage.getItem('main_page')
                }
                this.getData(page);
            }
        },
        methods: {
            async getData(page = 1) {
                await this.$store.dispatch('getFilteredTrades', {
                    page: page,
                    filters: this.filters
                });
            },
            changeStatus(payload) {
                if (payload.key === 'isHide') {
                    let page = null;
                    if (payload.page) {
                        page = payload.page
                    }
                    this.getData(page)
                }
            },
            removeFilters() {
                this.$store.commit('resetFilters', '');
                this.getData(1);
                this.$scrollTo('#cardList', 200);
            },
            toTariffsPage() {
                this.$router.push('/bot/tariffs')
            },
            runSearch(search) {
                this.getData(1);
                this.$scrollTo('#cardList', 200);
            },
        }
    }
</script>

<style scoped>

</style>
