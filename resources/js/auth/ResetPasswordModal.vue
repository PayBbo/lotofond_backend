<template>
    <bkt-modal :id="'resetPasswordModal'" ref="resetPasswordModal"
               :modal_class="'bkt-code-modal'" :loading="loading" @close-modal="exit"
    >
        <template #title>
            <div>
                <h3 class="bkt-modal__title" :class="{'bkt-text-green': new_mode, 'bkt-text-red': !new_mode}">
                    {{new_mode ? 'Задайте новый пароль': 'Смена пароля'}}
                </h3>
                <h4 class="bkt-modal__subtitle" v-if="!new_mode">
                    Введите электронную почту, на неё<br>мы пришлем код для сброса пароля
                </h4>
                <h4 class="bkt-modal__subtitle" v-if="new_mode">
                    Придумайте новый пароль и введите его
                </h4>
            </div>
        </template>
        <template #body="{ invalid }">
            <template v-if="!new_mode">
                <bkt-input
                    v-model="new_data.email"
                    name="reset_email"
                    type="email"
                    label="e-mail"
                    :rules="'required|email'"
                    placeholder="pochta@gmail.com"
                >
                    <template #group-item-inner>
                        <button class="bkt-button primary bkt-button_code" @click="sendCode" :disabled="code_loading">
                         <span v-if="code_loading" class="spinner-border spinner-border-sm"
                               role="status"></span>
                            Выслать код
                        </button>
                    </template>
                </bkt-input>
                <bkt-input
                    v-model="form.code"
                    name="reset_code"
                    type="text"
                    label="код"
                    :rules="'required|digits:6'"
                    :mask="'######'"
                    no_group_item
                >
                </bkt-input>
            </template>
            <template v-if="new_mode">
                <bkt-input
                    v-model="new_data.password"
                    name="reset_password"
                    :type="password"
                    label="пароль"
                    field_name="'пароль'"
                    @click-group-item="switchVisibility('password')"
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
                    v-model="new_data.confirm_password"
                    @click-group-item="switchVisibility('confirm_password')"
                    :name="'reset_confirmation'"
                    :type="confirm_password"
                    label="повторите пароль"
                    field_name="'повторите пароль'"
                    :rules="'required|min:8|confirmed:reset_password'"
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
            </template>
        </template>
        <template #footer="{ invalid }">
            <button type="button" class="bkt-button next" @click="skip">
                <bkt-icon name="ArrowDown" class="bkt-rotate-90"></bkt-icon>
                Назад
            </button>
            <button type="button" class="bkt-button primary bkt-button_save" v-if="!new_mode"
                    :disabled="invalid||loading||code_loading" @click="verifyCode"
            >
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status"></span>
                Далее
            </button>
            <button class="bkt-button primary bkt-button_save"
                    @click="submit"
                    v-if="new_mode"
                    :disabled="invalid || loading || code_loading"
            >
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status"></span>
                Сохранить
            </button>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "ResetPasswordModal",
        data() {
            return {
                loading: false,
                code_loading: false,
                new_mode: false,
                form: {
                    code: '',
                    grantType: "email",
                },
                new_data: {
                    email: '',
                    phone: '',
                    password: '',
                    confirm_password: '',
                },
                password: "password",
                confirm_password: "password",
            }
        },
        methods: {
            sendCode() {
                this.code_loading = true;
                let data = JSON.parse(JSON.stringify(this.form));
                data[this.form.grantType] = this.new_data[this.form.grantType];
                this.$store.dispatch('getPasswordCode', data)
                    .then((resp) => {
                        this.code_loading = false;
                        this.$store.dispatch('sendNotification',
                            // {self: this, message:'Код подтверждения был отправлен повторно'})
                            {self: this, message: 'Код подтверждения отправлен'})
                    })
                    .catch(err => {
                        this.code_loading = false;
                    });
            },
            verifyCode() {
                this.loading = true;
                let data = JSON.parse(JSON.stringify(this.form));
                data[this.form.grantType] = this.new_data[this.form.grantType];
                this.$store.dispatch('verifyPasswordCode', data)
                    .then((resp) => {
                        if (this.$refs.resetPasswordModal) {
                            this.$refs.resetPasswordModal.resetForm();
                        }
                        this.loading = false;
                        this.new_mode = true;
                    })
                    .catch(err => {
                        this.loading = false;
                    })
            },
            submit() {
                this.loading = true;
                let data = JSON.parse(JSON.stringify(this.form));
                data[this.form.grantType] = this.new_data[this.form.grantType];
                data.password = this.new_data.password;
                this.$store.dispatch('resetPassword', data)
                    .then((resp) => {
                        this.loading = false;
                        this.$store.commit('closeModal', '#resetPasswordModal');
                        this.$store.commit('openModal', '#resetSuccessModal');
                        this.new_mode = false;
                    })
                    .catch(err => {
                        this.loading = false;
                    })
            },
            skip() {
                if (!this.new_mode) {
                    this.$store.commit('closeModal', '#resetPasswordModal');
                    this.$store.commit('openModal', '#authModal');
                }
                this.new_mode = false;
            },
            switchVisibility(type) {
                this[type] = this[type] === "password" ? "text" : "password";
            },
            exit() {
                this.new_mode = false;
                this.form = {
                    code: '',
                    grantType: "email",
                };
                this.new_data = {
                    email: '',
                    phone: '',
                    password: '',
                    confirm_password: '',
                };
                this.password = "password";
                this.confirm_password = "password";
            }
        }
    }
</script>

<style scoped>

</style>
