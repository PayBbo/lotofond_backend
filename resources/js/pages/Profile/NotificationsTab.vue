<template>
    <div class="bkt-wrapper-column">
        <!--        <div class="bkt-card bkt-notifications-card">-->
        <!--            <div class="bkt-wrapper-between align-items-center bkt-nowrap">-->
        <!--                <div>-->
        <!--                    <div class="bkt-card__title">От организаторов</div>-->
        <!--                    <h5 class="bkt-card__subtitle">получение уведомлений об отчетах, задачах по лотам</h5>-->
        <!--                </div>-->

        <!--                <bkt-switch></bkt-switch>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="bkt-card bkt-notifications-card">
            <div class="bkt-wrapper-between align-items-center bkt-nowrap">
                <div>
                    <div class="bkt-card__title">Мониторинг</div>
                    <h5 class="bkt-card__subtitle">изменение лотов подобранных в разделе “Мониторинг”</h5>
                </div>

                <bkt-switch v-model="notifications.notificationsFromMonitoring" @input="save" :disabled="loading"></bkt-switch>
            </div>
        </div>
        <div class="bkt-card bkt-notifications-card">
            <div class="bkt-wrapper-between align-items-center bkt-nowrap">
                <div>
                    <div class="bkt-card__title">Избранное</div>
                    <h5 class="bkt-card__subtitle">изменение лотов подобранных в разделе “Избранное”</h5>
                </div>

                <bkt-switch v-model="notifications.notificationsFromFavourite" @input="save" :disabled="loading"></bkt-switch>
            </div>
            <div class="bkt-wrapper-column">
                <h6 class="bkt-card__title" :class="{'bkt-text-neutral-dark':!notifications.notificationsFromFavourite}">
                    Начало приёма заявок
                </h6>
                <bkt-checkbox label="за 1 день" v-model="notifications.notificationsSettings.favouriteApplicationStart"
                              val="1" name="favouriteApplicationStart1" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 2 дня" v-model="notifications.notificationsSettings.favouriteApplicationStart"
                              val="2" name="favouriteApplicationStart2" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 4 дня" v-model="notifications.notificationsSettings.favouriteApplicationStart"
                              val="4" name="favouriteApplicationStart3" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 7 дней" v-model="notifications.notificationsSettings.favouriteApplicationStart"
                              val="7" name="favouriteApplicationStart4" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <h6 class="bkt-card__title" :class="{'bkt-text-neutral-dark':!notifications.notificationsFromFavourite}">
                    Окончание приёма заявок
                </h6>
                <bkt-checkbox label="за 1 день" v-model="notifications.notificationsSettings.favouriteApplicationEnd"
                              val="1" name="favouriteApplicationEnd1" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 2 дня" v-model="notifications.notificationsSettings.favouriteApplicationEnd"
                              val="2" name="favouriteApplicationEnd2" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 4 дня" v-model="notifications.notificationsSettings.favouriteApplicationEnd"
                              val="4" name="favouriteApplicationEnd3" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 7 дней" v-model="notifications.notificationsSettings.favouriteApplicationEnd"
                              val="7" name="favouriteApplicationEnd4" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <h6 class="bkt-card__title" :class="{'bkt-text-neutral-dark':!notifications.notificationsFromFavourite}">
                    Начало проведение торгов
                </h6>
                <bkt-checkbox label="за 1 день" v-model="notifications.notificationsSettings.favouriteEventStart"
                              val="1" name="favouriteEventStart1" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 2 дня" v-model="notifications.notificationsSettings.favouriteEventStart"
                              val="2" name="favouriteEventStart2" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 4 дня" v-model="notifications.notificationsSettings.favouriteEventStart"
                              val="4" name="favouriteEventStart3" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 7 дней" v-model="notifications.notificationsSettings.favouriteEventStart"
                              val="7" name="favouriteEventStart4" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <h6 class="bkt-card__title" :class="{'bkt-text-neutral-dark':!notifications.notificationsFromFavourite}">
                    Окончание приёма заявок
                </h6>
                <bkt-checkbox label="за 1 день" v-model="notifications.notificationsSettings.favouriteEventEnd"
                              val="1" name="favouriteEventEnd1" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 2 дня" v-model="notifications.notificationsSettings.favouriteEventEnd"
                              val="2" name="favouriteEventEnd2" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 4 дня" v-model="notifications.notificationsSettings.favouriteEventEnd"
                              val="4" name="favouriteEventEnd3" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 7 дней" v-model="notifications.notificationsSettings.favouriteEventEnd"
                              val="7" name="favouriteEventEnd4" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <h6 class="bkt-card__title" :class="{'bkt-text-neutral-dark':!notifications.notificationsFromFavourite}">
                    Новый этап снижения цены
                </h6>
                <bkt-checkbox label="за 1 день" v-model="notifications.notificationsSettings.favouritePriceReduction"
                              val="1" name="favouritePriceReduction1" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 2 дня" v-model="notifications.notificationsSettings.favouritePriceReduction"
                              val="2" name="favouritePriceReduction2" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 4 дня" v-model="notifications.notificationsSettings.favouritePriceReduction"
                              val="4" name="favouritePriceReduction3" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
                <bkt-checkbox label="за 7 дней" v-model="notifications.notificationsSettings.favouritePriceReduction"
                              val="7" name="favouritePriceReduction4" type="radio" @input="save"
                              :disabled="!notifications.notificationsFromFavourite || loading"></bkt-checkbox>
            </div>
        </div>
        <!--        <div class="bkt-card bkt-notifications-card">-->
        <!--            <div class="bkt-wrapper-between align-items-center bkt-nowrap">-->
        <!--                <div>-->
        <!--                    <div class="bkt-card__title">Этапы торгов</div>-->
        <!--                    <h5 class="bkt-card__subtitle">изменение цены, начало/окончание торгов</h5>-->
        <!--                </div>-->
        <!--                <bkt-switch></bkt-switch>-->
        <!--            </div>-->
        <!--            <div class="bkt-wrapper-column">-->
        <!--                <bkt-checkbox label="за 1 день"></bkt-checkbox>-->
        <!--                <bkt-checkbox label="за 2 дня"></bkt-checkbox>-->
        <!--                <bkt-checkbox label="за 3 дня"></bkt-checkbox>-->
        <!--                <bkt-checkbox label="за 5 дней"></bkt-checkbox>-->
        <!--            </div>-->
        <!--        </div>-->
    </div>
</template>

<script>
    import BktSwitch from "../../components/Switch";

    export default {
        name: "NotificationsTab",
        components: {BktSwitch},
        data() {
            return {
                notifications: {
                    notificationsFromFavourite: true,
                    notificationsFromMonitoring: true,
                    notificationsSettings: {
                        favouriteEventStart: 1,
                        favouriteEventEnd: 1,
                        favouriteApplicationStart: 1,
                        favouriteApplicationEnd: 1,
                        favouriteResult: 1,
                        favouritePriceReduction: 1
                    }
                },
                loading: false
            }
        },
        mounted() {
            if (this.isLoggedIn) {
                this.notifications = JSON.parse(JSON.stringify(this.user));
            }
        },
        computed: {
            user() {
                return this.$store.getters.auth_user
            },
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
        methods: {
            save() {
                this.loading = true;
                this.$store.dispatch('saveNotificationsSettings', this.notifications)
                    .then(resp => {
                        this.loading = false;
                }).catch(error => {
                    this.loading = false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
