<template>
    <div ref="cardList" :class="main_class">
        <slot name="header">
        </slot>
        <slot name="filters">
        </slot>
        <slot name="list">
            <slot name="loading">
                <div v-if="loading" class="d-flex w-100 justify-content-center mb-5">
                    <div
                        style="color: #2953ff;border-width: 2px;"
                        class="spinner-border"
                        role="status"
                    ></div>
                </div>
            </slot>
            <slot name="card_list" v-if="!loading">
                <template v-for="(item, index) in items">
                    <component
                        :is="current_component"
                        :item="item"
                        :index="index"
                        :key="index"
                        :in_process="in_process"
                        :ref="'card'+index"
                    />
                </template>
            </slot>
        </slot>
        <slot name="footer">
            <slot name="pagination" v-if="!no_pagination && items.length>0 && !loading">
                <bkt-pagination v-if="!infinite"
                                :limit="1"
                                :data="pagination_data"
                                @change-page="changePage"
                ></bkt-pagination>
            </slot>
            <slot name="infinite" v-if="!no_pagination && infinite && !loading">
                <div ref="infiniteLoad" class="mx-auto">
                    <infinite-loading
                        @infinite="infiniteHandler"
                        ref="infiniteLoading" :distance="10"
                        style="min-height:10px;" spinner="waveDots"
                        :force-use-infinite-wrapper="'.'+ main_class"
                    >
                        <span slot="no-results"></span>
                        <span slot="no-more"></span>
                    </infinite-loading>
                </div>
            </slot>
        </slot>
    </div>
</template>

<script>
    import _ from 'lodash';
    export default {
        name: "CardList",
        props: {
            items: {
                type: Array,
                required: true,
                default: function () {
                    return [];
                }
            },
            loading: {
                type: Boolean,
                default: true
            },
            // params: {
            //     type: Object,
            //     required: true,
            // },
            // fields: {
            //     type: Array,
            //     required: true,
            //     default: function(){
            //         return [];
            //     }
            // },
            in_process: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            loading_class: {
                type: String,
                default: 'd-flex justify-content-center mt-5'
            },
            main_class: {
                type: String,
                default: 'bkt-main-cards bkt-card__list'
            },
            current_component: {
                // type:String
            },
            no_pagination: {
                type: Boolean,
                default: false
            },
            infinite: {
                type: Boolean,
                default: false
            },
            pagination_data: {
                type: Object,
                required: true,
            },
            search_value: {
                type:String,
                default: ''
            },
            method_name: {
                type: String,
                default: ''
            },
            method_params: {

            }
        },
        data() {
            return {
                results: [],
                observer: null,
                // search:'',
            }
        },
        mounted() {
            // if (this.infinite) {
            //     console.log(this.$refs)
            //     this.observer = new IntersectionObserver(entries => {
            //         this.handleIntersect(entries[0]);
            //         // document.querySelector('.card-list__wrapper')
            //     }, {root: null, threshold: 0.9});
            //     this.observer.observe(this.$refs.infiniteLoad);
            // }
            // this.runSearch();
        },
        computed: {
            search: {
                get() {
                    return this.search_value;
                },
                set(value) {
                    this.$emit("search_input", value);
                },
            },
            searchedItems: function () {
                if (!this.search || this.search.trim() === '') {
                    return this.items
                } else {
                    return this.results
                }
            },
        },
        // destroyed() {
        //     if (this.infinite) {
        //         this.observer.disconnect();
        //     }
        // },
        methods: {
            scrollToElement() {
                const [el] = this.$refs.card0;
                if (el) {
                    el.$el.scrollIntoView({ block: 'end', scrollBehavior: 'smooth' });
                }
            },
            changePage(page) {
                this.$emit('change-page', page);
                if(!this.infinite) {
                    this.scrollToElement();
                }
            },
            inputSearch: _.debounce(function (e) {
                this.runSearch()
            }, 600),
            runSearch() {
                if (this.params.search && this.params.search.trim() !== '') {
                    if (this.infinite) {
                        if (this.$refs.infiniteLoading.status !== 1) {
                            this.$refs.infiniteLoading.status = 1;
                            this.$refs.infiniteLoading.$emit('infinite', this.$refs.infiniteLoading.stateChanger);
                        }
                    }
                    this.$search(this.params.search, this.items, this.params.searchOptions).then(response => {
                        this.results = response;
                    })
                }
            },
            getObjectValue(object, nested_property) {
                nested_property = nested_property.replace(/\[(\w+)\]/g, '.$1'); // convert indexes to properties
                nested_property = nested_property.replace(/^\./, '');           // strip a leading dot
                let a = nested_property.split('.');
                for (let i = 0, n = a.length; i < n; ++i) {
                    let k = a[i];
                    if ((typeof object === 'object' && object !== null) && object.hasOwnProperty(k)) {
                        object = object[k];
                    } else {
                        return;
                    }
                }
                return object;
            },
            handleIntersect(entry) {
                let tmp = Math.round(this.$refs.cardList.scrollTop + this.$refs.cardList.clientHeight);
                if (tmp >= this.$refs.cardList.scrollHeight) {
                    if (entry.isIntersecting) {
                        if (this.$refs.infiniteLoading.status !== 1) {
                            this.$refs.infiniteLoading.status = 1;
                            this.$refs.infiniteLoading.$emit('infinite', this.$refs.infiniteLoading.stateChanger);
                        }
                    }
                }
            },
            async infiniteHandler($state) {
                let page = 0;
                if (this.pagination_data) {
                    page = this.pagination_data.currentPage;
                    if (this.pagination_data.nextPageUrl !== null) {
                        let payload = page + 1;
                        if (this.method_params) {
                            payload = this.method_params;
                            payload.page = page + 1;
                        }
                        await this.$store.dispatch(this.method_name, payload).then(resp => {
                            if (this.pagination_data.nextPageUrl !== null) {
                                $state.loaded();
                            } else {
                                $state.complete();
                            }
                        });
                    } else {
                        $state.complete();
                    }
                } else {
                    let payload = page + 1;
                    if (this.method_params) {
                        payload = this.method_params;
                        payload.page = page + 1;
                    }
                    await this.$store.dispatch(this.method_name, payload).then(resp => {
                        if (this.pagination_data.nextPageUrl !== null) {
                            $state.loaded();
                        } else {
                            $state.complete();
                        }
                    });
                }
            },
        }
    }
</script>

<style scoped>

</style>

