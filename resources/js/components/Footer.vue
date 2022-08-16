<template>
    <footer class="bkt-footer">
        <div class="bkt-footer__main">
            <div class="bkt-container">
                <div class="row w-100 mx-auto bkt-gap-row-large">
                    <div class="col-6 col-lg-3">
                        <router-link to="/"><img class="bkt-footer__logo" src="/images/logo.png" alt="logo"></router-link>
                        <p class="bkt-footer__description">Нашей деятельности позволяет выполнять важные
                            задания по разработке модели развития. Таким образом дальнейшее развитие различных форм
                            деятельности способствует подготовки.</p>
                        <div class="bkt-footer__buttons bkt-gap-small">
<!--                            <router-link to="/" class="bkt-button primary">Торги</router-link>-->
                            <router-link to="/tariffs" class="bkt-button blue">Тарифы</router-link>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bkt-footer__block bkt-wrapper bkt-wrapper-down-lg-column">
                            <ul class="bkt-footer__links">
                                <li class="bkt-footer__link">
                                    <router-link to="/agent">Купить через агента</router-link>
                                </li>
                                <li class="bkt-footer__link">
                                    <router-link to="/auctions">Горящие торги
                                        <bkt-icon name="Fire"></bkt-icon>
                                    </router-link>
                                </li>
                                <li class="bkt-footer__link">
                                    <router-link to="/week-winners">Победы недели</router-link>
                                </li>
                                <li class="bkt-footer__link">
                                    <router-link to="/registries">Реестры</router-link>
                                </li>
                                <li class="bkt-footer__link">
                                    <router-link to="/contacts">Контакты</router-link>
                                </li>
                            </ul>
                            <ul class="bkt-footer__links">
                                <li v-if="!isLoggedIn" class="bkt-footer__link"
                                    data-bs-toggle="modal" data-bs-target="#authModal"
                                >
                                    Вход и регистрация
                                    <strong style="color:rgb(65, 125, 255); margin-left: 5px;">&#10095;</strong>
                                </li>
                                <li v-else class="bkt-footer__link">
                                    <router-link to="/profile">Профиль
                                        <strong style="color:rgb(65, 125, 255); margin-left: 5px;">&#10095;</strong>
                                    </router-link>
                                </li>
                                <li class="bkt-footer__link bkt-cursor-pointer" @click="navigate('/calendar')">
                                    Календарь <strong style="color:rgb(216, 43, 30); margin-left: 5px;">&#10095;</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="bkt-footer__socials">
                            <h3 class="bkt-footer__socials-phone">+7 916 018-48-58</h3>
                            <h5 class="bkt-footer__socials-email">vicemine@mail.ru</h5>

                            <div class="bkt-footer__socials-links">
                                <a class="bkt-button-icon bkt-bg-main-light" href="/">
                                    <bkt-icon name="Vk" width="16px" height="16px"></bkt-icon>
                                </a>
                                <a class="bkt-button-icon bkt-bg-main-light" href="/">
                                    <bkt-icon name="Instagram" width="16px" height="16px"></bkt-icon>
                                </a>
                                <a class="bkt-button-icon bkt-bg-main-light" href="/">
                                    <bkt-icon name="Telegram" width="16px" height="16px"></bkt-icon>
                                </a>
                                <a class="bkt-button-icon bkt-bg-main-light" href="/">
                                    <bkt-icon name="Youtube" width="16px" height="16px"></bkt-icon>
                                </a>
<!--                                <button class="bkt-button-icon bkt-bg-main-light">-->
<!--                                    <bkt-icon name="AppleStore"></bkt-icon>-->
<!--                                </button>-->
<!--                                <button class="bkt-button-icon bkt-bg-main-light">-->
<!--                                    <bkt-icon name="GooglePlay"></bkt-icon>-->
<!--                                </button>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bkt-footer__politics">
            <div class="bkt-container">
                <div class="bkt-wrapper-between bkt-wrapper-down-sm-column">
                    <p class="bkt-footer__politics-copyright">Все права защищены © LotoFond, 2022</p>
                    <div class="bkt-footer__politics-links">
                        <a class="bkt-footer__politics-link" href="/">Политика конфиденциальности</a>
                        <a class="bkt-footer__politics-link" href="/">Публичная оферта</a>
                    </div>
                </div>

            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "Footer",
        computed: {
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
        methods: {
            navigate(path) {
                if(this.isLoggedIn) {
                    this.$router.push(path)
                }
                else {
                    this.$store.dispatch('sendAuthNotification', {self: this})
                }
            }
        }
    }
</script>

<style scoped>

</style>
