<template>
    <div>
        <notifications position="top right" classes="bkt-notification"/>
        <bkt-header></bkt-header>
        <main class="wrapper">
            <router-view></router-view>
        </main>
        <bkt-footer></bkt-footer>
    </div>
</template>

<script>
    export default {
        name: "App",
        computed: {
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
    }
</script>

<style scoped>

</style>
