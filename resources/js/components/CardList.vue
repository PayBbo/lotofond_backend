<template>
    <div ref="cardList" id="cardList">
        <slot name="modals" v-if="!no_modals">
            <bkt-move-favourite-modal v-if="isLoggedIn" @moveFavourite="moveFavourite"/>
            <bkt-note-modal v-if="isLoggedIn"/>
            <bkt-application-modal/>
            <bkt-purchase-modal/>
            <bkt-instruction-modal/>
            <bkt-egrn-modal/>
        </slot>
        <slot name="filters">
        </slot>
        <slot name="list">
            <transition-group name="fade" tag="div" :class="main_class">
                <slot name="loading" v-if="loading">
                    <!--                <div class="d-flex w-100 justify-content-center mb-5">-->
                    <!--                    <div-->
                    <!--                        style="color: #2953ff;border-width: 2px;"-->
                    <!--                        class="spinner-border"-->
                    <!--                        role="status"-->
                    <!--                    ></div>-->
                    <!--                </div>-->
                    <div class="bkt-card-trade bkt-card-trade__wrapper bkt-card__row w-100 mx-auto mx-0"
                         v-for="(item, index) in count" :key="'loading-'+index"
                    >
                        <div class="bkt-wrapper-between bkt-card__heading w-100">
                            <skeleton type_name="text" skeleton_class="me-auto mb-0" height="10px"
                                      width="100px"></skeleton>
                        </div>
                        <div class="col-12 col-lg-11 p-0">
                            <div class="row h-100 w-100 mx-auto row-cols-1 row-cols-lg-4 bkt-card-trade__gap">
                                <div class="col-12 col-lg-2 p-0 pe-md-2">
                                    <div class="bkt-wrapper-down-lg bkt-nowrap bkt-gap">
                                        <div class="bkt-card__image-wrapper">
                                            <skeleton type_name="item"
                                                      skeleton_class="bkt-card__image-category"></skeleton>
                                            <skeleton type_name="item"
                                                      skeleton_class="bkt-button bkt-card-trade__button bkt-card-trade__button_egrn w-100 d-none d-lg-flex"
                                                      height="44px"></skeleton>
                                        </div>
                                        <div class="bkt-wrapper-column d-lg-none w-100">
                                            <div
                                                class="bkt-wrapper-between bkt-gap-large bkt-gap-down-sm bkt-nowrap w-100">
                                                <skeleton :type_name="'title'" skeleton_class="mb-0"></skeleton>
                                                <div class="d-flex bkt-gap-small">
                                                    <skeleton :type_name="'item'" height="14px" width="14px" :count="2"
                                                              skeleton_class="bkt-card-trade__icon"></skeleton>
                                                </div>
                                            </div>
                                            <div class="d-flex bkt-gap-small" v-for="n in 2">
                                                <skeleton skeleton_class="mb-1" :type_name="'item'" height="14px"
                                                          width="14px"></skeleton>
                                                <skeleton :type_name="'item'" height="14px" width="120px"></skeleton>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-5 p-0 px-lg-2">
                                    <div class="bkt-card__head d-none d-lg-block">
                                        <skeleton :type_name="'title'"
                                                  skeleton_class="bkt-card__title bkt-text-truncate-1"></skeleton>
                                    </div>
                                    <div class="bkt-card-trade__gap bkt-wrapper-column">
                                        <div class="bkt-card__features d-none d-sm-flex">
                                            <div class="bkt-card__feature">
                                                <skeleton skeleton_class="mb-1" :type_name="'item'" height="12px"
                                                          width="50px"></skeleton>
                                                <skeleton :type_name="'item'" height="14px" width="150px"></skeleton>
                                            </div>
                                        </div>
                                        <div class="bkt-card__feature">
                                            <skeleton skeleton_class="mb-1 d-none d-sm-block" :type_name="'item'"
                                                      height="12px" width="50px"></skeleton>
                                            <skeleton :type_name="'text'" height="14px" :count="7"></skeleton>
                                            <skeleton :type_name="'text'" height="14px" width="150px"></skeleton>
                                        </div>
                                        <skeleton :type_name="'item'" height="35px"
                                                  skeleton_class="bkt-button bkt-card-trade__button bkt-card-trade__button_more d-none d-md-block">
                                        </skeleton>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-5 p-0">
                                    <div class="bkt-card-trade__gap bkt-wrapper-column">
                                        <div class="d-flex bkt-gap d-none d-lg-flex" v-for="n in 2">
                                            <skeleton skeleton_class="mb-1" :type_name="'item'" height="14px"
                                                      width="14px"></skeleton>
                                            <skeleton :type_name="'text'" height="14px" width="150px"></skeleton>
                                        </div>
                                        <div>
                                            <skeleton skeleton_class="mb-1" :type_name="'item'" height="14px"
                                                      width="150px"></skeleton>
                                            <skeleton skeleton_class="bkt-progress-bar"></skeleton>
                                        </div>
                                        <div class="bkt-card__features">
                                            <div class="bkt-card__feature" v-for=" n in 2">
                                                <skeleton skeleton_class="mb-1" :type_name="'item'" height="12px"
                                                          width="50px"></skeleton>
                                                <skeleton :type_name="'item'" height="14px" width="70px"></skeleton>
                                            </div>
                                        </div>
                                        <div class="bkt-wrapper-between bkt-nowrap bkt-gap-small">
                                            <div class="bkt-card__feature w-100 mt-0">
                                                <skeleton skeleton_class="mb-1" :type_name="'item'" height="12px"
                                                          width="50px"></skeleton>
                                                <skeleton :type_name="'item'" height="20px" width="80px"></skeleton>
                                            </div>
                                            <skeleton :type_name="'item'" height="20px" width="80px"
                                                      skeleton_class="bkt-button bkt-card-trade__button bkt-card-trade__button_buy d-none d-lg-block"></skeleton>
                                            <div class="d-lg-none">
                                                <skeleton :type_name="'item'" width="40px" height="40px" circle>
                                                </skeleton>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 col-lg-1 p-0 d-none d-lg-block">
                            <skeleton :type_name="'item'" width="40px" height="40px" circle
                                      skeleton_class="mb-1"
                                      v-for="(n,ind) in 4" :key="ind"
                            >
                            </skeleton>
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
            </transition-group>
            <transition name="fade">
                <slot name="no_results" v-if="!loading && items.length===0 && !no_results && pagination_data">
                    <div class="bkt-shadow-card bkt-shadow-card_primary w-100" key="no_results">
                        <div class="bkt-shadow-card__inner bkt-gap">
                            <h3 class="bkt-shadow-card__title bkt-text-white">
                                <slot name="no_results_title_inner">Странно, но ничего нет</slot>
                            </h3>
                            <h5 class="bkt-shadow-card__subtitle bkt-text-white">
                                <slot name="no_results_subtitle_inner">Попробуйте изменить критерии поиска</slot>
                            </h5>
                            <div class="bkt-shadow-card__shadow-1">
                            </div>
                            <div class="bkt-shadow-card__shadow-2">
                            </div>
                        </div>
                    </div>
                </slot>
            </transition>
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
    import BktPurchaseModal from "./SharedModals/PurchaseModal";
    import BktInstructionModal from "./SharedModals/InstructionModal";
    import BktEgrnModal from "./SharedModals/EgrnModal";

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
                type: String,
                default: ''
            },
            method_name: {
                type: String,
                default: ''
            },
            method_params: {}
        },
        components: {
            'bkt-move-favourite-modal': MoveFavouriteModal,
            'bkt-note-modal': NoteModal,
            BktApplicationModal, BktPurchaseModal, BktInstructionModal, BktEgrnModal
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
            count() {
                // if (this.isLoggedIn) {
                    return 20
                // }
                // return 5
            }
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
                // const el = this.$refs.cardList;
                // if (el) {
                //     requestAnimationFrame(() => {
                //         el.scrollIntoView({block: 'start', scrollBehavior: 'smooth'});
                //         requestAnimationFrame(() => {
                //             el.scrollIntoView();
                //         })
                //     })
                // }
                this.$scrollTo('#cardList', 500);
            },
            changePage(page) {
                this.$emit('change-page', page);
                if (!this.infinite) {
                    this.scrollToElement();
                }
            },
            changeStatus(payload) {
                if (this.pagination_data && !this.no_pagination) {
                    payload.page = this.pagination_data.currentPage;
                    if (payload.key === 'isHide' && this.items.length <= 1) {
                        payload.page = 1;
                    }
                }
                this.$emit('changeStatus', payload);
                this.$emit('updateData', payload);
                if (payload.key === 'isHide') {
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
                if (this.pagination_data && !this.no_pagination) {
                    payload.page = this.pagination_data.currentPage;
                    if (this.items.length <= 1) {
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

<style scoped lang="scss">
    #cardList {
        & .fade-enter-active,
        & .fade-leave-active {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        & .fade-enter-to,
        & .fade-leave-from {
            transition: opacity 0.3s ease-in;
            opacity: 0.9;
        }

        & .fade-enter-from,
        & .fade-leave-to {
            opacity: 0;
        }
    }

</style>

