<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :fill="fill" :stroke="stroke" stroke-width="2"
         stroke-linecap="round" stroke-linejoin="round" :width="width" :height="height">
        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
    </svg>
</template>

<script>
    export default {
        name: "Bookmark",
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
                default:'22px'
            },
            height:{
                type:String,
                default:'22px'
            },
        }
    }
</script>

<style scoped>

</style>
