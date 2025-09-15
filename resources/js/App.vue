<template>
    <div>
        <notifications position="top right" classes="bkt-notification"/>
        <bkt-header></bkt-header>
        <main class="wrapper">
            <router-view :key="$route.fullPath" ref="view"></router-view>
            <cookie-consent/>
        </main>
        <bkt-footer></bkt-footer>
    </div>
</template>

<script>
    import axios from "axios";
    import CookieConsent from "./components/CookieConsent";

    export default {
        name: "App",
        components: {CookieConsent},
        created() {
            let callback = (val, oldVal, uri) => {
                if (val && !oldVal) {
                    this.$store.commit('auth_success',
                        {token: localStorage.getItem('token'), refreshToken: localStorage.getItem('refreshToken')});
                    this.getUser();
                } else if (!val && oldVal) {
                    this.$store.dispatch('simpleLogout', true);
                    if (this.$router.currentRoute.meta.auth) {
                        if (this.$router.currentRoute.name !== 'Main') {
                            this.$router.push('/')
                        }
                    }
                }
                this.$nextTick(() => {
                    if(this.$refs.view.getData) {
                        this.$refs.view.getData(1)
                    }
                })
            };
            Vue.ls.on('token', callback);
            this.getUser();
        },
        mounted() {
            this.$store.dispatch('getContacts');
            this.$store.dispatch('getInformationMessage');
            localStorage.removeItem('is_tg_bot');
            delete axios.defaults.headers.common['TGBot'];
        },
        computed: {
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
        methods: {
            async getUser() {
                if (this.isLoggedIn) {
                    await this.$store.dispatch('getAuthUser').then(resp => {
                    }).catch(error => {
                    })
                } else {
                    await this.$store.dispatch('getRules')
                }
            }
        }
    }
</script>

<style scoped>

</style>
