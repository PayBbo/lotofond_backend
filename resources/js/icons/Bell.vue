<template>
    <svg xmlns="http://www.w3.org/2000/svg" :stroke="stroke" :width="width" :height="height" viewBox="0 0 24 24">
        <path :fill="fill" d="M22,19H21V11a9,9,0,0,0-8-8.94V1a1,1,0,0,0-2,0V2.06A9,9,0,0,0,3,11v8H2a1,1,0,0,0,0,2H8.14a4,4,0,0,0,7.72,0H22a1,1,0,0,0,0-2ZM12,22a2,2,0,0,1-1.72-1h3.44A2,2,0,0,1,12,22ZM5,19V11a7,7,0,0,1,14,0v8Z"/>
    </svg>
</template>

<script lang="js">
    export default {
        name: "Bell",
        props: {
            fill:{
                type:String,
                default:'#fff'
            },
            stroke:{
                type:String,
                default:'none'
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

<style lang="scss" scoped>

</style>
