<template>
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 30 30"
         :class="'bkt-stroke bkt-stroke-'+color"
         :width="width" :height="height" fill="none"
    >
        <path stroke-width="3" stroke-linejoin="round" stroke-miterlimit="10" d="M29,16c0,0-5.8,8-13,8S3,16,3,16s5.8-8,13-8S29,16,29,16z"/>
        <circle stroke-width="3" stroke-linejoin="round" stroke-miterlimit="10" cx="16" cy="16" r="4"/>
</svg>

</template>

<script>
    export default {
        name: "Eye",
        props: {
            color:{
                type:String,
                default:'white'
            },
            width:{
                type:String,
                default:'100%'
            },
            height:{
                type:String,
                default:'100%'
            },
        }
    }
</script>

<style scoped>

</style>
