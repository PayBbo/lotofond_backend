<template>
    <bkt-modal :id="'categoryModal'" ref="categoryModal" :title="'Выберите нужные категории'"
               modal_class="bkt-category-modal bkt-region-modal" @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body>
            <div class="bkt-wrapper-column bkt-gap-large" v-if="!loading">
                <bkt-categories-control v-model="model"></bkt-categories-control>
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
        </template>
    </bkt-modal>
</template>

<script>
    import BktCollapse from '../Collapse.vue';
    import BktCategoriesControl from "../FiltersControls/CategoriesControl";
    export default {
        name: "Category",
        components: {
            BktCollapse,
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
            }
        },
        data() {
            return {
                result: [],
                items:[]
            };
        },
        created() {
            this.getCategories();
        },
        computed: {
            filters_categories() {
                this.result = this.$store.getters[this.filter_name].categories;
                return this.$store.getters[this.filter_name].categories
            },
            filters() {
                return this.$store.getters[this.filter_name]
            },
            categories() {
                return this.$store.getters.categories
                    .sort(function (one, other) {
                    //a - b is
                    //   0 when elements are the same
                    //  >0 when a > b
                    //  <0 when a < b
                    return  other.subcategories.length - one.subcategories.length;
                });
            },
            loading() {
                return this.$store.getters.categories_loading
            },
            model:{
                get() {
                    return JSON.parse(JSON.stringify(this.filters_categories));
                },
                set(value) {
                    this.result = value
                }
            }
        },
        methods: {
            saveFilters() {
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'categories',
                    value: this.result
                }, {root: true});
                this.$store.commit('saveFiltersProperty', {key: this.filter_name +'_categories', value: this.result});
                this.$store.commit('closeModal', '#categoryModal');
                let tmp_filters = JSON.parse(JSON.stringify(this.filters));
                this.$store.dispatch(this.method_name, {page: 1, filters: tmp_filters});
            },
            clearFilters() {
                this.model = [];
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'categories',
                    value: []
                }, {root: true});
                this.$store.commit('saveFiltersProperty', {key: this.filter_name +'_categories', value: []});
                this.$store.commit('closeModal', '#categoryModal');
                let tmp_filters = JSON.parse(JSON.stringify(this.filters));
                this.$store.dispatch(this.method_name, {page: 1, filters: tmp_filters});
            },
            async getCategories() {
                await this.$store.dispatch('getCategories').then(resp => {
                    this.items = JSON.parse(JSON.stringify(this.categories));
                });
            },
        }
    }
</script>

<style scoped>
</style>
