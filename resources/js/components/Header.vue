<template>
    <header class="">
        <nav class="bkt-navbar">
            <div class="bkt-container bkt-navbar__wrapper">
                <router-link :to="'/without-ecp'">
                    <button class="bkt-button blue">
                        Покупка без ЭЦП
                    </button>
                </router-link>

                <ul class="bkt-navbar__nav d-none d-lg-flex">
                    <li class="bkt-navbar__nav-item">
                        <router-link to="/favourites" class="bkt-navbar__nav-link">
                            <span class="bkt-button-ellipse main">
                                <bkt-icon :name="'Star'" :color="'yellow'"/>
                            </span>
                            Топ-Избранное
                        </router-link>
                    </li>
                    <li class="bkt-navbar__nav-item">
                        <router-link to="/monitoring" class="bkt-navbar__nav-link">
                    <span class="bkt-button-ellipse main">
                         <bkt-icon :name="'Target'" :color="'red'"/>
                    </span>
                            Мониторинг
                        </router-link>
                    </li>
                    <li class="bkt-navbar__nav-item">
                        <router-link to="/messages" class="bkt-navbar__nav-link">
                    <span class="bkt-button-ellipse main">
                        <span class="info"></span>
                        <bkt-icon :name="'Bell'" :color="'green'"/>
                    </span>
                            Сообщения
                        </router-link>
                    </li>
                </ul>
                <button class="bkt-button primary">
                    Приложение
                </button>

                <div v-if="isLoggedIn" class="btn-group d-none d-md-block">
                    <div class="bkt-navbar__user-wrapper"
                         id="navbarDropdown"
                         role="button"
                         data-bs-toggle="dropdown"
                         aria-haspopup="true"
                         aria-expanded="false">

                        <div class="bkt-navbar__user text-truncate me-1">
                            <div class="bkt-navbar__user-name text-truncate">
                                {{ auth_user ? auth_user.name : '' }} {{ auth_user ? auth_user.surname : '' }}
                            </div>
                            <div class="bkt-navbar__user-tarif">
                                тариф: <span class="bkt-navbar__user-tarif-name">Базовый</span>
                            </div>
                        </div>
                        <div class="bkt-navbar__user-icon">
                            <bkt-icon :name="'ArrowDown'"></bkt-icon>
                        </div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right bkt-navbar__user-dropdown"
                         aria-labelledby="navbarDropdown">
                        <div class="bkt-navbar__user-dropdown-menu">
                            <button class="bkt-button bkt-tarif-button">Сменить тариф</button>
                            <div class="bkt-navbar__user-dropdown-item">
                                <div class="bkt-navbar__user-dropdown-item-icon bkt-bg-primary-lighter">
                                    <bkt-icon :name="'User'" :color="'primary'"></bkt-icon>
                                </div>
                                <a class="bkt-navbar__user-dropdown-item-text" href="/profile">Профиль</a>
                            </div>
                            <div class="bkt-navbar__user-dropdown-item" @click="logout" style="cursor: pointer">
                                <div class="bkt-navbar__user-dropdown-item-icon bkt-bg-red-lighter">
                                    <bkt-icon name="LogOut"></bkt-icon>
                                </div>
                                <div class="bkt-navbar__user-dropdown-item-text">Выйти</div>
                            </div>
                        </div>

                    </div>
                </div>
                <button v-else class="bkt-button primary-outline d-none d-md-block"
                        data-bs-toggle="modal" data-bs-target="#authModal"
                >
                    Вход и регистрация
                </button>
            </div>
        </nav>
        <nav class="bkt-navbar white">
            <div class="bkt-navbar__wrapper bkt-container">
                <div class="bkt-navbar__wrapper d-none d-lg-flex">
                    <router-link custom to="/auctions">
                        <button class="bkt-button primary-lighter">
                            Торги
                        </button>
                    </router-link>
                    <router-link custom to="/tariffs">
                        <button class="bkt-button blue-lighter">
                            Тарифы
                        </button>
                    </router-link>

                </div>
                <div class="bkt-navbar__logo d-flex d-lg-none">
                    LOGO
                </div>
                <ul class="bkt-navbar__nav">
                    <li class="bkt-navbar__nav-item d-none d-lg-flex">
                        <a class="bkt-navbar__nav-link" href="/agent">Купить через агента</a>
                    </li>
                    <li class="bkt-navbar__nav-item">
                        <a class="bkt-navbar__nav-link" href="#">
                    <span class="bkt-navbar__nav-icon">
                         <bkt-icon :name="'Fire'" :width="'22px'" :height="'22px'"/>
                    </span>
                            Горящие торги
                        </a>
                    </li>
                    <li class="bkt-navbar__nav-item d-none d-md-flex">
                        <a class="bkt-navbar__nav-link" href="/top-wins">Топ-побед</a>
                    </li>
                    <li class="bkt-navbar__nav-item d-none d-md-flex">
                        <a class="bkt-navbar__nav-link" href="/registries">Реестры</a>
                    </li>
                    <li class="bkt-navbar__nav-item d-none d-lg-flex">
                        <a class="bkt-navbar__nav-link" href="/contacts">Контакты</a>
                    </li>
                    <li class="bkt-navbar__nav-item d-flex d-lg-none">
                        <a class="bkt-navbar__nav-link" href="/tariffs">Тарифы</a>
                    </li>
                </ul>
                <div class="bkt-navbar__wrapper">
                    <button class="bkt-button red-outline d-none d-lg-flex">
                    <span class="bkt-button__icon mx-2">
                         <bkt-icon :name="'Law'" :width="'16px'" :height="'16px'"/>
                    </span>
                        Изменения в законах
                    </button>
                    <button class="bkt-button-ellipse m-0 d-flex d-lg-none" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasExample"
                    >
                        <span class="bkt-button__icon">
                             <bkt-icon :name="'Menu'"/>
                        </span>
                    </button>
                </div>
            </div>
        </nav>
        <div class="offcanvas offcanvas-start bkt-sidebar" tabindex="-1" id="offcanvasExample"
             aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header bkt-sidebar__header">
                <h4 class="offcanvas-title bkt-sidebar__title" id="offcanvasExampleLabel">LotoFond</h4>
                <button type="button" class="bkt-button bkt-sidebar__button" data-bs-dismiss="offcanvas"
                        aria-label="Close">
                    <bkt-icon :name="'Cancel'" :width="'13px'" :height="'13px'" color="white"></bkt-icon>
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
                        <img src="" alt="">
                        <div class="bkt-navbar__user text-truncate me-1">
                            <div class="bkt-navbar__user-name text-truncate">
                                {{ auth_user ? auth_user.name : '' }} {{ auth_user ? auth_user.surname : '' }}
                            </div>
                            <div class="bkt-navbar__user-tarif">
                                тариф: <span class="bkt-navbar__user-tarif-name">Базовый</span>
                            </div>
                        </div>
                    </div>
                    <div class="bkt-sidebar__button" @click="logout" data-bs-dismiss="offcanvas">
                        <bkt-icon name="LogOut" color="white"></bkt-icon>
                    </div>
                </div>

                <button v-else class="bkt-button primary w-100" type="button" data-bs-dismiss="offcanvas"
                        @click="openModal">
                    Вход и регистрация
                </button>
            </div>
        </div>
        <bkt-auth-modal></bkt-auth-modal>
        <bkt-code-modal></bkt-code-modal>
    </header>
</template>

<script>
export default {
    name: "Header",
    data() {
        return {
            loading: false,
            links: [
                {
                    path: '/',
                    icon: 'Home',
                    code: "Main",
                    label: "Главная",
                    color: 'primary',
                },
                {
                    path: '/agent',
                    icon: 'Target',
                    code: "Agent",
                    label: "Купить через агента",
                    color: 'red'
                },
                {
                    path: '/registries',
                    icon: 'Alignment',
                    code: "Registries",
                    label: "Реестры",
                    color: 'green',
                },
                {
                    path: '/top-wins',
                    icon: 'Star',
                    code: "TopWins",
                    label: "Топ-побед",
                    color: 'yellow',
                },
                {
                    path: '/contacts',
                    icon: 'Briefcase',
                    code: "Contacts",
                    label: "Контакты",
                    color: 'blue',
                },
                {
                    path: '/profile',
                    icon: 'User',
                    code: "Profile",
                    label: "Профиль",
                    color: 'primary',
                    meta: 'auth'
                },
            ],
        }
    },
    computed: {
        auth_user() {
            return this.$store.getters.auth_user
        },
        isLoggedIn() {
            return this.$store.getters.isLoggedIn
        },
    },
    created() {
        this.getUser();
    },
    methods: {
        async getUser() {
            if (this.isLoggedIn) {
                this.loading = true;
                await this.$store.dispatch('getAuthUser').then(resp => {
                    this.loading = false;
                }).catch(error => {
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
        openModal() {
            this.$store.commit('openModal', '#authModal');
        }
    }

}
</script>

<style scoped>

</style>
