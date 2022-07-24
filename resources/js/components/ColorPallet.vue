<template>
    <div class="bkt-wrapper mx-0">
        <bkt-checkbox v-model="model" val="yellow" name="yellow" type="radio"
                      class="bkt-check_color" check_color="yellow"
                      :border_color="model === 'yellow' ? 'yellow' : ''"
        >
        </bkt-checkbox>
        <bkt-checkbox v-model="model" val="blue" name="blue" type="radio"
                      class="bkt-check_color" check_color="blue"
                      :border_color="model === 'blue' ? 'blue' : ''"
        >
        </bkt-checkbox>
        <bkt-checkbox v-model="model" val="pink" name="pink" type="radio"
                      class="bkt-check_color" check_color="pink"
                      :border_color="model === 'pink' ? 'pink' : ''"
        >
        </bkt-checkbox>
        <bkt-checkbox v-model="model" val="green" name="green" type="radio"
                      class="bkt-check_color" check_color="green"
                      :border_color="model === 'green' ? 'green' : ''"
        >
        </bkt-checkbox>
        <bkt-checkbox v-model="model" val="red" name="red" type="radio"
                      class="bkt-check_color" check_color="red"
                      :border_color="model === 'red' ? 'red' : ''"
        >
        </bkt-checkbox>
        <bkt-checkbox v-model="model" val="main" name="main" type="radio"
                      class="bkt-check_color" check_color="main"
                      :border_color="model === 'main' ? 'main' : ''"
        >
        </bkt-checkbox>
        <bkt-checkbox v-model="model" val="primary" name="primary" type="radio"
                      class="bkt-check_color" check_color="primary"
                      :border_color="model === 'primary' ? 'primary' : ''"
        >
        </bkt-checkbox>
    </div>
</template>

<script>
    export default {
        name: "ColorPallet",
        props: {
            value: {
                type: String,
                default: 'yellow',
            },
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
        }
    }
</script>

<style scoped>

</style>
