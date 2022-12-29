<template>
    <div class="bkt-container bkt-page">
        <h1 class="bkt-page__title">Победы недели</h1>
        <bkt-card-list :current_component="'BktWinCard'" :items="items" :loading="loading"
                       :pagination_data="pagination_data" @change-page="getData" no_modals>
            <template #no_results_subtitle_inner>
                Побед недели пока нет, попробуйте позже.
            </template>
        </bkt-card-list>
    </div>
</template>

<script>
    export default {
        name: "WeekWinners",
        data() {
            return {
                // loading: false,
                search_mode: false,
                selectedBtn: 0,
                group: 'по порядку добавления',
                to_group: [
                    {title: 'по порядку добавления', value: "publishDate"},
                    {title: 'по порядку добавления2', value: "publishDate1"},
                    {title: 'по порядку добавления3s', value: "publishDate2"},
                ],
                settings: {
                    "dots": false,
                    "infinite": false,
                    "centerMode": false,
                    "centerPadding": "20px",
                    "slidesToShow": 1,
                    "slidesToScroll": 1,
                    "variableWidth": true
                },
                // items: [
                //     {
                //         id: '',
                //         description: '',
                //         trade: {externalId: '1'}
                //     }
                // ],
                // pagination_data: {}
            };
        },
        mounted() {
            this.getData();
        },
        computed: {
            items() {
                return this.$store.getters.wins;
            },
            pagination_data() {
                return this.$store.getters.wins_pagination;
            },
            loading() {
                return this.$store.getters.wins_loading;
            },
        },
        methods: {
            async getData(page = 1) {
                await this.$store.dispatch('getWins', {page: page});
            },

        }
    }
</script>

<style scoped>

</style>
