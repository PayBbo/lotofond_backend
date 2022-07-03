<template>
    <div class="bkt-form wide">
        <div class="col-12 col-lg-5 bkt-form__offset-right">
            <div class="bkt-card bkt-card__body">
                <h3 class="bkt-card__title">Ваши данные</h3>
                <bkt-input
                    v-model="user.lastname"
                    :name="'lastname'"
                    type="text"
                    :rules="'required|alpha|min:2'"
                    label="фамилия"
                    placeholder="Иванов"
                    icon_name="Pencil" icon_color="primary"
                />
                <bkt-input
                    v-model="user.name"
                    name="name"
                    type="text"
                    :rules="'required|alpha|min:2'"
                    label="имя"
                    placeholder="Иван"
                    icon_name="Pencil" icon_color="primary"
                />
                <bkt-input
                    v-model="user.name"
                    name="name"
                    type="text"
                    :rules="'alpha|min:2'"
                    label="отчество"
                    placeholder="Петрович"
                    icon_name="Pencil" icon_color="primary"
                />
            </div>
        </div>
        <div class="p-0 col-12 col-lg-7">
            <div class="bkt-card bkt-card__body">
                <h3 class="bkt-card__title">Ваши контакты</h3>
                <bkt-input
                    v-model="user.email"
                    :name="'email'"
                    type="email"
                    label="e-mail"
                    :rules="'required|email'"
                    placeholder="pochta@gmail.com"
                    icon_name="Pencil" icon_color="primary"
                    status="подтвержден"
                    status_class="bkt-text-green"
                >
                </bkt-input>
                <bkt-input
                    v-model="user.phone"
                    :name="'phone'"
                    type="tel"
                    label="номер телефона"
                    :rules="'required|phone'"
                    :placeholder="'+7 495 000-00-00'"
                    icon_name="Pencil" icon_color="primary"
                    :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
                    status="подтвердить >"
                    status_class="bkt-text-primary"
                />
            </div>
        </div>
        <div class="p-0 col-12">
            <div class="bkt-card bkt-card__body">
                <h3 class="bkt-card__title">Смена пароля</h3>
                <div class="bkt-form">
                    <div class="col-12">
                        <bkt-input
                            v-model="passwords.old_password"
                            name="old_password"
                            type="text"
                            label="старый пароль"
                            :rules="'required|min:8'"
                        >
                        </bkt-input>
                    </div>
                    <div class="col-12 col-lg-6">
                        <bkt-input
                            v-model="passwords.password"
                            name="password"
                            type="text"
                            label="новый пароль"
                            :rules="'required|min:8'"
                        >
                        </bkt-input>
                    </div>
                    <div class="col-12 col-lg-6">
                        <bkt-input
                            v-model="passwords.confirm_password"
                            name="confirmation"
                            type="text"
                            label="повторите новый пароль"
                            :rules="'required|min:8|confirmed:password'"
                        >
                        </bkt-input>
                    </div>
                    <div class="p-0 col-12">
                        <div class="bkt-wrapper-between">
                            <bkt-input
                                :name="'phone_code'"
                                type="tel"
                                :rules="'required|phone'"
                                :placeholder="'+7 495 000-00-00'"
                                :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
                            >
                                <template #group-item-inner>
                                    <button class="bkt-button green" @click="sendCode" :disabled="code_loading">
                                        <span v-if="code_loading" class="spinner-border spinner-border-sm" role="status"></span>
                                        Выслать код
                                    </button>
                                </template>
                            </bkt-input>
                            <button class="bkt-button primary">
                                Сохранить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ProfileTab",
        data() {
            return {
                passwords: {
                    password: '',
                    confirm_password: '',
                    old_password: ''
                },
                code_loading: false,
                edit_user:null,
                user: {
                    name:'',
                    lastname:'',
                    surname:'',
                    email:'',
                    phone:'',

                }
            }
        },
        computed: {
            // user: {
            //     get() {
            //         return JSON.parse(JSON.stringify(this.$store.getters.auth_user));
            //     },
            //     set(value) {
            //         this.edit_user = value;
            //     }
            // },
        },
        methods: {
            sendCode() {

            }
        }
    }
</script>

<style scoped>

</style>
