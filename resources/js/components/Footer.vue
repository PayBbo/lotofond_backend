<template>
    <footer class="bkt-footer">
        <div class="container bkt-main bkt-container row_div">
            <div class="footer_block">
                <img class="logo" src="/images/logo.png" alt="logo">
                <p style="color:gray; margin-bottom: 40px;">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Delectus necessitatibus
                    facere qui optio,
                    incidunt dolorem voluptatem amet, nihil quo unde quidem nam deleniti laudantium ex, quibusdam
                    dolores voluptas possimus alias? Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                <div class="footer_buttons">
                    <router-link to="/auctions" class="bkt-button primary">Торги</router-link>
                    <router-link to="/tariffs" class="bkt-button blue">Тарифы</router-link>
                </div>
            </div>
            <div class="footer_block" style="margin-right: 0;">
                <div>
                    <ul>
                        <li>Календарь</li>
                        <li>
                            <router-link to="/agent">Купить через агента</router-link>
                        </li>
                        <li>Горящие торги
                            <bkt-icon name="Fire"></bkt-icon>
                        </li>
                        <li>
                            <router-link to="/week-winners">Топ-побед</router-link>
                        </li>
                        <li>
                            <router-link to="/registries">Реестры</router-link>
                        </li>
                        <li>
                            <router-link to="/contacts">Контакты</router-link>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li>Приложение <strong style="color:blue; margin-left: 5px;">&#10095;</strong></li>
                        <li data-bs-toggle="modal" data-bs-target="#authModal">Вход и регистрация
                            <strong style="color:rgb(65, 125, 255); margin-left: 5px;">&#10095;</strong>
                        </li>
                        <li>Изменения в законах <strong
                            style="color:rgb(216, 43, 30); margin-left: 5px;">&#10095;</strong>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer_block socials" style="margin-right: 0;">
                <p style="color:rgb(255, 196, 0); font-weight: bold; font-size: 25px;">8 (800) 560-88-55</p>
                <p style="color:gray">nazvanieemaila@gmail.com</p>
                <p>г. Название, ул. Ленина, 74</p>

                <div class="socials" style="margin-right: 0; margin-bottom: 80px;">
                    <a class="bkt-button-icon bkt-bg-main-light" style="margin-left: 0;" href="#">
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
        <div class="politics">
            <div class="container bkt-main bkt-container row_div politics">
                <p style="color:gray;">Все права защищены © Название, 2022</p>
                <div>
                    <p style="text-decoration: underline;">Политика конфиденциальности</p>
                    <p style="text-decoration: underline;">Публичная оферта</p>
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
