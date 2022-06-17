<template>
    <bkt-modal :id="'codeModal'" v-if="user" :title="'Добро пожаловать'"
               :left_button_class="'d-none'"
               :modal_class="'bkt-code-modal'" :loading="loading"
               :left_action="skip"
               :right_action="submit"
    >
        <template #body="{ invalid }">
            <div class="bkt-code-modal-steps">
                <h4 class="bkt-modal__subtitle">Чтобы начать работу, пройдите несколько шагов:</h4>
                <div class="bkt-card bg-green">
                    <h5 class="bkt-card__subtitle">Попробуйте все услуги нашего сервиса</h5>
                    <h1 class="bkt-card__title">бесплатно в течение 7 дней</h1>
                    <div class="bkt-card bkt-card__background-figure-1">
                    </div>
                    <div class="bkt-card bkt-card__background-figure-2 bg-green-light">
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
                    <button class="bkt-button primary" @click="sendCode">
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
            >
                <!--                <template #group-item-inner>-->
                <!--                    <button class="bkt-button primary">-->
                <!--                        Выслать код-->
                <!--                    </button>-->
                <!--                </template>-->
            </bkt-input>

            <div class="bkt-select__wrapper">
                <label class="bkt-select__label" for="sortSelect">выберите регион и получите персональную подборку
                    лотов</label>
                <select class="form-select bkt-select" id="sortSelect" aria-label="">
                    <option selected></option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>

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
                region: 'region',
                loading: false,
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
        },
        methods: {
            submit() {
                let data = JSON.parse(JSON.stringify(this.user));
                data.region = this.region;
                this.loading = true;
                axios
                    .post('/api/registration/code/verify', {region:this.region, grantType: 'email', email: data.email, code: data.code})
                    .then((resp) => {
                        this.$store.commit('setUser', data);
                        this.$store.commit('closeModal', '#codeModal');
                        this.loading = false;

                    })
                    .catch(err => {
                        this.loading = false;
                    });
            },
            sendCode() {
                let data = JSON.parse(JSON.stringify(this.user));
                this.loading = true;
                axios
                    .post('/api/registration/code', data)
                    .then((resp) => {
                        this.$store.commit('setUser', data);
                        this.$store.commit('closeModal', '#codeModal');
                        this.loading = false;
                    })
                    .catch(err => {
                        this.loading = false;
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
