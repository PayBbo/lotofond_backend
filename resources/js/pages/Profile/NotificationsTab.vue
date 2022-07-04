<template>
    <div class="bkt-wrapper-column">
        <div class="bkt-card bkt-notifications-card">
            <div class="bkt-wrapper-between align-items-center">
                <div>
                    <div class="bkt-card__title">От организаторов</div>
                    <h5 class="bkt-card__subtitle">получение уведомлений об отчетах, задачах по лотам</h5>
                </div>

                <bkt-switch></bkt-switch>
            </div>
        </div>
        <div class="bkt-card bkt-notifications-card">
            <div class="bkt-wrapper-between align-items-center">
                <div>
                    <div class="bkt-card__title">Мониторинг</div>
                    <h5 class="bkt-card__subtitle">изменение лотов подобранных  в разделе “Мониторинг”</h5>
                </div>

                <bkt-switch></bkt-switch>
            </div>
        </div>
        <div class="bkt-card bkt-notifications-card">
            <div class="bkt-wrapper-between align-items-center">
                <div>
                    <div class="bkt-card__title">Этапы торгов</div>
                    <h5 class="bkt-card__subtitle">изменение цены, начало/окончание торгов</h5>
                </div>
                <bkt-switch></bkt-switch>
            </div>
            <div class="bkt-wrapper-column">
                <bkt-checkbox label="за 1 день"></bkt-checkbox>
                <bkt-checkbox label="за 2 дня"></bkt-checkbox>
                <bkt-checkbox label="за 3 дня"></bkt-checkbox>
                <bkt-checkbox label="за 5 дней"></bkt-checkbox>
            </div>
        </div>
    </div>
</template>

<script>
    import BktSwitch from "../../components/Switch";
    export default {
        name: "NotificationsTab",
        components: {BktSwitch}
    }
</script>

<style scoped>

</style>
