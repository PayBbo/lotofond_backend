<template>
    <bkt-modal :id="'authModal'" no_title :modal_class="'bkt-auth-modal '+tab">
        <template #aside>
            <div class="bkt-modal__aside">
                <img class="bkt-modal__aside-image" :src="'/images/'+tab+'_image.png'" alt="">
                <h3 class="bkt-modal__aside-title">Для чего нужна<br> регистрация на сайте?</h3>
                <div class="bkt-modal__aside-description">
                    <h4 class="bkt-modal__aside-description-text">Прохождение регистрации позволит вам получить
                        <span class="bkt-text-yellow">7-ми дневный пробный период тарифа "Бизнес",</span> а это:</h4>
                </div>
                <div class="bkt-modal__aside-features">
                    <div class="col-12 p-0">
                        <div class="bkt-modal__aside-feature">
                            <div class="bkt-modal__aside-feature-check bg-purple"></div>
                            <h5 class="bkt-modal__aside-feature-text">Поиск по самой полной базе<br> торгов по
                                банкротству (более<br> 65 000 открытых лотов).</h5>
                        </div>
                    </div>
                    <div class="col-sm-7 col-12 p-0">
                        <div class="bkt-modal__aside-feature">
                            <div class="bkt-modal__aside-feature-check bg-green"></div>
                            <h5 class="bkt-modal__aside-feature-text">Мониторинг новых лотов,<br> получение уведомлений
                                на e-mail.</h5>
                        </div>
                    </div>
                    <div class="col-sm-5 col-12 p-0">
                        <div class="bkt-modal__aside-feature">
                            <div class="bkt-modal__aside-feature-check bg-yellow"></div>
                            <h5 class="bkt-modal__aside-feature-text">Работа с<br> избранными лотами.</h5>
                        </div>
                    </div>
                    <div class="col-12 p-0">
                        <div class="bkt-modal__aside-feature">
                            <div class="bkt-modal__aside-feature-check bg-primary"></div>
                            <h5 class="bkt-modal__aside-feature-text">Реестры торговых площадок, должников,
                                арбитражных<br> управляющих и организаторов долгов.</h5>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #body="{ invalid }">
            <ul class="bkt-navbar__nav bkt-navbar__nav-pills">
                <li class="bkt-navbar__nav-item" :class="{active: tab==='registration'}"
                    @click="tab='registration'">
                    Регистрация
                </li>
                <li class="bkt-navbar__nav-item" :class="{active: tab==='login'}" @click="tab='login'">
                    Вход
                </li>
            </ul>
            <bkt-input
                v-model="user.name"
                v-if="tab=='registration'"
                name="name"
                type="text"
                :rules="'required|alpha|min:2'"
                label="имя"
                placeholder="Иван"
                icon_name="User"
            />
            <bkt-input
                v-if="tab=='registration'"
                v-model="user.surname"
                :name="'surname'"
                type="text"
                :rules="'required|alpha|min:2'"
                label="фамилия"
                placeholder="Иванов"
                icon_name="User"
            />
            <bkt-input
                v-model="user.email"
                :name="'email'"
                type="email"
                label="e-mail"
                :rules="'required'"
                placeholder="pochta@gmail.com"
                icon_name="Email"
            />
<!--            <bkt-input-->
<!--                v-model="user.phone"-->
<!--                v-if="tab=='registration'"-->
<!--                :name="'phone'"-->
<!--                type="tel"-->
<!--                label="номер телефона"-->
<!--                :rules="'required|phone'"-->
<!--                :placeholder="'+7 495 000-00-00'"-->
<!--                icon_name="Smartphone"-->
<!--            />-->
            <bkt-input
                v-model="user.password"
                name="password"
                :type="type1"
                label="пароль"
                @click-group-item="switchVisibility('type1')"
                :rules="'required|min:8'"
                group_item_action
            >
                <template #icon>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 516.000000 404.000000"
                         width="100%" height="18px">
                        <g transform="translate(0.000000,404.000000) scale(0.100000,-0.100000)" fill="#2953ff"
                           stroke="none">
                            <path d="M2295 4020 c-138 -17 -272 -42 -402 -76 -652 -168 -1237 -609 -1667
                                    -1258 -98 -148 -159 -276 -193 -403 -24 -87 -27 -116 -27 -263 0 -147 3 -176
                                    27 -263 47 -177 161 -379 348 -619 352 -453 761 -767 1244 -956 322 -126 641
                                    -178 1025 -169 250 6 363 20 580 73 188 46 330 98 515 189 462 227 868 596
                                    1189 1079 98 148 159 276 193 403 24 87 27 116 27 263 0 147 -3 176 -27 263
                                    -34 127 -95 255 -193 403 -328 495 -744 869 -1217 1094 -226 108 -479 185
                                    -737 226 -121 19 -571 28 -685 14z m456 -461 c453 -36 855 -199 1224 -496 193
                                    -156 417 -405 568 -633 115 -173 147 -263 147 -410 0 -149 -31 -234 -146 -408
                                    -311 -466 -718 -811 -1169 -990 -429 -170 -932 -195 -1385 -68 -532 148 -1015
                                    520 -1374 1058 -115 174 -146 259 -146 408 0 149 31 234 146 408 395 593 934
                                    978 1534 1096 215 42 386 52 601 35z"></path>
                            <path d="M2458 3100 c-790 -100 -1213 -962 -806 -1644 91 -153 247 -301 409
                                    -390 295 -162 667 -173 977 -30 208 95 389 267 500 474 141 262 166 593 65
                                    875 -107 298 -344 539 -638 650 -149 57 -360 84 -507 65z m322 -495 c183 -67
                                    316 -198 385 -385 25 -66 29 -89 29 -195 0 -85 -4 -135 -16 -171 -92 -288
                                    -344 -467 -633 -451 -250 15 -460 174 -551 417 -24 66 -28 89 -28 195 0 85 4
                                    135 16 171 56 176 175 316 332 391 53 26 82 36 171 57 11 3 65 3 120 1 77 -2
                                    117 -9 175 -30z"></path>
                        </g>
                    </svg>
                </template>
            </bkt-input>
            <bkt-input
                v-model="user.confirm_password"
                v-if="tab=='registration'"
                @click-group-item="switchVisibility('type2')"
                :name="'confirmation'"
                :type="type2"
                label="повторите пароль"
                :rules="'required|min:8|confirmed:password'"
                group_item_action
            >
                <template #icon>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 516.000000 404.000000"
                         width="100%" height="18px">
                        <g transform="translate(0.000000,404.000000) scale(0.100000,-0.100000)" fill="#2953ff"
                           stroke="none">
                            <path d="M2295 4020 c-138 -17 -272 -42 -402 -76 -652 -168 -1237 -609 -1667
                                    -1258 -98 -148 -159 -276 -193 -403 -24 -87 -27 -116 -27 -263 0 -147 3 -176
                                    27 -263 47 -177 161 -379 348 -619 352 -453 761 -767 1244 -956 322 -126 641
                                    -178 1025 -169 250 6 363 20 580 73 188 46 330 98 515 189 462 227 868 596
                                    1189 1079 98 148 159 276 193 403 24 87 27 116 27 263 0 147 -3 176 -27 263
                                    -34 127 -95 255 -193 403 -328 495 -744 869 -1217 1094 -226 108 -479 185
                                    -737 226 -121 19 -571 28 -685 14z m456 -461 c453 -36 855 -199 1224 -496 193
                                    -156 417 -405 568 -633 115 -173 147 -263 147 -410 0 -149 -31 -234 -146 -408
                                    -311 -466 -718 -811 -1169 -990 -429 -170 -932 -195 -1385 -68 -532 148 -1015
                                    520 -1374 1058 -115 174 -146 259 -146 408 0 149 31 234 146 408 395 593 934
                                    978 1534 1096 215 42 386 52 601 35z"></path>
                            <path d="M2458 3100 c-790 -100 -1213 -962 -806 -1644 91 -153 247 -301 409
                                    -390 295 -162 667 -173 977 -30 208 95 389 267 500 474 141 262 166 593 65
                                    875 -107 298 -344 539 -638 650 -149 57 -360 84 -507 65z m322 -495 c183 -67
                                    316 -198 385 -385 25 -66 29 -89 29 -195 0 -85 -4 -135 -16 -171 -92 -288
                                    -344 -467 -633 -451 -250 15 -460 174 -551 417 -24 66 -28 89 -28 195 0 85 4
                                    135 16 171 56 176 175 316 332 391 53 26 82 36 171 57 11 3 65 3 120 1 77 -2
                                    117 -9 175 -30z"></path>
                        </g>
                    </svg>
                </template>
            </bkt-input>
            <bkt-checkbox name="'Условия'" id="terms" :rules="'required_boolean'" v-model="terms"
                          v-if="tab=='registration'">
                <template #label>
                    Согласен с условиями пользовательского соглашения,<br>политики сайта, обработки персональных
                    данных.
                </template>
            </bkt-checkbox>

            <button class="bkt-button primary" v-if="tab=='registration'" :disabled="invalid" @click="submit">
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Зарегистрироваться
            </button>
            <div class="bkt-wrapper-between w-100" v-if="tab=='login'">
                <a class="bkt-forgot-password" @click="submit">Забыли пароль?
                    <bkt-icon name="ArrowDown"></bkt-icon>
                </a>
                <button class="bkt-button primary" :disabled="invalid" @click="submit">
                    <span v-if="loading" class="spinner-border spinner-border-sm" role="status"
                          aria-hidden="true"></span>
                    Войти
                </button>
            </div>
        </template>
        <template #footer>
            <button class="vk-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="25px" fill="#0077ff"
                     viewBox="0 25 548.4 312.9">
                    <path
                        d="M545.5,400.3c-.7-1.4-1.3-2.6-1.9-3.6q-14.2-25.6-54.5-63.1l-.6-.5-.3-.3-.3-.3h-.3c-12.1-11.6-19.9-19.4-23.1-23.4-5.9-7.6-7.2-15.3-4-23.2,2.3-5.9,10.9-18.3,25.7-37.4,7.8-10,14-18.1,18.6-24.2q49.4-65.7,42.8-84l-1.7-2.8c-1.2-1.7-4.1-3.3-8.9-4.7s-10.8-1.7-18.2-.7l-82.3.5a11.2,11.2,0,0,0-5.7.2l-3.7.8-1.4.8-1.2.8a14.1,14.1,0,0,0-3.1,3,18.5,18.5,0,0,0-2.8,5A476.3,476.3,0,0,1,388,207.4c-7,11.8-13.5,22.1-19.4,30.7s-10.9,15.1-14.9,19.2a108.8,108.8,0,0,1-10.8,9.8c-3.2,2.5-5.7,3.5-7.4,3.2l-4.9-1.2a18.9,18.9,0,0,1-6.4-7,31.7,31.7,0,0,1-3.3-11.1,113.7,113.7,0,0,1-1-11.6c-.1-3.2,0-7.8.2-13.7s.2-9.9.2-12c0-7.2.2-15.1.5-23.5s.5-15.2.7-20.2.3-10.1.3-15.7a72.1,72.1,0,0,0-1-13,51,51,0,0,0-3-9.1,15.7,15.7,0,0,0-5.9-6.8,30.9,30.9,0,0,0-9.5-3.9c-10.1-2.3-23-3.5-38.6-3.7q-53.1-.6-68.2,6.8a40.2,40.2,0,0,0-10.9,8.6c-3.4,4.2-3.9,6.5-1.4,6.9,11.4,1.7,19.5,5.8,24.3,12.2l1.7,3.5c1.3,2.4,2.6,6.8,4,13.1a127.4,127.4,0,0,1,2.5,20.8q1.5,20.9,0,35.7t-2.7,23.1a45.5,45.5,0,0,1-3.8,13.5,41.6,41.6,0,0,1-3.5,6.2,4.1,4.1,0,0,1-1.4,1.5,21.9,21.9,0,0,1-7.7,1.4c-2.7,0-5.9-1.3-9.7-4a68.8,68.8,0,0,1-11.8-11,158.3,158.3,0,0,1-13.9-19.5c-5.1-8.4-10.5-18.3-16-29.7l-4.5-8.3c-2.9-5.3-6.8-13.1-11.7-23.3s-9.4-20-13.2-29.5a19.1,19.1,0,0,0-6.8-9.2l-1.5-.8a17.5,17.5,0,0,0-4.5-2.5,35.7,35.7,0,0,0-6.6-1.8l-78.2.6c-8,0-13.4,1.8-16.3,5.4L.9,139.2a8.8,8.8,0,0,0-.9,4.6,24,24,0,0,0,1.7,7.7c11.4,26.8,23.9,52.7,37.3,77.6s25,45,34.9,60.3,20,29.6,30.3,43.1,17.1,22.2,20.4,26,6,6.6,7.9,8.5l7.1,6.9a186.7,186.7,0,0,0,20.1,16.4,332,332,0,0,0,29.4,18.8,159.5,159.5,0,0,0,37.6,15.2,131.8,131.8,0,0,0,41.7,4.7h32.8c6.7-.6,11.7-2.7,15.1-6.3l1.2-1.4a19.9,19.9,0,0,0,2.1-5.3,28,28,0,0,0,1-7.9,90.2,90.2,0,0,1,1.9-22.1c1.4-6.5,3-11.5,4.8-14.8a32.7,32.7,0,0,1,6.2-8.4,25.5,25.5,0,0,1,4.8-4.2l2.3-1c4.6-1.5,9.9,0,16.1,4.4a97,97,0,0,1,17.5,16.6c5.4,6.6,11.9,13.9,19.5,22.1S408,415,413.7,419l5.7,3.4a68.7,68.7,0,0,0,14.9,6.3c6,1.9,11.4,2.4,15.9,1.4l73.1-1.1c7.3,0,12.9-1.2,16.9-3.6s6.3-5,7.1-7.8a22.4,22.4,0,0,0,.2-9.7A42.7,42.7,0,0,0,545.5,400.3Z"
                        transform="translate(0 -117.7)"/>
                </svg>
                {{tab=='registration'? 'Регистрация':'Вход'}} через ВКонтакте
            </button>
            <button class="gosuslugi-button">
                {{tab=='registration'? 'Регистрация':'Вход'}} через
                <svg xmlns="http://www.w3.org/2000/svg" width="69px"
                     height="11px" viewBox="4 -3 146 26">
                    <path fill="#EE3F58"
                          d="M95.3.6H83.4c-.1 0-.2.1-.2.2-.3 5.4-1.3 11.2-2.8 15.9v.2c.1.1.1.1.2.1h4.1c.1 0 .2-.1.2-.1C86 13.3 87 8.5 87.3 4.5h3.9v12.4c0 .1.1.2.2.2h3.9c.1 0 .2-.1.2-.2V.9c0-.2-.1-.3-.2-.3M145.8.6h-3.9c-.1 0-.2.1-.2.2v12.3c-.9.3-1.7.3-2.7.3-2.6 0-3.2-.8-3.2-4.2V.9c0-.1-.1-.2-.2-.2h-3.9c-.1 0-.2.1-.2.2v8.9c0 5.6 1.9 7.7 6.7 7.7 2.7 0 5.8-.7 7.6-1.4.1 0 .1-.1.1-.2V.9c.1-.2 0-.3-.1-.3M63.2.7h-4c-.1 0-.2.1-.2.1-.6 2.4-1.9 6.5-3.6 10.8L51.4.7c0-.1-.1-.1-.2-.1h-4c-.1 0-.1.1-.2.1-.1.1-.1.1 0 .2l6 16.3c-.6 1.3-1.2 2.3-1.7 3.3-.4.7-.8 1.5-1.2 2.2-.1.1 0 .1 0 .2.1.1.1.1.2.1h4.3c.1 0 .1-.1.2-.1.7-1.4 1.7-3.4 2.5-5.4C59.8 11.6 61.9 6 63.4.9c0-.1 0-.1-.1-.2h-.1M77.4 13.2c0-.1-.1-.1-.1-.1h-.2c-.9.3-2.7.7-4 .7-2.7 0-4-.7-4-4.9 0-3.3.4-4.9 4-4.9 1 0 2 .1 3.2.5.1 0 .2 0 .3-.1.5-.9 1-1.9 1.6-3.2V1c0-.1-.2-.2-.2-.2-1.6-.5-3.5-.8-5.2-.8-5.7 0-8.2 2.6-8.2 8.7s2.5 8.8 8.2 8.8c1.4 0 4.2-.3 5.6-.9.1-.1.1-.1.1-.3l-1.1-3.1zM114.5.7h-4c-.1 0-.2.1-.2.1-.6 2.4-1.9 6.5-3.6 10.8l-4-10.9c0-.1-.1-.1-.2-.1h-4c-.1 0-.1.1-.2.1-.1.1-.1.1 0 .2l6 16.3c-.6 1.3-1.2 2.2-1.7 3.3-.4.7-.8 1.5-1.2 2.2-.1.1 0 .1 0 .2.1.1.1.1.2.1h4.3c.1 0 .1-.1.2-.1.7-1.4 1.7-3.4 2.5-5.4 2.5-5.9 4.6-11.5 6-16.6 0-.1 0-.1-.1-.2.1 0 0 0 0 0M129.1.6h-11.5c-.1 0-.2.1-.2.2v15.9c0 .1.1.2.2.2h3.9c.1 0 .2-.1.2-.2V4.4h6c.1 0 .2-.1.2-.1.5-1.1.9-2.2 1.4-3.4V.7c-.1 0-.2-.1-.2-.1"/>
                    <path fill="#0065B1"
                          d="M20.8 13.8c-2.6 0-3.4-.7-3.4-5 0-4.6.9-5 3.4-5s3.5.4 3.5 5c-.1 4.4-.9 5-3.5 5m0-13.7C15.2.1 13 2.5 13 8.7c0 6.3 2.2 8.7 7.8 8.7s7.9-2.4 7.9-8.7c0-6.1-2.3-8.6-7.9-8.6M44.2 13.2c0-.1-.1-.1-.1-.1h-.2c-.9.3-2.7.7-4 .7-2.7 0-4-.7-4-4.9 0-3.3.4-4.9 4-4.9 1 0 2 .1 3.2.5.1 0 .2 0 .3-.1.5-.9 1-1.9 1.6-3.2V1c0-.1-.1-.1-.1-.1-1.5-.5-3.5-.7-5.1-.7-5.7 0-8.2 2.6-8.2 8.7s2.5 8.8 8.2 8.8c1.4 0 4.2-.3 5.6-.9.1-.1.1-.1.1-.3l-1.3-3.3zM11.7.6H.2C.1.6 0 .7 0 .9v15.9c0 .1.1.2.2.2h3.9c.1 0 .2-.1.2-.2V4.4h6c.1 0 .1-.1.2-.1.5-1.1 1-2.3 1.4-3.4V.7s-.1-.1-.2-.1"/>
                </svg>
            </button>

        </template>
    </bkt-modal>
</template>

<script>
    import {Modal} from "bootstrap";
    import {mask} from 'vue-the-mask'
    export default {
        name: "AuthModal",
        data() {
            return {
                type1: "password",
                type2: "password",
                grantType: 'email',
                tab: 'registration',
                terms: false,
                loading: false,
                user:''
            }
        },
        computed: {
            shared_user() {
                return this.$store.getters.user
            },
        },
        mounted() {
            this.user = JSON.parse(JSON.stringify(this.shared_user));
        },
        methods: {
            switchVisibility(type) {
                this[type] = this[type] === "password" ? "text" : "password";
            },
            async submit() {
                let data = JSON.parse(JSON.stringify(this.user));
                data.grantType = this.grantType;
                this.loading = true;
                await axios
                    .post('/api/' + this.tab, data)
                    .then((resp) => {
                        this.$store.commit('setUser', data);
                        this.$store.commit('closeModal', '#authModal');
                        if (this.tab == 'registration') {
                            this.$store.commit('openModal', '#codeModal');
                        }else {
                            const token = resp.data.accessToken;
                            const refreshToken = resp.data.refreshToken;
                            localStorage.setItem('token', token);
                            localStorage.setItem('refreshToken', refreshToken);
                            axios.defaults.headers.common['Authorization'] =  "Bearer "+token;
                            location.reload();
                        }

                        this.loading = false;
                    })
                    .catch(err => {
                        this.loading = false;
                    });
            }
        },
        directives: {mask}
    }
</script>

<style scoped>
</style>
