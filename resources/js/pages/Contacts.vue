<template>
    <div class="container bkt-page bkt-container">
        <h1 class="bkt-page__title">Контакты</h1>
        <div class="bkt-form bkt-form_wide bkt-gap-row-large">
            <div class="col-12 col-lg-4 bkt-form__offset-right">
                <div class="bkt-wrapper-column bkt-gap-large">
                    <div class="bkt-card__row">
                        <div class="col-12 col-lg-10">
                            <div class="bkt-card__row-column">
                                <h5 class="bkt-text-neutral-dark">
                                    телефон
                                </h5>
                                <h4 class="bkt-card__title">+7 (495) 500-20-60</h4>
                                <button class="bkt-button primary bkt-w-sm-100" @click="phoneMe">
                                    Перезвонить мне
                                </button>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2 d-none d-lg-block">
                            <div class="bkt-card__category ms-auto bkt-bg-green-lighter">
                                <span class="bkt-card__category-icon">
                                    <bkt-icon name="Smartphone" color="green" height="22px"></bkt-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bkt-card__row">
                        <div class="col-12 col-lg-10">
                            <div class="bkt-card__row-column">
                                <h5 class="bkt-text-neutral-dark">
                                    e-mail
                                </h5>
                                <h4 class="bkt-card__title">bankrot@pochta.ru</h4>
                                <button class="bkt-button primary bkt-w-sm-100" @click="writeMe">
                                    Написать
                                </button>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2 d-none d-lg-block">
                            <div class="bkt-card__category ms-auto bkt-bg-yellow-lighter">
                                <span class="bkt-card__category-icon">
                                   <bkt-icon name="Email" color="yellow"></bkt-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bkt-wrapper bkt-gap-small ms-lg-0">
                        <a class="bkt-button bkt-button-icon bkt-bg-white" href="#">
                            <bkt-icon name="Vk" color="primary"></bkt-icon>
                        </a>
                        <a class="bkt-button bkt-button-icon bkt-bg-white" href="#">
                            <bkt-icon name="Instagram" color="gradient"></bkt-icon>
                        </a>
                        <a class="bkt-button bkt-button-icon bkt-bg-white" href="#">
                            <bkt-icon name="Telegram" color="blue"></bkt-icon>
                        </a>
                        <a class="bkt-button bkt-button-icon bkt-bg-white" href="#">
                            <bkt-icon name="Youtube" color="red"></bkt-icon>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="bkt-wrapper-column bkt-gap-large">
                    <div class="bkt-card bkt-card__body">
                        <ValidationObserver v-slot="{ invalid }" tag="div" class="bkt-form align-items-end wide">
                            <div class="col-12">
                                <bkt-textarea :name="'message'"
                                              field_name="Сообщение"
                                              v-model="contact.message" rows="6" rules="required"
                                              label="Задайте вопрос или опишите проблему"
                                              label_class="bkt-card__title"></bkt-textarea>
                            </div>
                            <div class="col">
                                <label class="bkt-input__label bkt-form__label mt-0">куда вам прислать ответ</label>
                                <div class="bkt-select__wrapper">
                                    <select class="form-select bkt-select w-100" v-model="contact.type">
                                        <option value="email">E-mail</option>
                                        <option value="phone">Телефон</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5">
                                <bkt-input v-if="contact.type=='email'" v-model="contact.email"
                                           :name="'email'" label="ваш e-mail" field_name="E-mail"
                                           :rules="'required|email'"
                                           label_class="bkt-form__label d-lg-none mt-0"
                                />
                                <bkt-input
                                    v-model="user.phone"
                                    v-if="contact.type=='phone'"
                                    :name="'phone'"
                                    type="tel"
                                    field_name="Телефон"
                                    label="ваш номер телефона"
                                    :rules="'required|phone'"
                                    :placeholder="'+7 495 000-00-00'"
                                    :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####']"
                                />
                            </div>
                            <div class="col">
                                <button class="bkt-button primary bkt-button_plump bkt-w-md-100 float-end"
                                        :disabled="invalid" @click="submit">
                                    <span v-if="loading" class="spinner-border spinner-border-sm" role="status"
                                          aria-hidden="true"></span>
                                    Задать вопрос
                                </button>
                            </div>
                        </ValidationObserver>
                    </div>
                    <button class="bkt-button_pill bkt-border-primary bkt-w-md-100 ms-auto" @click="subscribe">
                        Подписаться на новости
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Contacts",
        data() {
            return {
                loading: false,
                contact: {
                    message: '',
                    type: 'email',
                    email: '',
                    phone: '',
                }
            };
        },
        methods: {
            submit() {

            },
            subscribe() {

            },
            phoneMe() {

            },
            writeMe() {

            },
        }
    }
</script>

<style scoped>

</style>
