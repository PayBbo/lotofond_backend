<template>
    <div class="bkt-dropdown bkt-search__wrapper">
        <div class="bkt-search align-items-center" :class="[search_class, {'open': optionsShown}]">
            <input class="w-100 bkt-search__input" type="text" :placeholder="placeholder"
                   @keyup="keyMonitor"
                   v-model="searchFilter"
                   @focus="handleFocus"
                   @blur="handleBlur"
                   @input="getResults"
                   :disabled="disabled"
            >
            <span class="p-1" @click="clear" v-if="searchFilter != ''">
                <bkt-icon :class="{'d-none':currentLoading || !clearable}" :name="'Cancel'" color="green"
                          height="15px"></bkt-icon>
            </span>

            <button class="bkt-button green bkt-search__button bkt-bg-green"
                    :disabled="disabled || currentLoading ||immediate_search"
                    @click="runSearch"
            >
                <span v-show="currentLoading" class="spinner-border spinner-border-sm"
                      role="status"></span>
                <span :class="immediate_search ? 'd-none' :'d-none d-md-block'" v-if="!currentLoading">Найти</span>
                <bkt-icon :class="{'d-block d-md-none' : !immediate_search, 'd-none':currentLoading}"
                          :name="'Search'"></bkt-icon>
            </button>
        </div>
        <div class="bkt-dropdown__menu w-100" :class="dropdown_class" v-show="optionsShown&&!simple&&!no_dropdown">
            <slot name="dropdown-block-header" v-bind:pagination="pagination">
            </slot>
            <div class="dropdown-block" v-if="options">
                <slot name="dropdown-block" :options="options">
                    <div class="row w-100 m-auto bkt-gap">
                        <div class="col-12 px-0" v-for="(item, index) in options" @mousedown="selectOption(item)">
                            <slot name="dropdown-item" v-bind:item="item">
                                {{item}}
                            </slot>
                        </div>
                        <slot name="infinite" v-if="infinite && !currentLoading">
                            <div class="col-12 px-0">
                                <div ref="infiniteLoad" class="mx-auto">
                                    <infinite-loading
                                        @infinite="infiniteHandler"
                                        ref="infiniteLoading" :distance="10"
                                        style="min-height:10px;" spinner="waveDots"
                                    >
                                        <span slot="no-results"></span>
                                        <span slot="no-more"></span>
                                    </infinite-loading>
                                </div>
                            </div>
                        </slot>
                    </div>
                </slot>
            </div>
            <div class="text-center p-2" v-if="!options || options.length ===0">
                <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M24.8964 21.8028L34.0468 30.9532C34.9011 31.8075 34.9011 33.1925 34.0468 34.0468C33.1925 34.9011 31.8075 34.9011 30.9532 34.0468L21.8028 24.8964C19.5394 26.5344 16.7575 27.5 13.75 27.5C6.15608 27.5 0 21.3439 0 13.75C0 6.15608 6.15608 0 13.75 0C21.3439 0 27.5 6.15608 27.5 13.75C27.5 16.7575 26.5344 19.5394 24.8964 21.8028ZM13.75 23.125C18.9277 23.125 23.125 18.9277 23.125 13.75C23.125 8.57233 18.9277 4.375 13.75 4.375C8.57233 4.375 4.375 8.57233 4.375 13.75C4.375 18.9277 8.57233 23.125 13.75 23.125Z"
                        fill="#A0A4A8"/>
                </svg>
                <p class="dropdown-text">Ничего не нашлось</p>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';

    export default {
        name: "Search",
        props: {
            value: {
                type: String,
                default: ''
            },
            method_name: {
                type: String,
                required: false,
                default: '',
            },
            method_params: {},
            placeholder: {
                type: String,
                required: false,
                default: 'Введите нужное слово или фразу',
                note: 'Placeholder of dropdown'
            },
            disabled: {
                type: Boolean,
                required: false,
                default: false,
                note: 'Disable the dropdown'
            },
            maxItem: {
                type: Number,
                required: false,
                default: 6,
                note: 'Max items showing'
            },
            search_class: {
                type: String,
                required: false,
                default: 'bkt-bg-white'
            },
            search_field: {
                type: String,
                required: false,
                default: 'searchString'
            },
            dropdown_class: {
                type: String,
                required: false,
                default: ''
            },
            simple: {
                type: Boolean,
                default: false
            },
            no_dropdown: {
                type: Boolean,
                default: false
            },
            immediate_search: {
                type: Boolean,
                default: false
            },
            loading: {
                type: Boolean,
                default: false
            },
            clearable: {
                type: Boolean,
                default: false
            },
            infinite: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                selected: '',
                optionsShown: false,
                // searchFilter: '',
                options: [],
                currentLoading: false,
                pagination: {}
            }
        },
        computed: {
            searchFilter: {
                get() {
                    return this.value;
                },
                set(value) {
                    this.$emit("input", value);
                },
            },
            searchLoading: {
                get() {
                    return this.loading;
                },
                set(value) {
                    this.currentLoading = value;
                },
            },
        },
        methods: {
            handleBlur(value) {
                this.$emit('blur', value);
                if (!this.no_dropdown) {
                    // if (this.searchFilter == '') {
                    this.optionsShown = false;
                    // }
                }
            },
            handleFocus(value) {
                this.$emit('focus', value);
                if (!this.no_dropdown && this.searchFilter !== '' && this.options.length > 0) {
                    this.optionsShown = true;
                }
            },
            handleFocusOut(value) {
                this.$emit('focusout', value);
                setTimeout(() => this.optionsShown = false, 10000);

            },
            selectOption(option) {
                this.selected = JSON.parse(JSON.stringify(option));
                this.$emit('selected', this.selected);
                this.optionsShown = false;
            },
            showOptions() {
                if (!this.no_dropdown) {

                    if (!this.disabled) {
                        // this.searchFilter = '';
                        this.optionsShown = true;
                    }

                    // this.searchFilter = '';
                    // this.options = [];
                    // this.optionsShown = true;
                }
            },
            exit() {
                this.searchFilter = '';
                this.options = [];
                this.optionsShown = false;
            },
            // Selecting when pressing Enter
            keyMonitor: function (event) {
                if (event.key === "Enter" && this.options[0])
                    this.selectOption(this.options[0]);
            },
            getResults: _.debounce(function (e) {
                if (this.immediate_search) {
                    this.selected = '';
                    this.runSearch();
                }
                // else {
                //     this.showOptions();
                // }
            }, 700),
            async runSearch() {
                if (!this.simple) {
                    this.searchLoading = true;
                    this.selected = '';
                    let payload = this.searchFilter;
                    if (this.method_params) {
                        payload = this.method_params;
                        if (this.search_field) {
                            payload[this.search_field] = this.searchFilter;
                        }
                        if (!this.method_params.page) {
                            this.method_params.page = 1;
                        }
                    }
                    await this.$store.dispatch(this.method_name, payload)
                        .then(resp => {
                            if (!this.no_dropdown) {
                                if (resp.data.data) {
                                    this.options = resp.data.data;
                                    this.pagination = resp.data.pagination;
                                } else {
                                    this.options = resp.data;
                                    this.pagination = null;
                                }
                                this.showOptions();
                            }
                            this.searchLoading = false;
                        }).catch(error => {
                            this.options = [];
                            this.searchLoading = false;
                        });
                } else {
                    this.$emit("runSearch", this.searchFilter);
                }
            },
            clear() {
                this.exit();
                this.$nextTick(() => {
                    this.runSearch();
                })

            },
            async infiniteHandler($state) {
                let page = 0;
                if (this.pagination) {
                    this.searchLoading = true;
                    page = this.pagination.currentPage;
                    if (this.pagination.nextPageUrl !== null) {
                        let payload = this.searchFilter;
                        if (this.method_params) {
                            payload = this.method_params;
                            payload.page = page + 1;
                            if (this.search_field) {
                                payload[this.search_field] = this.searchFilter;
                            }
                            if (!this.method_params.page) {
                                this.method_params.page = page + 1;
                            }
                        }
                        await this.$store.dispatch(this.method_name, payload).then(resp => {
                            this.pagination = resp.data.pagination;
                            resp.data.data.forEach(item => {
                                let index = this.options.findIndex(el => el.id === item.id);
                                if (index < 0) {
                                    this.options.push(item)
                                }
                            });
                            if (this.pagination.nextPageUrl !== null) {
                                $state.loaded();
                            } else {
                                $state.complete();
                            }
                            this.searchLoading = false;
                        })
                            .catch(error => {
                                this.searchLoading = false;
                            });
                    } else {
                        $state.complete();
                        this.searchLoading = false;
                    }
                }
                // else {
                //     let payload = this.searchFilter;
                //     this.searchLoading = true;
                //     if (this.method_params) {
                //         payload = this.method_params;
                //         payload.page = page + 1;
                //         if (this.search_field) {
                //             payload[this.search_field] = this.searchFilter;
                //         }
                //         if (!this.method_params.page) {
                //             this.method_params.page = page + 1;
                //         }
                //     }
                //     await this.$store.dispatch(this.method_name, payload).then(resp => {
                //         this.pagination = resp.data.pagination;
                //         resp.data.data.forEach(item => {
                //             let index = this.options.findIndex(el => el.id === item.id);
                //             if (index < 0) {
                //                 this.options.push(item)
                //             }
                //         });
                //         if (this.pagination.nextPageUrl !== null) {
                //             $state.loaded();
                //         } else {
                //             $state.complete();
                //         }
                //         this.searchLoading = false;
                //     }).catch(error => {
                //         this.searchLoading = false;
                //     });
                // }
            },
        },
    }
</script>

<style scoped>

</style>
