<template>
    <bkt-modal :id="'dateModal'" ref="dateModal" title="Выберите дату торгов" modal_class="bkt-filters-modal"
               @left_action="clearFilters" @right_action="saveFilters" @close-modal="closeModal"
    >
        <template #body>
           <bkt-dates-control :value="filter"></bkt-dates-control>
        </template>
    </bkt-modal>
</template>

<script>
    import BktDatesControl from "../FiltersControls/DatesControl";
    export default {
        name: "DateModal",
        components: {
            BktDatesControl
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
                dates: '',
                template: {
                    eventTimeStart: {
                        start: "",
                        end: ""
                    },
                    eventTimeEnd: {
                        start: "",
                        end: ""
                    },
                    applicationTimeStart: {
                        start: "",
                        end: ""
                    },
                    applicationTimeEnd: {
                        start: "",
                        end: ""
                    }
                },
                time:'',
            };
        },
        computed: {
            filters() {
                return this.$store.getters[this.filter_name];
            },
            filter: {
                get() {
                    return JSON.parse(JSON.stringify(this.$store.getters[this.filter_name].dates));
                },
                set(value) {
                    this.dates = value;
                }
            },
        },
        methods: {
            saveFilters() {
                this.$store.commit('saveFiltersProperty', {key: this.filter_name +'_dates', value: this.filter});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'dates',
                    value: this.filter
                }, {root: true});
                this.$store.commit('closeModal', '#dateModal');
                this.callMethod();
            },
            clearFilters() {
                this.$store.commit('saveFiltersProperty', {key: this.filter_name +'_dates', value: this.template});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'dates',
                    value: this.template
                }, {root: true});
                this.$store.commit('closeModal', '#dateModal');
                this.callMethod();
            },
            closeModal() {
                Object.assign(this.filter, JSON.parse(JSON.stringify(this.filters.dates)))
            },
            callMethod() {
                let tmp_filters = JSON.parse(JSON.stringify(this.filters));
                this.$store.dispatch(this.method_name, {page: 1, filters: tmp_filters});
            }
        }
    }
</script>

<style scoped>

</style>
