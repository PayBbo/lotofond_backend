<template>
    <div class="bkt-input__wrapper">
        <label :for="name" class="bkt-input__label">{{ label }}</label>
        <div class="bkt-input__group">
            <input
                :name="name"
                :id="name"
                :type="type"
                class="bkt-input"
                :value="inputValue"
                :placeholder="placeholder"
                @input="handleChange"
                @blur="handleBlur"
            />
            <div class="bkt-input__group-item" :class="{'active': group_item_action}" @click="clickGroupItem">
                <slot name="group-item">
                    <div class="bkt-input__icon">
                        <slot name="icon">
                            <bkt-icon :name="icon_name"></bkt-icon>
                        </slot>
                    </div>
                </slot>
            </div>
        </div>
        <p class="bkt-input-error" v-if="!!errorMessage">{{errorMessage}}</p>
    </div>
</template>

<script>
    import {toRef} from "vue";
    import {useField} from "vee-validate";

    export default {
        props: {
            type: {
                type: String,
                default: "text",
            },
            value: {
                type: String,
                default: "",
            },
            name: {
                type: String,
                required: true,
            },
            label: {
                type: String,
                required: true,
            },
            placeholder: {
                type: String,
                default: "",
            },
            rules: {
                type: String,
                default: "",
            },
            icon_name: {
                type: String,
                default: "",
            },
            group_item_action: {
                type: Boolean,
                default: false,
            }
        },
        setup(props) {
            // use `toRef` to create reactive references to `name` prop which is passed to `useField`
            // this is important because vee-validte needs to know if the field name changes
            // https://vee-validate.logaretm.com/v4/guide/composition-api/caveats
            const name = toRef(props, "name");
            const rules = toRef(props, "rules");
            // const { value, errorMessage } = useField('email',);
            // we don't provide any rules here because we are using form-level validation
            // https://vee-validate.logaretm.com/v4/guide/validation#form-level-validation
            const {
                value: inputValue,
                errorMessage,
                handleBlur,
                handleChange,
                meta,
            } = useField(name, rules, {
                initialValue: props.value,
            });

            return {
                handleChange,
                handleBlur,
                errorMessage,
                inputValue,
                meta,
            };
        },
        methods: {
            clickGroupItem() {
                if(this.group_item_action)
                {
                    this.$emit('click-group-item');
                }
            }
        }
    };
</script>

<style scoped>

</style>
