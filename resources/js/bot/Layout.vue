<template>
    <div class="bkt-bot" :class="colorScheme">
        <notifications position="top right" classes="bkt-notification"/>
        <header class="bkt-bot__header">
            <nav class="bkt-navbar">
                <div class="bkt-container bkt-navbar__wrapper">
                    <div class="bkt-navbar__logo flex-grow-1">
                        <a href="/bot">
                            <img class="bkt-navbar__logo" src="/images/logo.png" alt="Lotofond">
                        </a>
                    </div>
                    <button class="bkt-button-ellipse my-0 ms-auto me-0" type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasExample"
                            v-if="isLoggedIn"
                    >
                        <span class="bkt-button__icon">
                             <bkt-icon :name="'Menu'"/>
                        </span>
                    </button>
                </div>
            </nav>
            <div class="offcanvas offcanvas-start bkt-sidebar" tabindex="-1" id="offcanvasExample"
                 aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header bkt-sidebar__header">
                    <a href="/bot">
                        <img class="logo" src="/images/logo.png" alt="logo">
                    </a>
                    <button type="button" class="bkt-button bkt-sidebar__button" data-bs-dismiss="offcanvas"
                            aria-label="Close">
                        <bkt-icon :name="'Cancel'" :width="'13px'" :height="'13px'" color="white"/>
                    </button>
                </div>
                <div class="offcanvas-body bkt-sidebar__body">
                    <ul class="bkt-sidebar__links">
                        <template v-for="(link, index) in links">
                            <router-link
                                :to="link.path"
                                custom
                                v-slot="{navigate, isExactActive }"
                            >
                                <li class="bkt-sidebar__link" @click="navigate"
                                    :class="[isExactActive ? 'bkt-bg-'+link.color+'-lighter' : '']"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <div class="bkt-sidebar__link-icon"
                                         :class="[isExactActive ? 'bkt-bg-'+link.color : 'bkt-bg-'+link.color+'-lighter',
                                     isExactActive && 'router-link-exact-active', 'bkt-hover'+link.color+'-lighter']"
                                    >
                                        <bkt-icon :name="link.icon"
                                                  :color="isExactActive ? 'white' : link.color"></bkt-icon>
                                    </div>
                                    <div class="bkt-sidebar__link-label">{{ link.label }}</div>
                                </li>
                            </router-link>
                        </template>
                    </ul>
                </div>
            </div>
        </header>
        <template v-if="!isLoggedIn">
            <auth-page/>
        </template>
        <template v-else>
            <router-view :key="$route.fullPath" :type="'bot'"/>
            <bkt-egrn-modal v-if="isLoggedIn"/>
        </template>
    </div>
</template>

<script>
    import BktEgrnModal from "../components/SharedModals/EgrnModal";
    import AuthPage from "./AuthPage";

    export default {
        name: "Layout",
        components: {
            BktEgrnModal,AuthPage
        },
        data() {
            return {
                loading: false,
                links: [
                    {
                        path: '/bot/',
                        icon: 'Home',
                        code: "Main",
                        label: "Лоты",
                        color: 'primary',
                        meta: 'auth'
                    },
                    {
                        path: '/bot/tariffs',
                        icon: 'Star',
                        code: "subscribe",
                        label: "Купить подписку",
                        color: 'primary',
                    },
                ],
            }
        },
        created() {
            localStorage.setItem('is_tg_bot', 1)
        },
        mounted() {
            let test_tg = window.Telegram.WebApp;
            console.log('test_tg', test_tg);
            this.tg.expand();
            console.log('tgUser', this.tgUser)
            this.getUser();
        },
        computed: {
            tg() {
                return window.Telegram.WebApp;
            },
            tgUser() {
                const urlParams = new URLSearchParams(this.tg.initData);
                return JSON.parse(urlParams.get('user'));
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
            colorScheme() {
            }
        },
        methods: {
            openLink(url) {
                this.tg.openLink(url, {
                    try_instant_view: true
                })
            },
            closeShop() {
                this.tg.close()
            },
            async getUser() {
                if (this.isLoggedIn) {
                    await this.$store.dispatch('getAuthUser')
                        .then(resp => {
                        }).catch(error => {
                        })
                } else {
                    await this.$store.dispatch('getRules')
                }
            }
        },
        destroyed() {
            localStorage.removeItem('is_tg_bot')
        }
    }
</script>

<style scoped>

</style>
