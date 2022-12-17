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

<style lang="scss">
.bkt-input__wrapper {
    background-color: #fff;
    border: 1px solid #ced4da;
    padding: 4px 8px;
    border-radius: 25px;
    .bkt-datepicker {
        .bkt-input-wrapper {
            padding: 0;
            border-radius: 0;
            background-color: #fff;
            .bkt-input {
                padding: 4px 16px;
                background-color: #fff;
            }
            .bkt-datepicker-group {
                width: 30px;
                min-height: 30px;
            }
            .bkt-datepicker-group-icon {
                max-width: 15px;
                max-height: 15px;
            }
            .bkt-icon-calendar, .bkt-icon-clear {
                cursor: pointer;
            }
        }
    }
    & + .input-group-append {
        background: #FFFFFF;
        border: 1px solid #ced4da;
        .btn:hover, .btn:active {
            border: 1px solid #ced4da;
        }
    }
}

</style>
