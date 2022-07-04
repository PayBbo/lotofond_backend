<template>
    <div>
        <notifications position="top right"/>
        <bkt-header></bkt-header>
        <main>
            <router-view></router-view>
        </main>
        <bkt-footer></bkt-footer>
    </div>
</template>

<script>
    export default {
        name: "App",
    }
</script>

<style scoped>

</style>
