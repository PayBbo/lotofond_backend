<template>
    <div ref="cardList" :class="main_class">
        <slot name="modals" v-if="!no_modals">
            <bkt-move-favourite-modal v-if="isLoggedIn" @moveFavourite="moveFavourite"/>
            <bkt-note-modal v-if="isLoggedIn"/>
            <bkt-application-modal/>
        </slot>
        <slot name="filters">
        </slot>
        <slot name="list">
            <slot name="loading" v-if="loading">
<!--                <div class="d-flex w-100 justify-content-center mb-5">-->
<!--                    <div-->
<!--                        style="color: #2953ff;border-width: 2px;"-->
<!--                        class="spinner-border"-->
<!--                        role="status"-->
<!--                    ></div>-->
<!--                </div>-->
                <div class="bkt-card-trade bkt-card__row w-100 mx-auto mx-0" v-for="(item, index) in 5">
                    <div class="bkt-wrapper-between bkt-card__heading w-100">
                        <skeleton type_name="text" skeleton_class="me-auto mb-0" height="10px" width="50px"></skeleton>
                        <skeleton type_name="text"  skeleton_class="mb-0" height="10px" width="55px"></skeleton>
                    </div>
                    <div class="col-12 col-lg-11 p-0">
                        <div class="row h-100 w-100 mx-auto row-cols-1 row-cols-md-2 row-cols-lg-3 bkt-card-trade__wrapper">
                            <div class="col p-0 px-sm-2 order-2 order-lg-1">
                                <div class="bkt-card__image-wrapper">
                                    <skeleton type_name="item" skeleton_class="bkt-card__image-category"></skeleton>
                                    <div class="bkt-wrapper-between bkt-card-ecp-wrapper">
                                        <skeleton type_name="item" skeleton_class="bkt-button bkt-card-ecp w-100"
                                                  height="44px"></skeleton>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4 p-0 px-sm-2 order-1 order-lg-2">
                                <div class="bkt-wrapper-between bkt-card__head bkt-nowrap bkt-gap">
                                    <skeleton :type_name="'title'" skeleton_class="mb-0"></skeleton>
                                    <div class="dropdown d-block d-lg-none">
                                        <skeleton :type_name="'item'" skeleton_class="bkt-button bkt-card-menu-button"></skeleton>
                                    </div>
                                </div>
                                <div class="d-none d-lg-block">
                                    <div class="bkt-card__feature" v-for="(n,index) in 3">
                                        <skeleton type_name="text" height="12px" width="60px"></skeleton>
                                        <skeleton type_name="text" height="14px" width="80%"></skeleton>
                                    </div>
                                </div>
                            </div>
                            <div class="col order-3 p-0 px-sm-2">
                                <div class="bkt-card-trade__wrapper bkt-wrapper-column">
                                    <div class="bkt-wrapper-column bkt-gap-small">
                                        <skeleton type_name="item" skeleton_class="bkt-card-trade__price-wrapper bkt-button w-100"></skeleton>
                                        <div class="bkt-card-infographics bkt-wrapper-between bkt-nowrap">
                                            <div class="bkt-card outline" v-for="(n,index) in 2">
                                                <div class="bkt-card__feature text-center w-100 mt-0">
                                                    <skeleton type_name="text" height="14px" width="40px"></skeleton>
                                                    <skeleton type_name="text" height="18px" width="90%"></skeleton>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bkt-card-trade__periods">
                                        <div class="bkt-form row-cols-2 row-cols-lg-1">
                                            <div class="col" v-for="(n,index) in 2">
                                                <div class="bkt-card-period bkt-gap-small">
                                                    <skeleton :type_name="'item'" width="44px" height="44px"></skeleton>
                                                    <div class="bkt-card__feature">
                                                        <skeleton type_name="text" height="12px" width="40px"></skeleton>
                                                        <skeleton type_name="text" height="12px" width="50px"></skeleton>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col d-lg-none" v-for="(n,index) in 4">
                                                <div class="bkt-card-period bkt-gap-small">
                                                    <skeleton :type_name="'item'" width="44px" height="44px"></skeleton>
                                                    <div class="bkt-card__feature">
                                                        <skeleton type_name="text" height="12px" width="40px"></skeleton>
                                                        <skeleton type_name="text" height="12px" width="50px"></skeleton>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 p-0 px-sm-2 order-4 align-self-end">
                                <div class="bkt-wrapper-between bkt-card-trade__cadastral-info">
                                    <div class="bkt-card__row outline bkt-wrapper-between align-items-center" v-for="(n,index) in 3">
                                        <div class="bkt-card__feature">
                                            <skeleton :type_name="'text'" width="90px"></skeleton>
                                            <skeleton :type_name="'text'" width="55px" height="8px"></skeleton>
                                        </div>
                                        <skeleton :type_name="'item'" width="25px" height="25px" circle></skeleton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 col-lg-1 p-0 d-none d-lg-block">
                        <div class="bkt-card vertical m-0 bkt-gap-mini">
                            <skeleton :type_name="'item'" width="40px" height="40px" circle  v-for="(n,index) in 7" :key="index"></skeleton>
                        </div>
                    </div>
                </div>
            </slot>
            <slot name="card_list" v-if="!loading">
                <template v-for="(item, index) in items">
                    <component
                        :is="current_component"
                        :item="item"
                        :index="index"
                        :key="index"
                        :ref="'card'+index"
                        @changeStatus="changeStatus"
                    />
                </template>
            </slot>
            <slot name="no_results" v-if="!loading && items.length===0 && !no_results">
                <div class="bkt-shadow-card bkt-shadow-card_primary w-100">
                    <div class="bkt-shadow-card__inner bkt-gap">
                        <h3 class="bkt-shadow-card__title bkt-text-white">
                            Странно, но ничего нет
                        </h3>
                        <h5 class="bkt-shadow-card__subtitle bkt-text-white">
                            Попробуйте изменить критерии поиска
                        </h5>
                        <div class="bkt-shadow-card__shadow-1">
                        </div>
                        <div class="bkt-shadow-card__shadow-2">
                        </div>
                    </div>
                </div>
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
    import MoveFavouriteModal from "../pages/Favourites/MoveFavouriteModal";
    import NoteModal from "./SharedModals/NoteModal";
    import BktApplicationModal from "./SharedModals/ApplicationModal";
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
            no_modals: {
                type: Boolean,
                default: false
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
            no_results: {
                type: Boolean,
                default: false
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
        components: {
            'bkt-move-favourite-modal': MoveFavouriteModal,
            'bkt-note-modal': NoteModal,  BktApplicationModal
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
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
        // destroyed() {
        //     if (this.infinite) {
        //         this.observer.disconnect();
        //     }
        // },
        methods: {
            scrollToElement() {
                // const [el] = this.$refs.card0;
                // if (el) {
                //     el.$el.scrollIntoView({ block: 'end', scrollBehavior: 'smooth' });
                // }
                const el = this.$refs.cardList;
                if (el) {
                    requestAnimationFrame(() => {
                        el.scrollIntoView({block: 'start', scrollBehavior: 'smooth'});
                        requestAnimationFrame(() => {
                            el.scrollIntoView();
                        })
                    })
                }
            },
            changePage(page) {
                this.$emit('change-page', page);
                if(!this.infinite) {
                    this.scrollToElement();
                }
            },
            changeStatus(payload) {
                if(this.pagination_data && !this.no_pagination)
                {
                    payload.page = this.pagination_data.currentPage;
                    if(payload.key === 'isHide' && this.items.length <= 1) {
                            payload.page = 1;
                    }
                }
                this.$emit('changeStatus', payload);
                this.$emit('updateData', payload);
                if(payload.key === 'isHide') {
                    if (!this.infinite) {
                        this.scrollToElement();
                    }
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
            moveFavourite(payload) {
                if(this.pagination_data && !this.no_pagination)
                {
                    payload.page = this.pagination_data.currentPage;
                    if(this.items.length <= 1) {
                        payload.page = 1;
                    }
                }
                payload.key = 'moveFavourite';
                this.$emit('moveFavourite', payload);
                this.$emit('updateData', payload);
                // if (!this.infinite) {
                //     this.scrollToElement();
                // }
            }
        }
    }
</script>

<style scoped>

</style>

