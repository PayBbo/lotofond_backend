<template>
    <div class="bkt-page bkt-container">
        <div class="bkt-card">
            <div class="bkt-card__body align-items-center text-center">
                <bkt-icon name="Check" height="100px" width="100px" color="green"></bkt-icon>
                <h2 class="bkt-card__title bkt-text-green">Спасибо! Оплата прошла успешно</h2>
                <a class="bkt-button green" href="/">На главную</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PayAnswer",
        data() {
            return {
                loading: false,
            }
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>
