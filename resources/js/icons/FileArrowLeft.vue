<template>
    <svg xmlns="http://www.w3.org/2000/svg" :class="'bkt-stroke bkt-stroke-'+color" :width="width" :height="height"
         viewBox="0 0 14 20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none">
        <path d="M14,3V7a.9.9,0,0,0,1,1h4" transform="translate(-4 -2)"/>
        <path d="M17,21H7a2,2,0,0,1-2-2V5A2,2,0,0,1,7,3h7l5,5V19A2,2,0,0,1,17,21Z" transform="translate(-4 -2)"/>
        <path d="M15,15H9" transform="translate(-4 -2)"/>
        <path d="M11.5,17.5,9,15l2.5-2.5" transform="translate(-4 -2)"/>
    </svg>
</template>

<script>
    export default {
        name: "FileArrowLeft",
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
