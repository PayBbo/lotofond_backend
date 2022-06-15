<script>
    export default {
        name: "Icon",
        props: {
            name: String,
            fill: String,
            stroke: String,
            width: String,
            height: String,
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
