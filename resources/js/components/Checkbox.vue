<template>
    <ValidationProvider :name="name" :rules="rules" v-slot="{ errors }" tag="div" class="bkt-check__wrapper" :class="wrapper_class">
        <div class="bkt-check">
            <div class="bkt-check__input">
                <input
                    v-if="type=='boolean'"
                    type="checkbox"
                    v-model="model"
                />
                <input
                    v-else
                    type="checkbox"
                    v-model="model"
                    :value="val"
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
                type: null,
                default: false,
            },
            val: {
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
            wrapper_class: {
                type: String,
                default: "",
            },
            // type: {
            //     type: String,
            //     default: "boolean",
            // },
        },
        // model: {
        //     prop: 'value',
        //     event: 'change'
        // },
        data: function() {
            return {
                // model:null,
                type: 'boolean'
                // tmp_val:null,
            };
        },
        mounted() {
            // this.model = this.value;
            if(typeof this.value != 'boolean')
            {
                this.type = 'other'
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
            saveValue() {
                this.$emit('input', this.model);
            },
        }
    };
</script>

<style scoped>

</style>
