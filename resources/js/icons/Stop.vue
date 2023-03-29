<template>
    <svg viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg"
         :width="width" :height="height" :class="'bkt-stroke bkt-stroke-'+color"
    >
        <path d="M14.6541 3.84619L3.34593 15.1543M8.99999 17.6421C13.4966 17.6421 17.1418 13.9969 17.1418 9.50025C17.1418 5.00363 13.4966 1.3584 8.99999 1.3584C4.50334 1.3584 0.858137 5.00363 0.858137 9.50025C0.858137 13.9969 4.50334 17.6421 8.99999 17.6421Z"
              stroke-width="1.28625" stroke-linecap="round" stroke-linejoin="round"
        />
    </svg>
</template>

<script>
    export default {
        name: "Stop",
        props: {
            color: {
                type: String,
                default: 'red'
            },
            width: {
                type: String,
                default: '18px'
            },
            height: {
                type: String,
                default: '19px'
            },
        }
    }
</script>

<style scoped>

</style>
