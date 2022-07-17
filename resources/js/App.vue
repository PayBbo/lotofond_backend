<template>
    <div>
        <notifications position="top right" classes="bkt-notification"/>
        <bkt-header></bkt-header>
        <main>
            <router-view></router-view>
        </main>
        <bkt-footer></bkt-footer>
        <bkt-move-favourite-modal :ref="'moveFavouriteModal'"></bkt-move-favourite-modal>
    </div>
</template>

<script>
    import MoveFavouriteModal from "./pages/Favourites/MoveFavouriteModal";
    export default {
        name: "App",
        components: {
            'bkt-move-favourite-modal': MoveFavouriteModal,
        }
    }
</script>

<style scoped>

</style>
