<template>
    <div>
        <notifications position="top right" classes="bkt-notification"/>
        <bkt-header></bkt-header>
        <main class="wrapper">
            <router-view></router-view>
        </main>
        <bkt-footer></bkt-footer>
        <bkt-move-favourite-modal :ref="'moveFavouriteModal'" v-if="isLoggedIn"></bkt-move-favourite-modal>
        <bkt-note-modal></bkt-note-modal>
        <bkt-application-modal></bkt-application-modal>
    </div>
</template>

<script>
    import MoveFavouriteModal from "./pages/Favourites/MoveFavouriteModal";
    import NoteModal from "./components/SharedModals/NoteModal";
    import BktApplicationModal from "./components/SharedModals/ApplicationModal";
    export default {
        name: "App",
        components: {
            'bkt-move-favourite-modal': MoveFavouriteModal,
            'bkt-note-modal': NoteModal,  BktApplicationModal
        },
        computed: {
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
    }
</script>

<style scoped>

</style>
