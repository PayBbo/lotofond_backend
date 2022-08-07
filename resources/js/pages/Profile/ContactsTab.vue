<template>
    <div class="bkt-wrapper-column bkt-gap-large bkt-gap-down-sm">
        <div class="bkt-card bkt-card__body bkt-gap-row-medium">
            <h3 class="bkt-card__title">Ваша электронная почта</h3>
            <div class="bkt-form bkt-gap-down-sm-row-medium">
                <div class="col-12 col-md-8">
                    <bkt-input
                        v-model="edit_user.email"
                        :name="'email'"
                        type="email"
                        :rules="'required|email'"
                        placeholder="pochta@gmail.com"
                        icon_name="Email" icon_color="primary"
                        disabled
                    >
                        <!--                 status="подтвержден"
                                        status_class="bkt-text-green"-->
                    </bkt-input>
                </div>
                <div class="col-12 col-md-4">
                    <button class="bkt-button primary bkt-button_plump float-end bkt-w-down-sm-100" @click="editContact('email')">
                        {{edit_user.email ? 'Изменить' : 'Привязать'}}
                        <!--                        Подтвердить-->
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
                    />
                    <!--             status="подтвердить >"
                                    status_class="bkt-text-primary"-->
                </div>
                <div class="col-12 col-md-4">
                    <button class="bkt-button primary bkt-button_plump float-end bkt-w-down-sm-100"  @click="editContact('phone')">
                        {{edit_user.phone ? 'Изменить' : 'Привязать'}}
                        <!--                        Подтвердить-->
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
            editContact(type) {
                this.$refs.editContact.setType(type);
                this.$store.commit('openModal', '#editContactModal')
            }
        }
    }
</script>

<style scoped>

</style>
