<template>
    <ValidationProvider :name="field_name" :rules="rules" v-slot="{ errors }"
                        tag="div" class="bkt-input__wrapper" :vid="name"
    >
        <label :for="name" class="bkt-input__label" v-if="label" :class="label_class">{{ label }}</label>
        <date-picker :type="type" :value="value" prefix-class="bkt" value-type="DD.MM.YYYY"
                     :placeholder="placeholder" format="DD MMMM YYYY"
                     :disabled="disabled" @input="saveValue"
        >
            <template #icon-clear>
                <div class="bkt-datepicker-group">
                    <span class="bkt-datepicker-group-icon">
                        <bkt-icon name="Cancel" color="blue"></bkt-icon>
                    </span>
                </div>
            </template>
            <template #icon-calendar>
                <div class="bkt-datepicker-group">
                    <div class="bkt-datepicker-group-icon">
                        <bkt-icon name="Date" color="blue"></bkt-icon>
                    </div>
                </div>
            </template>
        </date-picker>
        <p class="bkt-input-error" v-if="errors">{{errors[0]}}</p>
    </ValidationProvider>
</template>

<script>
    export default {
        name: "Datepicker",
        props: {
            type: {
                type: String,
                default: "date",
            },
            value: {
                type: [String, Date],
                default: "",
            },
            field_name: {
                type: String,
                required: true,
            },
            name: {
                type: String,
                required: true,
            },
            label: {
                type: String,
            },
            label_class: {
                type: String,
            },
            placeholder: {
                type: String,
                default: "",
            },
            rules: {
                type: String,
                default: "",
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            loading: {
                type: Boolean,
                default: false,
            },
        },
        data: function () {
            return {
            };
        },
        mounted() {
            if(!this.field_name) {
                this.field_name = this.label;
                if (!this.label) {
                    this.field_name = this.name;
                }
            }
        },
        computed: {
        },
        methods: {
            saveValue(date) {
                this.$emit('input', date);
            },
        }
    }
</script>

<style scoped>

</style>
