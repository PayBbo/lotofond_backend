<template>
    <div class="bkt-form wide bkt-gap-row-large bkt-profile-gap">
        <div class="col-12 col-lg-6 bkt-form__offset-right">
            <div class="bkt-card">
                <ValidationObserver v-slot="{ invalid }" tag="div" class="bkt-card__body bkt-gap-down-sm-row-large">
<!--                    <div class="bkt-wrapper-between">-->
                    <h3 class="bkt-card__title">Ваши данные</h3>
<!--                        <button class="bkt-button-icon bkt-bg-primary-lighter" v-if="!edit_user_mode"-->
<!--                                @click="edit_user_mode=true">-->
<!--                            <bkt-icon name="Pencil" color="primary"></bkt-icon>-->
<!--                        </button>-->
<!--                    </div>-->

                    <bkt-input
                        v-model="edit_user.lastName"
                        :name="'lastName'"
                        type="text"
                        :rules="'required|alpha|min:2'"
                        label="фамилия"
                        placeholder="Иванов"
                        :disabled="!edit_user_mode"
                        no_group_item
                    />
                    <bkt-input
                        v-model="edit_user.name"
                        name="name"
                        type="text"
                        :rules="'required|alpha|min:2'"
                        label="имя"
                        placeholder="Иван"
                        :disabled="!edit_user_mode"
                        no_group_item
                    />
                    <bkt-input
                        v-model="edit_user.middleName"
                        name="middleName"
                        type="text"
                        :rules="'alpha|min:2'"
                        label="отчество"
                        placeholder="Петрович"
                        :disabled="!edit_user_mode"
                        no_group_item
                    />
                    <div class="bkt-card__footer bkt-wrapper-between">
                        <button type="button" class="bkt-button bkt-button_delete" @click="cancel"
                                :disabled="loading" v-if="edit_user_mode"
                        >
                            <bkt-icon :name="'Cancel'" :width="'22px'" :height="'22px'" color="red"></bkt-icon>
                        </button>
                        <button type="button" class="bkt-button bkt-button_save" @click="save"
                                :disabled="invalid||loading" v-if="edit_user_mode"
                        >
                            <span v-if="loading" class="spinner-border spinner-border-sm" role="status"></span>
                            Сохранить
                        </button>
                        <button type="button" class="bkt-button next ms-auto" v-show="!edit_user_mode"
                                :disabled="invalid||loading" @click="edit_user_mode=true"
                        >
                            Редактировать
                            <bkt-icon name="ArrowDown"></bkt-icon>
                        </button>
                    </div>
                </ValidationObserver>
            </div>
        </div>
        <div class="px-0 col-12 col-lg-6">
            <div class="bkt-card">
                <ValidationObserver v-slot="{ invalid }" ref="change_password" tag="div" class="bkt-card__body bkt-gap-down-sm-row-large"
                                    v-show="!edit_password_mode">
                    <h3 class="bkt-card__title">Смена пароля</h3>
                    <bkt-input
                        v-model="passwords.oldPassword"
                        name="old_password"
                        :type="passwords_types.oldPassword"
                        label="старый пароль"
                        @click-group-item="switchVisibility('oldPassword')"
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
                        v-model="passwords.newPassword"
                        name="password"
                        :type="passwords_types.newPassword"
                        label="новый пароль"
                        @click-group-item="switchVisibility('newPassword')"
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
                        v-model="passwords.submitNewPassword"
                        name="confirmation"
                        :type="passwords_types.submitNewPassword"
                        label="повторите новый пароль"
                        @click-group-item="switchVisibility('submitNewPassword')"
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
                    <div class="bkt-card__footer bkt-wrapper-between">
                        <button type="button" class="bkt-button next ms-auto"
                                :disabled="invalid" @click="edit_password_mode=true"
                        >
                            Далее
                            <bkt-icon name="ArrowDown"></bkt-icon>
                        </button>
                    </div>
                </ValidationObserver>
                <ValidationObserver v-slot="{ invalid }" ref="verify_password" tag="div" class="bkt-card__body bkt-gap-down-sm-row-large"
                                    v-show="edit_password_mode">
                    <h3 class="bkt-card__title">Код подтверждения</h3>
                    <bkt-select v-model="passwords.grantType" :reduce="item => item.value" option_label="title"
                                name="grantType" :options="grantTypes" :clearable="false" label_class="bkt-input__label"
                                label="способ потверждения" select_class="w-100"
                                class="w-100"
                    ></bkt-select>
                    <bkt-input v-if="passwords.grantType==='email'"
                               v-model="edit_user.email"
                               :name="'edit_email'"
                               type="email"
                               label="e-mail"
                               :rules="'required'"
                               placeholder="pochta@gmail.com"
                               icon_name="Email" icon_color="primary"
                    />
                    <bkt-input v-if="passwords.grantType==='phone'"
                               v-model="edit_user.phone"
                               :name="'edit_phone'"
                               type="tel"
                               label="номер телефона"
                               :rules="'required|phone'"
                               :placeholder="'+7 495 000-00-00'"
                               icon_name="Smartphone" icon_color="primary"
                               :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
                    />
                    <bkt-input
                        v-model="passwords.code"
                        name="code"
                        type="text"
                        label="код"
                        :rules="'required|digits:6'"
                        :mask="'######'"
                    >
                        <template #group-item-inner>
                            <button class="bkt-button primary bkt-button_code" @click="sendCode" :disabled="password_loading || code_loading">
                                <span v-if="code_loading" class="spinner-border spinner-border-sm" role="status"></span>
                                Выслать код
                            </button>
                        </template>
                    </bkt-input>
                    <div class="bkt-card__footer bkt-wrapper-between">
                        <button type="button" class="bkt-button next me-auto" @click="edit_password_mode=false">
                            <bkt-icon name="ArrowDown" class="bkt-rotate-90"></bkt-icon>
                            Назад
                        </button>
                        <button class="bkt-button primary bkt-button_save" v-if="edit_password_mode"
                                @click="changePassword"
                                :disabled="invalid || password_loading || code_loading"
                        >
                            Сохранить
                        </button>
                    </div>
                </ValidationObserver>
            </div>
        </div>
        <div class="col-12">
            <contacts-tab></contacts-tab>
        </div>
    </div>
</template>

<script>
    import ContactsTab from "./ContactsTab";
    export default {
        name: "ProfileTab",
        components: {
            ContactsTab
        },
        data() {
            return {
                passwords: {
                    grantType: "email",
                    // email: "",
                    // phone: "",
                    newPassword: '',
                    oldPassword: '',
                    submitNewPassword: '',
                    code: ''
                },
                passwords_types: {
                    newPassword: 'password',
                    oldPassword: 'password',
                    submitNewPassword: 'password',
                },
                code_loading: false,
                // edit_user:null,
                edit_user: {
                    email: "",
                    middle_name: '',
                    name: "",
                    phone: '',
                    lastName: "",
                },
                edit_user_mode: false,
                loading: false,
                password_loading: false,
                edit_password_mode: false,
                grantTypes: [
                    {title: 'Email', value: 'email'},
                    {title: 'Телефон', value: 'phone'},
                ]
            }
        },
        mounted() {
            if (this.isLoggedIn) {
                this.edit_user = JSON.parse(JSON.stringify(this.user));
            }
        },
        computed: {
            user() {
                return this.$store.getters.auth_user
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
            // profile_user: {
            //     get() {
            //         return JSON.parse(JSON.stringify(this.user));
            //     },
            //     set(value) {
            //         this.edit_user = value;
            //     }
            // },
        },
        methods: {
            sendCode() {
                let data = {};
                data.grantType = this.passwords.grantType;
                let message = '';
                if (this.passwords.grantType === 'email') {
                    data.email = this.edit_user.email;
                    message = 'На указанную почту отправлено письмо с кодом подтверждения'
                } else {
                    data.phone = this.edit_user.phone;
                    message = 'На указанный номер телефона отправлено смс с кодом подтверждения'
                }
                this.code_loading = true;

                this.$store.dispatch('getPasswordCode', data)
                    .then((resp) => {
                        this.code_loading = false;
                        this.$store.dispatch('sendNotification',
                            {self: this, message: message})
                    })
                    .catch(err => {
                        this.code_loading = false;
                        // this.$store.dispatch('sendNotification',
                        //     {self: this, message:'Ошибка', type: 'error'})
                    });
            },
            changePassword() {
                this.password_loading = true;
                let data = this.passwords;
                if (this.passwords.grantType === 'email') {
                    data.email = this.edit_user.email;
                } else {
                    data.phone = this.edit_user.phone;
                }

                this.$store.dispatch('changePassword', data)
                    .then((resp) => {
                        this.password_loading = false;
                        this.$store.dispatch('sendNotification',
                            {self: this, message: 'Пароль успешно изменен'});
                        requestAnimationFrame(() => {
                            if(this.$refs.change_password){
                                this.$refs.change_password.reset();
                            }
                            if(this.$refs.verify_password) {
                                this.$refs.verify_password.reset();
                            }
                        });
                        this.edit_password_mode = false;
                        this.edit_user = JSON.parse(JSON.stringify(this.user));
                        this.passwords = {
                            grantType: "email",
                            newPassword: '',
                            oldPassword: '',
                            submitNewPassword: '',
                            code: ''
                        }
                    })
                    .catch(err => {
                        this.password_loading = false;
                        // this.$store.dispatch('sendNotification',
                        //     {self: this, message:'Ошибка', type: 'error'})
                    });
            },
            save() {
                this.loading = true;
                this.$store.dispatch('updateAuthUser', this.edit_user)
                    .then(resp => {
                        this.loading = false;
                        this.$store.dispatch('sendNotification',
                            {self: this, message: 'Ваши данные успешно обновлены'});
                        this.cancel();
                    })
                    .catch(error => {
                        this.loading = false;
                    })
            },
            cancel() {
                this.edit_user_mode = false;
                this.edit_user = JSON.parse(JSON.stringify(this.user));
            },
            switchVisibility(type) {
                this.passwords_types[type] = this.passwords_types[type] === "password" ? "text" : "password";
            },
        }
    }
</script>

<style scoped>

</style>
