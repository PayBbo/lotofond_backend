<template>
    <div class="bkt-form mx-auto align-items-center">
        <div class="col-12 col-lg-2">
            <h5 class="bkt-form__label">начало торгов</h5>
        </div>
        <div class="col-12 col-lg-5">
            <bkt-datepicker v-model="model.eventTimeStart.start"
                            field_name="'Начало торгов от'"
                            name="eventTimeStart"
            ></bkt-datepicker>
        </div>
        <div class="col-12 col-lg-5">
            <bkt-datepicker v-model="model.eventTimeStart.end"
                            field_name="'Начало торгов до'"
                            name="eventTimeStartEnd"
            ></bkt-datepicker>
        </div>
        <div class="col-12 col-lg-2">
            <h5 class="bkt-form__label">начало приёма заявок</h5>
        </div>
        <div class="col-12 col-lg-5">
            <bkt-datepicker v-model="model.applicationTimeStart.start"
                            field_name="'Начало приёма заявок от'"
                            name="applicationTimeStart"
            ></bkt-datepicker>
        </div>
        <div class="col-12 col-lg-5">
            <bkt-datepicker v-model="model.applicationTimeStart.end"
                            field_name="'Начало приёма заявок до'"
                            name="applicationTimeStartEnd"
            ></bkt-datepicker>
        </div>
        <div class="col-12 col-lg-2">
            <h5 class="bkt-form__label">окончание приёма заявок</h5>
        </div>
        <div class="col-12 col-lg-5">
            <bkt-datepicker v-model="model.applicationTimeEnd.start"
                            field_name="'Окончание приёма заявок от'"
                            name="applicationTimeEndStart"
            ></bkt-datepicker>
        </div>
        <div class="col-12 col-lg-5">
            <bkt-datepicker v-model="model.applicationTimeEnd.end"
                            field_name="'Окончание приёма заявок до'"
                            name="applicationTimeEnd"
            ></bkt-datepicker>
        </div>
        <div class="col-12 col-lg-2">
            <h5 class="bkt-form__label">окончание торгов</h5>
        </div>
        <div class="col-12 col-lg-5">
            <bkt-datepicker v-model="model.eventTimeEnd.start"
                            field_name="'Окончание торгов от'"
                            name="eventTimeEndStart"
            ></bkt-datepicker>
        </div>
        <div class="col-12 col-lg-5">
            <bkt-datepicker v-model="model.eventTimeEnd.end"
                            field_name="'Окончание торгов до'"
                            name="eventTimeEnd"
            ></bkt-datepicker>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DatesControl",
        props: {
            value: {
                type: null,
                default: false,
            },
        },
        model: {
            prop: 'value',
            event: 'input'
        },
        data() {
            return {
                loading: false,
                model:{
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
            };
        },
        mounted() {
            this.model = this.value;
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
