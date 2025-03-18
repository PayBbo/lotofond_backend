<template>
    <div class="bkt-container container">
        <div class="bkt-shadow-card bkt-shadow-card_primary mt-3 mb-4">
            <div class="bkt-shadow-card__inner bkt-gap-large">
                <h4 class="bkt-shadow-card__title bkt-text-white">
                    Давайте знакомиться!<br>
                    <span style="font-size: 12px; color: whitesmoke;font-weight: 200;">
                        для новых друзей действует 30-ти дневный пробный период
                    </span>
                </h4>
                <div class="bkt-shadow-card__shadow-1">
                </div>
                <div class="bkt-shadow-card__shadow-2">
                </div>
            </div>
        </div>
<!--                </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <ValidationObserver v-slot="{ invalid }" ref="observer" tag="div" class="bkt-card bkt-card__body modal-content bkt-modal-content">
            <ul class="bkt-navbar__nav bkt-navbar__nav-pills">
                <li class="bkt-navbar__nav-item" :class="{active: tab==='registration'}"
                    @click="changeTab('registration')">
                    Регистрация
                </li>
                <li class="bkt-navbar__nav-item" :class="{active: tab==='login'}" @click="changeTab('login')">
                    Вход
                </li>
            </ul>
            <bkt-input
                v-model="user.email"
                :name="'email'"
                v-if="grantType === 'email'"
                type="email"
                label="e-mail"
                field_name="'e-mail'"
                key="e-mail"
                :rules="'required'"
                placeholder="pochta@gmail.com"
                icon_name="Email"
            />
            <bkt-input
                v-model="user.phone"
                v-if="grantType === 'phone'"
                :name="'phone'"
                key="phone"
                type="tel"
                label="номер телефона"
                :rules="'required|phone'"
                :placeholder="'+7 495 000-00-00'"
                icon_name="Smartphone"
                :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
                :masked="false"
            />
            <bkt-select
                name="regions"
                v-model="user.region"
                v-if="tab==='registration'"
                :options="region_options"
                label="регион"
                label_class="bkt-input__label"
                option_label="label"
                :reduce="option => option.value"
                :method_name="'getRegions'"
                :loading="regions_loading"
                :rules="'required'"
            >
            </bkt-select>
            <bkt-input
                v-model="user.password"
                name="password"
                :type="type1"
                label="пароль"
                field_name="'пароль'"
                @click-group-item="switchVisibility('type1')"
                :rules="'required|min:8'"
                group_item_action
            >
                <template #errors="{errors}" v-if="password_error">
                    <p class="bkt-input-error" v-if="errors.length>0">{{errors[0]}}</p>
                    <p class="bkt-input-error" v-else>{{error.detail}}</p>
                </template>
                <template #icon>
                    <bkt-icon name="Eye" color="primary" height="18px"/>
                </template>
            </bkt-input>
            <bkt-input
                v-model="user.confirm_password"
                v-if="tab==='registration'"
                @click-group-item="switchVisibility('type2')"
                :name="'confirmation'"
                :type="type2"
                label="повторите пароль"
                field_name="'повторите пароль'"
                :rules="'required|min:8|confirmed:password'"
                group_item_action
            >
                <template #icon>
                    <bkt-icon name="Eye" color="primary" height="18px"/>
                </template>
            </bkt-input>
            <bkt-checkbox name="'Условия'" id="terms" :rules="'required_boolean'" v-model="terms"
                          v-if="tab=='registration'">
                <template #label>
                    Согласен с условиями пользовательского соглашения,<br>политики сайта, обработки персональных
                    данных.
                </template>
            </bkt-checkbox>

                <button class="bkt-button primary-outline bkt-text-main" @click="grantType = 'phone'" v-if="grantType === 'email'">
                    {{tab==='registration'? 'Регистрация':'Вход'}} через телефон
                </button>
                <button class="bkt-button primary-outline bkt-text-main" @click="grantType = 'email'" v-if="grantType === 'phone'">
                    {{tab==='registration'? 'Регистрация':'Вход'}} через эл.почту
                </button>


            <button class="bkt-button primary" v-if="tab==='registration'" :disabled="invalid||loading" @click="login">
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Зарегистрироваться
            </button>
            <button class="bkt-button primary" v-else :disabled="invalid||loading" @click="login">
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Войти
            </button>
        </ValidationObserver>
    </div>
</template>

<script>
    export default {
        name: "AuthPage",
        data() {
            return {
                grantType: 'email',
                loading: false,
                user: {
                    grantType: 'bot',
                    region: null,
                    email:null,
                    phone:null,
                    password: null,
                    confirm_password: null,
                    scope: 'bot'
                },
                tab: 'login',
                type1: "password",
                type2: "password",
                terms: false,
                password_error:false,
            }
        },
        computed: {
            region_options() {
                let tmp = [].concat.apply([], this.$store.getters.regions.map(item => item.regions));
                let result =[];
                tmp.forEach(item => {
                    result.push({label: this.$t('regions.'+item), value: item});
                });
                return result.sort((a, b) => a.label.localeCompare(b.label))
            },
            regions_loading() {
                return this.$store.getters.regions_loading
            },
            tg() {
                return window.Telegram.WebApp;
            },
            tgUser() {
                const urlParams = new URLSearchParams(this.tg.initData);
                return JSON.parse(urlParams.get('user'));
            },
        },
        methods: {
            async login() {
                this.loading = true;
                let data = {...this.user, ...this.tgUser};
                data.initData = this.tg.initDataUnsafe;
                data.initDataString = this.tg.initData;
                if(this.grantType === 'email') {
                    delete data.phone
                }
                else {
                    delete data.email
                }
                await this.$store.dispatch('login', data).then(resp => {
                    this.loading = false;
                    if(this.user.region) {
                        this.$store.commit('saveFiltersProperty', {key: 'bot_filters_regions', value: [this.user.region]});
                        this.$store.dispatch('saveDataProperty', {
                            module_key: 'filters', state_key: 'bot_filters',
                            key: 'regions',
                            value: [this.user.region]
                        }, {root: true});
                    }
                }).catch(error => {
                    this.loading = false;
                })
            },
            async submit() {
                this.loading = true;
                let data = {...this.user, ...this.tgUser};
                data.initData = this.tg.initDataUnsafe;
                data.initDataString = this.tg.initData;
                if(this.grantType === 'email') {
                    delete data.phone
                }
                else {
                    delete data.email
                }
                await this.$store.dispatch(this.tab, data).then(resp => {
                    this.loading = false;
                    if(this.tab == 'registration') {
                        this.$store.dispatch('sendNotification',
                            {self: this, message:'Код подтверждения был отправлен на указанный контакт'})
                    }
                    else {
                        this.$store.dispatch('saveDataProperty', {
                            module_key: 'auth',
                            key: 'auth_check.'+this.$route.name,
                            value: true
                        }, {root: true});
                    }
                }).catch(error => {
                    this.loading = false;
                })
            },
            changeTab(tab) {
                if(!this.loading) {
                    this.terms = false;
                    if(this.$refs.observer) {
                        this.$refs.observer.reset();
                    }
                    this.tab = tab;
                }
            },
            switchVisibility(type) {
                this[type] = this[type] === "password" ? "text" : "password";
            },
        }
    }
</script>

<style scoped>

</style>
