<template>
    <bkt-modal :id="'optionsModal'" ref="optionsModal" title="Выберите дополнительные параметры"
               modal_class="bkt-filters-modal"
               @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body>
            <bkt-options-control v-model="filter"></bkt-options-control>
        </template>
    </bkt-modal>
</template>

<script>
    import BktOptionsControl from "../FiltersControls/OptionsControl";
    export default {
        name: "OptionsModal",
        components: {
            BktOptionsControl
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
                loading: false,
                options: null,
                template: {
                    debtorCategories: [
                    ],
                    debtors: [],
                    organizers: [],
                    arbitrationManagers: []
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
                return this.$store.getters[this.filter_name]
            },
            filter: {
                get() {
                    return JSON.parse(JSON.stringify(this.$store.getters[this.filter_name].extraOptions))
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
                return this.$store.getters.filters_debtors_pagination
            },
            organizers_pagination() {
                return this.$store.getters.filters_organizers_pagination
            },
            arbitr_managers_pagination() {
                return this.$store.getters.filters_arbitration_managers_pagination
            },
        },
        methods: {
            saveFilters() {
                this.$store.commit('saveFiltersProperty', {key:this.filter_name +'_extraOptions', value: this.filter});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'extraOptions',
                    value: this.filter
                }, {root: true});
                this.$store.commit('closeModal', '#optionsModal');
                let tmp_filters = JSON.parse(JSON.stringify(this.filters));
                this.$store.dispatch(this.method_name, {page: 1, filters: tmp_filters});
            },
            clearFilters() {
                let tmp_filter = {...this.filters.extraOptions, ...this.template};
                this.$store.commit('saveFiltersProperty', {key:this.filter_name +'_extraOptions', value: tmp_filter});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'extraOptions',
                    value: tmp_filter
                }, {root: true});
                this.$store.commit('closeModal', '#optionsModal');
                let tmp_filters = JSON.parse(JSON.stringify(this.filters));
                this.$store.dispatch(this.method_name, {page: 1, filters: tmp_filters});
            }
        }
    }
</script>

<style scoped>

</style>
