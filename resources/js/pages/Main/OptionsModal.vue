<template>
    <bkt-modal :id="'optionsModal'" ref="optionsModal" title="Выберите дополнительные параметры" modal_class="bkt-filters-modal"
               @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body>
            <div class="bkt-form mx-auto align-items-start">
                <div class="col-12">
                    <bkt-select
                        v-model="filter.debtorCategories"
                        multiple
                        name="debtorCategories"
                        label="категория должника"
                        placeholder="Все категории"
                        :option_label="'title'"
                        :options="debtorCategories"
                        :reduce="item => item.value"
                    >
                    </bkt-select>
                </div>
                <div class="col-12 col-lg-4">
                    <h5 class="bkt-form__label">должник</h5>
                </div>
                <div class="col-12 col-lg-8">
                    <bkt-select
                        v-model="filter.debtors"
                        multiple
                        name="debtors"
                        :option_label="'shortName'"
                        :options="debtors"
                        :reduce="item => item.id"
                        :method_name="'getDebtors'"
                        :method_params="method_params"
                        :pagination="debtors_pagination"
                    ></bkt-select>
                </div>
                <div class="col-12 col-lg-4">
                    <h5 class="bkt-form__label">арбитражный управляющий</h5>
                </div>
                <div class="col-12 col-lg-8">
                    <bkt-select
                        v-model="filter.arbitrManagers"
                        multiple
                        name="arbitr_managers"
                        :option_label="'shortName'"
                        :options="arbitr_managers"
                        :reduce="item => item.id"
                        :method_name="'getArbitrationManagers'"
                        :method_params="method_params"
                        :pagination="arbitr_managers_pagination"
                    ></bkt-select>
                </div>
                <div class="col-12 col-lg-4">
                    <h5 class="bkt-form__label">организатор торгов</h5>
                </div>
                <div class="col-12 col-lg-8">
                    <bkt-select
                        v-model="filter.organizers"
                        multiple
                        name="organizers"
                        :option_label="'shortName'"
                        :options="organizers"
                        :reduce="item => item.id"
                        :method_name="'getOrganizers'"
                        :method_params="method_params"
                        :pagination="organizers_pagination"
                    ></bkt-select>
                </div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    import BktSelect from "../../components/Select";
    export default {
        name: "OptionsModal",
        components: {
            BktSelect
        },
        data() {
            return {
                loading: false,
                options: null,
                template: {
                    debtorCategories: [
                    ],
                    debtors: [],
                    organizers: [],
                    arbitrManagers: []
                },
                debtorCategories: [
                    { title:'Физ.лицо', value:"SimplePerson"},
                    { title:'Организация', value:"SimpleOrganization"}
                ],
                method_params: {
                    type:'filters'
                }
            };
        },
        computed: {
            filters() {
                return this.$store.getters.filters
            },
            filter: {
                get() {
                    return JSON.parse(JSON.stringify(this.$store.getters.filters_extra_options))
                },
                set(value) {
                    this.options = value;
                }
            },
            debtors() {
                return this.$store.getters.filters_debtors
            },
            organizers() {
                return this.$store.getters.filters_organizers
            },
            arbitr_managers() {
                return this.$store.getters.filters_arbitration_managers
            },
            debtors_pagination() {
                // return {
                //     pagination: this.$store.getters.filters_debtors_pagination,
                //     method_name: 'getDebtors',
                //     method_params:{
                //         type:'filters'
                //     }
                // }
                return this.$store.getters.filters_debtors_pagination
            },
            organizers_pagination() {
                // return {
                //     pagination: this.$store.getters.filters_organizers_pagination,
                //     method_name: 'getOrganizers',
                //     method_params:{
                //         type:'filters'
                //     }
                // }
                return this.$store.getters.filters_organizers_pagination
            },
            arbitr_managers_pagination() {
                // return {
                //     pagination: this.$store.getters.filters_arbitration_managers_pagination,
                //     method_name: 'getArbitrManagers',
                //     method_params:{
                //         type:'filters'
                //     }
                // }
                return this.$store.getters.filters_arbitration_managers_pagination
            },
        },
        methods: {
            saveFilters() {
                this.$store.commit('saveFiltersProperty', {key:'extraOptions', value: this.filter});
                this.$store.commit('closeModal', '#optionsModal');
                this.$store.dispatch('getFilteredTrades', {page:1, filters: this.filters});
            },
            clearFilters() {
                this.$store.commit('saveFiltersProperty', {key:'extraOptions', value: this.template});
                this.$store.commit('closeModal', '#optionsModal');
                this.$store.dispatch('getFilteredTrades', {page:1, filters: this.filters});
            }
        }
    }
</script>

<style scoped>

</style>
