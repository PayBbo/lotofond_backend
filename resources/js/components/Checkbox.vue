<template>
    <ValidationProvider :name="name" :rules="rules" v-slot="{ errors }" tag="div" class="bkt-check__wrapper">
        <div class="bkt-check">
            <div class="bkt-check__input">
                <input
                    type="checkbox"
                    v-model="model"
                    @change="saveValue"
                />
                <div class="bkt-check__input-check"></div>
            </div>
            <label class="bkt-check__label">
                <slot name="label">
                    {{label}}
                </slot>
            </label>
        </div>
        <p class="bkt-check-error" v-if="errors">{{errors[0]}}</p>
    </ValidationProvider>
</template>

<script>
    export default {
        props: {
            value: {
                type: Boolean,
                default: false,
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
        model: {
            prop: 'value',
            event: 'input'
        },
        data: function() {
            return {
                model:false,
            };
        },
        mounted() {
            this.model = this.value;
        },
        methods: {
            saveValue() {
                this.$emit('input', this.model);
            },
        }
    };
</script>

<style scoped>

</style>
