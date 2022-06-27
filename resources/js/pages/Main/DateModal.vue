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
                                    field_name="'Начало приёма заявок'"
                                    name="applicationTimeStart"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.eventTimeStart.end"
                                    field_name="'Начало приёма заявок'"
                                    name="applicationTimeStart"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-2">
                    <h5 class="bkt-form__label">начало приёма заявок</h5>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.applicationTimeStart.start"
                                    field_name="'Начало приёма заявок'"
                                    name="applicationTimeStart"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.applicationTimeStart.end"
                                    field_name="'Начало приёма заявок'"
                                    name="applicationTimeStart"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-2">
                    <h5 class="bkt-form__label">окончание приёма заявок</h5>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.applicationTimeEnd.start"
                                    field_name="'Начало приёма заявок'"
                                    name="applicationTimeStart"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.applicationTimeEnd.end"
                                    field_name="'Начало приёма заявок'"
                                    name="applicationTimeStart"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-2">
                    <h5 class="bkt-form__label">окончание торгов</h5>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.eventTimeEnd.start"
                                    field_name="'Начало приёма заявок'"
                                    name="applicationTimeStart"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-5">
                    <bkt-datepicker v-model="filter.eventTimeEnd.end"
                                    field_name="'Начало приёма заявок'"
                                    name="applicationTimeStart"
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
                date: '',
                dateRange: '',
                template: {
                    eventTimeStart: {
                        start: null,
                        end: null
                    },
                    eventTimeEnd: {
                        start: null,
                        end: null
                    },
                    applicationTimeStart: {
                        start: null,
                        end: null
                    },
                    applicationTimeEnd: {
                        start: null,
                        end: null
                    }
                },
            };
        },
        computed: {
            filters_dates() {
                return this.$store.getters.filters_dates
            },
            filters() {
                return this.$store.getters.filters
            },
            filter: {
                get() {
                    return this.filters_dates
                },
                set(value) {
                    this.$store.commit('saveFiltersProperty', {key: 'dates', value: value})
                }
            },
        },
        methods: {
            saveFilters() {
                this.$store.commit('closeModal', '#dateModal');
                this.$store.dispatch('getFilteredTrades', {page:1, filters: this.filters});
            },
            clearFilters() {
                this.$store.commit('saveFiltersProperty', {key:'dates', value: this.template});
                this.$store.commit('closeModal', '#dateModal');
                this.$store.dispatch('getFilteredTrades', {page:1, filters: this.filters});
            }
        }
    }
</script>

<style scoped>

</style>
