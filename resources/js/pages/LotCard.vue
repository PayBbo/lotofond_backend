<template>
    <div class="container bkt-main bkt-single-trade bkt-container">
        <div class="bkt-wrapper" style="margin: 30px 0;">
            <nav class="bkt-wrapper m-0" aria-label="breadcrumb">
                <div class="bkt-button-icon bg-white" style="margin-right:20px">
                    <bkt-icon :name="'ArrowDown'" class="bkt-button__icon"></bkt-icon>
                </div>
                <ol class="breadcrumb bkt-breadcrumb m-0">
                    <li class="breadcrumb-item bkt-breadcrumb__item"><a href="/" class=" bkt-text-neutral-dark">главная</a></li>
                    <li class="breadcrumb-item bkt-breadcrumb__item">торги</li>
                    <li class="breadcrumb-item bkt-breadcrumb__item active" aria-current="page">торги № 22000068750000000003 (лот 1)</li>
                </ol>
            </nav>
        </div>
        <div class="bkt-row bkt-bg-main bkt-wrapper-between bkt-single-trade-actions-nav">
            <h5 class="bkt-trading-number">
                торги № 22000068750000000003 (лот 1)
            </h5>
            <div class="bkt-actions">
                <button class="bkt-button-icon main-light">
                    <bkt-icon class="bkt-button__icon" :name="'Eye'" :width="'20px'" :height="'18px'"></bkt-icon>
                </button>
                <button class="bkt-button-icon main-light">
                    <bkt-icon class="bkt-button__icon" :name="'Bookmark'"></bkt-icon>
                </button>
                <button class="bkt-button-icon main-light">
                    <bkt-icon class="bkt-button__icon" :name="'Target'" :stroke="'#fff'"></bkt-icon>
                </button>
                <button class="bkt-button-icon main-light">
                    <bkt-icon class="bkt-button__icon" :name="'Star'"></bkt-icon>
                </button>
                <button class="bkt-button-icon main-light">
                    <span class="info"></span>
                    <bkt-icon class="bkt-button__icon" :name="'Bell'"></bkt-icon>
                </button>
                <button class="bkt-button-icon main-light">
                    <bkt-icon class="bkt-button__icon" :name="'Clip'" :width="'15px'" :height="'19px'"></bkt-icon>
                </button>
                <button class="bkt-button-icon">
                    <bkt-icon class="bkt-button__icon" :name="'Trash'"></bkt-icon>
                </button>
            </div>
        </div>
        <div class="row" style="gap: 30px 0; margin:30px auto;">
            <div class="col-12 col-md-7">
                <div class="bkt-card">
                    <div class="bkt-card__body">
                        <h3 class="bkt-card__title">Некоторое название торгов</h3>
                        <ul class="bkt-contents">
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">общая площадь</span>
                                </div>
                                <div class="bkt-contents__answer"><span>207 м2</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span
                                        class="bkt-contents__heading">общие сведения об ограничениях и обременениях</span>
                                </div>
                                <div class="bkt-contents__answer"><span>нет</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">назначение нежилого помещения</span>
                                </div>
                                <div class="bkt-contents__answer"><span>офисное помещение</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">расположение в пределах объекта недвижимости (этажа, части этажа, нескольких этажей)</span>
                                </div>
                                <div class="bkt-contents__answer"><span>7 этаж</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">кадастровый номер</span>
                                </div>
                                <div class="bkt-contents__answer"><span>77:06:0004004:1051</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">год ввода в эксплуатацию</span>
                                </div>
                                <div class="bkt-contents__answer"><span>1980</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">местонахождение имущества</span>
                                </div>
                                <div class="bkt-contents__answer"><span>Нахимовский проспект, дом 47</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">категория объекта</span>
                                </div>
                                <div class="bkt-contents__answer"><span>нежилые помещения</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">форма собственности</span>
                                </div>
                                <div class="bkt-contents__answer"><span>федеральная собственность</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span>
                                        Информация о сроках и порядке внесения задатка, реквизитах счета для перечисления задатка указана в документации (при наличии  требования о внесении задатка)
                                   </span>
                                </div>
                                <div class="bkt-contents__answer"><span>1</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">перечисление задатка</span>
                                </div>
                                <div class="bkt-contents__answer">
                                    <span>задаток перечисляется на счет организатора</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">вид договора</span>
                                </div>
                                <div class="bkt-contents__answer"><span>договор аренды</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">порядок оплаты</span>
                                </div>
                                <div class="bkt-contents__answer"><span>ежемесячный платеж</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">начальная цена за кв.м </span>
                                </div>
                                <div class="bkt-contents__answer"><span>12000</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">ежемесячный платеж за объект</span>
                                </div>
                                <div class="bkt-contents__answer"><span>207000</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">срок действия договора - лет</span>
                                </div>
                                <div class="bkt-contents__answer"><span>5</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span>порядок ознакомления с имуществом, иной информацией</span>
                                </div>
                                <div class="bkt-contents__answer"><span>в соответствии с аукционной документацией</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">обременения, ограничения</span>
                                </div>
                                <div class="bkt-contents__answer"><span>нет</span>
                                </div>
                            </li>
                            <li>
                                <div class="bkt-contents__heading">
                                    <span class="bkt-contents__heading">целевое назначение государственного или муниципального имущества, права на которое передаются по договору</span>
                                </div>
                                <div class="bkt-contents__answer"><span>офисное помещение</span>
                                </div>
                            </li>
                        </ul>
                        <div class="bkt-row outline bkt-wrapper-between align-items-center">
                            <div class="bkt-row__feature">
                                <h4 class="bkt-row__feature-title">600 кв.м.</h4>
                                <h6 class="bkt-row__feature-subtitle">земельный участок</h6>
                            </div>
                            <div class="bkt-row__icon">
                                <bkt-icon :name="'Tree'"></bkt-icon>
                            </div>
                        </div>
                        <div class="bkt-row outline bkt-wrapper-between">
                            <div class="bkt-row__feature">
                                <h4 class="bkt-row__feature-title">800 478 ₽</h4>
                                <h6 class="bkt-row__feature-subtitle">кадастровая стоимость</h6>
                            </div>
                            <span class="bkt-row__icon">
                            <bkt-icon :name="'File'"></bkt-icon>
                        </span>
                        </div>
                        <div class="bkt-row outline bkt-wrapper-between">
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
                                    <bkt-icon :name="'ArrowDown'" :fill="'#2953ff'"
                                              style="transform: rotate(270deg)"></bkt-icon>
                                </span>
                            </a>
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="bkt-card bkt-card-trade bkt-single-trade-card">
                    <div class="bkt-card__body">
                        <div class="bkt-card-image-wrapper">
                            <hooper :itemsToShow="1" :centerMode="true" class="bkt-card__image-slider">
                                <slide>
                                    <img src="/images/card-image.jpg" class="bkt-card__image"/>
                                </slide>
                                <slide>
                                    <img src="/images/card-image.jpg" class="bkt-card__image"/>
                                </slide>
                                <slide>
                                    <img src="/images/card-image.jpg" class="bkt-card__image"/>
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
                            {{item && item.price ? item.price : '2 485 400'}} ₽
                            <div class="bkt-card-price-icon bkt-bg-green-light">
                                <bkt-icon :name="'ArrowTriple'" :width="'22px'" :height="'22px'"></bkt-icon>
                            </div>
                        </div>
                        <div class="bkt-card-infographics" style="gap: 10px;">
                            <div class="bkt-card__row outline bkt-wrapper-between">
                                    <h5 class="bkt-card__subtitle">текущая цена</h5>
                                    <h4 class="bkt-card__title bkt-text-primary">
                                        {{item && item.auctionStep ? item.auctionStep : '0'}}
                                        {{item && item.isAuctionRub ? '₽' : '%'}}
                                    </h4>
                            </div>
                            <div class="bkt-card__row outline bkt-wrapper-between">
                                    <h5 class="bkt-card__subtitle">минимальная цена</h5>
                                    <h4 class="bkt-card__title bkt-text-red">
                                        {{item && item.deposit ? item.deposit : '0'}}
                                        {{item && item.isDepositRub ? '₽' : '%'}}
                                    </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="bkt-card bkt-single-trade-tasks">
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
                                            с 22 сентября 2022 <span class="bkt-text-blue">09:00</span>
                                            до 25 сентября 2022 <span class="bkt-text-blue">19:00</span>
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
                                            с 21 апреля 2022 <span class="bkt-text-yellow">10:30</span>
                                        </strong>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <a href="" class="bkt-platform-button">
                            <div class="bkt-platform-button-title">ЭТП TORGI.GOV</div>
                            <div class="bkt-platform-button-subtitle">torgi.gov - аренда</div>
                            <bkt-icon :name="'ArrowDown'" :fill="'#2953ff'"></bkt-icon>
                        </a>
                    </div>
                    <div class="bkt-card__body">
                        <div class="bkt-wrapper-between" style="margin-bottom: 23px;">
                            <div class="bkt-wrapper m-0">
                                <div class="bkt-card__category bkt-bg-primary-lighter">
                                    <bkt-icon :name="'Pencil'" :fill="'#2953ff'" class="bkt-card__category-icon"></bkt-icon>
                                </div>
                                <h5>Заметка по лоту (видите только вы)</h5>
                            </div>
                            <button class="bkt-button-icon primary">
                                <bkt-icon :name="'Plus'" class="bkt-button__icon"></bkt-icon>
                            </button>
                        </div>
                        <div class="bkt-single-trade-task">
                            <div class="bkt-row outline bkt-wrapper-between">
                                <div class="bkt-check__wrapper">
                                    <div class="bkt-check">
                                        <div class="bkt-check__input">
                                            <input class="" type="checkbox" disabled>
                                            <div class="bkt-check__input-check"></div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="m-auto">Некоторое название задачи</h5>
                                <h6 class="m-auto">Краткое описание задачи если таково имеется</h6>
                                <div class="bkt-card-period bkt-wrapper">
                                    <div class="bkt-card__category bkt-bg-blue-lighter">
                                        <bkt-icon :name="'Date'" :width="'16px'"
                                                  :height="'16px'" :fill="'#29b1ff'"></bkt-icon>
                                    </div>
                                    <div class="bkt-card_feature">
                                        <h5>
                                            с 22 сентября 2022 <span class="bkt-text-blue">09:00</span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <button class="bkt-button">
                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>
                            </button>
                        </div>
                        <div class="bkt-single-trade-task">
                            <div class="bkt-row outline bkt-wrapper-between">
                                <div class="bkt-check__wrapper">
                                    <div class="bkt-check">
                                        <div class="bkt-check__input">
                                            <input class="" type="checkbox" disabled>
                                            <div class="bkt-check__input-check"></div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="m-auto">Некоторое название задачи</h5>
                                <h6 class="m-auto">Краткое описание задачи если таково имеется</h6>
                                <div class="bkt-card-period bkt-wrapper">
                                    <div class="bkt-card__category bkt-bg-blue-lighter">
                                        <bkt-icon :name="'Date'" :width="'16px'"
                                                  :height="'16px'" :fill="'#29b1ff'"></bkt-icon>
                                    </div>
                                    <div class="bkt-card_feature">
                                        <h5>
                                            с 22 сентября 2022 <span class="bkt-text-blue">09:00</span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <button class="bkt-button">
                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>
                            </button>
                        </div>
                        <div class="bkt-single-trade-task">
                            <div class="bkt-row outline bkt-wrapper-between">
                                <div class="bkt-check__wrapper">
                                    <div class="bkt-check">
                                        <div class="bkt-check__input">
                                            <input class="" type="checkbox" disabled>
                                            <div class="bkt-check__input-check"></div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="m-auto">Некоторое название задачи</h5>
                                <h6 class="m-auto">Краткое описание задачи если таково имеется</h6>
                                <div class="bkt-card-period bkt-wrapper">
                                    <div class="bkt-card__category bkt-bg-blue-lighter">
                                        <bkt-icon :name="'Date'" :width="'16px'"
                                                  :height="'16px'" :fill="'#29b1ff'"></bkt-icon>
                                    </div>
                                    <div class="bkt-card_feature">
                                        <h5>
                                            с 22 сентября 2022 <span class="bkt-text-blue">09:00</span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <button class="bkt-button">
                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="bkt-card bkt-card__body bkt-single-trade-actual">
                    <div class="bkt-card__header bkt-wrapper-between">
                        <h3 class="bkt-card__title">Актуальное по лоту</h3>
                        <button class="bkt-button" style="gap:8px;">
                            Смотреть отчёт
                            <bkt-icon :name="'Clip'" :fill="'#2953ff'" class="bkt-button__icon"></bkt-icon>
                        </button>
                    </div>
                    <div class="bkt-card outline bkt-wrapper-between">
                        <h5 class=""><span class="bkt-text-green">Идёт приём заявок</span> (до 19.04.2022)</h5>
                        <h5 class="bkt-text-neutral-dark">1 декабря 2022 в 09:00</h5>
                    </div>
                    <div class="bkt-card outline bkt-wrapper-between">
                        <h5 class="bkt-text-red">Приём заявок заканчивается через 2 дня!</h5>
                        <h5 class="bkt-text-neutral-dark">1 декабря 2022 в 09:00</h5>
                    </div>
                    <div class="bkt-card outline bkt-wrapper-between">
                        <h5 class=""><span class="bkt-text-green">Проведение торгов с 21.04.2022</span> (до 19.04.2022)
                        </h5>
                        <h5 class="bkt-text-neutral-dark">1 декабря 2022 в 09:00</h5>
                    </div>
                    <div class="bkt-wrapper-between">
                        <button class="bkt-button-icon bkt-bg-body">
                            <bkt-icon class="bkt-button__icon"></bkt-icon>
                        </button>
                        <button class="bkt-button primary">Написать организатору</button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="bkt-card bkt-card__body bkt-single-trade-templates">
                    <div class="bkt-card__header"><h3 class="bkt-card__title">Шаблоны запросов</h3></div>
                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">
                        <div class="bkt-template-name text-truncate">
                            <div class="bkt-card__icon">
                                <bkt-icon :name="'Note'" :fill="'#ff41be'" :width="'16px'" :height="'16px'"></bkt-icon>
                            </div>
                            <h5 class="text-truncate">Заявка на участие в торгах</h5>
                        </div>
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'ArrowDown'" :fill="'#2953ff'"
                                      style="transform: rotate(270deg)"></bkt-icon>
                        </div>
                    </div>
                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">
                        <div class="bkt-template-name text-truncate">
                            <div class="bkt-card__icon">
                                <bkt-icon :name="'Note'" :fill="'#ff41be'" :width="'16px'" :height="'16px'"></bkt-icon>
                            </div>
                            <h5 class="text-truncate">Авто</h5>
                        </div>
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'ArrowDown'" :fill="'#2953ff'"
                                      style="transform: rotate(270deg)"></bkt-icon>
                        </div>
                    </div>
                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">
                        <div class="bkt-template-name text-truncate">
                            <div class="bkt-card__icon">
                                <bkt-icon :name="'Note'" :fill="'#ff41be'" :width="'16px'" :height="'16px'"></bkt-icon>
                            </div>
                            <h5 class="text-truncate">Квартира</h5>
                        </div>
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'ArrowDown'" :fill="'#2953ff'"
                                      style="transform: rotate(270deg)"></bkt-icon>
                        </div>
                    </div>
                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">
                        <div class="bkt-template-name text-truncate">
                            <div class="bkt-card__icon">
                                <bkt-icon :name="'Note'" :fill="'#ff41be'" :width="'16px'" :height="'16px'"></bkt-icon>
                            </div>
                            <h5 class="text-truncate">Земля</h5>
                        </div>
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'ArrowDown'" :fill="'#2953ff'"
                                      style="transform: rotate(270deg)"></bkt-icon>
                        </div>
                    </div>
                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">
                        <div class="bkt-template-name text-truncate">
                            <div class="bkt-card__icon">
                                <bkt-icon :name="'Note'" :fill="'#ff41be'" :width="'16px'" :height="'16px'"></bkt-icon>
                            </div>
                            <h5 class="text-truncate">Дом с участком</h5>
                        </div>
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'ArrowDown'" :fill="'#2953ff'"
                                      style="transform: rotate(270deg)"></bkt-icon>
                        </div>
                    </div>
                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">
                        <div class="bkt-template-name text-truncate">
                            <div class="bkt-card__icon">
                                <bkt-icon :name="'Note'" :fill="'#ff41be'" :width="'16px'" :height="'16px'"></bkt-icon>
                            </div>
                            <h5 class="text-truncate">Дебиторская задолженность</h5>
                        </div>
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'ArrowDown'" :fill="'#2953ff'"
                                      style="transform: rotate(270deg)"></bkt-icon>
                        </div>
                    </div>
                    <button class="bkt-button primary">
                        Загрузить другой шаблон
                    </button>
                </div>
                <div class="bkt-card bkt-card__body bkt-single-trade-sent-requests">
                    <div class="bkt-card__header"><h3 class="bkt-card__title">Отправленные запросы</h3></div>
                    <div class="bkt-card outline">
                        <div class="bkt-card__feature">
                            <h6 class="bkt-card__subtitle">16 апреля 2022</h6>
                            <h6 class="bkt-card__title">Запрос документов по торгам</h6>
                        </div>
                    </div>
                    <div class="bkt-card outline">
                        <div class="bkt-card__feature">
                            <h6 class="bkt-card__subtitle">17 апреля 2022</h6>
                            <h6 class="bkt-card__title">Какой-то запрос</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <div class="bkt-card bkt-card__body bkt-single-trade-request">
                    <div class="bkt-card__header"><h3 class="bkt-card__title">Запрос организатору торгов</h3></div>
                    <div class="bkt-select__wrapper">
                        <label class="bkt-select__label" for="sortSelect">шаблон запроса</label>
                        <select class="form-select bkt-select" id="sortSelect" aria-label="">
                            <option selected>Авто</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <bkt-input
                        name="from_email"
                        type="email"
                        label="от кого"
                        :rules="'required|email'"
                        placeholder="pochta@gmail.com"
                    >
                    </bkt-input>

                    <bkt-input
                        name="to_email"
                        type="email"
                        label="кому"
                        :rules="'required|email'"
                        placeholder="pochta@gmail.com"
                    >
                    </bkt-input>
                    <bkt-input
                        name="subject"
                        type="text"
                        label="тема запроса"
                        :rules="'required'"
                        placeholder=""
                    >
                    </bkt-input>
                    <bkt-textarea
                        name="description"
                        type="text"
                        label="текст запроса"
                        :rules="'required'"
                        placeholder=""
                    >
                    </bkt-textarea>

                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="bkt-card bkt-single-trade-required-documents">
                    <div class="bkt-card__body">
                        <div class="bkt-card__header">
                            <h3 class="bkt-card__title">Необходимые документы</h3>
                        </div>
                        <div class="bkt-requred-document">
                            <div class="bkt-card__row outline w-100 bkt-wrapper-between bkt-nowrap">
                                <h5 class="text-truncate">Свидетельство о праве собственности</h5>
                                <div class="bkt-card__icon">
                                    <bkt-icon :name="'Check'" :fill="'#2fbb40'"></bkt-icon>
                                </div>
                            </div>
                            <button class="bkt-button">
                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>
                            </button>
                        </div>
                        <div class="bkt-requred-document">
                            <div class="bkt-card__row outline w-100 bkt-wrapper-between bkt-nowrap">
                                <h5 class="text-truncate">Правоустанавливающие документы</h5>
                                <div class="bkt-card__icon">
                                    <bkt-icon :name="'DotsCircle'" :width="'16px'" :height="'16px'"></bkt-icon>
                                </div>
                            </div>
                            <button class="bkt-button">
                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>
                            </button>
                        </div>
                        <div class="bkt-requred-document">
                            <div class="bkt-card__row outline w-100 bkt-wrapper-between bkt-nowrap">
                                <h5 class="text-truncate">Кадастровый паспорт участка</h5>
                                <div class="bkt-card__icon">
                                    <bkt-icon :name="'Download'" :fill="'#2953ff'" :width="'16px'"
                                              :height="'16px'"></bkt-icon>
                                </div>
                            </div>
                            <button class="bkt-button">
                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>
                            </button>
                        </div>
                        <div class="bkt-requred-document">
                            <div class="bkt-card__row outline  w-100 bkt-wrapper-between bkt-nowrap">
                                <h5 class="text-truncate">Положение о порядке и сроках реализации имуще...</h5>
                                <div class="bkt-card__icon">
                                    <bkt-icon :name="'Download'" :fill="'#2953ff'" :width="'16px'"
                                              :height="'16px'"></bkt-icon>
                                </div>
                            </div>
                            <button class="bkt-button">
                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>
                            </button>
                        </div>
                        <div class="bkt-requred-document">
                            <div class="bkt-card__row outline w-100 bkt-wrapper-between bkt-nowrap">
                                <h5 class="text-truncate">Оценка рыночной стоимости участка</h5>
                                <div class="bkt-card__icon">
                                    <bkt-icon :name="'Check'" :fill="'#2fbb40'"></bkt-icon>
                                </div>
                            </div>
                            <button class="bkt-button">
                                <bkt-icon class="bkt-button__icon" name="Trash"></bkt-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="bkt-card bkt-card__body bkt-single-trade-document-sets">
                    <div class="bkt-card__header"><h3 class="bkt-card__title">Наборы документов</h3></div>
                    <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'Note'" :fill="'#29b1ff'" :width="'16px'" :height="'16px'"></bkt-icon>
                        </div>
                        <h5 class="text-truncate">Авто</h5>
                    </div>
                    <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'Note'" :fill="'#29b1ff'" :width="'16px'" :height="'16px'"></bkt-icon>
                        </div>
                        <h5 class="text-truncate">Квартира</h5>
                    </div>
                    <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'Note'" :fill="'#29b1ff'" :width="'16px'" :height="'16px'"></bkt-icon>
                        </div>
                        <h5 class="text-truncate">Земля</h5>
                    </div>
                    <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'Note'" :fill="'#29b1ff'" :width="'16px'" :height="'16px'"></bkt-icon>
                        </div>
                        <h5 class="text-truncate">Дом с участком</h5>
                    </div>
                    <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'Note'" :fill="'#29b1ff'" :width="'16px'" :height="'16px'"></bkt-icon>
                        </div>
                        <h5 class="text-truncate">Дебиторская задолженность</h5>
                    </div>
                    <div class="bkt-card__row outline bkt-wrapper bkt-nowrap">
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'Note'" :fill="'#29b1ff'" :width="'16px'" :height="'16px'"></bkt-icon>
                        </div>
                        <h5 class="text-truncate">Свой набор</h5>
                    </div>
                    <button class="bkt-button primary">Добавить набор</button>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="bkt-card bkt-card__body bkt-single-trade-my-files">
                    <div class="bkt-card__header"><h3 class="bkt-card__title">Мои файлы</h3></div>
                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">
                        <div class="bkt-card__feature text-truncate">
                            <h5 class="text-truncate">Nazvanie.pdf</h5>
                            <h6 class="bkt-card__subtitle">23.1 Mb</h6>
                        </div>
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'More'"></bkt-icon>
                        </div>
                    </div>
                    <div class="bkt-card__row outline bkt-wrapper-between bkt-nowrap">
                        <div class="bkt-card__feature text-truncate">
                            <h5 class="text-truncate">Foto.jpg</h5>
                            <h6 class="bkt-card__subtitle">45.99 Kb</h6>
                        </div>
                        <div class="bkt-card__icon">
                            <bkt-icon :name="'More'"></bkt-icon>
                        </div>
                    </div>
                    <button class="bkt-button green">Добавить фото</button>
                    <button class="bkt-button green">Добавить документ</button>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class=" bkt-card bkt-card__body bkt-single-trade-debtor">
                    <div class="bkt-card__header bkt-wrapper-between">
                        <h3 class="bkt-card__title">Информация по должнику</h3>
                        <a href="" class="bkt-button next">Сообщения по должнику
                            <span class="bkt-text-red">(7)</span>
                            <bkt-icon name="ArrowDown"></bkt-icon>
                        </a>
                    </div>
                    <ul class="bkt-contents">
                        <li>
                            <div class="bkt-contents__heading"><span>должник</span></div>
                            <div class="bkt-contents__answer"><span>Васильев Василий Васильевич</span></div>
                        </li>
                        <li>
                            <div class="bkt-contents__heading"><span>дело №</span></div>
                            <div class="bkt-contents__answer"><span>1234567890/85</span></div>

                        </li>
                        <li>
                            <div class="bkt-contents__heading"><span>суд</span></div>
                            <div class="bkt-contents__answer"><span>Арбитражный Суд республики Башкортостан</span>
                            </div>
                        </li>
                        <li>
                            <div class="bkt-contents__heading"><span>ИНН</span></div>
                            <div class="bkt-contents__answer"><span>34334567890</span></div>
                        </li>
                        <li>
                            <div class="bkt-contents__heading"><span>регион</span></div>
                            <div class="bkt-contents__answer"><span>Республика Башкортостан</span></div>
                        </li>
                        <li>
                            <div class="bkt-contents__heading"><span>адрес должника</span></div>
                            <div class="bkt-contents__answer"><span>РБ, г. Стерлитамак ул. Фурманова д. 6</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="bkt-card bkt-card__body bkt-single-trade-active-lots">
                    <div class="bkt-wrapper-between">
                        <h3 class="bkt-card__title">
                            Другие активные лоты должника <span class="bkt-text-neutral-dark">(0)</span>
                        </h3>
                        <a class="bkt-button-icon" data-bs-toggle="collapse" href="#collapseActiveLots"  role="button" aria-expanded="false" >
                            <bkt-icon :name="'ArrowDown'" class="bkt-button__icon"></bkt-icon>
                        </a>
                    </div>
                    <div class="collapse" id="collapseActiveLots">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class=" bkt-card bkt-card__body">
                    <div class="bkt-wrapper-between">
                        <h3 class="bkt-card__title">
                            Завершённые лоты должника <span class="bkt-text-green">(1)</span>
                        </h3>
                        <button class="bkt-button-icon" >
                            <bkt-icon :name="'ArrowDown'" class="bkt-button__icon"></bkt-icon>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class=" bkt-card bkt-card__body">
                    <h3 class="bkt-card__title">Информация по организатору</h3>
                    <ul class="bkt-contents">
                        <li>
                            <div class="bkt-contents__heading"><span>организатор</span></div>
                            <div class="bkt-contents__answer bkt-text-green"><span>ФЕДЕРАЛЬНОЕ ГОСУДАРСТВЕННОЕ БЮДЖЕТНОЕ УЧРЕЖДЕНИЕ НАУКИ
                            ЦЕНТРАЛЬНЫЙ ЭКОНОМИКО-МАТЕМАТИЧЕСКИЙ ИНСТИТУТ РОССИЙСКОЙ АКАДЕМИИ НАУК</span>
                            </div>
                        </li>
                        <li>
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">ИНН</span>
                            </div>
                            <div class="bkt-contents__answer"><span>45757541414</span>
                            </div>
                        </li>
                        <li>
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">телефон</span>
                            </div>
                            <div class="bkt-contents__answer kt-text-primary"><span>+7 (919) 333 44-55</span>
                            </div>
                        </li>
                        <li>
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">почта</span>
                            </div>
                            <div class="bkt-contents__answer"><span>pochta@mail.ru</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class=" bkt-card bkt-card__body bkt-single-trade-arbitration-manager">
                    <h3 class="bkt-card__title">
                        Информация по арбитражному управляющему
                    </h3>
                    <ul class="bkt-contents">
                        <li>
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">арбитражный управляющий</span>
                            </div>
                            <div class="bkt-contents__answer"><span>Иванов Иван Иванович</span></div>
                        </li>
                        <li>
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">ИНН</span>
                            </div>
                            <div class="bkt-contents__answer"><span>7745424377</span>
                            </div>
                        </li>
                        <li>
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading">СРО</span>
                            </div>
                            <div class="bkt-contents__answer" style="font-size: 12px; font-weight:600">
                                <span>Ассоциация арбитражных управляющих саморегулируемая организация "Центральное
                                    агентство арбитражных управляющих" (ИНН 7731024000, ГРН 1107799028523)</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="bkt-card bkt-card__body">
                    <h3 class="bkt-card__title">Документы по торгам <span class="bkt-text-blue">(6)</span></h3>
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
        name: "LotCard",
        props: ['item'],
        components: {
            Hooper,
            Slide,
            HooperNavigation
        },
    }
</script>

<style lang="scss" scoped>
</style>
