<template>
    <div>
        <div class="bkt-card bkt-card__body bkt-gap-down-sm-row-large">
            <h3 class="bkt-card__title">Ваши контакты</h3>
            <bkt-input
                v-model="edit_user.email"
                :name="'email'"
                type="email"
                label="e-mail"
                :rules="'required|email'"
                placeholder="pochta@gmail.com"
                icon_name="Email" icon_color="primary"
                disabled
            >
<!--                 status="подтвержден"
                status_class="bkt-text-green"-->
            </bkt-input>
            <bkt-input
                v-model="edit_user.phone"
                :name="'phone'"
                type="tel"
                label="номер телефона"
                :rules="'required|phone'"
                :placeholder="'+7 495 000-00-00'"
                icon_name="Smartphone" icon_color="primary"
                :mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
                disabled
            />
<!--             status="подтвердить >"
                status_class="bkt-text-primary"-->
        </div>
    </div>
</template>

<script>
    export default {
        name: "ContactTab",
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
    }
</script>

<style scoped>

</style>
