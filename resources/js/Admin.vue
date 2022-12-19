<template>
    <fragment>
        <navbar/>
        <sidebar/>
        <main class="content-wrapper">
            <router-view></router-view>
        </main>
    </fragment>
</template>

<script>
import Navbar from "./admin/Navbar";
import Sidebar from "./admin/Sidebar";

export default {
    name: "Admin",
    components: {Sidebar, Navbar}
}
</script>

<style scoped>

</style>
