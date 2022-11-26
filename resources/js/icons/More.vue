<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
         :width="width" :height="height"
         :class="'bkt-fill bkt-fill-'+color+' bkt-stroke bkt-stroke-'+color" stroke-width="2"
         stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="1"></circle>
        <circle cx="19" cy="12" r="1"></circle>
        <circle cx="5" cy="12" r="1"></circle>
    </svg>
</template>

<script>
    export default {
        name: "More",
        props: {
            color: {
                type: String,
                default: 'primary'
            },
            width: {
                type: String,
                default: '100%'
            },
            height: {
                type: String,
                default: '100%'
            },
        }
    }
</script>

<style scoped>

</style>
