<template>
    <div class="dropdown bkt-search__wrapper">
        <div class="bkt-search" :class="search_class">
            <input class="w-100 bkt-search__input" type="text" :placeholder="placeholder"
                   @keyup="keyMonitor"
                   v-model="searchFilter"
                   :disabled="disabled"
            >
            <button class="bkt-button green bkt-search__button" :disabled="disabled || searchLoading"
                    @click="runSearch">
                <span v-show="searchLoading" class="spinner-border spinner-border-sm"
                      role="status"></span>
                <span class="d-none d-md-block" v-if="!searchLoading">Найти</span>
                <bkt-icon v-show="!searchLoading" class="d-block d-md-none" :name="'Search'"></bkt-icon>
            </button>
        </div>
        <div class="dropdown-content w-100 p-3" :class="dropdown_class" v-show="optionsShown&&!simple&&!no_dropdown">
            <div class="dropdown-block" v-if="options">
                <div class="dropdown-item" v-for="(item, index) in options" @click="selectOption(item)">
                    <slot name="dropdown-item" v-bind:item="item">
                        {{item}}
                    </slot>
                </div>
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
            loading: {
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
                currentLoading: false
            }
        },
        created() {
            this.searchFilter = '';
            this.selected = '';
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
            filteredOptions() {
                const filtered = [];
                const regOption = new RegExp(this.searchFilter, 'ig');
                for (const option of this.options) {
                    if (this.searchFilter.length < 1 || option.name.match(regOption) || option.email.match(regOption)) {
                        if (filtered.length < this.maxItem) filtered.push(option);
                    }
                }
                return filtered;
            }
        },
        methods: {
            handleBlur(value) {
                this.$emit('blur', value);
                if (this.searchFilter == '') {
                    this.optionsShown = false;
                }
                // this.exit();
            },
            selectOption(option) {
                this.selected = JSON.parse(JSON.stringify(option));
                this.$emit('selected', this.selected);
                this.searchFilter = '';
                this.optionsShown = false;
            },
            showOptions() {
                // if (!this.disabled) {
                //     this.searchFilter = '';
                //     this.optionsShown = true;
                // }
                this.searchFilter = '';
                this.options = [];
                this.optionsShown = true;
            },
            exit() {
                if (!this.selected.id) {
                    this.selected = '';
                    // this.searchFilter = '';
                } else {
                    this.searchFilter = this.selected.name;
                }
                // this.$emit('selected', this.selected);
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
                if (this.searchFilter.trim() !== '') {
                    this.selected = '';
                    this.runSearch();
                } else {
                    this.showOptions();
                }

            }, 700),
            async runSearch() {
                console.log('search runSearch method')
                if (!this.simple) {
                    if (this.searchFilter.trim() !== '') {
                        this.searchLoading = true;
                        this.selected = '';
                        let payload = this.searchFilter;
                        if (this.method_params) {
                            payload = this.method_params;
                            if (this.search_field) {
                                payload[this.search_field] = this.searchFilter;
                            }
                        }
                        await this.$store.dispatch(this.method_name, payload)
                            .then(resp => {
                                if (!this.no_dropdown) {
                                    this.showOptions();
                                    this.options = resp.data;
                                }
                                this.searchLoading = false;
                            }).catch(error => {
                                this.options = [];
                                this.searchLoading = false;
                            });
                    }
                } else {
                    console.log('search runSearch')
                    this.$emit("runSearch", this.searchFilter);
                }
            }
        },
    }
</script>

<style scoped>

</style>
