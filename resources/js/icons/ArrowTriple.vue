<template>
    <svg :width="width" :height="height" fill="none"
         :class="'bkt-stroke-'+color" viewBox="0 0 15 21" xmlns="http://www.w3.org/2000/svg">
        <path d="M13.0303 19.1665L7.76479 13.901L2.49931 19.1665" stroke-width="3.05554" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M13.0303 13.0908L7.76479 7.82534L2.49931 13.0908" stroke-width="3.05554" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M13.0303 7.01562L7.76479 1.75014L2.49931 7.01562" stroke-width="3.05554" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</template>

<script>
    export default {
        name: "ArrowTriple",
        props: {
            color: {
                type: String,
                default: 'yellow'
            },
            width: {
                type: String,
                default: '10px'
            },
            height: {
                type: String,
                default: '12px'
            },
        }
    }
</script>

<style scoped>

</style>
