<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 24 24" stroke-width="2"
         stroke-linecap="round" stroke-linejoin="round" fill="none"
         :class="'bkt-stroke bkt-stroke-'+color" :width="width" :height="height"
    >
        <rect x="4" y="5" width="16" height="16" rx="2" />
        <line x1="16" y1="3" x2="16" y2="7" />
        <line x1="8" y1="3" x2="8" y2="7" />
        <line x1="4" y1="11" x2="20" y2="11" />
        <rect x="8" y="15" width="2" height="2" />
    </svg>
</template>

<script>
    export default {
        name: "CalendarEvent",
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
