<template>
    <bkt-modal :id="'resetSuccessModal'" :modal_class="'bkt-auth-modal reset login'" no_footer>
        <template #aside>
            <div class="bkt-modal__aside bkt-bg-green">
                <img class="bkt-modal__aside-image" v-lazy="'/images/reset_image.png'" alt="">
            </div>
        </template>
        <template #title>
            <div class="bkt-wrapper-column bkt-gap-row-medium bkt-gap-down-md-row">
                <h3 class="bkt-modal__title">
                    Пароль изменен
                </h3>
                <h6 class="bkt-modal__subtitle bkt-text-neutral-dark">Теперь вы можете использовать его для входа</h6>
            </div>
        </template>
        <template #body="{ invalid }">
            <button class="bkt-button primary bkt-button_plump mb-0 me-auto ms-0 bkt-w-down-md-100" @click="navigate">
                Войти
            </button>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "ResetSuccessModal",
        methods: {
            navigate() {
                this.$store.commit('closeModal', '#resetSuccessModal');
                this.$store.commit('openModal', '#authModal');
            }
        }
    }
</script>

<style scoped>

</style>
