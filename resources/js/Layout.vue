<template>
    <div id="app">
        <component :is="layout">
            <router-view/>
        </component>
    </div>
</template>

<script>
export default {
    name: "Layout",
    computed: {
        layout() {
            if(window.location.href.includes('/admin')){
                return this.$route.meta.layout
            }else{
                return 'App'
            }
        }
    }
}
</script>

<style scoped>

</style>
