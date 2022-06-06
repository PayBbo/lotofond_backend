<template>
    <svg xmlns="http://www.w3.org/2000/svg" :width="width" :height="height" viewBox="0 0 24 24">
        <g>
            <circle cx="12" cy="12" r="9"
                    :stroke="stroke" stroke-width="2px" :fill="fill"
                    stroke-linecap="round" stroke-linejoin="round"
            />
            <line :stroke="stroke" stroke-width="2px" x1="12" y1="1" x2="12" y2="7"/>
            <line :stroke="stroke" stroke-width="2px" x1="12" y1="17" x2="12" y2="23"/>
            <line :stroke="stroke" stroke-width="2px" x1="1" y1="12" x2="7" y2="12"/>
            <line :stroke="stroke" stroke-width="2px" x1="17" y1="12" x2="23" y2="12"/>
            <line :stroke="stroke" stroke-width="2px" x1="12" y1="12" x2="12" y2="12"/>
        </g>
    </svg>
</template>

<script>
    export default {
        name: "Target",
        props: {
            fill:{
                type:String,
                default:'none'
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

<style scoped>

</style>
