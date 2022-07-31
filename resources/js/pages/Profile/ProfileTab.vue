<template>
    <div class="bkt-form wide bkt-profile-gap">
        <div class="col-12 col-lg-6 bkt-form__offset-right">
            <div class="bkt-card">
                <ValidationObserver v-slot="{ invalid }" tag="div" class="bkt-card__body bkt-gap-down-sm-row-large">
                    <div class="bkt-wrapper-between">
                        <h3 class="bkt-card__title">Ваши данные</h3>
                        <button class="bkt-button-icon bkt-bg-primary-lighter" v-if="!edit_user_mode"
                                @click="edit_user_mode=true">
                            <bkt-icon name="Pencil" color="primary"></bkt-icon>
                        </button>
                    </div>

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
                        name="name"
                        type="text"
                        :rules="'alpha|min:2'"
                        label="отчество"
                        placeholder="Петрович"
                        :disabled="!edit_user_mode"
                        no_group_item
                    />
                    <div class="bkt-card__footer bkt-wrapper-between" v-if="edit_user_mode">
                        <button type="button" class="bkt-button bkt-button_delete" @click="cancel"
                                :disabled="loading">
                            <bkt-icon :name="'Cancel'" :width="'22px'" :height="'22px'" color="red"></bkt-icon>
                        </button>

                        <button type="button" class="bkt-button bkt-button_save"
                                :disabled="invalid||loading"
                                @click="save">
                                        <span v-if="loading" class="spinner-border spinner-border-sm"
                                              role="status"></span>
                            Сохранить
                        </button>
                    </div>
                </ValidationObserver>
            </div>
        </div>
<!--        <div class="p-0 col-12 col-lg-7">-->
<!--            <div class="bkt-card bkt-card__body bkt-gap-down-sm-row-large">-->
<!--                <h3 class="bkt-card__title">Ваши контакты</h3>-->
<!--                <bkt-input-->
<!--                    v-model="user.email"-->
<!--                    :name="'email'"-->
<!--                    type="email"-->
<!--                    label="e-mail"-->
<!--                    :rules="'required|email'"-->
<!--                    placeholder="pochta@gmail.com"-->
<!--                    icon_name="Pencil" icon_color="primary"-->
<!--                    status="подтвержден"-->
<!--                    status_class="bkt-text-green"-->
<!--                >-->
<!--                </bkt-input>-->
<!--                <bkt-input-->
<!--                    v-model="user.phone"-->
<!--                    :name="'phone'"-->
<!--                    type="tel"-->
<!--                    label="номер телефона"-->
<!--                    :rules="'required|phone'"-->
<!--                    :placeholder="'+7 495 000-00-00'"-->
<!--                    icon_name="Pencil" icon_color="primary"-->
<!--                    :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"-->
<!--                    status="подтвердить >"-->
<!--                    status_class="bkt-text-primary"-->
<!--                />-->
<!--            </div>-->
<!--        </div>-->
        <div class="p-0 col-12 col-lg-6">
            <div class="bkt-card">
                <ValidationObserver v-slot="{ invalid }" tag="div" class="bkt-card__body bkt-gap-down-sm-row-large">
                <h3 class="bkt-card__title">{{edit_password_mode ? 'Код подтверждения' : 'Смена пароля'}}</h3>
<!--                <div class="bkt-form bkt-gap-down-sm-large">-->
<!--                    <div class="col-12">-->
                        <bkt-input v-if="!edit_password_mode"
                            v-model="passwords.old_password"
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
<!--                    </div>-->
<!--                    <div class="col-12">-->
                        <bkt-input v-if="!edit_password_mode"
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
<!--                    </div>-->
<!--                    <div class="col-12">-->
                        <bkt-input v-if="!edit_password_mode"
                            v-model="passwords.submitNewPassword"
                            name="confirmation"
                            :type="passwords_types.submitNewPassword"
                            label="повторите новый пароль"
                            @click-group-item="switchVisibility('submitNewPassword')"
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
                    <label class="bkt-input__label bkt-form__label mt-0" v-if="edit_password_mode">способ потверждения</label>
                    <div class="bkt-select__wrapper" v-if="edit_password_mode">
                        <select class="form-select bkt-select w-100" v-model="passwords.grantType">
                            <option value="email">E-mail</option>
                            <option value="phone">Телефон</option>
                        </select>
                    </div>
                    <bkt-input v-if="edit_password_mode && passwords.grantType==='email'"
                        v-model="edit_user.email"
                        :name="'email'"
                        type="email"
                        label="e-mail"
                        :rules="'required'"
                        placeholder="pochta@gmail.com"
                        icon_name="Email"
                    />
                    <bkt-input
                        v-model="edit_user.phone"
                        v-show="edit_password_mode && passwords.grantType==='phone'"
                        :name="'phone'"
                        type="tel"
                        label="номер телефона"
                        :rules="'required|phone'"
                        :placeholder="'+7 495 000-00-00'"
                        icon_name="Smartphone"
                        :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
                    />
<!--                    </div>-->
<!--                    <div class="p-0 col-12">-->
<!--                        <div class="bkt-wrapper-between bkt-gap bkt-gap-down-sm-row-large">-->
<!--                            <div class="bkt-wrapper-down-sm-column bkt-gap-small">-->
<!--                                <bkt-input-->
<!--                                    :name="'phone_code'"-->
<!--                                    type="tel"-->
<!--                                    :rules="'required|phone'"-->
<!--                                    :placeholder="'+7 495 000-00-00'"-->
<!--                                    :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"-->
<!--                                >-->
<!--                                    <template #group-item-inner>-->
<!--                                        <button class="bkt-button green d-none d-sm-flex" @click="sendCode"-->
<!--                                                :disabled="code_loading">-->
<!--                                            <span v-if="code_loading" class="spinner-border spinner-border-sm"-->
<!--                                                  role="status"></span>-->
<!--                                            Выслать код-->
<!--                                        </button>-->
<!--                                    </template>-->
<!--                                </bkt-input>-->
<!--                                <button class="bkt-button green d-sm-none" @click="sendCode" :disabled="code_loading">-->
<!--                                    <span v-if="code_loading" class="spinner-border spinner-border-sm"-->
<!--                                          role="status"></span>-->
<!--                                    Выслать код-->
<!--                                </button>-->
<!--                            </div>-->

<!--                            <button class="bkt-button primary bkt-w-sm-100 bkt-button_plump">-->
<!--                                Далее-->
<!--                            </button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                    <div class="bkt-card__footer bkt-wrapper-between">
                        <button type="button" class="bkt-button next ms-auto" v-if="!edit_password_mode"
                                :disabled="invalid" @click="edit_password_mode=true"
                        >
                            Далее <bkt-icon name="ArrowDown"></bkt-icon>
                        </button>
                        <button type="button" class="bkt-button next me-auto" v-if="edit_password_mode"
                                @click="edit_password_mode=false"
                        >
                            <bkt-icon name="ArrowDown" class="bkt-rotate-90"></bkt-icon> Назад
                        </button>
                        <button class="bkt-button primary bkt-button_plump" v-if="edit_password_mode"
                                :disabled="invalid || password_loading"
                        >
                            Сохранить
                        </button>
                    </div>
                </ValidationObserver>
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
                    grantType: "email",
                    email: "test@gmail.com",
                    newPassword: '',
                    oldPassword: '',
                    submitNewPassword:'',
                    code:''
                },
                passwords_types:{
                    newPassword: 'password',
                    oldPassword: 'password',
                    submitNewPassword:'password',
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

            },
            save() {

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
