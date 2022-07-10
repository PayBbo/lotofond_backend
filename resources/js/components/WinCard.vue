<template>
    <div class="bkt-card-trade bkt-card__row w-100 mx-auto mx-0">
        <div class="bkt-wrapper-between bkt-card__heading w-100">
            <h5>торги № {{item && item.trade.externalId ? item.trade.externalId : '0'}}</h5>
        </div>
        <div class="col-12 p-0">
            <div class="row h-100 w-100 mx-auto row-cols-1 row-cols-md-2">
                <div class="col-12 col-lg-4 p-0 p-sm-2 order-2 order-lg-1">
                    <div class="bkt-card-image-wrapper">
                        <hooper :itemsToShow="1" :centerMode="true" class="bkt-card__image-slider">
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
                        <div class="bkt-wrapper-between bkt-card-ecp-wrapper">
                            <button class="bkt-button primary bkt-card-ecp">
                                Купить без ЭЦП
                            </button>
                            <div class="bkt-check__wrapper">
                                <div class="bkt-check">
                                    <div class="bkt-check__input">
                                        <input class="" type="checkbox">
                                        <div class="bkt-check__input-check"></div>
                                    </div>
                                    <label  class="bkt-check__label">
                                        Есть ЭЦП
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8 p-0 p-sm-2 order-1 order-lg-2">
                    <div class="bkt-wrapper-between bkt-card__head bkt-nowrap">
                        <router-link :to="'/lot/'+item.id" class="bkt-card__title bkt-text-truncate">
                            {{item && item.description ? item.description:'Некоторое название торгов'}}
                        </router-link>
                        <div class="dropdown d-block d-lg-none">
                            <button class="bkt-button bkt-bg-primary-lighter bkt-card-menu-button" type="button"
                                    id="dropdownMenuClickableOutside" data-bs-toggle="dropdown" data-bs-offset="10,20"
                                    data-bs-display="static" data-bs-auto-close="outside"  aria-expanded="false"
                            >
                                <bkt-icon :name="'More'"></bkt-icon>
                            </button>
                            <div class="bkt-card-menu m-0 dropdown-menu dropdown-menu-end position-absolute"
                                 aria-labelledby="dropdownMenuClickableOutside"
                            >
                                <card-actions :item="item" class="bkt-card-menu-inner" type="menu"></card-actions>
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
