<script>
    export default {
        name: "Icon",
        props: {
            name: String,
            width: String,
            height: String,
            color: String,
        },

        data() {
            return {

            }
        },

        computed: {
            icon() {
                return () => import('../icons/'+this.name+'.vue')
            }
        }
    }
</script>

<template>
    <component v-if="name" v-bind:is="icon" v-bind="$props"></component>
</template>
<style scoped>

</style>
