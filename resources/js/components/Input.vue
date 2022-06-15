<template>
    <ValidationProvider :name="label" :rules="rules" v-slot="{ errors }" tag="div" class="bkt-input__wrapper" :vid="name">
        <label :for="name" class="bkt-input__label">{{ label }}</label>
        <div class="bkt-input__group">
            <input
                :type="type"
                class="bkt-input"
                :name="name"
                :id="name"
                :value="value"
                :placeholder="placeholder"
                :disabled="disabled"
                @input="saveValue"
            />
            <slot name="group-item">
                <div class="bkt-input__group-item" :class="{'active': group_item_action&&!disabled}" @click="clickGroupItem">
                    <slot name="group-item-inner">
                        <div class="bkt-input__icon">
                            <slot name="icon">
                                <bkt-icon :name="icon_name"></bkt-icon>
                            </slot>
                        </div>
                    </slot>
                </div>
            </slot>
        </div>
        <p class="bkt-input-error" v-if="errors">{{errors[0]}}</p>
    </ValidationProvider>
</template>

<script>
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
        data: function() {
            return {

            };
        },
        methods: {
            saveValue(event) {
                this.$emit('input', event.target.value);
            },
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
