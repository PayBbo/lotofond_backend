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
                <li class="bkt-navbar__nav-item" :class="{active: grantType === 'email'}"
                    @click="grantType = 'email'">
                    Email
                </li>
                <li class="bkt-navbar__nav-item" :class="{active: grantType === 'phone'}" @click="grantType = 'phone'">
                    Телефон
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
            <button class="bkt-button primary" :disabled="invalid||loading" @click="login">
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
                    password: 'bot',
                    scope: 'bot'
                },
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
            }
        }
    }
</script>

<style scoped>

</style>
