<template>
    <div class="container bkt-page bkt-agent bkt-container">
        <h1 class="bkt-page__title">Покупка через агента</h1>
        <div class="promo-wrapper">
            <div class="promo">
                <img class="promo__image" src="/images/agent-image.png" alt="">
                <div class="promo_block_wrapper">
                    <h1>Новичок?</h1>
                    <h1 style="color:rgb(255, 196, 0)">сэкономьте до 50%</h1>
                    <h2>на торгах с нашей помощью</h2>
                    <p>Воспользуйтесь нашим опытом побед, чтобы избежать ошибок и сэкономить время, деньги и
                        нервы.
                    </p>
                </div>
                <div class="promo_block_wrapper">
                    <div class="promo_block">
                        <div class="check_mark bkt-bg-pink">&#10003;</div>
                        <span>ЭЦП не нужна</span>
                    </div>
                    <div class="promo_block">
                        <div class="check_mark bkt-bg-blue">&#10003;</div>
                        <span>Аккредитация не нужна</span>
                    </div>
                    <div class="promo_block">
                        <div class="check_mark bkt-bg-teal">&#10003;</div>
                        <span>Заполнять документы не нужно</span>
                    </div>
                </div>
                <div class="promo_buy">
                    <h2>3000 ₽</h2>
                    <button class="bkt-button btn-yellow bkt-bg-yellow">Купить</button>
                </div>
            </div>
            <div class="promo-shadow"
                 style="background-color: rgba(13, 110, 255, 0.4); z-index: -1; top: -5px; width: calc(100% - 5vw);">
            </div>
            <div class="promo-shadow"
                 style="background-color: rgba(13, 110, 255, 0.2); z-index: -2; top: -5px; width: calc(100% - 10vw);">
            </div>
        </div>
        <h2>Что это даёт?</h2>
        <div class="row_div">
            <div class="profit_cell">
                <div class="bkt-icon-frame" style="background-color: rgb(226, 242, 255);">
                    <bkt-icon name="LightBulb" color="blue"></bkt-icon>
                </div>
                <p>Не нужно вникать в тонкости процесса торгов</p>
            </div>
            <div class="profit_cell">
                <div class="bkt-icon-frame" style="background-color: rgb(223, 255, 247);">
                    <bkt-icon name="Like" color="green"></bkt-icon>
                </div>
                <p>Обходится дешевле, чем покупка ЭЦП</p>
            </div>
            <div class="profit_cell">
                <div class="bkt-icon-frame" style="background-color: rgb(255, 248, 226);">
                    <bkt-icon name="Devices" color="yellow"></bkt-icon>
                </div>
                <p>Не нужно изучать сервисы и площадки</p>
            </div>
            <div class="profit_cell">
                <div class="bkt-icon-frame" style="background-color: rgb(255, 228, 242);">
                    <bkt-icon name="Clipboard" color="pink"></bkt-icon>
                </div>
                <p>Гарантируем допуск к торгам</p>
            </div>
            <div class="profit_cell">
                <div class="bkt-icon-frame" style="background-color: rgb(255, 240, 227);">
                    <bkt-icon name="Clock" color="red"></bkt-icon>
                </div>
                <p>Экономим вам время и силы</p>
            </div>
        </div>
        <h2>Что делаем мы?</h2>
        <div class="row_div">
            <div class="action_cell">
                <div class="plus">
                    <div>+</div>
                </div>
                <p>Проводим анализ лота</p>
                <div class="number"><span>01</span></div>
            </div>
            <div class="action_cell">
                <div class="plus">
                    <div>+</div>
                </div>
                <div>
                    <p>Выезжаем на место для получения доп. информации*</p>
                    <p style="color: rgb(172, 172, 172)">*По Москве и Московской области</p>
                </div>
                <div class="number"><span>02</span></div>
            </div>
            <div class="action_cell">
                <div class="plus">
                    <div>+</div>
                </div>
                <p>Даём шаблоны документов по торгам</p>
                <div class="number"><span>03</span></div>
            </div>
            <div class="action_cell">
                <div class="plus">
                    <div>+</div>
                </div>
                <p>Участвуем в торгах от вашего имени</p>
                <div class="number"><span>04</span></div>
            </div>
            <div class="action_cell">
                <div class="plus">
                    <div>+</div>
                </div>
                <p>Контролируем оплату и возврат задатка</p>
                <div class="number"><span>05</span></div>
            </div>
        </div>
        <h2>Что от вас?</h2>
        <div class="row_div">
            <div class="todo_cell">
                <div class="check_mark">&#10003;</div>
                <p>Выбрать интересующий лот или обозначить пожелания</p>
            </div>
            <div class="todo_cell">
                <div class="check_mark">&#10003;</div>
                <p>Оплатить услугу</p>
            </div>
            <div class="todo_cell">
                <div class="check_mark">&#10003;</div>
                <p>Заполнить шаблоны документов для участия</p>
            </div>
            <div class="todo_cell">
                <div class="check_mark">&#10003;</div>
                <p>Вовремя внести задаток</p>
            </div>
        </div>
        <div class="mini-promo">
            <h2>С нами <strong style="color:rgb(255, 196, 0)">шансы на победу</strong> в торгах увеличиваются до
            </h2><strong style="color:rgb(255, 196, 0)">80%</strong>
        </div>
        <h2>Как получить услугу?</h2>
        <form class="modal-content bkt-modal-content form-content" action="#">
            <div data-v-549085c8="" class="bkt-input__wrapper">
                <label for="name" class="bkt-input__label">введите ваше имя</label>
                <div class="bkt-input__group">
                    <input type="text" name="name" id="name" placeholder="Иванов Иван" class="bkt-input">
                    <div class="bkt-input__group-item">
                        <div class="bkt-input__icon">
                            <svg version="1.0"
                                 xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"
                                 viewBox="0 0 478.000000 512.000000" preserveAspectRatio="xMidYMid meet"
                                 class="bkt-fill-red" name="User">
                                <g
                                    transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)">
                                    <path d="M2215 5113 c-223 -28 -440 -111 -615 -234 -96 -68 -241 -213 -309
                        -309 -240 -340 -299 -742 -175 -1178 34 -120 159 -367 241 -477 360 -480 905
                        -661 1403 -466 432 169 768 594 875 1108 25 118 30 318 12 438 -46 292 -168
                        536 -372 741 -198 199 -454 328 -726 368 -97 15 -258 19 -334 9z m355 -523
                        c397 -113 648 -510 577 -915 -77 -436 -402 -778 -762 -802 -148 -10 -310 47
                        -450 158 -181 144 -315 366 -365 609 -65 311 50 622 299 814 98 76 228 132
                        359 156 77 14 258 4 342 -20z"></path>
                                    <path d="M1108 2109 c-490 -58 -883 -371 -1031 -824 -62 -187 -81 -405 -75
                        -830 4 -287 8 -308 71 -373 53 -56 102 -76 182 -76 80 0 129 20 182 76 66 69
                        67 70 74 523 7 464 9 480 92 640 49 94 159 211 249 264 79 46 206 88 308 101
                        59 8 453 10 1285 8 l1200 -3 80 -23 c263 -74 440 -246 516 -502 21 -70 23
                        -100 28 -485 7 -453 8 -454 74 -523 53 -56 102 -76 182 -76 82 0 134 22 185
                        80 60 69 60 67 60 491 0 420 -7 501 -55 668 -35 123 -120 292 -199 396 -176
                        232 -412 378 -734 451 l-97 22 -1250 2 c-687 1 -1284 -2 -1327 -7z"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div data-v-549085c8="" class="bkt-input__wrapper"><label
                for="phone"
                class="bkt-input__label">введите
                номер телефона</label>
                <div class="bkt-input__group"><input type="tel"
                                                     name="phone" id="phone"
                                                     placeholder="+7 495 000-00-00"
                                                     class="bkt-input">
                    <div class="bkt-input__group-item">
                        <div class="bkt-input__icon">
                            <svg data-v-19124af8=""
                                 xmlns="http://www.w3.org/2000/svg"
                                 width="100%" height="100%" viewBox="0 0 298.6 470" class="bkt-fill-green"
                                 name="Smartphone">
                                <path data-v-19124af8=""
                                      d="M491,636H311l-7.3-1.5c-31.2-6.4-51.9-31.8-51.9-64.2q-.2-114.9,0-229.7c0-36.7-.2-73.3,0-110,.1-29.8,19.2-54.6,47.6-62.1,3.8-1,7.7-1.7,11.6-2.5H491c3.9.8,7.8,1.5,11.6,2.5,28.7,7.6,47.6,32.5,47.6,63.2q.1,122.9,0,245.7c0,31.5.2,63,0,94.4-.2,29.6-19.4,54.2-47.6,61.7C498.8,634.5,494.9,635.2,491,636ZM294.2,400.8q0,83.6.1,166.9c0,17.3,8.1,25.3,25.4,25.3H483.6c15.6,0,24.1-8.5,24.1-24.1q.2-168,0-335.9c0-15.5-8.6-24-24.2-24H319.6c-17.3,0-25.3,8.1-25.3,25.4Q294.2,317.7,294.2,400.8Z"
                                      transform="translate(-251.7 -166)"></path>
                                <path data-v-19124af8=""
                                      d="M401.1,529c7,0,14-.1,21,0,11.9.2,21,8.9,21.6,20.6s-7.7,21.2-19.1,21.7a468.4,468.4,0,0,1-47.4,0c-11.4-.6-19.6-11.1-18.9-22A21.4,21.4,0,0,1,379.6,529C386.8,528.9,394,529,401.1,529Z"
                                      transform="translate(-251.7 -166)"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <p class="bkt-input-error"></p>
            </div>
            <div data-v-549085c8="" class="bkt-input__wrapper"><label
                for="email"
                class="bkt-input__label">e-mail</label>
                <div class="bkt-input__group"><input type="email"
                                                     name="email" id="email"
                                                     placeholder="pochta@gmail.com"
                                                     class="bkt-input">
                    <div class="bkt-input__group-item">
                        <div class="bkt-input__icon">
                            <svg data-v-285a95b9=""
                                 version="1.0"
                                 xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"
                                 viewBox="0 0 516.000000 516.000000" preserveAspectRatio="xMidYMid meet"
                                 class="bkt-fill-yellow" name="Email">
                                <g data-v-285a95b9=""
                                   transform="translate(0.000000,516.000000) scale(0.100000,-0.100000)">
                                    <path data-v-285a95b9="" d="M2445 5149 c-174 -23 -384 -107 -517 -208 -68 -51 -1491 -1407 -1621
                    -1544 -133 -140 -220 -297 -276 -496 l-26 -96 0 -940 0 -940 26 -96 c58 -209
                    150 -372 289 -510 136 -136 303 -230 509 -288 l96 -26 1655 0 1655 0 96 26
                    c209 58 372 150 510 289 136 136 230 303 288 509 l26 96 0 940 0 940 -27 97
                    c-54 196 -143 356 -275 495 -129 136 -1553 1492 -1621 1544 -87 66 -265 153
                    -367 178 -154 38 -281 47 -420 30z m337 -492 c37 -13 93 -40 124 -58 35 -21
                    330 -297 795 -742 406 -390 739 -711 739 -715 0 -4 -332 -338 -737 -743 -793
                    -790 -787 -784 -938 -832 -99 -31 -271 -31 -370 0 -151 48 -145 42 -937 832
                    -406 405 -738 739 -738 743 0 16 1470 1414 1524 1449 115 75 207 99 361 95 86
                    -3 125 -9 177 -29z m-850 -3376 c375 -271 868 -280 1263 -23 52 34 258 233
                    783 756 l712 711 -2 -885 -3 -885 -23 -65 c-66 -182 -210 -326 -392 -392 l-65
                    -23 -1603 -3 c-1792 -3 -1655 -8 -1804 70 -130 67 -237 188 -296 336 l-27 67
                    -3 890 -2 890 702 -701 c387 -386 729 -720 760 -743z"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
                <p class="bkt-input-error"></p>
            </div>
            <div class="bkt-input__wrapper">
                <label class="bkt-input__label" style="margin-bottom: 10px;">где вам удобнее общаться</label>
                <div class="communications">
                    <button class="bkt-button btn-light-gray">
                        <bkt-icon name="Viber" color="purple"></bkt-icon>
                    </button>
                    <button class="bkt-button btn-light-gray">
                        <bkt-icon name="Vk" color="primary"></bkt-icon>
                    </button>
                    <button class="bkt-button btn-light-gray">
                        <bkt-icon name="Telegram" color="blue"></bkt-icon>
                    </button>
                    <button class="bkt-button btn-light-gray">
                        <bkt-icon name="WhatsApp"  color="green"></bkt-icon>
                    </button>
                    <button class="bkt-button btn-light-gray">перезвоним в течение 10 минут</button>
                </div>
            </div>
            <label class="bkt-form__label" for="" style="align-self: flex-start; font-size: 15px;">позвоните
                лучше</label>
            <div class="time_to_call">
                <select class="form-select" name="day" id="day">
                    <option value="1">01</option>
                    <option value="2">02</option>
                    <option value="3">03</option>
                    <option value="4">04</option>
                    <option value="5">05</option>
                    <option value="6">06</option>
                    <option value="7">07</option>
                    <option value="8">08</option>
                    <option value="9">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                </select>
                <select class="form-select" name="month" id="month">
                    <option value="01">янв.</option>
                    <option value="02">фев.</option>
                    <option value="03">март</option>
                    <option value="04">апр.</option>
                    <option value="05">май</option>
                    <option value="06">июнь</option>
                    <option value="07">июль</option>
                    <option value="08">авг.</option>
                    <option value="09">сент.</option>
                    <option value="10">окт.</option>
                    <option value="11">нояб.</option>
                    <option value="12">дек.</option>
                </select>
                <select class="form-select" name="hours" id="hours">
                    <option value="00">00</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                </select>
                <select class="form-select" name="minutes" id="minutes">
                    <option value="00">00</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
                    <option value="49">49</option>
                    <option value="50">50</option>
                    <option value="51">51</option>
                    <option value="52">52</option>
                    <option value="53">53</option>
                    <option value="54">54</option>
                    <option value="55">55</option>
                    <option value="56">56</option>
                    <option value="57">57</option>
                    <option value="58">58</option>
                    <option value="59">59</option>
                </select>
            </div>
            <bkt-checkbox name="'Условия'" id="terms" :rules="'required_boolean'">
                <template #label>
                    Согласен с условиями пользовательского соглашения,<br>политики сайта, обработки персональных
                    данных.
                </template>
            </bkt-checkbox>
            <button class="bkt-button primary">
                Получить услугу
            </button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "Agent"
    }
</script>

<style scoped>

</style>
