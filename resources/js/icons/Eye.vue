<template>
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
         viewBox="2 2 34 30"
         :fill="fill" :stroke="stroke"
         :width="width" :height="height"
    >
        <path stroke-width="2" stroke-linejoin="round" stroke-miterlimit="10" d="M29,16c0,0-5.8,8-13,8S3,16,3,16s5.8-8,13-8S29,16,29,16z"/>
        <circle stroke-width="2" stroke-linejoin="round" stroke-miterlimit="10" cx="16" cy="16" r="4"/>
</svg>

</template>

<script>
    export default {
        name: "Eye",
        props: {
            fill:{
                type:String,
                default:'none'
            },
            stroke:{
                type:String,
                default:'#fff'
            },
            width:{
                type:String,
                default:'100%'
            },
            height:{
                type:String,
                default:'18px'
            },
        }
    }
</script>

<style scoped>

</style>
