<template>
    <bkt-modal :id="'dateModal'" ref="dateModal" title="Выберите дату торгов" modal_class="bkt-filters-modal"
               @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body>
            <div class="bkt-form mx-auto align-items-start">
                <div class="col-12 col-lg-2">
                    <h5 class="bkt-form__label">начало торгов</h5>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.eventTimeStart.start"
                                    field_name="'Начало торгов от'"
                                    name="eventTimeStart"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.eventTimeStart.end"
                                    field_name="'Начало торгов до'"
                                    name="eventTimeStartEnd"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-2">
                    <h5 class="bkt-form__label">начало приёма заявок</h5>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.applicationTimeStart.start"
                                    field_name="'Начало приёма заявок от'"
                                    name="applicationTimeStart"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.applicationTimeStart.end"
                                    field_name="'Начало приёма заявок до'"
                                    name="applicationTimeStartEnd"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-2">
                    <h5 class="bkt-form__label">окончание приёма заявок</h5>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.applicationTimeEnd.start"
                                    field_name="'Окончание приёма заявок от'"
                                    name="applicationTimeEndStart"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.applicationTimeEnd.end"
                                    field_name="'Окончание приёма заявок до'"
                                    name="applicationTimeEnd"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-2">
                    <h5 class="bkt-form__label">окончание торгов</h5>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.eventTimeEnd.start"
                                    field_name="'Окончание торгов от'"
                                    name="eventTimeEndStart"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.eventTimeEnd.end"
                                    field_name="'Окончание торгов до'"
                                    name="eventTimeEnd"
                    ></bkt-datepicker>
                </div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "DateModal",
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
                time:''
            };
        },
        computed: {
            filters() {
                return this.$store.getters.filters;
            },
            filter: {
                get() {
                    return JSON.parse(JSON.stringify(this.$store.getters.filters_dates));
                },
                set(value) {
                    this.dates = value;
                }
            },
        },
        methods: {
            saveFilters() {
                this.$store.commit('saveFiltersProperty', {key: 'dates', value: this.filter});
                this.$store.commit('closeModal', '#dateModal');
                this.$store.dispatch('getFilteredTrades', {page: 1, filters: this.filters});
            },
            clearFilters() {
                this.$store.commit('saveFiltersProperty', {key: 'dates', value: this.template});
                this.$store.commit('closeModal', '#dateModal');
                this.$store.dispatch('getFilteredTrades', {page: 1, filters: this.filters});
            }
        }
    }
</script>

<style scoped>

</style>
