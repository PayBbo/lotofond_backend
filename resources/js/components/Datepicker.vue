<template>
    <ValidationProvider :name="field_name" :rules="rules" v-slot="{ errors }"
                        tag="div" class="bkt-input__wrapper" :vid="name"
    >
        <label :for="name" class="bkt-input__label" v-if="label" :class="label_class">{{ label }}</label>
        <date-picker :type="type" prefix-class="bkt" :value-type="value_type+time_format"
                     :placeholder="placeholder" :format="format+time_format"
                     :disabled="disabled" v-model="model"
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
                        <bkt-icon :name="icon_name" color="blue"></bkt-icon>
                    </div>
                </div>
            </template>
        </date-picker>
        <p class="bkt-input-error" v-if="errors && errors.length>0">{{errors[0]}}</p>
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
            name: {
                type: String,
                required: true,
            },
            label: {
                type: String,
            },
            field_name: {
                type: String,
                default: function () {
                    let field_label = this.label;
                    if (!this.label) {
                        field_label = this.name;
                    }
                    return field_label;
                }
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
            value_type: {
                type: String,
                default: "DD.MM.YYYY",
            },
            format: {
                type: String,
                default: "DD MMMM YYYY",
            },
            icon_name: {
                type: String,
                default: "Date",
            }
        },
        data: function () {
            return {
                time_format: ''
            };
        },
        mounted() {
            // if(!this.field_name) {
            //     this.field_name = this.label;
            //     if (!this.label) {
            //         this.field_name = this.name;
            //     }
            // }
            if (this.type == 'datetime') {
                this.time_format = ' HH:mm'
            }
        },
        computed: {
            model: {
                get() {
                    return this.value;
                },
                set(value) {
                    this.$emit("input", value);
                },
            },
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
