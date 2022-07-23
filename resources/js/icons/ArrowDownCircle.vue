<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         :class="'bkt-stroke bkt-stroke-'+color" :width="width" :height="height" fill="none"
         viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
    >
        <circle cx="12" cy="12" r="9"/>
        <line x1="8" y1="12" x2="12" y2="16"/>
        <line x1="12" y1="8" x2="12" y2="16"/>
        <line x1="16" y1="12" x2="12" y2="16"/>
    </svg>
</template>

<script>
    export default {
        name: "ArrowDownCircle",
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
