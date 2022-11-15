<template>
    <div class="container bkt-page bkt-container">
        <h1 class="bkt-page__title">Контакты</h1>
        <bkt-modal :id="'details'" title="Реквизиты Исполнителя" modal_class="bkt-filters-modal">
            <template #body>
                <div>
                    <p><strong>ИП Валигурский С.Д.</strong></p>
                    <p><strong>ИНН:</strong> 502982976506 <strong>ОГРН:</strong> 318502900011975</p>
                    <p>Российская Федерация, 141014, Московская область, г. Мытищи, ул. Трудовая, д. 32</p>
                    <p><strong>Расчётный счёт:</strong> 40802810440000043320 в ПАО СБЕРБАНК, г. Москва</p>
                    <p><strong>Кор. счёт:</strong> 30101810400000000225</p>
                    <p><strong>БИК:</strong> 044525225</p>
                    <strong><a :href="contacts.email ? 'mailto:'+contacts.email : ''" class="bkt-text-primary">
                        <skeleton>
                            {{contacts.email ? contacts.email : ''}}
                        </skeleton>
                    </a></strong>
                </div>
            </template>
            <template #footer>
                <button class="bkt-button primary bkt-modal-save" data-bs-dismiss="modal">
                    Закрыть
                </button>
            </template>
        </bkt-modal>
        <div class="bkt-form bkt-form_wide bkt-gap-row-large">
            <div class="col-12 col-lg-4 bkt-form__offset-right">
                <div class="bkt-wrapper-column bkt-gap-large">
<!--                    <div class="bkt-card__row">-->
<!--                        <div class="col-12 col-lg-10">-->
<!--                            <div class="bkt-card__row-column">-->
<!--                                <h5 class="bkt-text-neutral-dark">-->
<!--                                    телефон-->
<!--                                </h5>-->
<!--                                <h4 class="bkt-card__title">+7 916 018-48-58</h4>-->
<!--                                <a class="bkt-button primary bkt-text-white bkt-w-sm-100" href="tel:+79160184858">-->
<!--                                    Перезвонить мне-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-12 col-lg-2 d-none d-lg-block">-->
<!--                            <div class="bkt-card__category ms-auto bkt-bg-green-lighter">-->
<!--                                <span class="bkt-card__category-icon">-->
<!--                                    <bkt-icon name="Smartphone" color="green" height="22px"></bkt-icon>-->
<!--                                </span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="bkt-card__row">
                        <div class="col-12 col-lg-10">
                            <div class="bkt-card__row-column">
                                <h5 class="bkt-text-neutral-dark">
                                    e-mail
                                </h5>
                                <h4 class="bkt-card__title"><skeleton>{{contacts.email ? contacts.email : ''}}</skeleton></h4>
                                <a class="bkt-button primary bkt-text-white bkt-w-sm-100" :href="'mailto:'+contacts.email" v-if="contacts.email">
                                    Написать
                                </a>
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
<!--                    <div class="bkt-card__row">-->
<!--                        <div class="col-12 col-lg-10">-->
<!--                            <div class="bkt-card__row-column">-->
<!--                                <h5 class="bkt-text-neutral-dark">-->
<!--                                    реквизиты-->
<!--                                </h5>-->
<!--                                <h4 class="bkt-card__title">исполнителя</h4>-->
<!--                                <button class="bkt-button primary bkt-text-white bkt-w-sm-100" data-bs-toggle="modal" data-bs-target="#details">-->
<!--                                    Посмотреть-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-12 col-lg-2 d-none d-lg-block">-->
<!--                            <div class="bkt-card__category ms-auto bkt-bg-green-lighter">-->
<!--                                <span class="bkt-card__category-icon">-->
<!--                                   <bkt-icon name="Email" color="green"></bkt-icon>-->
<!--                                </span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <button class="bkt-button bkt-bg-white bkt-text-primary text-uppercase" data-bs-toggle="modal" data-bs-target="#details">
                        реквизиты Исполнителя
                    </button>
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
                        <ValidationObserver v-slot="{ invalid }" ref="observer" tag="div" class="bkt-form align-items-end wide">
                            <div class="col-12">
                                <bkt-textarea name="message"
                                              field_name="вопроса"
                                              v-model="contact.question" rows="6" rules="required"
                                              label="Задайте вопрос или опишите проблему"
                                              label_class="bkt-card__title" no_group_item
                                >
                                </bkt-textarea>
                            </div>
                            <div class="col">
                                <label class="bkt-input__label bkt-form__label mt-0">куда вам прислать ответ</label>
                                <div class="bkt-select__wrapper">
                                    <select class="form-select bkt-select w-100" v-model="contact.communicationType">
                                        <option value="email">E-mail</option>
                                        <option value="phone">Телефон</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5">
                                <bkt-input v-if="contact.communicationType=='email'" v-model="email"
                                           :name="'email'" label="ваш e-mail" field_name="E-mail"
                                           :rules="'required|email'"
                                           label_class="bkt-form__label d-lg-none mt-0"
                                           no_group_item
                                           errors_class="d-lg-none"
                                />
                                <bkt-input
                                    v-model="phone"
                                    v-if="contact.communicationType=='phone'"
                                    :name="'phone'"
                                    type="tel"
                                    field_name="Телефон"
                                    label="ваш номер телефона"
                                    label_class="bkt-form__label d-lg-none mt-0"
                                    :rules="'required|phone'"
                                    :placeholder="'+7 495 000-00-00'"
                                    :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####']"
                                    no_group_item
                                    errors_class="d-lg-none"
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
<!--                    <button class="bkt-button_pill bkt-border-primary bkt-w-md-100 ms-auto" @click="subscribe">-->
<!--                        Подписаться на новости-->
<!--                    </button>-->
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
                    question: '',
                    communicationType: 'email',
                    communication: '',
                },
                phone:'',
                email:''
            };
        },
        computed: {
            contacts() {
                return this.$store.getters.main_contacts
            },
        },
        methods: {
            submit() {
                this.loading = true;
                axios.post('/api/send/contact', this.contact)
                    .then(resp => {
                        this.loading = false;
                        this.$store.dispatch('sendNotification',
                            {self:this, message: 'Вопрос успешно отправлен'});
                        this.contact = {
                            question: '',
                            communicationType: 'email',
                            communication: '',
                        };
                        this.$nextTick(() => {
                            this.$refs.observer.reset();
                        });
                    })
                    .catch(error => {
                        // this.$store.dispatch('sendNotification', {self:this, type: 'error'});
                        this.loading = false;
                    })
            },
            subscribe() {

            },
        }
    }
</script>

<style scoped>

</style>
