<template>
    <div class="container bkt-page bkt-profile bkt-container">
        <h1 class="bkt-page__title d-md-none">
            Профиль
            <bkt-icon v-if="isLoggedIn" class="ms-1" name="LogOut" color="red" width="16px" height="16px"></bkt-icon>
        </h1>

        <div v-if="isLoggedIn && !user_loading" class="bkt-form wide bkt-profile-gap">
            <div class="col-12 col-lg-3 bkt-form__offset-right">
                <div class="bkt-wrapper-sm-column bkt-wrapper-column-reverse bkt-profile-gap">
                    <div class="bkt-card bkt-card__body bkt-sidebar">
                        <ul class="bkt-sidebar__links">
                            <li class="bkt-sidebar__link" v-for="link in links"
                                :class="[tab==link.code ? 'bkt-bg-'+link.color+'-lighter' : '']"
                                @click="navigate(link)"
                            >
                                <div class="bkt-sidebar__link-icon"
                                     :class="[tab==link.code ? 'bkt-bg-'+link.color : 'bkt-bg-'+link.color+'-lighter']"
                                >
                                    <bkt-icon :name="link.icon"
                                              :color="tab==link.code ? 'white' : link.color"></bkt-icon>
                                </div>
                                <div class="bkt-sidebar__link-label">{{link.label}}</div>
                            </li>
                        </ul>
                    </div>
                    <div class="bkt-profile-tariff-wrapper">
                        <div class="bkt-card bkt-bg-primary bkt-profile-tariff">
                            <h5 class="d-sm-none me-auto">{{user ? user.name+' '+user.lastName : ''}}</h5>
                            <div class="bkt-wrapper-between bkt-wrapper-sm-column">
                                <h6 class="bkt-card__subtitle">тарифный план</h6>
                                <h5 class="bkt-card__title">{{user.tariff ? user.tariff.title  :'Базовый'}}</h5>
                            </div>
                            <a class="bkt-button bkt-tariff-button" href="/tariff">
                                Сменить тариф
                            </a>
                            <div class="bkt-card bkt-card__background-figure-1">
                            </div>
                            <div class="bkt-card bkt-card__background-figure-2 bkt-bg-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-0 col-12 col-lg-9">
                <component :is="tab+'Tab'"></component>
            </div>
        </div>
        <div v-if="!isLoggedIn && !user_loading" class="bkt-shadow-card bkt-shadow-card_primary">
            <div class="bkt-shadow-card__inner bkt-gap-large">
                <h5 class="bkt-card__title bkt-text-white">Войдите или зарегистрируйтесь</h5>
                <button class="bkt-button bkt-bg-white bkt-text-primary mx-auto" style="max-width: 320px"
                        data-bs-toggle="modal" data-bs-target="#authModal"
                >
                    Вход и регистрация
                </button>
                <div class="bkt-shadow-card__shadow-1">
                </div>
                <div class="bkt-shadow-card__shadow-2">
                </div>
            </div>
        </div>
        <div v-if="user_loading" class="d-flex w-100 justify-content-center my-5">
            <div
                style="color: #2953ff;border-width: 2px;"
                class="spinner-border"
                role="status"
            ></div>
        </div>
    </div>
</template>

<script>
    import ProfileTab from "./Profile/ProfileTab";
    import AboutTab from "./Profile/AboutTab";
    import HelpTab from "./Profile/HelpTab";
    import AskQuestionTab from "./Profile/AskQuestionTab";
    import ContactsTab from "./Profile/ContactsTab";
    import NotificationsTab from "./Profile/NotificationsTab";

    export default {
        name: "Profile",
        components: {
            ProfileTab, AboutTab, AskQuestionTab, ContactsTab, NotificationsTab, HelpTab
        },
        data() {
            return {
                passwords: {
                    password: '',
                    confirm_password: '',
                    old_password: ''
                },
                code_loading: false,
                tab: 'Profile',
                links: [
                    {
                        icon: 'User',
                        code: "Profile",
                        label: "Профиль",
                        color: 'primary',
                    },
                    {
                        icon: 'Bell',
                        code: "Notifications",
                        label: "Уведомления",
                        color: 'green',
                    },
                    {
                        icon: 'Information',
                        code: "AskQuestion",
                        label: "Задать вопрос",
                        color: 'yellow',
                    },
                    // {
                    //     icon: 'Briefcase',
                    //     code: "Contacts",
                    //     label: "Контакты",
                    //     color: 'blue',
                    // },
                    {
                        icon: 'Help',
                        code: "Help",
                        label: "Помощь",
                        color: 'pink'
                    },
                    {
                        icon: 'Alignment',
                        code: "About",
                        label: "О сайте",
                        color: 'red'
                    },
                    {
                        path: '/calendar',
                        icon: 'Date',
                        code: "Calendar",
                        label: "Календарь",
                        color: 'blue'
                    },
                ],
            }
        },
        computed: {
            user() {
                return this.$store.getters.auth_user
            },
            user_loading() {
                return this.$store.getters.auth_user_loading
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
        methods: {
            navigate(link) {
                if(link.path) {
                    this.$router.push(link.path)
                }
                else {
                    this.tab=link.code;
                }
            }
        }
    }
</script>

<style scoped>

</style>
