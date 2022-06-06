<template>
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         x="0px" y="0px"
         viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;"
         xml:space="preserve"
         :width="width" :height="height"

    >
        <path class="st0" :stroke="stroke"
              d="M22,13v-3c0-3.3-2.7-6-6-6h0c-3.3,0-6,2.7-6,6v3h0c-2.8,0-5,2.2-5,5v0c0,2.8,2.2,5,5,5h12c2.8,0,5-2.2,5-5v0 C27,15.2,24.8,13,22,13L22,13z"/>
        <path class="st0" :stroke="stroke" d="M16,30v-8.7c0-1.4-0.7-2.8-1.9-3.6l0,0c-0.7-0.5-1.5-0.7-2.4-0.7H10"/>
        <line class="st0" :stroke="stroke" x1="16" y1="9" x2="16" y2="19"/>
        <path class="st0" :stroke="stroke" d="M16,20h0.4c2.3,0,4.4-1.1,5.6-3l0,0"/>
</svg>
</template>

<script>
    export default {
        name: "Tree",
        props: {
            fill: {
                type: String,
                default: 'none'
            },
            stroke: {
                type: String,
                default: '#2fbb40'
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
    .st0 {
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-miterlimit: 10;
    }
</style>
