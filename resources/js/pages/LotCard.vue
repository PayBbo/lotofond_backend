<template>
    <div class="container bkt-main bkt-lot-card bkt-container">
        <div class="bkt-wrapper" style="margin: 30px 0;">
            <nav class="bkt-wrapper bkt-nowrap m-0" aria-label="breadcrumb">
                <button class="bkt-button-icon bg-white" style="margin-right:20px" @click="goBack">
                    <bkt-icon :name="'ArrowDown'" class="bkt-button__icon bkt-rotate-90"></bkt-icon>
                </button>
                <ol class="breadcrumb bkt-breadcrumb m-0">
                    <li class="breadcrumb-item bkt-breadcrumb__item">
                        <a href="/" class="bkt-text-neutral-dark">главная</a>
                    </li>
                    <li class="breadcrumb-item bkt-breadcrumb__item">торги</li>
                    <li class="breadcrumb-item bkt-breadcrumb__item active" aria-current="page">торги №
                        {{item.trade.externalId ? item.trade.externalId : ''}} (лот {{item.lotNumber}})
                    </li>
                </ol>
            </nav>
        </div>
        <div class="bkt-row bkt-bg-main bkt-wrapper-between bkt-lot-card-actions-nav d-none d-lg-flex">
            <h5 class="bkt-trading-number">
                торги № {{item.tradingNumber}} (лот {{item.lotNumber}})
            </h5>
            <bkt-card-actions :item="item" class="bkt-actions" button_type="-icon"></bkt-card-actions>
        </div>
        <div class="row p-0" style="gap: 30px 0; margin:30px auto;">
            <div class="col-12 col-lg-7 order-2 order-lg-1">
                <div class="bkt-card">
                    <div class="bkt-card__body">
                        <h3 class="bkt-card__title bkt-text-truncate">
                            {{item && item.description ? item.description:'Некоторое название торгов'}}
                        </h3>
                        <ul class="bkt-contents">
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">общая площадь</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>207 м2</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">-->
<!--                                        общие сведения об ограничениях и обременениях-->
<!--                                    </span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>нет</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">назначение нежилого помещения</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>офисное помещение</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">расположение в пределах объекта недвижимости (этажа, части этажа, нескольких этажей)</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>7 этаж</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">кадастровый номер</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>77:06:0004004:1051</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">год ввода в эксплуатацию</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>1980</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">местонахождение имущества</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>Нахимовский проспект, дом 47</span>-->
<!--                                </div>-->
<!--                            </li>-->
                            <template v-for="(category, index) in item.categories">
                                <li>
                                    <div class="bkt-contents__heading">
                                        <span class="bkt-contents__heading">категория объекта</span>
                                    </div>
                                    <div class="bkt-contents__answer">
<!--                                        <span>{{$t('categories.'+category.key)}}</span>-->
                                        <span>{{category.label}}</span>
                                    </div>
                                </li>
                                <li v-for="subcategory in category.subcategories">
                                    <div class="bkt-contents__heading">
                                        <span class="bkt-contents__heading">подкатегория объекта</span>
                                    </div>
                                    <div class="bkt-contents__answer">
<!--                                        <span>{{$t('categories.'+subcategory)}}</span>-->
                                        <span>{{subcategory.label}}</span>
                                    </div>
                                </li>
                            </template>
                            <li v-if="item.location">
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">регион объекта</span>
                                </div>
                                <div class="bkt-contents__answer">
                                    <span>{{item.location}}</span>
                                </div>
                            </li>
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">категория объекта</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>нежилое</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">форма собственности</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>федеральная собственность</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span>-->
<!--                                        Информация о сроках и порядке внесения задатка, реквизитах счета для перечисления задатка указана в документации (при наличии  требования о внесении задатка)-->
<!--                                   </span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>1</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">перечисление задатка</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer">-->
<!--                                    <span>задаток перечисляется на счет организатора</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">вид договора</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>договор аренды</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">порядок оплаты</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>ежемесячный платеж</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">начальная цена за кв.м </span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>12000</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">ежемесячный платеж за объект</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>207000</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">срок действия договора - лет</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>5</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span>порядок ознакомления с имуществом, иной информацией</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>в соответствии с аукционной документацией</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">обременения, ограничения</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>нет</span>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="bkt-contents__heading">-->
<!--                                    <span class="bkt-contents__heading">целевое назначение государственного или муниципального имущества, права на которое передаются по договору</span>-->
<!--                                </div>-->
<!--                                <div class="bkt-contents__answer"><span>офисное помещение</span>-->
<!--                                </div>-->
<!--                            </li>-->
                        </ul>
                        <div class="bkt-contents">
                            {{item.description}}
                        </div>
                        <div class="bkt-row outline bkt-wrapper-between align-items-center" v-if="item.cadastralData">
                            <div class="bkt-row__feature">
                                <h4 class="bkt-row__feature-title">600 кв.м.</h4>
                                <h6 class="bkt-row__feature-subtitle">земельный участок</h6>
                            </div>
                            <div class="bkt-row__icon">
                                <bkt-icon :name="'Tree'"></bkt-icon>
                            </div>
                        </div>
                        <div class="bkt-row outline bkt-wrapper-between" v-if="item.cadastralData">
                            <div class="bkt-row__feature">
                                <h4 class="bkt-row__feature-title">800 478 ₽</h4>
                                <h6 class="bkt-row__feature-subtitle">кадастровая стоимость</h6>
                            </div>
                            <span class="bkt-row__icon">
                            <bkt-icon :name="'File'"></bkt-icon>
                        </span>
                        </div>
                        <div class="bkt-row outline bkt-wrapper-between" v-if="item.cadastralData">
                            <div class="bkt-row__feature">
                                <h4 class="bkt-row__feature-title">95%</h4>
                                <h6 class="bkt-row__feature-subtitle">доля в собственности</h6>
                            </div>
                            <span class="bkt-row__icon">
                            <bkt-icon :name="'Pie'"></bkt-icon>
                        </span>
                        </div>
                    </div>
                    <div class="bkt-card__footer">
                        <h6>
                            <a href="">№135-ФЗ "О защите конкуренции", статья 17.1
                                <span>
                                    <bkt-icon :name="'ArrowDown'" :color="'primary'"
                                              class="bkt-rotate-270"></bkt-icon>
                                </span>
                            </a>
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5 order-1 order-lg-2">
                <div class="bkt-card bkt-lot-card-card">
                    <div class="bkt-card__body">
                        <div class="bkt-wrapper-between bkt-card__head bkt-nowrap d-flex d-lg-none">
                            <h5 class="bkt-card__title bkt-text-truncate">
                                {{item && item.description ? item.description:'Некоторое название торгов'}}
                            </h5>
                            <div class="dropdown d-block d-lg-none">
                                <button class="bkt-button bkt-bg-primary-lighter bkt-card-menu-button" type="button"
                                        id="dropdownMenuClickableOutside" data-bs-toggle="dropdown"
                                        data-bs-offset="10,20" data-bs-display="static"
                                        data-bs-auto-close="inside" aria-expanded="false">
                                    <bkt-icon :name="'More'"></bkt-icon>
                                </button>
                                <div class="bkt-card-menu m-0 dropdown-menu dropdown-menu-end position-absolute"
                                     aria-labelledby="dropdownMenuClickableOutside"
                                >
                                    <bkt-card-actions :item="item" type="menu" class="bkt-card-menu-inner"></bkt-card-actions>
                                </div>
                            </div>
                            <!--                        <button class="bkt-button bkt-bg-primary-lighter bkt-card-menu-button">-->
                            <!--                            <bkt-icon :name="'More'"></bkt-icon>-->
                            <!--                        </button>-->
                        </div>
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
                                            <input class="" type="checkbox" disabled>
                                            <div class="bkt-check__input-check"></div>
                                        </div>
                                        <label class="bkt-check__label">
                                            Есть ЭЦП
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bkt-card-price bkt-button green w-100">
                            {{item.currentPrice ? item.currentPrice : '0' | priceFormat}} ₽
                            <div class="bkt-card-price-icon bkt-bg-green-light">
                                <bkt-icon :name="'ArrowTriple'" :width="'22px'" :height="'22px'"
                                          :class="{'bkt-rotate-180': item.currentPriceState=='down',
                                          'bkt-rotate-90': item.currentPriceState=='hold'}"
                                >
                                </bkt-icon>
                            </div>
                        </div>
                        <div class="bkt-card-infographics" style="gap: 10px;">
                            <div class="bkt-card__row outline bkt-wrapper-between">
                                <h5 class="bkt-card__subtitle">начальная цена</h5>
                                <h4 class="bkt-card__title bkt-text-primary">
                                    {{item && item.startPrice ? item.startPrice : '0' | priceFormat}} ₽
                                </h4>
                            </div>
                            <div class="bkt-card__row outline bkt-wrapper-between">
                                <h5 class="bkt-card__subtitle">минимальная цена</h5>
                                <h4 class="bkt-card__title bkt-text-red">
                                    {{item && item.minPrice ? item.minPrice : '0' | priceFormat}} ₽
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 order-3">
                <div class="bkt-card bkt-lot-card-tasks">
                    <div class="bkt-card__header bkt-wrapper-between m-0">
                        <div class="bkt-card-periods">
                            <div class="bkt-card-period bkt-wrapper">
                                <div class="bkt-card__category bkt-bg-blue">
                                    <bkt-icon :name="'Date'" :width="'16px'"
                                              :height="'16px'"></bkt-icon>
                                </div>
                                <div class="bkt-card_feature">
                                    <h6>прием заявок
                                        <strong>
                                            с {{item.trade.applicationTime.start | moment('DD MMMM YYYY')}}
                                            <span class="bkt-text-blue">{{item.trade.applicationTime.start | moment('HH:mm')}}</span>
                                            до {{item.trade.applicationTime.end | moment('DD MMMM YYYY')}}
                                            <span class="bkt-text-blue">{{item.trade.applicationTime.end | moment('HH:mm')}}</span>
                                        </strong>
                                    </h6>
                                </div>
                            </div>
                            <div class="bkt-card-period bkt-wrapper">
                                <div class="bkt-card__category bkt-bg-yellow">
                                    <bkt-icon :name="'Alarm'" :width="'16px'"
                                              :height="'16px'"></bkt-icon>
                                </div>
                                <div class="bkt-card_feature">
                                    <h6>проведение торгов
                                        <strong>
                                            с {{item.trade.eventTime.start | moment('DD MMMM YYYY')}}
                                            <span class="bkt-text-yellow">{{item.trade.eventTime.start | moment('HH:mm')}}
                                            </span>
                                        </strong>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <a :href="'http://'+item.trade.tradePlace.site" target="_blank" class="bkt-platform-button">
                            <div class="bkt-platform-button-title">ЭТП {{item.trade.tradePlace.name}}</div>
                            <div class="bkt-platform-button-subtitle">{{item.trade.tradePlace.site}}</div>
                            <bkt-icon :name="'ArrowDown'" :color="'primary'"></bkt-icon>
                        </a>
                    </div>
                    <!--                    <div class="bkt-card__body">-->
                    <!--                        <div class="bkt-wrapper-between bkt-nowrap" style="margin-bottom: 23px;">-->
                    <!--                            <div class="bkt-wrapper bkt-nowrap m-0">-->
                    <!--                                <div class="bkt-card__category bkt-bg-primary-lighter">-->
                    <!--                                    <bkt-icon :name="'Pencil'" :color="'primary'"-->
                    <!--                                              class="bkt-card__category-icon"></bkt-icon>-->
                    <!--                                </div>-->
                    <!--                                <h5>Заметка по лоту (видите только вы)</h5>-->
                    <!--                            </div>-->
                    <!--                            <button class="bkt-button-icon primary">-->
                    <!--                                <bkt-icon :name="'Plus'" class="bkt-button__icon"></bkt-icon>-->
                    <!--                            </button>-->
                    <!--                        </div>-->
                    <!--&lt;!&ndash;                        <div class="bkt-lot-card-task">&ndash;&gt;-->
                    <!--&lt;!&ndash;                            <div class="bkt-row outline bkt-wrapper-between">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <div class="bkt-check__wrapper">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    <div class="bkt-check check">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        <div class="bkt-check__input">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                            <input class="" type="checkbox">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                            <div class="bkt-check__input-check"></div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <h5 class="m-auto">Некоторое название задачи</h5>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <h6 class="m-auto">Краткое описание задачи если таково имеется</h6>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <div class="bkt-card-period bkt-wrapper">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    <div class="bkt-card__category bkt-bg-blue-lighter">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        <bkt-icon :name="'Date'" :width="'16px'"&ndash;&gt;-->
                    <!--&lt;!&ndash;                                                  :height="'16px'" :color="'blue'"></bkt-icon>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    <div class="bkt-card_feature">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        <h5>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                            22 сентября 2022 <span class="bkt-text-blue">09:00</span>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        </h5>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                            </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                            <button class="bkt-button">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>&ndash;&gt;-->
                    <!--&lt;!&ndash;                            </button>&ndash;&gt;-->
                    <!--&lt;!&ndash;                        </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                        <div class="bkt-lot-card-task">&ndash;&gt;-->
                    <!--&lt;!&ndash;                            <div class="bkt-row outline bkt-wrapper-between">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <div class="bkt-check__wrapper">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    <div class="bkt-check check">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        <div class="bkt-check__input">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                            <input class="" type="checkbox">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                            <div class="bkt-check__input-check"></div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <h5 class="m-auto">Некоторое название задачи</h5>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <h6 class="m-auto">Краткое описание задачи если таково имеется</h6>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <div class="bkt-card-period bkt-wrapper">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    <div class="bkt-card__category bkt-bg-blue-lighter">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        <bkt-icon :name="'Date'" :width="'16px'"&ndash;&gt;-->
                    <!--&lt;!&ndash;                                                  :height="'16px'" :color="'blue'"></bkt-icon>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    <div class="bkt-card_feature">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        <h5>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                            22 сентября 2022 <span class="bkt-text-blue">09:00</span>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        </h5>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                            </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                            <button class="bkt-button">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>&ndash;&gt;-->
                    <!--&lt;!&ndash;                            </button>&ndash;&gt;-->
                    <!--&lt;!&ndash;                        </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                        <div class="bkt-lot-card-task">&ndash;&gt;-->
                    <!--&lt;!&ndash;                            <div class="bkt-row outline bkt-wrapper-between">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <div class="bkt-check__wrapper">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    <div class="bkt-check">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        <div class="bkt-check__input">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                            <input class="" type="checkbox">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                            <div class="bkt-check__input-check check"></div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <h5 class="m-auto">Некоторое название задачи</h5>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <h6 class="m-auto">Краткое описание задачи если таково имеется</h6>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <div class="bkt-card-period bkt-wrapper">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    <div class="bkt-card__category bkt-bg-blue-lighter">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        <bkt-icon :name="'Date'" :width="'16px'"&ndash;&gt;-->
                    <!--&lt;!&ndash;                                                  :height="'16px'" :color="'blue'"></bkt-icon>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    <div class="bkt-card_feature">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        <h5>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                            22 сентября 2022 <span class="bkt-text-blue">09:00</span>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                        </h5>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                    </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                            </div>&ndash;&gt;-->
                    <!--&lt;!&ndash;                            <button class="bkt-button">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>&ndash;&gt;-->
                    <!--&lt;!&ndash;                            </button>&ndash;&gt;-->
                    <!--&lt;!&ndash;                        </div>&ndash;&gt;-->
                    <!--                    </div>-->
                </div>
            </div>
            <!--            <div class="col-12 col-lg-12 order-3">-->
            <!--                <div class="bkt-card bkt-card__body bkt-lot-card-actual">-->
            <!--                    <div class="bkt-card__header bkt-wrapper-between">-->
            <!--                        <h3 class="bkt-card__title">Актуальное по лоту</h3>-->
            <!--                        <button class="bkt-button" style="gap:8px;">-->
            <!--                            Смотреть отчёт-->
            <!--                            <bkt-icon :name="'Clip'" :color="'primary'" class="bkt-button__icon"></bkt-icon>-->
            <!--                        </button>-->
            <!--                    </div>-->
            <!--&lt;!&ndash;                    <div class="bkt-card outline bkt-wrapper-between">&ndash;&gt;-->
            <!--&lt;!&ndash;                        <h5 class=""><span class="bkt-text-green">Идёт приём заявок</span> (до 19.04.2022)</h5>&ndash;&gt;-->
            <!--&lt;!&ndash;                        <h5 class="bkt-text-neutral-dark">1 декабря 2022 в 09:00</h5>&ndash;&gt;-->
            <!--&lt;!&ndash;                    </div>&ndash;&gt;-->
            <!--&lt;!&ndash;                    <div class="bkt-card outline bkt-wrapper-between">&ndash;&gt;-->
            <!--&lt;!&ndash;                        <h5 class="bkt-text-red">Приём заявок заканчивается через 2 дня!</h5>&ndash;&gt;-->
            <!--&lt;!&ndash;                        <h5 class="bkt-text-neutral-dark">1 декабря 2022 в 09:00</h5>&ndash;&gt;-->
            <!--&lt;!&ndash;                    </div>&ndash;&gt;-->
            <!--&lt;!&ndash;                    <div class="bkt-card outline bkt-wrapper-between">&ndash;&gt;-->
            <!--&lt;!&ndash;                        <h5 class=""><span class="bkt-text-green">Проведение торгов с 21.04.2022</span> (до 19.04.2022)&ndash;&gt;-->
            <!--&lt;!&ndash;                        </h5>&ndash;&gt;-->
            <!--&lt;!&ndash;                        <h5 class="bkt-text-neutral-dark">1 декабря 2022 в 09:00</h5>&ndash;&gt;-->
            <!--&lt;!&ndash;                    </div>&ndash;&gt;-->
            <!--                    <div class="bkt-card__footer bkt-wrapper-between">-->
            <!--                        <button class="bkt-button-icon bkt-bg-body">-->
            <!--                            <bkt-icon class="bkt-button__icon" name="ArrowDown"></bkt-icon>-->
            <!--                        </button>-->
            <!--                        <button class="bkt-button primary">Написать организатору</button>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="col-12 col-lg-5 order-3">-->
            <!--                <div class="bkt-card bkt-card__body bkt-lot-card-templates">-->
            <!--                    <div class="bkt-card__header"><h3 class="bkt-card__title">Шаблоны запросов</h3></div>-->
            <!--                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">-->
            <!--                        <div class="bkt-template-name text-truncate">-->
            <!--                            <div class="bkt-card__icon">-->
            <!--                                <bkt-icon :name="'Note'" :color="'pink'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                            </div>-->
            <!--                            <h5 class="text-truncate">Заявка на участие в торгах</h5>-->
            <!--                        </div>-->
            <!--                        <div class="bkt-card__icon">-->
            <!--                            <bkt-icon :name="'ArrowDown'" :color="'primary'"-->
            <!--                                      class="bkt-rotate-270"></bkt-icon>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">-->
            <!--                        <div class="bkt-template-name text-truncate">-->
            <!--                            <div class="bkt-card__icon">-->
            <!--                                <bkt-icon :name="'Note'" :color="'pink'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                            </div>-->
            <!--                            <h5 class="text-truncate">Авто</h5>-->
            <!--                        </div>-->
            <!--                        <div class="bkt-card__icon">-->
            <!--                            <bkt-icon :name="'ArrowDown'" :color="'primary'"-->
            <!--                                      class="bkt-rotate-270"></bkt-icon>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">-->
            <!--                        <div class="bkt-template-name text-truncate">-->
            <!--                            <div class="bkt-card__icon">-->
            <!--                                <bkt-icon :name="'Note'" :color="'pink'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                            </div>-->
            <!--                            <h5 class="text-truncate">Квартира</h5>-->
            <!--                        </div>-->
            <!--                        <div class="bkt-card__icon">-->
            <!--                            <bkt-icon :name="'ArrowDown'" :color="'primary'"-->
            <!--                                      style="transform: rotate(270deg)"></bkt-icon>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">-->
            <!--                        <div class="bkt-template-name text-truncate">-->
            <!--                            <div class="bkt-card__icon">-->
            <!--                                <bkt-icon :name="'Note'" :color="'pink'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                            </div>-->
            <!--                            <h5 class="text-truncate">Земля</h5>-->
            <!--                        </div>-->
            <!--                        <div class="bkt-card__icon">-->
            <!--                            <bkt-icon :name="'ArrowDown'" :color="'primary'"-->
            <!--                                      class="bkt-rotate-270"></bkt-icon>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">-->
            <!--                        <div class="bkt-template-name text-truncate">-->
            <!--                            <div class="bkt-card__icon">-->
            <!--                                <bkt-icon :name="'Note'" :color="'pink'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                            </div>-->
            <!--                            <h5 class="text-truncate">Дом с участком</h5>-->
            <!--                        </div>-->
            <!--                        <div class="bkt-card__icon">-->
            <!--                            <bkt-icon :name="'ArrowDown'" :color="'primary'"-->
            <!--                                      class="bkt-rotate-270"></bkt-icon>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">-->
            <!--                        <div class="bkt-template-name text-truncate">-->
            <!--                            <div class="bkt-card__icon">-->
            <!--                                <bkt-icon :name="'Note'" :color="'pink'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                            </div>-->
            <!--                            <h5 class="text-truncate">Дебиторская задолженность</h5>-->
            <!--                        </div>-->
            <!--                        <div class="bkt-card__icon">-->
            <!--                            <bkt-icon :name="'ArrowDown'" :color="'primary'"-->
            <!--                                      class="bkt-rotate-270"></bkt-icon>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <button class="bkt-button primary">-->
            <!--                        Загрузить другой шаблон-->
            <!--                    </button>-->
            <!--                </div>-->
            <!--                <div class="bkt-card bkt-card__body bkt-lot-card-sent-requests">-->
            <!--                    <div class="bkt-card__header"><h3 class="bkt-card__title">Отправленные запросы</h3></div>-->
            <!--                    <div class="bkt-card outline">-->
            <!--                        <div class="bkt-card__feature">-->
            <!--                            <h6 class="bkt-card__subtitle">16 апреля 2022</h6>-->
            <!--                            <h6 class="bkt-card__title">Запрос документов по торгам</h6>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <div class="bkt-card outline">-->
            <!--                        <div class="bkt-card__feature">-->
            <!--                            <h6 class="bkt-card__subtitle">17 апреля 2022</h6>-->
            <!--                            <h6 class="bkt-card__title">Какой-то запрос</h6>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="col-12 col-lg-7 order-3">-->
            <!--                <div class="bkt-card bkt-card__body bkt-lot-card-request">-->
            <!--                    <div class="bkt-card__header">-->
            <!--                        <h3 class="bkt-card__title">Запрос организатору торгов</h3>-->
            <!--                    </div>-->
            <!--                    <div class="row align-items-start" style="gap: 10px 0;">-->
            <!--                        <div class="col-4 ps-md-0 d-none d-md-block">-->
            <!--                            <h5 class="bkt-lot-card-request-label">шаблон запроса</h5>-->
            <!--                        </div>-->
            <!--                        <div class="col-12 col-md-8 p-md-0">-->
            <!--                            <div class="bkt-select__wrapper">-->
            <!--                                <label class="bkt-select__label d-md-none" for="sortSelect">шаблон запроса</label>-->
            <!--                                <select class="form-select bkt-select" id="sortSelect" aria-label="">-->
            <!--                                    <option selected>Авто</option>-->
            <!--                                    <option value="1">One</option>-->
            <!--                                    <option value="2">Two</option>-->
            <!--                                    <option value="3">Three</option>-->
            <!--                                </select>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <div class="col-4 ps-md-0 d-none d-md-block">-->
            <!--                            <h5 class="bkt-lot-card-request-label">от кого</h5>-->
            <!--                        </div>-->
            <!--                        <div class="col-12 col-md-8 p-md-0">-->
            <!--                            <bkt-input-->
            <!--                                name="from_email"-->
            <!--                                type="email"-->
            <!--                                label="от кого"-->
            <!--                                :rules="'required|email'"-->
            <!--                                placeholder="pochta@gmail.com"-->
            <!--                                :label_class="'d-md-none'"-->
            <!--                            >-->
            <!--                            </bkt-input>-->
            <!--                        </div>-->
            <!--                        <div class="col-4 ps-md-0 d-none d-md-block">-->
            <!--                            <h5 class="bkt-lot-card-request-label">кому</h5>-->
            <!--                        </div>-->
            <!--                        <div class="col-12 col-md-8 p-md-0">-->
            <!--                            <bkt-input-->
            <!--                                name="to_email"-->
            <!--                                type="email"-->
            <!--                                label="кому"-->
            <!--                                :rules="'required|email'"-->
            <!--                                placeholder="pochta@gmail.com"-->
            <!--                                :label_class="'d-md-none'"-->
            <!--                            >-->
            <!--                            </bkt-input>-->
            <!--                        </div>-->
            <!--                        <div class="col-4 ps-md-0 d-none d-md-block">-->
            <!--                            <h5 class="bkt-lot-card-request-label">тема запрос</h5>-->
            <!--                        </div>-->
            <!--                        <div class="col-12 col-md-8 p-md-0">-->
            <!--                            <bkt-input-->
            <!--                                name="subject"-->
            <!--                                type="text"-->
            <!--                                label="тема запроса"-->
            <!--                                :rules="'required'"-->
            <!--                                placeholder=""-->
            <!--                                :label_class="'d-md-none'"-->
            <!--                            >-->
            <!--                            </bkt-input>-->
            <!--                        </div>-->
            <!--                        <div class="col-4 ps-md-0 d-none d-md-block">-->
            <!--                            <h5 class="bkt-lot-card-request-label">текст запроса</h5>-->
            <!--                        </div>-->
            <!--                        <div class="col-12 col-md-8 p-md-0">-->
            <!--                            <bkt-textarea-->
            <!--                                name="description"-->
            <!--                                type="text"-->
            <!--                                label="текст запроса"-->
            <!--                                :rules="'required'"-->
            <!--                                placeholder=""-->
            <!--                                :label_class="'d-md-none'"-->
            <!--                            ></bkt-textarea>-->
            <!--                        </div>-->

            <!--                        <div class="col-4 ps-md-0 d-none d-md-block"></div>-->
            <!--                        <div class="col-12 col-md-8 p-md-0">-->
            <!--                            <div class="bkt-lot-card-request-actions bkt-wrapper-between">-->
            <!--                                <button class="bkt-button-link">-->
            <!--                                    <bkt-icon name="Clip" color="primary" class="bkt-button__icon"></bkt-icon>-->
            <!--                                    прикрепить файл-->
            <!--                                </button>-->
            <!--                                <button class="bkt-button primary" style="flex-grow:1">-->
            <!--                                    Отправить-->
            <!--                                </button>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="col-12 col-lg-6 order-3">-->
            <!--                <div class="bkt-card bkt-lot-card-required-documents">-->
            <!--                    <div class="bkt-card__body">-->
            <!--                        <div class="bkt-card__header">-->
            <!--                            <h3 class="bkt-card__title">Необходимые документы</h3>-->
            <!--                        </div>-->
            <!--                        <div class="bkt-requred-document">-->
            <!--                            <div class="bkt-card__row outline w-100 bkt-wrapper-between bkt-nowrap">-->
            <!--                                <h5 class="text-truncate">Свидетельство о праве собственности</h5>-->
            <!--                                <div class="bkt-card__icon">-->
            <!--                                    <bkt-icon :name="'Check'" :color="'green'"></bkt-icon>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                            <button class="bkt-button">-->
            <!--                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>-->
            <!--                            </button>-->
            <!--                        </div>-->
            <!--                        <div class="bkt-requred-document">-->
            <!--                            <div class="bkt-card__row outline w-100 bkt-wrapper-between bkt-nowrap">-->
            <!--                                <h5 class="text-truncate">Правоустанавливающие документы</h5>-->
            <!--                                <div class="bkt-card__icon">-->
            <!--                                    <bkt-icon :name="'DotsCircle'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                            <button class="bkt-button">-->
            <!--                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>-->
            <!--                            </button>-->
            <!--                        </div>-->
            <!--                        <div class="bkt-requred-document">-->
            <!--                            <div class="bkt-card__row outline w-100 bkt-wrapper-between bkt-nowrap">-->
            <!--                                <h5 class="text-truncate">Кадастровый паспорт участка</h5>-->
            <!--                                <div class="bkt-card__icon">-->
            <!--                                    <bkt-icon :name="'Download'" :color="'primary'" :width="'16px'"-->
            <!--                                              :height="'16px'"></bkt-icon>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                            <button class="bkt-button">-->
            <!--                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>-->
            <!--                            </button>-->
            <!--                        </div>-->
            <!--                        <div class="bkt-requred-document">-->
            <!--                            <div class="bkt-card__row outline  w-100 bkt-wrapper-between bkt-nowrap">-->
            <!--                                <h5 class="text-truncate">Положение о порядке и сроках реализации имуще...</h5>-->
            <!--                                <div class="bkt-card__icon">-->
            <!--                                    <bkt-icon :name="'Download'" :color="'primary'" :width="'16px'"-->
            <!--                                              :height="'16px'"></bkt-icon>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                            <button class="bkt-button">-->
            <!--                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>-->
            <!--                            </button>-->
            <!--                        </div>-->
            <!--                        <div class="bkt-requred-document">-->
            <!--                            <div class="bkt-card__row outline w-100 bkt-wrapper-between bkt-nowrap">-->
            <!--                                <h5 class="text-truncate">Оценка рыночной стоимости участка</h5>-->
            <!--                                <div class="bkt-card__icon">-->
            <!--                                    <bkt-icon :name="'Check'" :color="'green'"></bkt-icon>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                            <button class="bkt-button">-->
            <!--                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>-->
            <!--                            </button>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="col-12 col-lg-3 order-3">-->
            <!--                <div class="bkt-card bkt-card__body bkt-lot-card-document-sets">-->
            <!--                    <div class="bkt-card__header"><h3 class="bkt-card__title">Наборы документов</h3></div>-->
            <!--                    <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">-->
            <!--                        <div class="bkt-card__icon">-->
            <!--                            <bkt-icon :name="'Note'" :color="'blue'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                        </div>-->
            <!--                        <h5 class="text-truncate">Авто</h5>-->
            <!--                    </div>-->
            <!--                    <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">-->
            <!--                        <div class="bkt-card__icon">-->
            <!--                            <bkt-icon :name="'Note'" :color="'blue'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                        </div>-->
            <!--                        <h5 class="text-truncate">Квартира</h5>-->
            <!--                    </div>-->
            <!--                    <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">-->
            <!--                        <div class="bkt-card__icon">-->
            <!--                            <bkt-icon :name="'Note'" :color="'blue'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                        </div>-->
            <!--                        <h5 class="text-truncate">Земля</h5>-->
            <!--                    </div>-->
            <!--                    <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">-->
            <!--                        <div class="bkt-card__icon">-->
            <!--                            <bkt-icon :name="'Note'" :color="'blue'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                        </div>-->
            <!--                        <h5 class="text-truncate">Дом с участком</h5>-->
            <!--                    </div>-->
            <!--                    <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">-->
            <!--                        <div class="bkt-card__icon">-->
            <!--                            <bkt-icon :name="'Note'" :color="'blue'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                        </div>-->
            <!--                        <h5 class="text-truncate">Дебиторская задолженность</h5>-->
            <!--                    </div>-->
            <!--                    <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">-->
            <!--                        <div class="bkt-card__icon">-->
            <!--                            <bkt-icon :name="'Note'" :color="'blue'" :width="'16px'" :height="'16px'"></bkt-icon>-->
            <!--                        </div>-->
            <!--                        <h5 class="text-truncate">Свой набор</h5>-->
            <!--                    </div>-->
            <!--                    <button class="bkt-button primary">Добавить набор</button>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="col-12 col-lg-3 order-3">-->
            <!--                <div class="bkt-card bkt-card__body bkt-lot-card-my-files">-->
            <!--                    <div class="bkt-card__header"><h3 class="bkt-card__title">Мои файлы</h3></div>-->
            <!--&lt;!&ndash;                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">&ndash;&gt;-->
            <!--&lt;!&ndash;                        <div class="bkt-card__feature text-truncate">&ndash;&gt;-->
            <!--&lt;!&ndash;                            <h5 class="text-truncate">Nazvanie.pdf</h5>&ndash;&gt;-->
            <!--&lt;!&ndash;                            <h6 class="bkt-card__subtitle">23.1 Mb</h6>&ndash;&gt;-->
            <!--&lt;!&ndash;                        </div>&ndash;&gt;-->
            <!--&lt;!&ndash;                        <div class="bkt-card__icon">&ndash;&gt;-->
            <!--&lt;!&ndash;                            <bkt-icon :name="'More'"></bkt-icon>&ndash;&gt;-->
            <!--&lt;!&ndash;                        </div>&ndash;&gt;-->
            <!--&lt;!&ndash;                    </div>&ndash;&gt;-->
            <!--&lt;!&ndash;                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">&ndash;&gt;-->
            <!--&lt;!&ndash;                        <div class="bkt-card__feature text-truncate">&ndash;&gt;-->
            <!--&lt;!&ndash;                            <h5 class="text-truncate">Foto.jpg</h5>&ndash;&gt;-->
            <!--&lt;!&ndash;                            <h6 class="bkt-card__subtitle">45.99 Kb</h6>&ndash;&gt;-->
            <!--&lt;!&ndash;                        </div>&ndash;&gt;-->
            <!--&lt;!&ndash;                        <div class="bkt-card__icon">&ndash;&gt;-->
            <!--&lt;!&ndash;                            <bkt-icon :name="'More'"></bkt-icon>&ndash;&gt;-->
            <!--&lt;!&ndash;                        </div>&ndash;&gt;-->
            <!--&lt;!&ndash;                    </div>&ndash;&gt;-->
            <!--                    <button class="bkt-button green">Добавить фото</button>-->
            <!--                    <button class="bkt-button green">Добавить документ</button>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div v-if="item.trade.debtorId" class="col-12 col-lg-12 order-3">-->
            <!--                <div class=" bkt-card bkt-card__body bkt-lot-card-debtor">-->
            <!--                    <div class="bkt-card__header bkt-wrapper-between">-->
            <!--                        <h3 class="bkt-card__title">Информация по должнику</h3>-->
            <!--                        <a href="" class="bkt-button next">Сообщения по должнику-->
            <!--                            <span class="bkt-text-neutral-dark">(0)</span>-->
            <!--                            <bkt-icon name="ArrowDown"></bkt-icon>-->
            <!--                        </a>-->
            <!--                    </div>-->
            <!--                    <ul class="bkt-contents">-->
            <!--                        <li>-->
            <!--                            <div class="bkt-contents__heading"><span>должник</span></div>-->
            <!--                            <div class="bkt-contents__answer"><span>Васильев Василий Васильевич</span></div>-->
            <!--                        </li>-->
            <!--                        <li>-->
            <!--                            <div class="bkt-contents__heading"><span>дело №</span></div>-->
            <!--                            <div class="bkt-contents__answer"><span>1234567890/85</span></div>-->

            <!--                        </li>-->
            <!--                        <li>-->
            <!--                            <div class="bkt-contents__heading"><span>суд</span></div>-->
            <!--                            <div class="bkt-contents__answer"><span>Арбитражный Суд республики Башкортостан</span>-->
            <!--                            </div>-->
            <!--                        </li>-->
            <!--                        <li>-->
            <!--                            <div class="bkt-contents__heading"><span>ИНН</span></div>-->
            <!--                            <div class="bkt-contents__answer"><span>34334567890</span></div>-->
            <!--                        </li>-->
            <!--                        <li>-->
            <!--                            <div class="bkt-contents__heading"><span>регион</span></div>-->
            <!--                            <div class="bkt-contents__answer"><span>Республика Башкортостан</span></div>-->
            <!--                        </li>-->
            <!--                        <li>-->
            <!--                            <div class="bkt-contents__heading"><span>адрес должника</span></div>-->
            <!--                            <div class="bkt-contents__answer"><span>РБ, г. Стерлитамак ул. Фурманова д. 6</span>-->
            <!--                            </div>-->
            <!--                        </li>-->
            <!--                    </ul>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div v-if="item.trade.debtorId" class="col-12 col-lg-12 order-3">-->
            <!--                <div class="bkt-card bkt-card__body bkt-lot-card-active-lots">-->
            <!--                    <div class="bkt-wrapper-between bkt-nowrap">-->
            <!--                        <h3 class="bkt-card__title">-->
            <!--                            Другие активные лоты должника <span class="bkt-text-neutral-dark">(0)</span>-->
            <!--                        </h3>-->
            <!--                        <button class="bkt-button-icon bkt-bg-body" data-bs-toggle="collapse"-->
            <!--                                data-bs-target="#collapseActiveLots" aria-expanded="false"-->
            <!--                        >-->
            <!--                            <bkt-icon :name="'ArrowDown'" class="bkt-button__icon"></bkt-icon>-->
            <!--                        </button>-->
            <!--                    </div>-->
            <!--                    &lt;!&ndash;                    <div class="collapse" id="collapseActiveLots">&ndash;&gt;-->
            <!--                    &lt;!&ndash;                    </div>&ndash;&gt;-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div v-if="item.trade.debtorId" class="col-12 col-lg-12 order-3">-->
            <!--                <div class="bkt-card bkt-card__body bkt-lot-card-completed-lots">-->
            <!--                    <div class="bkt-wrapper-between bkt-nowrap">-->
            <!--                        <h3 class="bkt-card__title">-->
            <!--                            Завершённые лоты должника <span class="bkt-text-green">(1)</span>-->
            <!--                        </h3>-->
            <!--                        <button class="bkt-button-icon bkt-bg-body" data-bs-toggle="collapse"-->
            <!--                                data-bs-target="#collapseCompletedLots" aria-expanded="false">-->
            <!--                            <bkt-icon :name="'ArrowDown'" class="bkt-button__icon"></bkt-icon>-->
            <!--                        </button>-->
            <!--                    </div>-->
            <!--                    <div class="collapse" id="collapseCompletedLots">-->
            <!--                        <div class="row w-100 m-auto">-->
            <!--                            <div class="col-12 p-0 d-none d-md-block">-->
            <!--                                <div-->
            <!--                                    style="padding-bottom: 10px"-->
            <!--                                    class="row w-100 mx-auto align-items-center justify-content-center"-->
            <!--                                >-->
            <!--                                    <div class="col-2 pl-0">-->
            <!--                                        <h6 class="bkt-text-neutral-dark">фото</h6>-->
            <!--                                    </div>-->
            <!--                                    <div class="col-3">-->
            <!--                                        <h6 class="bkt-text-neutral-dark">описание лота</h6>-->
            <!--                                    </div>-->
            <!--                                    <div class="col-2">-->
            <!--                                        <h6 class="bkt-text-neutral-dark">цена</h6>-->
            <!--                                    </div>-->
            <!--                                    <div class="col-2">-->
            <!--                                        <h6 class="bkt-text-neutral-dark">даты торгов</h6>-->
            <!--                                    </div>-->
            <!--                                    <div class="col-3">-->
            <!--                                        <h6 class="bkt-text-neutral-dark">ЭТП и организатор</h6>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                            <div class="col-12 p-0">-->
            <!--                                <div class="row w-100 mx-auto bkt-row outline">-->
            <!--                                    <div class="col-12 col-md-2 ps-0">-->
            <!--                                        <img v-lazy="'/images/card-image.jpg'" class="bkt-card__image"/>-->
            <!--                                    </div>-->
            <!--                                    <div class="col-12 col-md-3">-->
            <!--                                        <h6 class="bkt-card__subtitle">№ 113351, лот 1</h6>-->
            <!--                                        <h5 class="">-->
            <!--                                            1/4 доли в праве на квартиру, общей площадью 64 кв.м.-->
            <!--                                        </h5>-->
            <!--                                    </div>-->
            <!--                                    <div class="col-12 col-md-2">-->
            <!--                                        <h6 class="bkt-card__subtitle d-md-none">цена</h6>-->
            <!--                                        <h4 class="bkt-card__title bkt-text-primary">2 485 400 ₽</h4>-->
            <!--                                    </div>-->
            <!--                                    <div class="col-12 col-md-2">-->
            <!--                                        <h6 class="bkt-card__subtitle d-md-none">даты торгов</h6>-->
            <!--                                        <h6>с 25 апреля 2022</h6>-->
            <!--                                    </div>-->
            <!--                                    <div class="col-12 col-md-3">-->
            <!--                                        <h6 class="bkt-card__subtitle d-md-none">ЭТП и организатор</h6>-->
            <!--                                        <h6 class="bkt-card__title bkt-text-main text-uppercase">nazvanie.com</h6>-->
            <!--                                        <h5 class="">-->
            <!--                                            Перов Сергей Николаевич-->
            <!--                                        </h5>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <div class="col-12 col-lg-8  order-3">
                <div class="bkt-card bkt-card__body">
                    <div class="bkt-card__header">
                        <h3 class="bkt-card__title">Информация по организатору</h3>
                        <button class="bkt-button next">
                            Подробнее об организаторе
                            <bkt-icon name="ArrowDown" color="primary"></bkt-icon>
                        </button>
                    </div>

                    <ul class="bkt-contents">
                        <li>
                            <div class="bkt-contents__heading"><span>организатор</span></div>
                            <div class="bkt-contents__answer bkt-text-green" v-if="item.trade.organizer">
                                <span v-if="item.trade.organizer.type=='person'">
                                    <template v-for="(value, key, index) in item.trade.organizer.person">
                                         {{value ? value+' ' : ''}}
                                    </template>
                                </span>
                                <span v-else>
                                    {{item.trade.organizer.company.shortName ? item.trade.organizer.company.shortName : item.trade.organizer.company.fullName}}
                                </span>
                            </div>
                        </li>
                        <li>
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">ИНН</span>
                            </div>
                            <div class="bkt-contents__answer"><span>{{item.trade.organizer.inn}}</span>
                            </div>
                        </li>
                        <!--                        <li>-->
                        <!--                            <div class="bkt-contents__heading">-->
                        <!--                                <span class="bkt-contents__heading">телефон</span>-->
                        <!--                            </div>-->
                        <!--                            <div class="bkt-contents__answer kt-text-primary"><span>+7 (919) 333 44-55</span>-->
                        <!--                            </div>-->
                        <!--                        </li>-->
                        <!--                        <li>-->
                        <!--                            <div class="bkt-contents__heading">-->
                        <!--                                <span class="bkt-contents__heading">почта</span>-->
                        <!--                            </div>-->
                        <!--                            <div class="bkt-contents__answer"><span>pochta@mail.ru</span>-->
                        <!--                            </div>-->
                        <!--                        </li>-->
                    </ul>
                    <!--                    <div class="bkt-wrapper-between align-items-center">-->
                    <!--                        <button class="bkt-button next">-->
                    <!--                            мои победы-->
                    <!--                            <span class="bkt-text-red" style="text-transform: initial"> (добавьте ИНН)  </span>-->
                    <!--                            <bkt-icon name="ArrowDown" color="green"></bkt-icon>-->
                    <!--                        </button>-->
                    <!--                        <div class="bkt-rating text-center">-->
                    <!--                            <h6>3,3 / 5</h6>-->
                    <!--                            <star-rating :show-rating="false" :rating="3.3" :read-only="true" :star-size="16"-->
                    <!--                                         :increment="0.01" :rounded-corners="false"></star-rating>-->
                    <!--                        </div>-->
                    <!--                        <button class="bkt-button bkt-bg-body text-uppercase bkt-text-main">-->
                    <!--                            оценить организатора-->
                    <!--                            <bkt-icon name="ArrowDown" color="primary" class="bkt-rotate-270"></bkt-icon>-->
                    <!--                        </button>-->
                    <!--                    </div>-->
                </div>
            </div>
            <div class="col-12 col-lg-4 order-3">
                <div class=" bkt-card bkt-card__body bkt-lot-card-arbitration-manager">
                    <h3 class="bkt-card__title">
                        Информация по арбитражному управляющему
                    </h3>
                    <ul class="bkt-contents">
                        <li>
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">арбитражный управляющий</span>
                            </div>
                            <div class="bkt-contents__answer">
                                <span v-if="item.trade.arbitrManager.type =='person'">
                                    <template v-for="(value, key, index) in item.trade.arbitrManager.person">
                                         {{value ? value+' ' : ''}}
                                    </template>
                                </span>
                                <span v-else>
                                    {{item.trade.arbitrManager.company.shortName ? item.trade.arbitrManager.company.shortName : item.trade.arbitrManager.company.fullName}}
                                </span>
                            </div>
                        </li>
                        <li v-if="item.trade.arbitrManager.inn">
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">ИНН</span>
                            </div>
                            <div class="bkt-contents__answer"><span>{{item.trade.arbitrManager.inn}}</span>
                            </div>
                        </li>
                        <li v-if="item.trade.arbitrManager.sroAU">
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">СРО</span>
                            </div>
                            <div class="bkt-contents__answer" style="font-size: 12px; font-weight:600">
                                <span>{{item.trade.arbitrManager.sroAU}}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-12 order-3">
                <bkt-collapse title="Документы по торгам" :count="files.length"
                    id="collapseDocuments" :loading="files_loading"
                >
                    <template #collapse v-if="files.length>0">
                        <div class="row w-100 g-2 align-items-stretch mx-auto">
                            <div class="col-12 col-md-6" v-for="file in files">
                                <div class="row bkt-row outline align-items-start bkt-nowrap">
                                    <div class="col p-0" style="max-width: 28px;">
                                        <bkt-icon name="Note" color="red" width="16px" height="16px"
                                                  class="d-flex"></bkt-icon>
                                    </div>
                                    <div class="col-7 col-md-8 px-1">
                                        <h6>{{file}}</h6>
                                    </div>
                                    <div class="col p-0">
                                        <h6 class="bkt-text-blue">jpg</h6>
                                    </div>
                                    <div class="col p-0">
                                        <h6 class="bkt-text-neutral-dark">23.1 Mb</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>
<!--                <div class="bkt-card bkt-card__body">-->
<!--                    <div class="bkt-wrapper-between bkt-nowrap">-->
<!--                        <h3 class="bkt-card__title">-->
<!--                            Документы по торгам <span class="bkt-text-neutral-dark">(0)</span>-->
<!--                        </h3>-->
<!--                        <button class="bkt-button-icon bkt-bg-body" data-bs-toggle="collapse"-->
<!--                                data-bs-target="#collapseDocuments" aria-expanded="false"-->
<!--                        >-->
<!--                            <bkt-icon :name="'ArrowDown'" class="bkt-button__icon"></bkt-icon>-->
<!--                        </button>-->
<!--                    </div>-->
<!--                    <div class="collapse show" id="collapseDocuments">-->
<!--                        &lt;!&ndash;                        <div class="row w-100 g-2 align-items-stretch mx-auto">&ndash;&gt;-->
<!--                        &lt;!&ndash;                            <div class="col-12 col-md-6">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                <div class="row bkt-row outline align-items-start bkt-nowrap">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0" style="max-width: 28px;">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <bkt-icon name="Note" color="red" width="16px" height="16px"&ndash;&gt;-->
<!--                        &lt;!&ndash;                                                  class="d-flex"></bkt-icon>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col-7 col-md-8 px-1">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6>728-732</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6 class="bkt-text-blue">jpg</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6 class="bkt-text-neutral-dark">23.1 Mb</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            <div class="col-12 col-md-6">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                <div class="row bkt-row outline align-items-start bkt-nowrap">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0" style="max-width: 28px;">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <bkt-icon name="Note" color="red" width="16px" height="16px"&ndash;&gt;-->
<!--                        &lt;!&ndash;                                                  class="d-flex"></bkt-icon>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col-7 col-md-8 px-1">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6>7 этаж</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6 class="bkt-text-blue">pdf</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6 class="bkt-text-neutral-dark">0.71 Mb</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            <div class="col-12 col-md-6">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                <div class="row bkt-row outline align-items-start bkt-nowrap">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0" style="max-width: 28px;">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <bkt-icon name="Note" color="red" width="16px" height="16px"&ndash;&gt;-->
<!--                        &lt;!&ndash;                                                  class="d-flex"></bkt-icon>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col-7 col-md-8 px-1">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6>Справка БТИ о состоянии здания от 28.07.2021</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6 class="bkt-text-blue">pdf</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6 class="bkt-text-neutral-dark">46.6 Mb</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            <div class="col-12 col-md-6">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                <div class="row bkt-row outline align-items-start bkt-nowrap">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0" style="max-width: 28px;">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <bkt-icon name="Note" color="red" width="16px" height="16px"&ndash;&gt;-->
<!--                        &lt;!&ndash;                                                  class="d-flex"></bkt-icon>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col-7 col-md-8 px-1">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6>Св-во оперативного управления</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6 class="bkt-text-blue">pdf</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6 class="bkt-text-neutral-dark">147.21 Mb</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            <div class="col-12 col-md-6">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                <div class="row bkt-row outline align-items-start bkt-nowrap">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0" style="max-width: 28px;">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <bkt-icon name="Note" color="red" width="16px" height="16px"&ndash;&gt;-->
<!--                        &lt;!&ndash;                                                  class="d-flex"></bkt-icon>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col-7 col-md-8 px-1">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6>Выписка ЕГРН</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6 class="bkt-text-blue">pdf</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6 class="bkt-text-neutral-dark">22.47 Mb</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            <div class="col-12 col-md-6">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                <div class="row bkt-row outline align-items-start bkt-nowrap">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0" style="max-width: 28px;">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <bkt-icon name="Note" color="red" width="16px" height="16px"&ndash;&gt;-->
<!--                        &lt;!&ndash;                                                  class="d-flex"></bkt-icon>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col-7 col-md-8 px-1">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6>Аукционная документация Лот № 3</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6 class="bkt-text-blue">pdf</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    <div class="col p-0">&ndash;&gt;-->
<!--                        &lt;!&ndash;                                        <h6 class="bkt-text-neutral-dark">4.02 Mb</h6>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                                </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                            </div>&ndash;&gt;-->
<!--                        &lt;!&ndash;                        </div>&ndash;&gt;-->
<!--                    </div>-->
<!--                </div>-->
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
    import StarRating from 'vue-star-rating'
    import BktCollapse from '../components/Collapse.vue'
    import BktCardActions from '../components/CardActions.vue'

    export default {
        name: "LotCard",
        components: {
            Hooper,
            Slide,
            HooperNavigation,
            StarRating,
            BktCollapse,
            BktCardActions
        },
        data() {
            return {
                loading: false,
                item: '',
                files: [],
                files_loading: false,
            };
        },
        computed: {
            trades: function () {
                return this.$store.getters.trades;
            },
            auth_user: function () {
                return this.$store.getters.auth_user;
            },
        },
        async mounted() {
            this.getLot();
            this.getLotFiles();
        },
        methods: {
            goBack() {
                window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/')
            },
            async getLot() {
                this.loading = true;
                if (this.trades.length > 0) {
                    let trade = this.trades.findIndex(item => item.id == this.$route.params.id);
                    if (trade >= 0) {
                        this.item = JSON.parse(JSON.stringify(this.trades[trade]));
                    }
                    this.loading = false;
                } else {
                    await this.$store.dispatch('getTradeLot', this.$route.params.id)
                        .then(resp => {
                            this.item = resp.data;
                            this.loading = false;
                        })
                        .catch(error => {
                            this.loading = false;
                        });

                }
            },
            async getLotFiles() {
                this.files_loading = true;
                await this.$store.dispatch('getLotFiles', this.$route.params.id)
                    .then(resp => {
                        this.files = resp.files;
                    }).catch(error => {

                    }).finally(() => {
                        this.files_loading = false;
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>
</style>
