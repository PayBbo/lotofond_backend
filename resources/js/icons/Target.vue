<template>
    <svg xmlns="http://www.w3.org/2000/svg" :width="width" :height="height" :class="'bkt-stroke bkt-stroke-'+color"
         viewBox="0 0 24 24" fill="none"
    >

        <circle cx="12" cy="12" r="9"
                stroke-width="2px"
                stroke-linecap="round" stroke-linejoin="round"
        />
        <line stroke-width="2px" x1="12" y1="1" x2="12" y2="7"/>
        <line stroke-width="2px" x1="12" y1="17" x2="12" y2="23"/>
        <line stroke-width="2px" x1="1" y1="12" x2="7" y2="12"/>
        <line stroke-width="2px" x1="17" y1="12" x2="23" y2="12"/>
        <line stroke-width="2px" x1="12" y1="12" x2="12" y2="12"/>
    </svg>
</template>

<script>
    export default {
        name: "Target",
        props: {
            color: {
                type: String,
                default: 'white'
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
