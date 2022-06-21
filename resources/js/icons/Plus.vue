<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 298.6 298.8" :width="width" :height="height"
         :class="'bkt-fill-'+color"
    >
        <path
            d="M379.8,422.2h-6.7c-33,0-66,.1-99,0-12.3,0-21.4-7.9-22.2-19.1-1-13.2,8-23.2,21.5-23.3,24.6-.2,49.3,0,74,0,10.4-.1,20.9,0,32.4,0v-6.1c0-33.3-.1-66.6,0-99.9.1-16.3,15.4-26.7,29.7-20.3,9,4.1,12.8,11.4,12.8,21.2q-.2,49.4-.1,98.5v6.6c2.5,0,4.5-.1,6.4,0,33.3,0,66.7-.2,100,0,15.9.1,26.2,15.4,19.9,29.6-4,9-11.3,12.9-21.1,12.9H422.2c0,2.5.1,4.4,0,6.3,0,33.3.2,66.7,0,100-.1,16.6-16.5,26.9-30.8,19.5-8.2-4.3-11.7-11.3-11.7-20.5.1-32.8.1-65.7.1-98.5Z"
            transform="translate(-251.8 -251.6)"/>
    </svg>
</template>

<script>
    export default {
        name: "Plus",
        props: {
            color: {
                type: String,
                default: 'white'
            },
            width: {
                type: String,
                default: '22px'
            },
            height: {
                type: String,
                default: '22px'
            },
        }
    }
</script>

<style scoped>

</style>
