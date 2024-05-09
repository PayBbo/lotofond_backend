<template>
    <div class="container bkt-promo bkt-page bkt-container">
        <section>
            <h1 class="bkt-page__title">Как работает Лотофонд</h1>
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
<!--                        <h2>3000 ₽</h2>-->
<!--                        <button class="bkt-button bkt-button_yellow bkt-button_plump" @click="scrollToElement">Купить-->
<!--                        </button>-->
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
<!--        <section ref="form">-->
<!--            <h2 class="bkt-page__subtitle">Как получить услугу?</h2>-->
<!--            <ValidationObserver v-slot="{ invalid }" tag="div" class="bkt-card bkt-promo__form bkt-form">-->
<!--                <div v-if="selected_lot" class="bkt-promo__lot-wrapper">-->
<!--                    <label class="bkt-input__label bkt-form__label">-->
<!--                        лот-->
<!--                    </label>-->
<!--                    <div class="bkt-wrapper bkt-gap bkt-nowrap">-->
<!--                        <card-image-category :no_multiple="true"-->
<!--                                             v-if="(!selected_lot.photos || selected_lot.photos.length==0) && selected_lot && selected_lot.categories"-->
<!--                                             :categories="selected_lot.categories"></card-image-category>-->
<!--                        <img v-if="selected_lot.photos.length>0" v-lazy="selected_lot.photos[0].preview" class="bkt-card__image"/>-->
<!--                        <router-link :to="'/lot/'+selected_lot.id">-->
<!--                            <h4 class="bkt-promo__lot-title bkt-text-truncate bkt-cursor-pointer">-->
<!--                                {{selected_lot.description}}-->
<!--                            </h4>-->
<!--                        </router-link>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <bkt-input-->
<!--                    v-model="service.name"-->
<!--                    name="name"-->
<!--                    type="text"-->
<!--                    :rules="'required|alpha_spaces|min:2'"-->
<!--                    label="имя фамилия <span class='bkt-text-red'>*</span>"-->
<!--                    label_class="bkt-form__label"-->
<!--                    field_name="Имя Фамилия"-->
<!--                    placeholder="Иванов Иван"-->
<!--                    icon_name="User"-->
<!--                />-->
<!--                <bkt-input-->
<!--                    v-model="service.email"-->
<!--                    :name="'email'"-->
<!--                    type="email"-->
<!--                    label="email <span class='bkt-text-red'>*</span>"-->
<!--                    label_class="bkt-form__label"-->
<!--                    field_name="Email"-->
<!--                    :rules="'required'"-->
<!--                    placeholder="pochta@gmail.com"-->
<!--                    icon_name="Email"-->
<!--                />-->
<!--                <bkt-input-->
<!--                    v-model="service.phone"-->
<!--                    :name="'phone'"-->
<!--                    type="tel"-->
<!--                    label="номер телефона <span class='bkt-text-red'>*</span>"-->
<!--                    label_class="bkt-form__label"-->
<!--                    field_name="Номер телефона"-->
<!--                    :rules="'required|phone'"-->
<!--                    :placeholder="'+7 495 000-00-00'"-->
<!--                    icon_name="Smartphone"-->
<!--                    :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"-->
<!--                />-->
<!--                <div class="bkt-input__wrapper">-->
<!--                    <label class="bkt-input__label bkt-form__label" style="margin-bottom: 10px;">-->
<!--                        где вам удобнее общаться <span class="bkt-text-red">*</span>-->
<!--                    </label>-->
<!--                    <ValidationProvider :name="'Мессенджеры'" rules="required|min:1" v-slot="{ errors }">-->
<!--                        <div class="communications">-->
<!--                            <bkt-checkbox wrapper_class="flex-fill"-->
<!--                                input_class="bkt-button bkt-bg-body flex-fill" name="Viber"-->
<!--                                v-model="service.socialsForAnswer" val="Viber"-->
<!--                                :border_color="service.socialsForAnswer.includes('Viber') ? 'primary': 'body'"-->
<!--                            >-->
<!--                                <template #input-check>-->
<!--                                    <bkt-icon name="Viber" color="purple" class="bkt-button__icon"></bkt-icon>-->
<!--                                </template>-->
<!--                            </bkt-checkbox>-->
<!--                            <bkt-checkbox wrapper_class="flex-fill"-->
<!--                                input_class="bkt-button bkt-bg-body flex-fill" name="Vk"-->
<!--                                v-model="service.socialsForAnswer" val="Vk"-->
<!--                                :border_color="service.socialsForAnswer.includes('Vk') ? 'primary': 'body'"-->
<!--                            >-->
<!--                                <template #input-check>-->
<!--                                    <bkt-icon name="Vk" color="primary" class="bkt-button__icon"></bkt-icon>-->
<!--                                </template>-->
<!--                            </bkt-checkbox>-->
<!--                            <bkt-checkbox wrapper_class="flex-fill"-->
<!--                                input_class="bkt-button bkt-bg-body flex-fill" name="Telegram"-->
<!--                                v-model="service.socialsForAnswer" val="Telegram"-->
<!--                                :border_color="service.socialsForAnswer.includes('Telegram') ? 'primary': 'body'"-->
<!--                            >-->
<!--                                <template #input-check>-->
<!--                                    <bkt-icon name="Telegram" color="blue" class="bkt-button__icon"></bkt-icon>-->
<!--                                </template>-->
<!--                            </bkt-checkbox>-->
<!--                            <bkt-checkbox wrapper_class="flex-fill"-->
<!--                                input_class="bkt-button bkt-bg-body flex-fill" name="WhatsApp"-->
<!--                                v-model="service.socialsForAnswer" val="WhatsApp"-->
<!--                                :border_color="service.socialsForAnswer.includes('WhatsApp') ? 'primary': 'body'"-->
<!--                            >-->
<!--                                <template #input-check>-->
<!--                                    <bkt-icon name="WhatsApp" color="green" class="bkt-button__icon"></bkt-icon>-->
<!--                                </template>-->
<!--                            </bkt-checkbox>-->
<!--                            <div class="bkt-button bkt-bg-body bkt-text-main">перезвоним в течение 10 минут</div>-->
<!--                        </div>-->
<!--                        <p class="bkt-input-error" v-if="errors.length>0">{{errors[0]}}</p>-->
<!--                    </ValidationProvider>-->
<!--                </div>-->
<!--                <div class="bkt-input__wrapper">-->
<!--                    <label class="bkt-form__label">-->
<!--                        позвоните лучше-->
<!--                    </label>-->
<!--                    <div class="time_to_call">-->
<!--                        <bkt-datepicker v-model="service.dateForCallback" type="datetime" name="dateForCallback"-->
<!--                                        field_name="'позвоните лучше'"-->
<!--                        >-->
<!--                        </bkt-datepicker>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <bkt-checkbox name="'Условия'" v-model="service.terms" id="terms" :rules="'required_boolean'">-->
<!--                    <template #label>-->
<!--                        Согласен с условиями пользовательского соглашения, политики сайта, обработки персональных-->
<!--                        данных. <span class="bkt-text-red" style="font-size: 14px;">*</span>-->
<!--                    </template>-->
<!--                </bkt-checkbox>-->
<!--                <button class="bkt-button primary" :disabled="invalid || loading" @click="sendApplication">-->
<!--                    Получить услугу-->
<!--                </button>-->
<!--            </ValidationObserver>-->
<!--        </section>-->
    </div>
</template>

<script>
    import CardImageCategory from "../components/CardImageCategory";
    export default {
        name: "Agent",
        components: {CardImageCategory},
        data() {
            return {
                loading: false,
                service: {
                    name: '',
                    email: '',
                    phone: '',
                    socialsForAnswer: [],
                    dateForCallback: '',
                    paymentTradingTypes:['purchaseBidByAgent'],
                    terms: false,
                }
            }
        },
        computed: {
            selected_lot() {
                return this.$store.getters.selected_lot
            }
        },
        methods: {
            sendApplication() {
                this.loading = true;
                let data = JSON.parse(JSON.stringify(this.service));
                // data.socialsForAnswer = [this.service.socialsForAnswer];
                axios.post('/api/send/application', data)
                    .then(resp => {
                        this.loading = false;
                        this.$store.dispatch('sendNotification',
                            {self: this, message: 'Заявка на услугу успешно отправлена менеджеру'})
                    })
                    .catch(error => {
                        this.loading = false;
                    })
            },
            scrollToElement() {
                const el = this.$refs.form;
                if (el) {
                    el.scrollIntoView({block: 'start', scrollBehavior: 'smooth'});
                }
            }
        }
    }
</script>

<style scoped>

</style>
