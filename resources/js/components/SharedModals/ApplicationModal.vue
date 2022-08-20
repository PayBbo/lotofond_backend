<template>
    <bkt-modal :id="'applicationModal'" title="Заявка менеджеру" modal_class="bkt-filters-modal"
               left_button_class="d-none" @right_action="sendApplication" :loading="loading"
               right_button="Отправить"
    >
        <template #body>
            <div class="bkt-form bkt-wrapper-column">
                <bkt-input
                    v-model="service.name"
                    name="application_name"
                    type="text"
                    :rules="'required|alpha_spaces|min:2'"
                    label="имя фамилия"
                    label_class="bkt-form__label"
                    field_name="Имя Фамилия"
                    placeholder="Иванов Иван"
                    icon_name="User"
                />
                <bkt-input
                    v-model="service.email"
                    :name="'application_email'"
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
                    :name="'application_phone'"
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
                    <label class="bkt-input__label bkt-form__label" style="margin-bottom: 10px;">где вам удобнее
                        общаться</label>
                    <div class="communications bkt-wrapper-between bkt-gap-small">
                        <bkt-checkbox
                            input_class="bkt-button bkt-bg-body flex-fill" name="Viber"
                            v-model="service.socialsForAnswer" val="Viber" type="radio"
                            :border_color="service.socialsForAnswer=='Viber' ? 'primary': 'body'"
                        >
                            <template #input-check>
                                <bkt-icon name="Viber" color="purple" class="bkt-button__icon"></bkt-icon>
                            </template>
                        </bkt-checkbox>
                        <bkt-checkbox
                            input_class="bkt-button bkt-bg-body flex-fill" name="Vk"
                            v-model="service.socialsForAnswer" val="Vk" type="radio"
                            :border_color="service.socialsForAnswer=='Vk' ? 'primary': 'body'"
                        >
                            <template #input-check>
                                <bkt-icon name="Vk" color="primary" class="bkt-button__icon"></bkt-icon>
                            </template>
                        </bkt-checkbox>
                        <bkt-checkbox
                            input_class="bkt-button bkt-bg-body flex-fill" name="Telegram"
                            v-model="service.socialsForAnswer" val="Telegram" type="radio"
                            :border_color="service.socialsForAnswer=='Telegram' ? 'primary': 'body'"
                        >
                            <template #input-check>
                                <bkt-icon name="Telegram" color="blue" class="bkt-button__icon"></bkt-icon>
                            </template>
                        </bkt-checkbox>
                        <bkt-checkbox
                            input_class="bkt-button bkt-bg-body flex-fill" name="WhatsApp"
                            v-model="service.socialsForAnswer" val="WhatsApp" type="radio"
                            :border_color="service.socialsForAnswer=='WhatsApp' ? 'primary': 'body'"
                        >
                            <template #input-check>
                                <bkt-icon name="WhatsApp" color="green" class="bkt-button__icon"></bkt-icon>
                            </template>
                        </bkt-checkbox>
                    </div>
                </div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "ApplicationModal",
        data() {
            return {
                loading: false,
                service: {
                    name: '',
                    email: '',
                    phone: '',
                    socialsForAnswer: [],
                    lotId: 0,
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
                data.socialsForAnswer = [this.service.socialsForAnswer];
                data.lotId = this.selected_lot.id;
                axios.post('/api/send/application', data)
                    .then(resp => {
                        this.loading = false;
                        this.$store.dispatch('sendNotification',
                            {self:this, message: 'Заявка успешно отправлена. Менеджер скоро с Вами свяжется'});
                        this.service = {
                            name: '',
                            email: '',
                            phone: '',
                            socialsForAnswer: [],
                            lotId: 0,
                        };
                        this.$store.commit('closeModal', '#applicationModal');
                    })
                    .catch(error => {
                        // this.$store.dispatch('sendNotification', {self:this, type: 'error'});
                        this.loading = false;
                    })
            },
        }
    }
</script>

<style scoped>

</style>
