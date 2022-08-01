<template>
    <label class="bkt-switch">
        <input type="checkbox" v-model="model" :disabled="disabled">
        <span class="bkt-slider"></span>
    </label>
</template>

<script>
    export default {
        name: "BktSwitch",
        props: {
            value: {
                type: [Boolean, Number],
                default: false,
            },
            // name: {
            //     type: String,
            //     required: true,
            // },
            // label: {
            //     type: String,
            //     default: "",
            // },
            // rules: {
            //     type: null,
            //     default: "",
            // },
            // wrapper_class: {
            //     type: String,
            //     default: "",
            // },
            disabled: {
                type: Boolean,
                default: false
            }
        },
        // model: {
        //     prop: 'value',
        //     event: 'input'
        // },
        data: function() {
            return {
                // model:false,
            };
        },
        mounted() {
            // this.model = this.value;
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
    }
</script>

<style scoped>

</style>
