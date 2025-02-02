<template>
    <div class="container bkt-container">
        <bkt-card-list :current_component="'BktCard'" :items="items" :loading="loading"
                       :current_component_attrs="attributes"
                       :pagination_data="pagination_data" @change-page="getData" @changeStatus="changeStatus">
        </bkt-card-list>
    </div>
</template>

<script>
    export default {
        name: "MainPage",
        data() {
            return {
                attributes: {
                    type: 'bot'
                }
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
            auth_check() {
                return this.$store.getters.auth_check
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
            }
        }
    }
</script>

<style scoped>

</style>
