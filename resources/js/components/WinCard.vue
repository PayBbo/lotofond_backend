<template>
    <div class="bkt-card-trade bkt-card-win bkt-card__row w-100 mx-auto mx-0">
        <div class="bkt-wrapper-between bkt-card__heading w-100">
            <h5>торги № {{item && item.trade.externalId ? item.trade.externalId : '0'}}</h5>
        </div>
        <div class="col-12 p-0">
            <div class="row h-100 w-100 mx-auto row-cols-1 row-cols-md-2 bkt-gap-row-large">
                <div class="col-12 col-md-8 d-md-none p-0">
                    <router-link :to="'/lot/'+item.id" class="bkt-card__title bkt-text-truncate">
                        {{item && item.description ? item.description:'Некоторое название торгов'}}
                    </router-link>
                </div>
                <div class="col-12 col-md-12 col-lg-4 p-0 pe-sm-2">
                    <hooper :itemsToShow="1" :centerMode="true" class="bkt-card__image-slider h-100 w-100">
                            <slide>
                                <img v-lazy="'/images/card-image.jpg'" class="bkt-card__image"/>
                            </slide>
                            <slide>
                                <img v-lazy="'/images/card-image.jpg'" class="bkt-card__image"/>
                            </slide>
                            <slide>
                                <img v-lazy="'/images/card-image.jpg'" class="bkt-card__image"/>
                            </slide>
                            <hooper-navigation slot="hooper-addons"></hooper-navigation>
                        </hooper>
                </div>
                <div class="col-12 col-md-12 col-lg-8 p-0 ps-sm-2">
                    <div class="bkt-form bkt-form_wide w-100">
                        <div class="col-12 col-md-8 d-none d-md-block p-0">
                                <router-link :to="'/lot/'+item.id" class="bkt-card__title bkt-text-truncate">
                                    {{item && item.description ? item.description:'Некоторое название торгов'}}
                                </router-link>
                        </div>
                        <div class="col-12 col-md-4 p-0">
                            <div class="bkt-card-price-wrapper">
                                <h6 class="bkt-card-price__subtitle bkt-text-main">
                                    конечная цена
                                </h6>
                                <h2 class="bkt-card-price__title">2 485 400 ₽</h2>
                            </div>
                        </div>
                        <div class="bkt-form p-0 bkt-card-infographics">
                            <div class="col-12 col-md-6">
                                <div class="bkt-card__row outline bkt-wrapper-between align-items-center">
                                    <div class="bkt-card__feature">
                                        <h6 class="bkt-card__subtitle">начальная цена</h6>
                                        <h4 class="bkt-card__title">50 000 ₽</h4>
                                    </div>
                                    <span class="bkt-card__icon">
                                    <bkt-icon :name="'Activity'" color="primary"></bkt-icon>
                                </span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="bkt-card__row outline bkt-wrapper-between align-items-center">
                                    <div class="bkt-card__feature">
                                        <h6 class="bkt-card__subtitle">процент падения</h6>
                                        <h4 class="bkt-card__title">90%</h4>
                                    </div>
                                    <span class="bkt-card__icon">
                                    <bkt-icon :name="'ArrowDownCircle'" color="primary"></bkt-icon>
                                </span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="bkt-card__row outline bkt-wrapper-between align-items-center">
                                    <div class="bkt-card__feature">
                                        <h6 class="bkt-card__subtitle">участники</h6>
                                        <h4 class="bkt-card__title">4</h4>
                                    </div>
                                    <span class="bkt-card__icon">
                                    <bkt-icon :name="'User'" color="primary"></bkt-icon>
                                </span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="bkt-card__row outline bkt-wrapper-between align-items-center">
                                    <div class="bkt-card__feature">
                                        <h6 class="bkt-card__subtitle">дата</h6>
                                        <h4 class="bkt-card__title">4</h4>
                                    </div>
                                    <span class="bkt-card__icon">
                                    <bkt-icon :name="'CalendarEvent'" color="primary"></bkt-icon>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 p-0">
                            <div class="bkt-wrapper bkt-nowrap bkt-gap">
                                <div class="bkt-icon-frame bkt-bg-yellow">
                                    <bkt-icon name="Trophy" class="bkt-button__icon"></bkt-icon>
                                </div>
                                <div class="bkt-wrapper-between bkt-gap-small mx-0 w-100">
                                    <h5 class="bkt-card-winner__title">Иванов Иван Иванович</h5>
                                    <h6 class="bkt-card-winner__subtitle bkt-card__subtitle">
                                        кол-во побед: <strong class="bkt-text-blue">4</strong>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        Hooper,
        Slide,
        Navigation as HooperNavigation
    } from 'hooper';
    import 'hooper/dist/hooper.css';

    export default {
        props: {
            item: {
                type: Object,
            },
            in_process: {
                type: Array,
                default: function () {
                    return [];
                }
            }
        },
        components: {
            Hooper,
            Slide,
            HooperNavigation,
        },
        data() {
            return {

            }
        },
        methods: {

        }
    };
</script>

<style scoped>
</style>
