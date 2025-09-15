<template>
    <header class="">
        <nav class="bkt-navbar">
            <div class="bkt-container bkt-navbar__wrapper">
                <div class="bkt-navbar__logo flex-grow-1">
                    <a href="/">
                        <img class="bkt-navbar__logo" src="/images/logo.png" alt="Lotofond">
                    </a>
                </div>
                <ul class="bkt-navbar__nav d-none d-lg-flex">
                    <li class="bkt-navbar__nav-item">
                        <div @click="navigate('/favourites')" class="bkt-navbar__nav-link">
                            <span class="bkt-button-ellipse bkt-bg-body">
                                <bkt-icon :name="'Star'" :color="'yellow'"/>
                            </span>
                            Избранное
                        </div>
                    </li>
                    <li class="bkt-navbar__nav-item">
                        <div @click="navigate('/monitoring')" class="bkt-navbar__nav-link">
                            <span class="bkt-button-ellipse bkt-bg-body">
                                 <bkt-icon :name="'Target'" :color="'red'"/>
                            </span>
                            Мониторинг
                        </div>
                    </li>
                    <li class="bkt-navbar__nav-item">
                        <div @click="navigate('/messages')" class="bkt-navbar__nav-link">
                            <span class="bkt-button-ellipse bkt-bg-body">
                                <span class="info" v-if="hasNotSeenNotifications&&isLoggedIn"></span>
                                <bkt-icon :name="'Bell'" :color="'green'"/>
                            </span>
                            Сообщения
                        </div>
                    </li>
                </ul>
                <div class="bkt-wrapper bkt-nowrap mx-md-auto me-0 ms-auto">
                   <a class="bkt-button-icon" href="https://apps.apple.com/ru/app/lotofond/id6462861593"
                      target="_blank" rel="nofollow noopener">
                        <bkt-icon name="AppleStore" color="main"></bkt-icon>
                   </a>
<!--                    <a class="bkt-button-icon" href="https://play.google.com/store/apps/details?id=ru.lotofond"-->
<!--                       target="_blank" rel="nofollow noopener"-->
<!--                    >-->
<!--                        <bkt-icon name="GooglePlay" color="main"></bkt-icon>-->
<!--                    </a>-->
<!--                    <a class="bkt-button-icon" href="https://appgallery.huawei.ru/app/C107494421"-->
<!--                       target="_blank" rel="nofollow noopener"-->
<!--                    >-->
<!--                        <bkt-icon name="AppGallery" color="main"></bkt-icon>-->
<!--                    </a>-->
                    <a class="bkt-button-icon" href="https://apps.rustore.ru/app/ru.lotofond"
                       target="_blank" rel="nofollow noopener"
                    >
                        <bkt-icon name="Rustore" color="main"></bkt-icon>
                    </a>
                </div>

                <div v-if="isLoggedIn" class="btn-group d-none d-md-block">
                    <template v-if="!loading && !auth_user_loading">
                        <div class="bkt-navbar__user-wrapper"
                             id="navbarDropdown"
                             role="button"
                             data-bs-toggle="dropdown"
                             aria-haspopup="true"
                             aria-expanded="false"
                        >
                            <div class="bkt-navbar__user text-truncate me-1">
                                <div class="bkt-navbar__user-name text-truncate">
                                    {{ auth_user ? auth_user.name : '' }} {{ auth_user ? auth_user.lastName : '' }}
                                </div>
                                <div class="bkt-navbar__user-tariff">
                                    тариф:
                                    <span class="bkt-navbar__user-tariff-name">
                                        {{auth_user && auth_user.tariff ? auth_user.tariff.title  :'Базовый'}}
                                    </span>
                                </div>
                                <div class="bkt-navbar__user-tariff"
                                     v-if="auth_user && auth_user.tariff && auth_user.tariff.expiredAt"
                                >
                                    до:
                                    <span class="bkt-navbar__user-tariff-name">
                                        {{auth_user && auth_user.tariff ? auth_user.tariff.expiredAt  :''}}
                                    </span>
                                </div>
                            </div>
                            <div class="bkt-navbar__user-icon">
                                <bkt-icon :name="'ArrowDown'" color="primary"></bkt-icon>
                            </div>
                        </div>
                        <div class="dropdown-menu dropdown-menu-right bkt-navbar__user-dropdown"
                             aria-labelledby="navbarDropdown" v-if="!loading && !auth_user_loading">
                            <div class="bkt-navbar__user-dropdown-menu">
                                <a class="bkt-button bkt-tariff-button" href="/profile?tab=Tariff">
                                    Сменить тариф
                                </a>
                                <a class="bkt-navbar__user-dropdown-item" href="/profile">
                                    <div class="bkt-navbar__user-dropdown-item-icon bkt-bg-primary-lighter">
                                        <bkt-icon :name="'User'" :color="'primary'"></bkt-icon>
                                    </div>
                                    <div class="bkt-navbar__user-dropdown-item-text">Профиль</div>
                                </a>
                                <div class="bkt-navbar__user-dropdown-item" @click="logout" style="cursor: pointer">
                                    <div class="bkt-navbar__user-dropdown-item-icon bkt-bg-red-lighter">
                                        <bkt-icon name="LogOut"></bkt-icon>
                                    </div>
                                    <div class="bkt-navbar__user-dropdown-item-text">Выйти</div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="bkt-navbar__user-wrapper" role="button">
                            <div class="bkt-navbar__user text-truncate me-1 w-100">
                                <skeleton type_name="text" height="14px" skeleton_class="mb-1"></skeleton>
                                <skeleton type_name="text" height="12px" skeleton_class="mb-0"></skeleton>
                            </div>
                            <div class="bkt-navbar__user-icon">
                                <skeleton type_name="item" height="12px" width="10px"></skeleton>
                            </div>
                        </div>
                    </template>
                </div>
                <button v-else class="bkt-button primary d-none d-md-block"
                        data-bs-toggle="modal" data-bs-target="#authModal"
                >
                    Вход и регистрация
                </button>
            </div>
        </nav>
        <nav class="bkt-navbar white">
            <div class="bkt-navbar__wrapper bkt-wrapper-down-md-wrap bkt-container">
                <div class="bkt-wrapper bkt-nowrap bkt-gap-small order-last order-md-1 bkt-w-down-md-100">
                    <button @click="toInstruction" class="bkt-button bkt-text-white blue mx-0 bkt-navbar__ecp" title="инструкция работы сервиса">
                        Инструкция
                    </button>
                    <button @click="buyEgrn" class="bkt-button bkt-text-white blue mx-0 bkt-navbar__ecp" title="отчёт на любой кадастр">
                        Отчёт ЕГРН
                    </button>
                </div>
                <ul class="bkt-navbar__nav order-1 order-md-2">
                    <!--                    <li class="bkt-navbar__nav-item d-none d-lg-flex">-->
                    <!--                        <router-link to="/agent" class="bkt-navbar__nav-link">-->
                    <!--                            Купить через агента-->
                    <!--                        </router-link>-->
                    <!--                    </li>-->
                    <li class="bkt-navbar__nav-item">
                        <router-link to="/" class="bkt-navbar__nav-link">
                            Все торги
                        </router-link>
                    </li>
                    <li class="bkt-navbar__nav-item">
                        <router-link to="/auctions" class="bkt-navbar__nav-link">
                            <span class="bkt-navbar__nav-icon d-none d-sm-flex">
                                 <bkt-icon :name="'Fire'"/>
                            </span>
                            Горящие торги
                        </router-link>
                    </li>
                    <li class="bkt-navbar__nav-item d-none bkt-d-up-xsm-flex bkt-d-up-md-none bkt-d-up-lg-flex">
                        <router-link to="/week-winners" class="bkt-navbar__nav-link">
                            Победы недели
                        </router-link>
                    </li>
                    <li class="bkt-navbar__nav-item d-none d-sm-flex" v-if="isLoggedIn">
                        <router-link to="/registries" class="bkt-navbar__nav-link">
                            Реестры
                        </router-link>
                    </li>
                    <li class="bkt-navbar__nav-item d-none d-sm-flex" v-if="isLoggedIn">
                        <router-link to="/map" class="bkt-navbar__nav-link">
                            Карта
                        </router-link>
                    </li>
                    <li class="bkt-navbar__nav-item d-none d-lg-flex">
                        <router-link to="/contacts" class="bkt-navbar__nav-link">
                            Контакты
                        </router-link>
                    </li>
                    <li class="bkt-navbar__nav-item d-flex d-lg-none">
                        <router-link to="/tariffs" class="bkt-navbar__nav-link">
                            Тарифы
                        </router-link>
                    </li>
                </ul>
                <!--                <div class="bkt-navbar__wrapper d-none d-lg-flex">-->
                <!--&lt;!&ndash;                    <router-link custom to="/">&ndash;&gt;-->
                <!--&lt;!&ndash;                        <button class="bkt-button primary-lighter">&ndash;&gt;-->
                <!--&lt;!&ndash;                            Торги&ndash;&gt;-->
                <!--&lt;!&ndash;                        </button>&ndash;&gt;-->
                <!--&lt;!&ndash;                    </router-link>&ndash;&gt;-->
                <!--                    <router-link custom to="/tariffs">-->
                <!--                        <button class="bkt-button blue-lighter">-->
                <!--                            Тарифы-->
                <!--                        </button>-->
                <!--                    </router-link>-->

                <!--                </div>-->
                <div class="bkt-navbar__wrapper flex-grow-1 order-2 order-md-3">
                    <!--                    <button class="bkt-button red-outline d-none d-lg-flex">-->
                    <!--                        <span class="bkt-button__icon mx-2">-->
                    <!--                             <bkt-icon :name="'Law'" :width="'16px'" :height="'16px'"/>-->
                    <!--                        </span>-->
                    <!--                        Изменения в законах-->
                    <!--                    </button>-->
                    <router-link custom to="/tariffs" class=" w-100 bkt-button blue-lighter d-none d-lg-block">
                        Тарифы
                    </router-link>
                    <button class="bkt-button-ellipse my-0 ms-auto me-0 d-block d-lg-none" type="button"
                            data-bs-toggle="offcanvas"
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
                <a href="/">
                    <img class="logo" src="/images/logo.png" alt="logo">
                </a>
                <!--                <h4 class="offcanvas-title bkt-sidebar__title" id="offcanvasExampleLabel">LotoFond</h4>-->

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
                            v-if="!link.meta || (link.meta && isLoggedIn)"
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
                        <!--                        <div class="bkt-sidebar__user-image d-flex align-items-center" style="padding:14px;">-->
                        <!--                            <bkt-icon name="User" color="white" width="22px" height="22px"></bkt-icon>-->
                        <!--                        </div>-->
                        <div class="text-truncate me-1" v-if="!loading&&!auth_user_loading">
                            <div class="bkt-sidebar__user-name text-truncate">
                                {{ auth_user ? auth_user.name : '' }} {{ auth_user ? auth_user.lastName : '' }}
                            </div>
                            <div class="bkt-sidebar__user-tariff">
                                тариф: <span class="bkt-sidebar__user-tariff-name">
                                {{auth_user && auth_user.tariff ? auth_user.tariff.title  :'Базовый'}}</span>
                            </div>
                            <div class="bkt-sidebar__user-tariff">
                                истекает:
                                <span class="bkt-sidebar__user-tariff-name">
                                    {{auth_user && auth_user.tariff ? auth_user.tariff.expiredAt  :''}}
                                </span>
                            </div>
                        </div>
                        <div class="text-truncate me-1" v-else>
                            <skeleton type_name="text" height="14px" skeleton_class="mb-1"></skeleton>
                            <skeleton type_name="text" height="12px" skeleton_class="mb-1"></skeleton>
                            <skeleton type_name="text" height="12px" skeleton_class="mb-0"></skeleton>
                        </div>
                    </div>
                    <div class="bkt-sidebar__button" @click="logout" data-bs-dismiss="offcanvas">
                        <bkt-icon name="LogOut" color="white" width="20px" height="20px"></bkt-icon>
                    </div>
                </div>

                <button v-else class="bkt-button primary w-100" type="button" data-bs-dismiss="offcanvas"
                        @click="openModal">
                    Вход и регистрация
                </button>
            </div>
        </div>
        <bkt-auth-modal v-if="!isLoggedIn"></bkt-auth-modal>
        <bkt-code-modal v-if="!isLoggedIn"></bkt-code-modal>
        <bkt-reset-password-modal v-if="!isLoggedIn"></bkt-reset-password-modal>
        <bkt-reset-success-modal v-if="!isLoggedIn"></bkt-reset-success-modal>
        <bkt-egrn-modal/>
    </header>
</template>

<script>
    import BktResetPasswordModal from "../auth/ResetPasswordModal";
    import BktResetSuccessModal from "../auth/ResetSuccessModal";
    import BktEgrnModal from "./SharedModals/EgrnModal";

    export default {
        name: "Header",
        components: {
            BktResetPasswordModal,
            BktResetSuccessModal,
            BktEgrnModal
        },
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
                        path: '/favourites',
                        icon: 'Star',
                        code: "Favourites",
                        label: "Избранное",
                        color: 'yellow',
                        meta: 'auth'
                    },
                    {
                        path: '/monitoring',
                        icon: 'Target',
                        code: "Monitoring",
                        label: "Мониторинг",
                        color: 'red',
                        meta: 'auth'
                    },
                    {
                        path: '/messages',
                        icon: 'Bell',
                        code: "messages",
                        label: "Сообщения",
                        color: 'green',
                        meta: 'auth'
                    },
                    {
                        path: '/profile',
                        icon: 'User',
                        code: "Profile",
                        label: "Профиль",
                        color: 'primary',
                        meta: 'auth'
                    },
                    {
                        path: '/week-winners',
                        icon: 'Trophy',
                        code: "WeekWinners",
                        label: "Победы недели",
                        color: 'yellow',
                    },
                    // {
                    //     path: '/agent',
                    //     icon: 'Percentage',
                    //     code: "Agent",
                    //     label: "Купить через агента",
                    //     color: 'red'
                    // },
                    {
                        path: '/registries',
                        icon: 'Alignment',
                        code: "Registries",
                        label: "Реестры",
                        color: 'green',
                        meta: 'auth'
                    },
                    {
                        path: '/calendar',
                        icon: 'Date',
                        code: "Calendar",
                        label: "Календарь",
                        color: 'primary',
                        meta: 'auth'
                    },
                    {
                        path: '/contacts',
                        icon: 'Briefcase',
                        code: "Contacts",
                        label: "Контакты",
                        color: 'yellow',
                    },
                    {
                        path: '/map',
                        icon: 'Location',
                        code: "Map",
                        label: "Карта",
                        color: 'red',
                        meta: 'auth'
                    },
                ],
            }
        },
        computed: {
            auth_user() {
                return this.$store.getters.auth_user
            },
            auth_user_loading() {
                return this.$store.getters.auth_user_loading
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
            hasNotSeenNotifications() {
                return this.$store.getters.hasNotSeenNotifications;
            },
        },
        methods: {
            async logout() {
                this.loading = true;
                await this.$store.dispatch('logout').then(resp => {
                    this.loading = false;
                    if (this.$router.currentRoute.meta.auth) {
                        if (this.$router.currentRoute.name !== 'Main') {
                            this.$router.push('/')
                        }
                    }
                    this.$store.dispatch('saveDataProperty', {
                        module_key: 'auth',
                        key: 'auth_check.' + this.$router.currentRoute.name,
                        value: false
                    }, {root: true});
                }).catch(error => {
                    this.loading = false;
                })
            },
            openModal() {
                this.$store.commit('openModal', '#authModal');
            },
            navigate(path) {
                if (this.isLoggedIn) {
                    this.$router.push(path)
                } else {
                    this.$store.dispatch('sendAuthNotification', {self: this})
                }
            },
            checkNotifications() {
                this.$store.dispatch('checkNotifications')
            },
            toInstruction() {
                this.$store.commit('setSelectedLot', null);
                this.$router.push('/agent')
            },
            buyEgrn() {
                this.$store.commit('setSelectedItem', null);
                this.$store.commit('openModal', '#egrnModal')
            }
        }

    }
</script>

<style scoped>

</style>
