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
                <div class="bkt-sidebar__footer">
                    <div v-if="isLoggedIn" class="bkt-sidebar__user">
                        <div class="bkt-sidebar__profile">
                            <div class="text-truncate me-1" v-if="!loading&&!auth_user_loading">
                                <div class="bkt-sidebar__user-tariff">
                                    тариф: <span class="bkt-sidebar__user-tariff-name">
                                {{auth_user && auth_user.botTariff ? auth_user.botTariff.title  :'Базовый'}}</span>
                                </div>
                                <div class="bkt-sidebar__user-tariff">
                                    истекает:
                                    <span class="bkt-sidebar__user-tariff-name">
                                    {{auth_user && auth_user.botTariff ? auth_user.botTariff.expiredAt  :''}}
                                </span>
                                </div>
                            </div>
                            <div class="text-truncate me-1" v-else>
                                <skeleton type_name="text" height="14px" skeleton_class="mb-1"/>
                                <skeleton type_name="text" height="12px" skeleton_class="mb-1"/>
                                <skeleton type_name="text" height="12px" skeleton_class="mb-0"/>
                            </div>
                        </div>
                        <div class="bkt-sidebar__button" @click="logout" data-bs-dismiss="offcanvas">
                            <bkt-icon name="LogOut" color="white" width="20px" height="20px"/>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div v-if="!loading && !auth_user_loading">
            <template v-if="!isLoggedIn">
                <auth-page/>
            </template>
            <template v-else-if="!user_filters_exist">
                <filters-page/>
            </template>
            <template v-else>
                <router-view :key="$route.fullPath" :type="'bot'"/>
                <bkt-egrn-modal v-if="isLoggedIn"/>
            </template>
        </div>
        <div v-else class="d-flex w-100 justify-content-center mb-5">
            <div
                style="color: #2953ff;border-width: 2px;"
                class="spinner-border"
                role="status"
            ></div>
        </div>
    </div>
</template>

<script>
    import BktEgrnModal from "../components/SharedModals/EgrnModal";
    import AuthPage from "./AuthPage";
    import FiltersPage from "./FiltersPage";
    import axios from "axios";

    export default {
        name: "Layout",
        components: {
            BktEgrnModal,AuthPage, FiltersPage
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
            this.tg.expand();
            localStorage.setItem('is_tg_bot', 1);
            axios.defaults.headers.common['TGBot'] = 'is_tg_bot';
            this.getUser();
        },
        mounted() {

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
                return this.tg.colorScheme ? this.tg.colorScheme : ''
            },
            auth_user() {
                return this.$store.getters.auth_user;
            },
            auth_user_loading() {
                return this.$store.getters.auth_user_loading;
            },
            user_filters_exist() {
                return this.$store.getters.user_filters_exist;
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
                this.loading = true;
                if (this.isLoggedIn) {
                    await this.$store.dispatch('getAuthUser')
                        .then(resp => {
                            this.loading = false;
                            this.getUserFilters();
                        })
                        .catch(error => {
                            this.loading = false;
                        })
                } else {
                    await this.$store.dispatch('getRules')
                        .then(resp => {
                            this.loading = false;
                        })
                        .catch(error => {
                            this.loading = false;
                        })
                }
            },
            async logout() {
                this.loading = true;
                await this.$store.dispatch('logout').then(resp => {
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
                })
            },
            async getUserFilters() {
                this.loading = true;
                await this.$store.dispatch('getUserFilters').then(resp => {
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
                });
            }
        },
        destroyed() {
            localStorage.removeItem('is_tg_bot');
            delete axios.defaults.headers.common['TGBot'];
        }
    }
</script>

<style scoped>

</style>
