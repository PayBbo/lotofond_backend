<template>
    <footer class="bkt-footer">
        <div class="bkt-footer__main">
            <div class="bkt-container">
                <div class="row w-100 mx-auto bkt-gap-row-large">
                    <div class="col-6 col-lg-3">
                        <img class="bkt-footer__logo" src="/images/logo.png" alt="logo">
                        <p class="bkt-footer__description">Нашей деятельности позволяет выполнять важные
                            задания по разработке модели развития. Таким образом дальнейшее развитие различных форм
                            деятельности способствует подготовки.</p>
                        <div class="bkt-footer__buttons bkt-gap-small">
                            <router-link to="/" class="bkt-button primary">Торги</router-link>
                            <router-link to="/tariffs" class="bkt-button blue">Тарифы</router-link>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bkt-footer__block bkt-wrapper bkt-wrapper-down-lg-column">
                            <ul class="bkt-footer__links">
                                <li class="bkt-footer__link">
                                    <router-link to="/calendar">Календарь</router-link>
                                </li>
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
                                <li class="bkt-footer__link">Приложение <strong style="color:blue; margin-left: 5px;">&#10095;</strong>
                                </li>
                                <li class="bkt-footer__link" data-bs-toggle="modal" data-bs-target="#authModal">Вход и
                                    регистрация
                                    <strong style="color:rgb(65, 125, 255); margin-left: 5px;">&#10095;</strong>
                                </li>
                                <li class="bkt-footer__link text-truncate">Изменения в законах <strong
                                    style="color:rgb(216, 43, 30); margin-left: 5px;">&#10095;</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="bkt-footer__socials">
                            <h3 class="bkt-footer__socials-phone">8 (800) 560-88-55</h3>
                            <h5 class="bkt-footer__socials-email">nazvanieemaila@gmail.com</h5>
                            <p class="bkt-footer__socials-address">г. Название, ул. Ленина, 74</p>

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
        name: "Footer"
    }
</script>

<style scoped>

</style>
