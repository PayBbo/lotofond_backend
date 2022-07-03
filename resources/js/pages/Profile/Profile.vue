<template>
    <div class="container bkt-profile bkt-container">
        <div class="bkt-form wide">
            <div class="col-12 col-lg-3 bkt-form__offset-right">
                <div class="bkt-wrapper-column">
                    <div class="bkt-card bkt-card__body bkt-sidebar">
                        <ul class="bkt-sidebar__links">
                            <li class="bkt-sidebar__link" v-for="link in links"
                                :class="[tab==link.code ? 'bkt-bg-'+link.color+'-lighter' : '']"
                                @click="tab=link.code"
                            >
                                <div class="bkt-sidebar__link-icon"
                                     :class="[tab==link.code ? 'bkt-bg-'+link.color : 'bkt-bg-'+link.color+'-lighter']"
                                >
                                    <bkt-icon :name="link.icon" :color="tab==link.code ? 'white' : link.color"></bkt-icon>
                                </div>
                                <div class="bkt-sidebar__link-label">{{link.label}}</div>
                            </li>
                        </ul>
                    </div>
                    <div class="bkt-card bkt-bg-primary bkt-profile-tariff">
                        <h6 class="bkt-card__subtitle">тарифный план</h6>
                        <h5 class="bkt-card__title">Базовый</h5>
                        <button class="bkt-button bkt-tariff-button">
                            Сменить тариф
                        </button>
                        <div class="bkt-card bkt-card__background-figure-1">
                        </div>
                        <div class="bkt-card bkt-card__background-figure-2 bkt-bg-primary">
                        </div>
                    </div>
                </div>

            </div>
            <div class="p-0 col-12 col-lg-9">
                <component :is="tab+'Tab'"></component>
            </div>
        </div>
    </div>
</template>

<script>
    import ProfileTab from "./ProfileTab";
    import AboutTab from "./AboutTab";
    import HelpTab from "./HelpTab";
    import AskQuestionTab from "./AskQuestionTab";
    import ContactsTab from "./ContactsTab";
    import NotificationsTab from "./NotificationsTab";
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
                    {
                        icon: 'Briefcase',
                        code: "Contacts",
                        label: "Контакты",
                        color: 'blue',
                    },
                    {
                        icon: 'Help',
                        code: "Help",
                        label: "Помощь",
                        color: 'pink'
                    },
                    {
                        icon: 'Alignment',
                        code: "About",
                        label: "Об сайте",
                        color: 'red'
                    },
                ],
            }
        },
        mounted() {

        },
        computed: {
            user() {
                return this.$store.getters.auth_user
            },
        },
        methods: {
            sendCode() {

            }
        }
    }
</script>

<style scoped>

</style>
