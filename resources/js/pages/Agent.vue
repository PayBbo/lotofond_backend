<template>
    <div class="container bkt-promo bkt-page bkt-container">
        <section>
            <h1 class="bkt-page__title">Покупка через агента</h1>
            <div class="bkt-promo__block-wrapper">
                <div class="bkt-promo__block bkt-promo__block_agent">
                    <div class="bkt-promo__block-body">
                        <h1 class="bkt-promo__block-title">Новичок?<br><span
                            class="bkt-text-yellow">сэкономьте до 50%</span></h1>
                        <h5 class="bkt-promo__block-subtitle">на торгах с нашей помощью</h5>
                        <h4 class="bkt-promo__block-text">
                            Воспользуйтесь нашим опытом побед, чтобы избежать ошибок и сэкономить время, деньги и
                            нервы.
                        </h4>
                    </div>
                    <div class="bkt-promo__block-body">
                        <div class="bkt-promo__block-body-column">
                            <div class="bkt-promo__block-feature">
                                <div class="check_mark bkt-bg-pink">&#10003;</div>
                                <span>ЭЦП не нужна</span>
                            </div>
                            <div class="bkt-promo__block-feature">
                                <div class="check_mark bkt-bg-blue">&#10003;</div>
                                <span>Аккредитация не нужна</span>
                            </div>
                            <div class="bkt-promo__block-feature">
                                <div class="check_mark bkt-bg-green">&#10003;</div>
                                <span>Заполнять документы не нужно</span>
                            </div>
                        </div>
                    </div>
                    <div class="bkt-promo__block-price">
                        <h2>3000 ₽</h2>
                        <button class="bkt-button bkt-button_yellow bkt-button_plump">Купить</button>
                    </div>
                </div>
                <div class="bkt-promo__block-shadow"
                     style="background-color: rgba(13, 110, 255, 0.4); z-index: -1; top: -5px; width: calc(100% - 5vw);">
                </div>
                <div class="bkt-promo__block-shadow"
                     style="background-color: rgba(13, 110, 255, 0.2); z-index: -2; top: -5px; width: calc(100% - 10vw);">
                </div>
            </div>
        </section>
        <section>
            <h2 class="bkt-page__subtitle">Что это даёт?</h2>
            <div class="bkt-form row-cols-1 row-cols-md-2 row-cols-lg-5">
                <div class="col">
                    <div class="bkt-card bkt-promo__profit-card h-100">
                        <div class="bkt-icon-frame-large bkt-bg-blue-lighter">
                            <bkt-icon name="LightBulb" color="blue" class="bkt-icon-frame__item"></bkt-icon>
                        </div>
                        <!--                        <div class="bkt-promo__profit-card-body">-->
                        <p class="bkt-card__text my-auto my-md-0">Не нужно вникать в тонкости процесса торгов</p>
                        <!--                        </div>-->
                    </div>
                </div>
                <div class="col">
                    <div class="bkt-card bkt-promo__profit-card h-100">
                        <div class="bkt-icon-frame-large bkt-bg-green-lighter">
                            <bkt-icon name="Like" color="green" class="bkt-icon-frame__item"></bkt-icon>
                        </div>
                        <!--                        <div class="bkt-promo__profit-card-body">-->
                        <p class="bkt-card__text my-auto my-md-0">
                            Обходится дешевле, чем покупка ЭЦП
                        </p>
                        <!--                        </div>-->
                    </div>
                </div>
                <div class="col">
                    <div class="bkt-card bkt-promo__profit-card h-100">
                        <div class="bkt-icon-frame-large bkt-bg-yellow-lighter">
                            <bkt-icon name="Devices" color="yellow" class="bkt-icon-frame__item"></bkt-icon>
                        </div>
                        <!--                        <div class="bkt-promo__profit-card-body">-->
                        <p class="bkt-card__text my-auto my-md-0">Не нужно изучать сервисы и площадки</p>
                        <!--                        </div>-->
                    </div>
                </div>
                <div class="col">
                    <div class="bkt-card bkt-promo__profit-card h-100">
                        <div class="bkt-icon-frame-large bkt-bg-pink-lighter">
                            <bkt-icon name="Clipboard" color="pink" class="bkt-icon-frame__item"></bkt-icon>
                        </div>
                        <!--                        <div class="bkt-promo__profit-card-body">-->
                        <p class="bkt-card__text my-auto my-md-0">Гарантируем допуск к торгам</p>
                        <!--                        </div>-->
                    </div>
                </div>
                <div class="col">
                    <div class="bkt-card bkt-promo__profit-card h-100">
                        <div class="bkt-icon-frame-large bkt-bg-red-lighter">
                            <bkt-icon name="Clock" color="red" class="bkt-icon-frame__item"></bkt-icon>
                        </div>
                        <!--                        <div class="bkt-promo__profit-card-body">-->
                        <p class="bkt-card__text my-auto my-md-0">Экономим вам время и силы</p>
                        <!--                        </div>-->
                    </div>
                </div>
            </div>
        </section>
        <section>
            <h2 class="bkt-page__subtitle">Что делаем мы?</h2>
            <div class="bkt-form bkt-container row-cols-1 row-cols-md-5 row-cols-lg-5">
                <div class="col">
                    <div class="bkt-promo__action-card">
                        <div class="plus-wrapper">
                            <div class="plus">
                                +
                            </div>
                        </div>
                        <h5 class="bkt-card__text">Проводим анализ лота</h5>
                        <div class="number"><span>01</span></div>
                    </div>
                </div>
                <div class="col">
                    <div class="bkt-promo__action-card">
                        <div class="plus-wrapper">
                            <div class="plus">
                                +
                            </div>
                        </div>
                        <h5 class="bkt-card__text">Выезжаем на место для получения доп. информации*<br>
                            <span class="bkt-card__subtitle">*По Москве и Московской области</span>
                        </h5>

                        <div class="number"><span>02</span></div>
                    </div>
                </div>
                <div class="col">
                    <div class="bkt-promo__action-card">
                        <div class="plus-wrapper">
                            <div class="plus">
                                +
                            </div>
                        </div>
                        <h5 class="bkt-card__text">Даём шаблоны документов по торгам</h5>
                        <div class="number"><span>03</span></div>
                    </div>
                </div>
                <div class="col">
                    <div class="bkt-promo__action-card">
                        <div class="plus-wrapper">
                            <div class="plus">
                                +
                            </div>
                        </div>
                        <h5 class="bkt-card__text">Участвуем в торгах от вашего имени</h5>
                        <div class="number"><span>04</span></div>
                    </div>
                </div>
                <div class="col">
                    <div class="bkt-promo__action-card">
                        <div class="plus-wrapper">
                            <div class="plus">
                                +
                            </div>
                        </div>
                        <h5 class="bkt-card__text">Контролируем оплату и возврат задатка</h5>
                        <div class="number"><span>05</span></div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <h2 class="bkt-page__subtitle">Что от вас?</h2>
            <div class="bkt-form bkt-container pe-0 justify-content-center row-cols-1 row-cols-md-2 row-cols-lg-4">
                <div class="col">
                    <div class="bkt-promo__todo-card-wrapper h-100">
                        <div class="bkt-card bkt-promo__todo-card h-100">
                            <div class="check-wrapper">
                                <div class="check_mark">&#10003;</div>
                            </div>
                            <h5 class="bkt-card__text">Выбрать интересующий лот или обозначить пожелания</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="bkt-promo__todo-card-wrapper h-100">
                        <div class="bkt-card bkt-promo__todo-card h-100">
                            <div class="check-wrapper">
                                <div class="check_mark">&#10003;</div>
                            </div>
                            <h5 class="bkt-card__text">Оплатить услугу</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="bkt-promo__todo-card-wrapper h-100">
                        <div class="bkt-card bkt-promo__todo-card h-100">
                            <div class="check-wrapper">
                                <div class="check_mark">&#10003;</div>
                            </div>
                            <h5 class="bkt-card__text">Заполнить шаблоны документов для участия</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="bkt-promo__todo-card-wrapper h-100">
                        <div class="bkt-card bkt-promo__todo-card h-100">
                            <div class="check-wrapper">
                                <div class="check_mark">&#10003;</div>
                            </div>
                            <h5 class="bkt-card__text">Вовремя внести задаток</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="bkt-promo__block_mini">
            <h2 class="bkt-promo__block-title">С нами <span class="bkt-text-yellow">шансы на победу</span> в торгах
                увеличиваются до
            </h2><span class="bkt-promo__block-title bkt-text-yellow bkt-promo__block-percentage">80%</span>
        </div>
        <section>
            <h2 class="bkt-page__subtitle">Как получить услугу?</h2>
            <ValidationObserver v-slot="{ invalid }" tag="div" class="bkt-card bkt-promo__form bkt-form">
                <bkt-input
                    v-model="service.name"
                    name="name"
                    type="text"
                    :rules="'required|alpha|min:2'"
                    label="имя фамилия"
                    label_class="bkt-form__label"
                    field_name="Имя Фамилия"
                    placeholder="Иванов Иван"
                    icon_name="User"
                />
                <bkt-input
                    v-model="service.email"
                    :name="'email'"
                    type="email"
                    label="email"
                    label_class="bkt-form__label"
                    field_name="Email"
                    :rules="'required'"
                    placeholder="pochta@gmail.com"
                    icon_name="Email"
                />
                <bkt-input
                    v-model="service.phone"
                    :name="'phone'"
                    type="tel"
                    label="номер телефона"
                    label_class="bkt-form__label"
                    field_name="Номер телефона"
                    :rules="'required|phone'"
                    :placeholder="'+7 495 000-00-00'"
                    icon_name="Smartphone"
                    :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
                />
                <div class="bkt-input__wrapper">
                    <label class="bkt-input__label bkt-form__label" style="margin-bottom: 10px;">где вам удобнее общаться</label>
                    <div class="communications">
                        <button class="bkt-button bkt-bg-body"
                                :class="service.socialsForAnswer.indexOf('Viber')>=0 ? 'bkt-border-primary': 'bkt-border-body'"
                                @click="toggleSocial('Viber')">
                            <bkt-icon name="Viber" color="purple" class="bkt-button__icon"></bkt-icon>
                        </button>
                        <button class="bkt-button bkt-bg-body"
                                :class="service.socialsForAnswer.indexOf('Vk')>=0 ? 'bkt-border-primary': 'bkt-border-body'"
                                @click="toggleSocial('Vk')"
                        >
                            <bkt-icon name="Vk" color="primary" class="bkt-button__icon"></bkt-icon>
                        </button>
                        <button class="bkt-button bkt-bg-body"
                                :class="service.socialsForAnswer.indexOf('Telegram')>=0 ? 'bkt-border-primary': 'bkt-border-body'"
                                @click="toggleSocial('Telegram')"
                        >
                            <bkt-icon name="Telegram" color="blue" class="bkt-button__icon"></bkt-icon>
                        </button>
                        <button class="bkt-button bkt-bg-body"
                                :class="service.socialsForAnswer.indexOf('WhatsApp')>=0 ? 'bkt-border-primary': 'bkt-border-body'"
                                @click="toggleSocial('WhatsApp')"
                        >
                            <bkt-icon name="WhatsApp" color="green" class="bkt-button__icon"></bkt-icon>
                        </button>
                        <div class="bkt-button bkt-bg-body bkt-text-main">перезвоним в течение 10 минут</div>
                    </div>
                </div>
                <div class="bkt-input__wrapper">
                    <label class="bkt-form__label">
                        позвоните лучше
                    </label>
                    <div class="time_to_call">
                        <bkt-datepicker v-model="service.date" type="datetime" name="service.date"
                                        field_name="'позвоните лучше'"
                        >
                        </bkt-datepicker>
                        <!--                        <select class="form-select" name="day" id="day">-->
                        <!--                            <option value="1">01</option>-->
                        <!--                            <option value="2">02</option>-->
                        <!--                            <option value="3">03</option>-->
                        <!--                            <option value="4">04</option>-->
                        <!--                            <option value="5">05</option>-->
                        <!--                            <option value="6">06</option>-->
                        <!--                            <option value="7">07</option>-->
                        <!--                            <option value="8">08</option>-->
                        <!--                            <option value="9">09</option>-->
                        <!--                            <option value="10">10</option>-->
                        <!--                            <option value="11">11</option>-->
                        <!--                            <option value="12">12</option>-->
                        <!--                            <option value="13">13</option>-->
                        <!--                            <option value="14">14</option>-->
                        <!--                            <option value="15">15</option>-->
                        <!--                            <option value="16">16</option>-->
                        <!--                            <option value="17">17</option>-->
                        <!--                            <option value="18">18</option>-->
                        <!--                            <option value="19">19</option>-->
                        <!--                            <option value="20">20</option>-->
                        <!--                            <option value="21">21</option>-->
                        <!--                            <option value="22">22</option>-->
                        <!--                            <option value="23">23</option>-->
                        <!--                            <option value="24">24</option>-->
                        <!--                            <option value="25">25</option>-->
                        <!--                            <option value="26">26</option>-->
                        <!--                            <option value="27">27</option>-->
                        <!--                            <option value="28">28</option>-->
                        <!--                            <option value="29">29</option>-->
                        <!--                            <option value="30">30</option>-->
                        <!--                            <option value="31">31</option>-->
                        <!--                        </select>-->
                        <!--                        <select class="form-select" name="month" id="month">-->
                        <!--                            <option value="01">янв.</option>-->
                        <!--                            <option value="02">фев.</option>-->
                        <!--                            <option value="03">март</option>-->
                        <!--                            <option value="04">апр.</option>-->
                        <!--                            <option value="05">май</option>-->
                        <!--                            <option value="06">июнь</option>-->
                        <!--                            <option value="07">июль</option>-->
                        <!--                            <option value="08">авг.</option>-->
                        <!--                            <option value="09">сент.</option>-->
                        <!--                            <option value="10">окт.</option>-->
                        <!--                            <option value="11">нояб.</option>-->
                        <!--                            <option value="12">дек.</option>-->
                        <!--                        </select>-->
                        <!--                        <select class="form-select" name="hours" id="hours">-->
                        <!--                            <option value="00">00</option>-->
                        <!--                            <option value="01">01</option>-->
                        <!--                            <option value="02">02</option>-->
                        <!--                            <option value="03">03</option>-->
                        <!--                            <option value="04">04</option>-->
                        <!--                            <option value="05">05</option>-->
                        <!--                            <option value="06">06</option>-->
                        <!--                            <option value="07">07</option>-->
                        <!--                            <option value="08">08</option>-->
                        <!--                            <option value="09">09</option>-->
                        <!--                            <option value="10">10</option>-->
                        <!--                            <option value="11">11</option>-->
                        <!--                            <option value="12">12</option>-->
                        <!--                            <option value="13">13</option>-->
                        <!--                            <option value="14">14</option>-->
                        <!--                            <option value="15">15</option>-->
                        <!--                            <option value="16">16</option>-->
                        <!--                            <option value="17">17</option>-->
                        <!--                            <option value="18">18</option>-->
                        <!--                            <option value="19">19</option>-->
                        <!--                            <option value="20">20</option>-->
                        <!--                            <option value="21">21</option>-->
                        <!--                            <option value="22">22</option>-->
                        <!--                            <option value="23">23</option>-->
                        <!--                        </select>-->
                        <!--                        <select class="form-select" name="minutes" id="minutes">-->
                        <!--                            <option value="00">00</option>-->
                        <!--                            <option value="01">01</option>-->
                        <!--                            <option value="02">02</option>-->
                        <!--                            <option value="03">03</option>-->
                        <!--                            <option value="04">04</option>-->
                        <!--                            <option value="05">05</option>-->
                        <!--                            <option value="06">06</option>-->
                        <!--                            <option value="07">07</option>-->
                        <!--                            <option value="08">08</option>-->
                        <!--                            <option value="09">09</option>-->
                        <!--                            <option value="10">10</option>-->
                        <!--                            <option value="11">11</option>-->
                        <!--                            <option value="12">12</option>-->
                        <!--                            <option value="13">13</option>-->
                        <!--                            <option value="14">14</option>-->
                        <!--                            <option value="15">15</option>-->
                        <!--                            <option value="16">16</option>-->
                        <!--                            <option value="17">17</option>-->
                        <!--                            <option value="18">18</option>-->
                        <!--                            <option value="19">19</option>-->
                        <!--                            <option value="20">20</option>-->
                        <!--                            <option value="21">21</option>-->
                        <!--                            <option value="22">22</option>-->
                        <!--                            <option value="23">23</option>-->
                        <!--                            <option value="24">24</option>-->
                        <!--                            <option value="25">25</option>-->
                        <!--                            <option value="26">26</option>-->
                        <!--                            <option value="27">27</option>-->
                        <!--                            <option value="28">28</option>-->
                        <!--                            <option value="29">29</option>-->
                        <!--                            <option value="30">30</option>-->
                        <!--                            <option value="31">31</option>-->
                        <!--                            <option value="32">32</option>-->
                        <!--                            <option value="33">33</option>-->
                        <!--                            <option value="34">34</option>-->
                        <!--                            <option value="35">35</option>-->
                        <!--                            <option value="36">36</option>-->
                        <!--                            <option value="37">37</option>-->
                        <!--                            <option value="38">38</option>-->
                        <!--                            <option value="39">39</option>-->
                        <!--                            <option value="40">40</option>-->
                        <!--                            <option value="41">41</option>-->
                        <!--                            <option value="42">42</option>-->
                        <!--                            <option value="43">43</option>-->
                        <!--                            <option value="44">44</option>-->
                        <!--                            <option value="45">45</option>-->
                        <!--                            <option value="46">46</option>-->
                        <!--                            <option value="47">47</option>-->
                        <!--                            <option value="48">48</option>-->
                        <!--                            <option value="49">49</option>-->
                        <!--                            <option value="50">50</option>-->
                        <!--                            <option value="51">51</option>-->
                        <!--                            <option value="52">52</option>-->
                        <!--                            <option value="53">53</option>-->
                        <!--                            <option value="54">54</option>-->
                        <!--                            <option value="55">55</option>-->
                        <!--                            <option value="56">56</option>-->
                        <!--                            <option value="57">57</option>-->
                        <!--                            <option value="58">58</option>-->
                        <!--                            <option value="59">59</option>-->
                        <!--                        </select>-->
                    </div>
                </div>
                <bkt-checkbox name="'Условия'" v-model="service.terms" id="terms" :rules="'required_boolean'">
                    <template #label>
                        Согласен с условиями пользовательского соглашения, политики сайта, обработки персональных
                        данных.
                    </template>
                </bkt-checkbox>
                <button class="bkt-button primary" :disabled="invalid || loading">
                    Получить услугу
                </button>
            </ValidationObserver>
        </section>
    </div>
</template>

<script>
    export default {
        name: "Agent",
        data() {
            return {
                loading: false,
                service: {
                    name: '',
                    email: '',
                    phone: '',
                    socialsForAnswer: [],
                    date: '',
                    terms: false,
                }
            }
        },
        methods: {
            sendApplication() {
                this.loading = true;
                axios.post('/api/send/', this.service)
                    .then(resp => {
                        this.loading = false;
                    })
                    .catch(error => {
                        this.loading = false;
                    })
            },
            toggleSocial(social) {
                let index = this.service.socialsForAnswer.indexOf(social);
                if(index < 0)
                {
                    this.service.socialsForAnswer.push(social)
                }
                else {
                    this.service.socialsForAnswer.splice(index, 1)
                }
            }
        }
    }
</script>

<style scoped>

</style>
