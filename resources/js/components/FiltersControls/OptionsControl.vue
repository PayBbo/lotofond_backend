<template>
    <div class="bkt-form mx-auto align-items-center">
        <div class="col-12">
            <bkt-select
                v-model="model.debtorCategories"
                multiple
                name="debtorCategories"
                label="категория должника"
                label_class="bkt-form__label"
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
                v-model="model.debtors"
                multiple
                name="debtors"
                :option_label="'shortName'"
                :options="debtors"
                :reduce="item => item.id"
                :method_name="'getFiltersBidders'"
                :method_params="{type: 'debtors'}"
                :pagination="debtors_pagination"
            ></bkt-select>
        </div>
        <div class="col-12 col-lg-4">
            <h5 class="bkt-form__label">арбитражный управляющий</h5>
        </div>
        <div class="col-12 col-lg-8">
            <bkt-select
                v-model="model.arbitrationManagers"
                multiple
                name="arbitr_managers"
                :option_label="'shortName'"
                :options="arbitr_managers"
                :reduce="item => item.id"
                :method_name="'getFiltersBidders'"
                :method_params="{type: 'arbitrationManagers'}"
                :pagination="arbitr_managers_pagination"
            ></bkt-select>
        </div>
        <div class="col-12 col-lg-4">
            <h5 class="bkt-form__label">организатор торгов</h5>
        </div>
        <div class="col-12 col-lg-8">
            <bkt-select
                v-model="model.organizers"
                multiple
                name="organizers"
                :option_label="'shortName'"
                :options="organizers"
                :reduce="item => item.id"
                :method_name="'getFiltersBidders'"
                :method_params="{type: 'organizers'}"
                :pagination="organizers_pagination"
            ></bkt-select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "OptionsControl",
        props: {
            value: {
                type: null,
            },
        },
        model: {
            prop: 'value',
            event: 'input'
        },
        data() {
            return {
                loading: false,
                debtorCategories: [
                    { title:'Физ.лицо', value:"SimplePerson"},
                    { title:'Организация', value:"SimpleOrganization"}
                ],
                model:{
                    debtorCategories: [
                    ],
                    debtors: [],
                    organizers: [],
                    arbitrationManagers: []
                },
            };
        },
        mounted() {
            this.model = this.value;
        },
        computed: {
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
            saveValue() {
                this.$emit('input', this.model);
            },
        },
    }
</script>

<style scoped>

</style>
