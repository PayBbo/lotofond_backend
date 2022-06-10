<template>
    <div class="bkt-check__wrapper">
        <div class="bkt-check">
            <div class="bkt-check__input">
                <input
                    type="checkbox"
                    :value="value"
                    :name="name"
                    :id="name"
                    @change="onChange"
                />
                <div class="bkt-check__input-check"></div>
            </div>
            <label :for="name" class="bkt-check__label">
                <slot name="label">
                    {{label}}
                </slot>
            </label>
        </div>
        <p class="bkt-check-error" v-if="!!errorMessage">{{errorMessage}}</p>
    </div>

</template>

<script>
    import {toRef} from "vue";
    import {useField} from "vee-validate";
    import * as yup from "yup";
    export default {
        props: {
            value: {
                type: Boolean,
                default: false,
            },
            modelValue: {
                type: null,
            },
            name: {
                type: String,
                required: true,
            },
            label: {
                type: String,
                default: "",
            },
            placeholder: {
                type: String,
                default: "",
            },
            rules: {
                type: null,
                default: "",
            },
        },
        setup(props, ctx) {
            const name = toRef(props, "name");
            const rules = toRef(props, "rules");
            const {  checked, handleChange, errorMessage } = useField(props.name, rules, {
                type: "checkbox",
                valueProp: props.value,
                initialValue: false,
                checkedValue: true,
                uncheckedValue: false,
            });
            const onChange = (event) => {
                let val = event.target.value;

                if (!event.target.checked) {
                    val = false;
                }

                // val = !Number.isNaN(val) ? (Number.isInteger(val) ? parseInt(val) : parseFloat(val)) : '';

                handleChange(val);
                ctx.emit("update:modelValue", val);
            };
            return {
                handleChange,
                errorMessage,
                onChange,
                // meta,
                checked,
                // inputValue
            };
        },
    };
</script>

<style scoped>

</style>
