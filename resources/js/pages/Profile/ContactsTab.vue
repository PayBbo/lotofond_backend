<template>
    <div class="bkt-wrapper-column bkt-gap-large bkt-profile-gap">
        <div class="bkt-card bkt-card__body bkt-gap-row-medium">
            <h3 class="bkt-card__title">Ваша электронная почта</h3>
            <div class="bkt-form bkt-gap-down-sm-row-medium align-items-end">
                <div class="col-12 col-md-8">
                    <bkt-input
                        v-model="edit_user.email"
                        :name="'email'"
                        type="email"
                        :rules="'required|email'"
                        placeholder="pochta@gmail.com"
                        icon_name="Email" icon_color="primary"
                        disabled
                        :status="status.email"
                        status_class="bkt-text-primary"
                    >
                        <!--                 status="подтвержден"
                                        status_class="bkt-text-green"-->
                    </bkt-input>
                </div>
                <div class="col-12 col-md-4">
                    <button class="bkt-button primary bkt-button_plump float-end bkt-w-down-sm-100"
                            @click="editContact('email')" v-if="!status.email">
                        {{edit_user.email ? 'Изменить' : 'Привязать'}}
                        {{edit_user.email && status.email ? 'Отменить изменение' : ''}}
                    </button>
                    <button class="bkt-button primary bkt-button_plump float-end bkt-w-down-sm-100"
                            @click="cancelChange('email')" v-if="status.email" :disabled="email_change_loading">
                        <span v-if="email_change_loading" class="spinner-border spinner-border-sm flex-shrink-0" role="status"></span>
                        Отменить изменение
                    </button>
                </div>
            </div>
        </div>
        <div class="bkt-card bkt-card__body bkt-gap-row-medium">
            <h3 class="bkt-card__title">Ваш номер телефона</h3>
            <div class="bkt-form bkt-gap-down-sm-row-medium">
                <div class="col-12 col-md-8">
                    <bkt-input
                        v-model="edit_user.phone"
                        :name="'phone'"
                        type="tel"
                        :rules="'required|phone'"
                        :placeholder="'+7 495 000-00-00'"
                        icon_name="Smartphone" icon_color="primary"
                        :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
                        disabled
                        :status="status.phone"
                        status_class="bkt-text-primary"
                    />
                    <!--             status="подтвердить >"
                                    status_class="bkt-text-primary"-->
                </div>
                <div class="col-12 col-md-4">
                    <button class="bkt-button primary bkt-button_plump float-end bkt-w-down-sm-100"
                            @click="editContact('phone')" v-if="!status.phone">
                        {{edit_user.phone ? 'Изменить' : 'Привязать'}}
                    </button>
                    <button class="bkt-button primary bkt-button_plump float-end bkt-w-down-sm-100"
                            @click="cancelChange('phone')" v-if="status.phone" :disabled="phone_change_loading">
                        <span v-if="phone_change_loading" class="spinner-border spinner-border-sm flex-shrink-0" role="status"></span>
                        Отменить изменение
                    </button>
                </div>
            </div>
        </div>
        <bkt-edit-contact-modal ref="editContact"></bkt-edit-contact-modal>
    </div>
</template>

<script>
    import BktEditContactModal from "./EditContactModal";

    export default {
        name: "ContactTab",
        components: {
            BktEditContactModal
        },
        data() {
            return {
                edit_user: {
                    email: "",
                    middle_name: '',
                    name: "",
                    phone: '',
                    lastName: "",
                },
                loading: false,
                status: {
                    email: '',
                    phone: ''
                },
                email_change_loading: false,
                phone_change_loading: false,
            }
        },
        mounted() {
            if (this.isLoggedIn) {
                this.edit_user = JSON.parse(JSON.stringify(this.user));
                if (this.edit_user.changeCredentialsProcess) {
                    // const start = this.$moment(this.edit_user.changeCredentialsProcess.dateOfChange);
                    // const end = this.$moment();
                    // let days = start.diff(end, "days");
                    // if (days>0)
                    // {
                    //     this.status[this.edit_user.changeCredentialsProcess.newValueType] = 'дней до изменения на '
                    //         +this.edit_user.changeCredentialsProcess.newValue+' : '+days;
                    // }
                    this.status[this.edit_user.changeCredentialsProcess.newValueType] = 'изменится на '
                        + this.edit_user.changeCredentialsProcess.newValue + ' '
                        + this.$moment(this.edit_user.changeCredentialsProcess.dateOfChange).format('DD MMMM YYYY HH:mm');
                }
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
            editContact(type) {
                this.$refs.editContact.setType(type);
                this.$store.commit('openModal', '#editContactModal')
            },
            cancelChange(type) {
                this[type + '_change_loading'] = true;
                this.$store.dispatch('deleteCredentialsProcess', this.edit_user.changeCredentialsProcess.changeCredentialsProcessId)
                    .then(resp => {
                        this.edit_user.changeCredentialsProcess = null;
                        this.status[type] = '';
                        this.$store.dispatch('saveDataProperty', {
                            module_key: 'auth', state_key: 'auth_user',
                            key: 'changeCredentialsProcess',
                            value: null
                        }, {root: true});
                        this[type + '_change_loading'] = false;
                        this.$store.dispatch('sendNotification',
                            { message:'Изменение успешно отменено'})
                    }).catch(error => {
                    this[type + '_change_loading'] = false;
                })
            },
        }
    }
</script>

<style scoped>

</style>
