<template>
    <bkt-modal :id="'applicationModal'" title="Заявка менеджеру" modal_class="bkt-filters-modal"
               left_button_class="d-none" @right_action="sendApplication" :loading="loading"
               right_button="Отправить"
    >
        <template #body>
            <div class="bkt-form bkt-wrapper-column bkt-promo__form p-0 w-100">
                <div class="bkt-promo__block-wrapper" v-if="promo == true">
                    <div class="bkt-promo__block">
                        <div class="bkt-promo__block-body">
                            <h1 class="bkt-promo__block-title">Новичок?<br><span
                                class="bkt-text-yellow">сэкономьте до 50%</span></h1>
                            <h5 class="bkt-promo__block-subtitle">на торгах с нашей помощью</h5>
                            <h4 class="bkt-promo__block-text">
                                Воспользуйтесь нашим опытом побед, чтобы избежать ошибок и сэкономить время, деньги и
                                нервы.
                            </h4>
                        </div>
                        <button class="bkt-button bkt-button_yellow bkt-button_plump" @click="navigate('/agent')">
                            Подробнее о покупке без ЭЦП
                        </button>
                        <span type="button" class="bkt-close-button" @click="close"
                                aria-label="Close">
                            <bkt-icon :name="'Cancel'" :width="'20px'" :height="'20px'" color="white"></bkt-icon>
                        </span>
                    </div>
                </div>
                <div v-if="selected_lot" class="bkt-promo__lot-wrapper">
                    <label class="bkt-input__label bkt-form__label">
                        лот
                    </label>
                    <div class="bkt-wrapper bkt-gap bkt-nowrap" @click="navigate('/lot/'+selected_lot.id)">
                        <card-image-category :no_multiple="true"
                            v-if="(!selected_lot.photos || selected_lot.photos.length==0) && selected_lot && selected_lot.categories"
                            :categories="selected_lot.categories"></card-image-category>
                        <img v-if="selected_lot.photos.length>0" v-lazy="selected_lot.photos[0].preview"
                             class="bkt-card__image"
                        />
                        <h4 class="bkt-promo__lot-title bkt-text-truncate bkt-cursor-pointer">
                            {{selected_lot.description}}
                        </h4>
                    </div>
                </div>

                <bkt-input
                    v-model="service.name"
                    name="application_name"
                    type="text"
                    :rules="'required|alpha_spaces|min:2'"
                    label="имя фамилия <span class='bkt-text-red'>*</span>"
                    label_class="bkt-form__label"
                    field_name="Имя Фамилия"
                    placeholder="Иванов Иван"
                    icon_name="User"
                />
                <bkt-input
                    v-model="service.email"
                    :name="'application_email'"
                    type="email"
                    label="email <span class='bkt-text-red'>*</span>"
                    label_class="bkt-form__label"
                    field_name="Email"
                    :rules="'required'"
                    placeholder="pochta@gmail.com"
                    icon_name="Email"
                />
                <bkt-input
                    v-model="service.phone"
                    :name="'application_phone'"
                    type="tel"
                    label="номер телефона <span class='bkt-text-red'>*</span>"
                    label_class="bkt-form__label"
                    field_name="Номер телефона"
                    :rules="'required|phone'"
                    :placeholder="'+7 495 000-00-00'"
                    icon_name="Smartphone"
                    :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
                />
                <div class="bkt-input__wrapper">
                    <label class="bkt-input__label bkt-form__label" style="margin-bottom: 10px;">где вам удобнее
                        общаться <span class="bkt-text-red">*</span></label>
                    <ValidationProvider :name="'Мессенджеры'" rules="required|min:1" v-slot="{ errors }">
                        <div class="communications bkt-wrapper-between bkt-gap-small">
                            <bkt-checkbox wrapper_class="flex-fill"
                                          input_class="bkt-button bkt-bg-body flex-fill" name="Viber"
                                          v-model="service.socialsForAnswer" val="Viber"
                                          :border_color="service.socialsForAnswer.includes('Viber') ? 'primary': 'body'"
                            >
                                <template #input-check>
                                    <bkt-icon name="Viber" color="purple" class="bkt-button__icon"></bkt-icon>
                                </template>
                            </bkt-checkbox>
                            <bkt-checkbox wrapper_class="flex-fill"
                                          input_class="bkt-button bkt-bg-body flex-fill" name="Vk"
                                          v-model="service.socialsForAnswer" val="Vk"
                                          :border_color="service.socialsForAnswer.includes('Vk') ? 'primary': 'body'"
                            >
                                <template #input-check>
                                    <bkt-icon name="Vk" color="primary" class="bkt-button__icon"></bkt-icon>
                                </template>
                            </bkt-checkbox>
                            <bkt-checkbox wrapper_class="flex-fill"
                                          input_class="bkt-button bkt-bg-body flex-fill" name="Telegram"
                                          v-model="service.socialsForAnswer" val="Telegram"
                                          :border_color="service.socialsForAnswer.includes('Telegram') ? 'primary': 'body'"
                            >
                                <template #input-check>
                                    <bkt-icon name="Telegram" color="blue" class="bkt-button__icon"></bkt-icon>
                                </template>
                            </bkt-checkbox>
                            <bkt-checkbox wrapper_class="flex-fill"
                                          input_class="bkt-button bkt-bg-body flex-fill" name="WhatsApp"
                                          v-model="service.socialsForAnswer" val="WhatsApp"
                                          :border_color="service.socialsForAnswer.includes('WhatsApp') ? 'primary': 'body'"
                            >
                                <template #input-check>
                                    <bkt-icon name="WhatsApp" color="green" class="bkt-button__icon"></bkt-icon>
                                </template>
                            </bkt-checkbox>
                        </div>
                        <p class="bkt-input-error" v-if="errors.length>0">{{errors[0]}}</p>
                    </ValidationProvider>
                </div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    import CardImageCategory from "../CardImageCategory";

    export default {
        name: "ApplicationModal",
        components: {CardImageCategory},
        data() {
            return {
                loading: false,
                service: {
                    name: '',
                    email: '',
                    phone: '',
                    socialsForAnswer: [],
                    lotId: 0,
                },
                promo: localStorage.getItem('bkt_application_promo') || true,
            }
        },
        mounted() {
            if(this.user && this.isLoggedIn) {
                this.service.name = this.user.name +' '+this.user.lastName;
                this.service.email = this.user.email;
                this.service.phone = this.user.phone;
            }
        },
        computed: {
            selected_lot() {
                return this.$store.getters.selected_lot;
            },
            user() {
                return this.$store.getters.auth_user
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
        watch: {
            isLoggedIn: function (newVal, oldVal) {
                if (oldVal == false && newVal == true && this.user) {
                    this.service.name = this.user.name +' '+this.user.lastName;
                    this.service.email = this.user.email;
                    this.service.phone = this.user.phone;
                }
                else if (oldVal == true && newVal == false) {
                    this.service.name = '';
                    this.service.email = '';
                    this.service.phone = '';
                }
            },
            user: function (newVal, oldVal) {
                if (newVal !== null) {
                    this.service.name = this.user.name +' '+this.user.lastName;
                    this.service.email = this.user.email;
                    this.service.phone = this.user.phone;
                }
            }
        },
        methods: {
            sendApplication() {
                this.loading = true;
                let data = JSON.parse(JSON.stringify(this.service));
                // data.socialsForAnswer = [this.service.socialsForAnswer];
                data.lotId = this.selected_lot.id;
                axios.post('/api/send/application', data)
                    .then(resp => {
                        this.loading = false;
                        this.$store.dispatch('sendNotification',
                            {self: this, message: 'Заявка успешно отправлена. Менеджер скоро с Вами свяжется'});
                        // this.service = {
                        //     name: '',
                        //     email: '',
                        //     phone: '',
                        //     socialsForAnswer: [],
                        //     lotId: 0,
                        // };
                        this.service.lotId = 0;
                        this.$store.commit('closeModal', '#applicationModal');
                    })
                    .catch(error => {
                        // this.$store.dispatch('sendNotification', {self:this, type: 'error'});
                        this.loading = false;
                    })
            },
            navigate(path) {
                this.$store.commit('closeModal', '#applicationModal');
                if (this.$router.currentRoute.path != path) {
                    this.$router.push(path)
                }
            },
            close() {
                this.promo=false;
                localStorage.setItem('bkt_application_promo', 'false')
            },
        }
    }
</script>

<style scoped>

</style>
