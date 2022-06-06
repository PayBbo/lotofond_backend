<template>
    <div class="bkt-card-bidding bkt-card row w-100 mx-auto position-relative mx-0">
        <div class="bkt-wrapper-between bkt-card__heading">
            <h5>торги №</h5>
            <h5>до окончания более 14 дней
                <span class="bkt-card__icon">
                    <bkt-icon :name="'Alarm'" :fill="'#2fbb40'" :width="'14px'" :height="'14px'"></bkt-icon>
                </span>
            </h5>
        </div>
        <div class="col-12 col-lg-11 p-0">
            <div class="row h-100 w-100 mx-auto row-cols-1 row-cols-md-2 row-cols-lg-3">
                <div class="col order-2 order-lg-1">
                    <div>
                        <img src="/images/card-image.jpg" class="bkt-card__image"/>
                        <div class="bkt-wrapper-between" style="margin-top: 25px; margin-bottom: 25px">
                            <button class="bkt-button primary">
                                Купить без ЭЦП
                            </button>
                            <div class="form-check form-check-inline my-2">
                                <input class="form-check-input bkt-check__input" type="checkbox" value="" id="">
                                <label class="form-check-label bkt-check__label" for="">
                                    Есть ЭЦП
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 order-1 order-lg-2">
                    <div class="bkt-wrapper-between bkt-card__head">
                        <h3 class="bkt-card__title">Некоторое название торгов</h3>
                        <button class="bkt-button bg-primary-lighter bkt-card-menu-button d-block d-lg-none">
                            <bkt-icon :name="'More'"></bkt-icon>
                        </button>
                    </div>
                    <div class="d-none d-lg-block">
                        <div class="bkt-card__feature">
                            <h6 class="bkt-card__subtitle">кад.номер</h6>
                            <h5 class="bkt-card__text">23:28:0101272:330</h5>
                        </div>
                        <div class="bkt-card__feature">
                            <h6 class="bkt-card__subtitle">назначение объекта недвижимости</h6>
                            <h5 class="bkt-card__text">земли населенных пунктов</h5>
                        </div>
                        <div class="bkt-card__feature">
                            <h6 class="bkt-card__subtitle">виды разрешенного использования<br> объекта недвижимости</h6>
                            <h5 class="bkt-card__text">для садоводства</h5>
                        </div>
                        <div class="bkt-card__feature">
                            <bkt-icon :name="'More'" :width="'22px'" :height="'22px'"></bkt-icon>
                        </div>
                    </div>
                </div>
                <div class="col order-3 ">
                    <div class="bkt-card-price bkt-button green w-100">2 485 400 ₽
                        <div class="bkt-card-price-icon bg-green-light"></div>
                    </div>
                    <div class="bkt-card-infographics bkt-wrapper-between">
                        <div class="bkt-card outline">
                            <div class="bkt-card__feature text-center w-100 mt-0">
                                <h5 class="bkt-card__subtitle">шаг аукциона</h5>
                                <h4 class="bkt-card__title bkt-text-primary">4 700 ₽</h4>
                            </div>

                        </div>
                        <div class="bkt-card outline">
                            <div class="bkt-card__feature text-center w-100 mt-0">
                                <h5 class="bkt-card__subtitle">задаток</h5>
                                <h4 class="bkt-card__title bkt-text-red">149 990 ₽</h4>
                            </div>
                        </div>
                    </div>
                    <div class="bkt-card-period bkt-wrapper">
                        <div class="bkt-card__category bg-primary-lighter">
                            <bkt-icon :name="'Date'" :fill="'#2953ff'" :width="'16px'" :height="'16px'"></bkt-icon>
                        </div>
                        <div class="bkt-card_feature">
                            <h6>прием заявок</h6>
                            <h6>
                                с 22 сентября 2022 <span class="bkt-text-blue">09:00</span>
                                <br>до 25 сентября 2022 <span class="bkt-text-blue">19:00</span>
                            </h6>
                        </div>
                    </div>
                    <div class="bkt-card-period bkt-wrapper">
                        <div class="bkt-card__category bg-primary-lighter">
                            <bkt-icon :name="'Alarm'" :fill="'#2953ff'" :width="'16px'" :height="'16px'"></bkt-icon>
                        </div>
                        <div class="bkt-card_feature">
                            <h6>проведение торгов</h6>
                            <h6>
                                с 21 апреля 2022 <span class="bkt-text-yellow">10:30</span>
                                <br>до 21 апреля 2022 <span class="bkt-text-yellow">13:30</span>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-12 order-4" style="align-self: end;">
                    <div class="bkt-wrapper-between bkt-card-infographics">
                        <div class="bkt-card outline bkt-wrapper-between">
                            <div class="bkt-card__feature">
                                <h4 class="bkt-card__title">600 кв.м.</h4>
                                <h6 class="bkt-card__subtitle">земельный участок</h6>
                            </div>
                            <span class="bkt-card__icon">
                                <bkt-icon :name="'Tree'"></bkt-icon>
                            </span>
                        </div>
                        <div class="bkt-card outline bkt-wrapper-between">
                            <div class="bkt-card__feature">
                                <h4 class="bkt-card__title">800 478 ₽</h4>
                                <h6 class="bkt-card__subtitle">кадастровая стоимость</h6>
                            </div>
                            <span class="bkt-card__icon">
                                <bkt-icon :name="'File'"></bkt-icon>
                            </span>
                        </div>
                        <div class="bkt-card outline bkt-wrapper-between">
                            <div class="bkt-card__feature">
                                <h4 class="bkt-card__title">95%</h4>
                                <h6 class="bkt-card__subtitle">доля в собственности</h6>
                            </div>
                            <span class="bkt-card__icon">
                                <bkt-icon :name="'Pie'"></bkt-icon>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2 col-lg-1 p-0 d-none d-lg-block">
            <div class="bkt-card bg-main vertical m-0">
                <button class="bkt-button-ellipse main-light">
                    <bkt-icon class="bkt-button__icon" :name="'Eye'" :width="'20px'" :height="'18px'"></bkt-icon>
                </button>
                <button class="bkt-button-ellipse main-light">
                    <bkt-icon class="bkt-button__icon" :name="'Pencil'"></bkt-icon>
                </button>
                <button class="bkt-button-ellipse main-light">
                    <bkt-icon class="bkt-button__icon" :name="'Target'" :stroke="'#fff'"></bkt-icon>
                </button>
                <button class="bkt-button-ellipse main-light">
                    <bkt-icon class="bkt-button__icon" :name="'Star'"></bkt-icon>
                </button>
                <button class="bkt-button-ellipse main-light">
                    <span class="info"></span>
                    <bkt-icon class="bkt-button__icon" :name="'Bell'"></bkt-icon>
                </button>
                <button class="bkt-button-ellipse main-light">
                    <bkt-icon class="bkt-button__icon" :name="'Clip'" :width="'15px'" :height="'19px'"></bkt-icon>
                </button>
                <button class="bkt-button-ellipse">
                    <bkt-icon class="bkt-button__icon" :name="'Trash'"></bkt-icon>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Card"
    }
</script>

<style scoped>
    /*.parent {*/
    /*    display: grid;*/
    /*    !*grid-template-columns: repeat(4, 1fr);*!*/
    /*    !*grid-template-rows: repeat(2, 1fr);*!*/
    /*    grid-column-gap: 0px;*/
    /*    grid-row-gap: 0px;*/
    /*}*/

    /*.div1 { grid-area: 1 / 1 / 2 / 2; }*/
    /*.div2 { grid-area: 1 / 2 / 2 / 3; }*/
    /*.div3 { grid-area: 1 / 3 / 2 / 4; }*/
    /*.div4 { grid-area: 1 / 4 / 3 / 5; }*/
    /*.div5 { grid-area: 2 / 1 / 3 / 4; }*/
</style>
