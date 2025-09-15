<template>
    <bkt-modal :id="'applicationModal'" title="Заявка менеджеру" modal_class="bkt-filters-modal bkt-purchase"
               left_button_class="d-none" @right_action="sendApplication" :loading="loading||service_loading"
               right_button="Отправить"  @close-modal="clear" ref="applicationModal"
    >
        <template #body>
            <div class="bkt-form bkt-wrapper-column bkt-promo__form p-0 w-100" v-if="!service_loading">
<!--                                <div class="bkt-promo__block-wrapper" v-if="promo == true">-->
<!--                                    <div class="bkt-promo__block">-->
<!--                                        <div class="bkt-promo__block-body">-->
<!--                                            <h1 class="bkt-promo__block-title">Новичок?<br><span-->
<!--                                                class="bkt-text-yellow">сэкономьте до 50%</span></h1>-->
<!--                                            <h5 class="bkt-promo__block-subtitle">на торгах с нашей помощью</h5>-->
<!--                                            <h4 class="bkt-promo__block-text">-->
<!--                                                Воспользуйтесь нашим опытом побед, чтобы избежать ошибок и сэкономить время, деньги и-->
<!--                                                нервы.-->
<!--                                            </h4>-->
<!--                                        </div>-->
<!--                                        <button class="bkt-button bkt-button_yellow bkt-button_plump" @click="navigate('/agent')">-->
<!--                                            Подробнее о покупке без ЭЦП-->
<!--                                        </button>-->
<!--                                        <span type="button" class="bkt-close-button" @click="close"-->
<!--                                                aria-label="Close">-->
<!--                                            <bkt-icon :name="'Cancel'" :width="'20px'" :height="'20px'" color="white"></bkt-icon>-->
<!--                                        </span>-->
<!--                                    </div>-->
<!--                                </div>-->
                <div v-if="selected_lot" class="bkt-promo__lot-wrapper">
                    <div class="bkt-wrapper bkt-gap bkt-nowrap bkt-cursor-pointer"
                         @click="navigate('/lot/'+selected_lot.id)">
                        <card-image-category :no_multiple="true"
                                             v-if="selected_lot && ((rules && (!rules.categories || !rules.photos)) ||
                                         ((!selected_lot.photos || (selected_lot.photos && selected_lot.photos.length==0))
                                         && selected_lot.categories && (!rules || rules && rules.categories)))"
                                             :categories="selected_lot.categories"></card-image-category>
                        <img
                            v-if="selected_lot && selected_lot.photos && selected_lot.photos.length>0
                            && ((rules && rules.photos) || !rules)"
                            class="bkt-card__image"
                        />
                        <div class="bkt-wrapper-column bkt-gap bkt-gap-down-sm-mini">
                            <h4 class="bkt-promo__lot-title">Торги №
                                <skeleton type_name="spoiler" tag="span" :loading="rules && !rules.trade.externalId">
                                    {{selected_lot && selected_lot.trade && selected_lot.trade.externalId ?
                                    selected_lot.trade.externalId : ''}}
                                </skeleton>
                                (лот
                                <skeleton type_name="spoiler" tag="span" :loading="rules && !rules.lotNumber">
                                    {{selected_lot && selected_lot.lotNumber ? selected_lot.lotNumber : '0'}}
                                </skeleton>
                                )
                            </h4>
                            <h5 class="bkt-promo__lot-subtitle bkt-text-truncate-5 bkt-text-truncate-down-sm-4"
                                v-html="selected_lot.description">
                            </h5>
                        </div>
                    </div>
                </div>
                <div v-for="item in buyLotBlock"
                     class="bkt-card__row bkt-purchase__service bkt-wrapper-down-lg-column bkt-cursor-pointer"
                >
                    <div class="bkt-purchase__service__check-wrapper">
                        <div class="bkt-icon-frame bkt-bg-primary-lighter">
                            <bkt-icon name="Information" color="primary"  class="bkt-icon-frame__item"/>
                        </div>
                        <h4 class="bkt-card__title" v-if="item.header">{{item.header}}</h4>
                        <h5 class="bkt-card__subtitle">{{item.value}}</h5>
                    </div>
                </div>
                <ValidationProvider :name="'Услуги'" rules="required|min:1" v-slot="{ errors }" tag="div"
                                    class="bkt-wrapper-column bkt-gap-medium" ref="services" v-if="filtered_services.length"
                >
                    <div v-for="item in filtered_services"
                         class="bkt-card__row bkt-purchase__service bkt-wrapper-down-lg-column bkt-cursor-pointer"
                         :class="{'active': service.paymentTradingTypes.includes(item.type)}"
                         @click="toggleService(item.type)"
                    >
                        <div class="bkt-purchase__service__check-wrapper">
                            <bkt-checkbox type="checkbox" wrapper_class="bkt-check_check" :name="item.type"
                                          v-model="service.paymentTradingTypes" :val="item.type"></bkt-checkbox>
                            <div class="bkt-purchase__service__text-wrapper">
                                <h4 class="bkt-card__title">{{item.header}}</h4>
                                <h5 class="bkt-card__subtitle">{{item.description}}</h5>
                            </div>
                        </div>
                        <hr class="d-lg-none w-100 m-0">
                        <h3 class="bkt-purchase__service__price">от {{item.price | priceFormat}} ₽</h3>
                    </div>
<!--                    <div v-if="mode==='ECP'||mode===''" class="bkt-card__row bkt-purchase__service bkt-wrapper-down-lg-column bkt-cursor-pointer"-->
<!--                         :class="{'active': service.paymentTradingTypes.includes('purchaseBidByAgent')}"-->
<!--                         @click="toggleService('purchaseBidByAgent')"-->
<!--                    >-->
<!--                        <div class="bkt-purchase__service__check-wrapper">-->
<!--                            <bkt-checkbox type="checkbox" wrapper_class="bkt-check_check" name="purchaseBidByAgent"-->
<!--                                          v-model="service.paymentTradingTypes" val="purchaseBidByAgent"></bkt-checkbox>-->
<!--                            <div class="bkt-purchase__service__text-wrapper">-->
<!--                                <h4 class="bkt-card__title">Покупка без ЭЦП - проведение торгов</h4>-->
<!--                                <h5 class="bkt-card__subtitle">Проведение торгов нашими специалистами за вас</h5>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <hr class="d-lg-none w-100 m-0">-->
<!--                        <h3 class="bkt-purchase__service__price">от 10 000 ₽</h3>-->
<!--                    </div>-->
<!--                    <template v-if="mode!=='ECP'||mode===''">-->
<!--                        <div class="bkt-card__row bkt-purchase__service bkt-wrapper-down-lg-column bkt-cursor-pointer"-->
<!--                             :class="{'active': service.paymentTradingTypes.includes('infoAboutLot')}"-->
<!--                             @click="toggleService('infoAboutLot')"-->
<!--                        >-->
<!--                            <div class="bkt-purchase__service__check-wrapper">-->
<!--                                <bkt-checkbox type="checkbox" wrapper_class="bkt-check_check" name="infoAboutLot"-->
<!--                                              :value="service.paymentTradingTypes" val="infoAboutLot"></bkt-checkbox>-->
<!--                                <div class="bkt-purchase__service__text-wrapper">-->
<!--                                    <h4 class="bkt-card__title">Подробная информация о лоте</h4>-->
<!--                                    <h5 class="bkt-card__subtitle">Оценка ликвидности выбранного лота нашими-->
<!--                                        сотрудниками-->
<!--                                    </h5>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <hr class="d-lg-none w-100 m-0">-->
<!--                            <h3 class="bkt-purchase__service__price">от 3 000 ₽</h3>-->
<!--                        </div>-->
<!--                        <div class="bkt-card__row bkt-purchase__service bkt-wrapper-down-lg-column bkt-cursor-pointer"-->
<!--                             :class="{'active': service.paymentTradingTypes.includes('consultation')}"-->
<!--                             @click="toggleService('consultation')"-->
<!--                        >-->
<!--                            <div class="bkt-purchase__service__check-wrapper">-->
<!--                                <bkt-checkbox type="checkbox" wrapper_class="bkt-check_check" ref="con_check" name="consultation"-->
<!--                                              v-model="service.paymentTradingTypes" val="consultation"></bkt-checkbox>-->
<!--                                <div class="bkt-purchase__service__text-wrapper">-->
<!--                                    <h4 class="bkt-card__title">Консультация по лоту</h4>-->
<!--                                    <h5 class="bkt-card__subtitle">Юридическая консультация по выбранному лоту</h5>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <hr class="d-lg-none w-100 m-0">-->
<!--                            <h3 class="bkt-purchase__service__price">от 5 000 ₽</h3>-->
<!--                        </div>-->
<!--                        <div class="bkt-card__row bkt-purchase__service bkt-wrapper-down-lg-column bkt-cursor-pointer"-->
<!--                             :class="{'active': service.paymentTradingTypes.includes('accompanimentFAS')}"-->
<!--                             @click="toggleService('accompanimentFAS')"-->
<!--                        >-->
<!--                            <div class="bkt-purchase__service__check-wrapper">-->
<!--                                <bkt-checkbox type="checkbox" wrapper_class="bkt-check_check" name="accompanimentFAS"-->
<!--                                              v-model="service.paymentTradingTypes" val="accompanimentFAS"></bkt-checkbox>-->
<!--                                <div class="bkt-purchase__service__text-wrapper">-->
<!--                                    <h4 class="bkt-card__title">Сопровождение в ФАС</h4>-->
<!--                                    <h5 class="bkt-card__subtitle">Сопровождение в Федеральной Антимонопольной службе</h5>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <hr class="d-lg-none w-100 m-0">-->
<!--                            <h3 class="bkt-purchase__service__price">от 9 000 ₽</h3>-->
<!--                        </div>-->
<!--                    </template>-->
                    <p class="bkt-input-error" v-if="errors.length>0">{{errors[0]}}</p>
                </ValidationProvider>
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
<!--                            <bkt-checkbox wrapper_class="flex-fill"-->
<!--                                          input_class="bkt-button bkt-bg-body flex-fill" name="Viber"-->
<!--                                          v-model="service.socialsForAnswer" val="Viber"-->
<!--                                          :border_color="service.socialsForAnswer.includes('Viber') ? 'primary': 'body'"-->
<!--                            >-->
<!--                                <template #input-check>-->
<!--                                    <bkt-icon name="Viber" color="purple" class="bkt-button__icon"></bkt-icon>-->
<!--                                </template>-->
<!--                            </bkt-checkbox>-->
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
            <div v-if="service_loading" class="d-flex w-100 justify-content-center my-5">
                <div
                    style="color: #2953ff;border-width: 2px;"
                    class="spinner-border"
                    role="status"
                ></div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    import CardImageCategory from "../CardImageCategory";

    export default {
        name: "ApplicationModal",
        components: {CardImageCategory},
        props: {
            service_loading: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                loading: false,
                service: {
                    name: '',
                    email: '',
                    phone: '',
                    paymentTradingTypes: [],
                    socialsForAnswer: [],
                    lotId: 0,
                },
                mode: '',
                filtered_services: [],
                // promo: localStorage.getItem('bkt_application_promo') || true,
            }
        },
        mounted() {
            if (this.user && this.isLoggedIn) {
                this.service.name = this.user.name + ' ' + this.user.lastName;
                this.service.email = this.user.email;
                this.service.phone = this.user.phone;
            }
            this.getBuyLotBlock();
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
            rules() {
                return this.$store.getters.rules
            },
            services() {
                return this.$store.getters.services.filter(item => item.type !== 'purchaseInstructions' && item.type !== 'receiptEGRN');
            },
            buyLotBlock() {
                return this.$store.getters.buyLotBlock;
            }
        },
        watch: {
            isLoggedIn: function (newVal, oldVal) {
                if (oldVal == false && newVal == true && this.user) {
                    this.service.name = this.user.name + ' ' + this.user.lastName;
                    this.service.email = this.user.email;
                    this.service.phone = this.user.phone;
                } else if (oldVal == true && newVal == false) {
                    this.service.name = '';
                    this.service.email = '';
                    this.service.phone = '';
                }
            },
            user: function (newVal, oldVal) {
                if (newVal !== null) {
                    this.service.name = this.user.name + ' ' + this.user.lastName;
                    this.service.email = this.user.email;
                    this.service.phone = this.user.phone;
                }
            }
        },
        methods: {
            sendApplication() {
                this.loading = true;
                let data = JSON.parse(JSON.stringify(this.service));
                if(this.mode === 'ECP') {
                    data.paymentTradingTypes = ['purchaseBidByAgent'];
                }
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
                        this.closeModal();
                    })
                    .catch(error => {
                        // this.$store.dispatch('sendNotification', {self:this, type: 'error'});
                        this.loading = false;
                        this.$store.dispatch('sendNotification',
                            {self: this, message: 'Произошла ошибка, попробуйте позже'});
                    })
            },
            navigate(path) {
                this.closeModal();
                if (this.$router.currentRoute.path != path) {
                    this.$router.push(path)
                }
            },
            toggleService(service) {
                let index = this.service.paymentTradingTypes.findIndex(el => el == service);
                if (index < 0) {
                    this.service.paymentTradingTypes.push(service);
                } else {
                    this.service.paymentTradingTypes.splice(index, 1);
                }
                if(this.$refs.services) {
                    this.$refs.services.validate();
                }
            },
            clear() {
                this.service.paymentTradingTypes = [];
            },
            closeModal() {
                this.$store.commit('closeModal', '#applicationModal');
                this.clear();
            },
            close() {
                this.promo = false;
                localStorage.setItem('bkt_application_promo', 'false')
            },
            changeMode(mode) {
                this.mode = mode;
                this.filtered_services = this.services
                    .filter(item => {
                        if (this.mode === 'ECP') {
                            return item.type === 'purchaseBidByAgent'
                        }
                        if (this.mode === 'services') {
                            return item.type !== 'purchaseBidByAgent'
                        }
                        return true;
                    });
                if(this.filtered_services.length>0) {
                    this.toggleService(this.filtered_services[0].type)
                }
            },
            async getBuyLotBlock() {
                if(!this.buyLotBlock || this.buyLotBlock.length==0) {
                    this.loading = true;
                    await this.$store.dispatch('getBuyLotBlock')
                        .then(resp => {
                            this.loading = false;
                        })
                }
            }
        }
    }
</script>

<style scoped>

</style>
