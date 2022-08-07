<template>
    <bkt-modal :id="'codeModal'" ref="codeModal" v-if="user" :title="'Добро пожаловать'"
               :left_button_class="'d-none'"
               :modal_class="'bkt-code-modal'" :loading="loading"
               :left_action="skip"
               :right_action="submit"
    >
        <template #body="{ invalid }">
            <div class="bkt-code-modal-steps">
                <h4 class="bkt-modal__subtitle bkt-input__label">Чтобы начать работу, пройдите несколько шагов:</h4>
                <div class="bkt-shadow-card bkt-shadow-card_green">
                    <div class="bkt-shadow-card__inner bkt-gap-large">
                        <h5 class="bkt-card__subtitle">Попробуйте все услуги нашего сервиса</h5>
                        <h1 class="bkt-card__title">бесплатно в течение 7 дней</h1>
                        <div class="bkt-shadow-card__shadow-1">
                        </div>
                        <div class="bkt-shadow-card__shadow-2">
                        </div>
                    </div>
                </div>
            </div>

            <bkt-input
                v-model="user.email"
                name="user_email"
                type="email"
                label="e-mail"
                :rules="'required|email'"
                placeholder="pochta@gmail.com"
                disabled
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
                v-model="user.code"
                name="code"
                type="text"
                label="код"
                :rules="'required|digits:6'"
                v-mask="'######'"
                no_group_item
            >
                <!--                <template #group-item-inner>-->
                <!--                    <button class="bkt-button primary">-->
                <!--                        Выслать код-->
                <!--                    </button>-->
                <!--                </template>-->
            </bkt-input>

            <bkt-select name="regions"
                        v-model="region"
                        :options="region_options"
                        label="выберите регион и получите персональную подборку лотов"
                        label_class="bkt-input__label"
                        with_option
                        with_selected_option
                        :method_name="'getRegions'"
                        :loading="regions_loading"
            >
                <template #option="{option}">
                    {{$t('regions.'+option.label)}}
                </template>
                <template #selected-option="{option}">
                    {{$t('regions.'+option.label)}}
                </template>
            </bkt-select>
            <!--            <div class="bkt-select__wrapper">-->
            <!--                <label class="bkt-select__label" for="sortSelect">выберите регион и получите персональную подборку-->
            <!--                    лотов</label>-->
            <!--                <select class="form-select bkt-select" id="sortSelect" aria-label="">-->
            <!--                    <option selected></option>-->
            <!--                    <option value="1">One</option>-->
            <!--                    <option value="2">Two</option>-->
            <!--                    <option value="3">Three</option>-->
            <!--                </select>-->
            <!--            </div>-->
        </template>
        <!--        <template #left_button_inner>-->
        <!--            Пропустить-->
        <!--            <bkt-icon name="ArrowDown"></bkt-icon>-->
        <!--        </template>-->
    </bkt-modal>
</template>

<script>
    export default {
        name: "CodeModal",
        data() {
            return {
                region: '',
                loading: false,
                code_loading: false,
                // user:''
            }
        },
        computed: {
            shared_user() {
                this.user = JSON.parse(JSON.stringify(this.$store.getters.user));
                return this.$store.getters.user
            },
            user: {
                get() {
                    return this.shared_user
                },
                set(value) {
                    this.$store.commit('setUser', value)
                }
            },
            region_options() {
                return [].concat.apply([], this.$store.getters.regions.map(item => item.regions));
            },
            regions_loading() {
                return this.$store.getters.regions_loading
            },
        },
        methods: {
            submit() {
                let data = JSON.parse(JSON.stringify(this.user));
                data.region = this.region;
                this.loading = true;
                this.$store.dispatch('registrationCodeVerify', {
                    region: this.region,
                    grantType: 'email',
                    email: data.email,
                    code: data.code
                })
                    .then((resp) => {
                        this.loading = false;
                    })
                    .catch(err => {
                        this.loading = false;
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },
            sendCode() {
                let data = JSON.parse(JSON.stringify(this.user));
                this.code_loading = true;

                this.$store.dispatch('registrationCode', data)
                    .then((resp) => {
                        this.code_loading = false;
                    })
                    .catch(err => {
                        this.code_loading = false;
                        // this.$store.dispatch('sendNotification',
                        //     {self: this, message:'Ошибка', type: 'error'})
                    });
            },
            skip() {
                this.$store.commit('closeModal', '#codeModal');
            }
        }
    }
</script>

<style scoped>

</style>
