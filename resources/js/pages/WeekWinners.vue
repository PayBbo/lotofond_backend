<template>
    <div class="bkt-container bkt-page">
        <h1 class="bkt-page__title">Победы недели</h1>
        <bkt-card-list :current_component="'BktWinCard'" :items="items" :loading="loading"
                       :pagination_data="pagination_data" @change-page="getData">
        </bkt-card-list>
    </div>
</template>

<script>
    export default {
        name: "WeekWinners",
        data() {
            return {
                loading: false,
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
                items: [
                    {
                        id: '',
                        description: '',
                        trade: {externalId: '1'}
                    }
                ],
                pagination_data: {}
            };
        },
        created() {

        },
        mounted() {
        },
        computed: {
            // items() {
            //     return this.$store.getters.current_favourites;
            // },
            // pagination_data() {
            //     return this.$store.getters.favourites_pagination;
            // },
        },
        methods: {
            async getData(page = 1, pathId) {
                await this.$store.dispatch('getFavourites', {page: page, pathId: pathId});
            },
            async getFavouritePaths() {
                this.loading = true;
                await this.$store.dispatch('getFavouritePaths').then(response => {
                    // this.$store.commit('setFavouritePaths', response.data)
                    // this.$store.commit('setCurrentPath', response.data[0].pathId)
                    // this.getData(1, this.current_path)
                    this.$store.dispatch('getFavourites', {page: 1, pathId: this.current_path})
                        .finally(() => {
                            this.loading = false;
                        });

                }).catch(err => {
                    this.loading = false;
                });
            },
            async setCurrentPath(value) {
                this.loading = true;
                await this.$store.dispatch('setCurrentPath', value)
                    .finally(() => {
                        this.loading = false;
                    });
            },
            async removeFavouritePath() {
                await this.$store.dispatch('removeFavouritePath', this.current_path)
                    .then(resp => {
                        this.setCurrentPath(this.items_paths[0].pathId)
                    });
            }

        }
    }
</script>

<style scoped>

</style>
