<template>
    <ValidationProvider :name="name" :rules="rules" v-slot="{ errors }" tag="div" class="bkt-check__wrapper" :class="wrapper_class">
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
            // val: {
            // },
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
            wrapper_class: {
                type: String,
                default: "",
            },
        },
        model: {
            prop: 'value',
            event: 'input'
        },
        data: function() {
            return {
                model:null,
                // tmp_val:null,
            };
        },
        mounted() {
            this.model = this.value;
            // if(!this.val) {
            //     this.tmp_val = this.model
            // }
            // else {
            //     this.tmp_val =this.val;
            // }
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
