<template>
    <div class="bkt-register bkt-page container bkt-container">
        <h1 class="bkt-page__title">
            Реестры
        </h1>
        <div class="bkt-register__menu">
            <div class="accordion" role="tablist">
                <bkt-collapse main_class="bkt-register-collapse mb-2" collapse_button_class="bkt-bg-white" id="register1">
                    <template #title>
                        <div class="bkt-register-collapse__header">
                            <div class="bkt-bg-red-lighter bkt-icon-frame-small bkt-icon-frame-sm">
                                <bkt-icon :name="'User'" class="bkt-icon-frame__item"></bkt-icon>
                            </div>
                            <h4 class="bkt-register-collapse__title">Должники</h4>
                        </div>
                    </template>
                    <template #collapse>
                        <hr>
                        <div class="bkt-search position-relative bg-white bkt-bg-item-neutral pt-0 pb-0">
                            <input class="w-100 bkt-search__input" type="text"
                                   :placeholder="'Введите нужное слово или фразу'">
                            <button class="bkt-button green bkt-search__button">
                                <span class="d-none d-md-block">Найти</span>
                                <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
                            </button>
                        </div>
                        <hr>
                        <div class="bkt-table-debtors p-3 m-3 overflow-auto">
                            <table class="table table-borderless bkt-table">
                                <tr>
                                    <th>№</th>
                                    <th>Должник</th>
                                    <th>ИНН</th>
                                    <th>Регион</th>
                                    <th>Адрес</th>
                                </tr>
                                <tbody>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>540101, Ярославская обл., Ярославский р-н, г.Название, ул.Ленина, д.454</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>540101, Ярославская обл., Ярославский р-н, г.Название, ул.Ленина, д.454</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>540101, Ярославская обл., Ярославский р-н, г.Название, ул.Ленина, д.454</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>540101, Ярославская обл., Ярославский р-н, г.Название, ул.Ленина, д.454</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>540101, Ярославская обл., Ярославский р-н, г.Название, ул.Ленина, д.454</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>540101, Ярославская обл., Ярославский р-н, г.Название, ул.Ленина, д.454</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>540101, Ярославская обл., Ярославский р-н, г.Название, ул.Ленина, д.454</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>540101, Ярославская обл., Ярославский р-н, г.Название, ул.Ленина, д.454</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bkt-register-filters bkt-row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="d-flex w-100 mx-auto justify-content-around">
                                    <div class="form-floating bkt-select__wrapper bkt-item-rounded">
                                        <select class="form-select bkt-select bkt-item-rounded" id="sortSelect1" aria-label="">
                                            <option selected>алфавиту</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <label class="bkt-select__subtitle" for="sortSelect1">сортировать по</label>
                                    </div>
                                    <button class="bkt-button-ellipse">
                                        <bkt-icon name="Bars"></bkt-icon>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-5 d-flex justify-content-center bkt-pagination-items">
                                <nav>
                                    <ul class="pagination m-0">
                                        <li class="page-item d-flex align-items-center"><a
                                            class="page-link bkt-text-yellow" href="#">
                                            < </a></li>
                                        <li class="page-item page-item__num active"><a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">...</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">450</a></li>
                                        <li class="page-item page-item__next d-flex align-items-center"><a
                                            class="page-link bkt-text-yellow" href="#"> > </a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-floating bkt-select__wrapper bkt-item-rounded">
                                    <select class="form-select bkt-select bkt-item-rounded" id="sortSelect9" aria-label="">
                                        <option selected>20</option>
                                        <option value="1">30</option>
                                        <option value="2">50</option>
                                        <option value="3">100</option>
                                    </select>
                                    <label class="bkt-select__subtitle" for="sortSelect9">выводить
                                        по</label>
                                </div>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>

                <bkt-collapse main_class="bkt-register-collapse mb-2" collapse_button_class="bkt-bg-white" id="register2">
                    <template #title>
                        <div class="bkt-register-collapse__header">
                            <div class="bkt-bg-yellow-lighter bkt-icon-frame-small bkt-icon-frame-sm">
                                <bkt-icon :name="'Star'" class="bkt-icon-frame__item" color="yellow"></bkt-icon>
                            </div>
                            <h4 class="bkt-register-collapse__title">Организаторы торгов</h4>
                        </div>
                    </template>
                    <template #collapse>
                        <hr>
                        <div class="bkt-search position-relative bg-white bkt-bg-item-neutral pt-0 pb-0">
                            <input class="w-100 bkt-search__input" type="text"
                                   :placeholder="'Введите нужное слово или фразу'">
                            <button class="bkt-button green bkt-search__button">
                                <span class="d-none d-md-block">Найти</span>
                                <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
                            </button>
                        </div>
                        <hr>
                        <div class="bkt-table-debtors p-3 m-3 overflow-auto">
                            <table class="table table-borderless bkt-table text-left">
                                <tr>
                                    <th>№</th>
                                    <th width="60%">Наименование</th>
                                    <th>ИНН</th>
                                    <th>Регион</th>
                                </tr>
                                <tbody>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bkt-register-filters bkt-row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="d-flex w-100 mx-auto justify-content-around">
                                    <div class="form-floating bkt-select__wrapper bkt-bg-light-gray bkt-item-rounded">
                                        <select class="form-select bkt-select bkt-item-rounded" id="sortSelect2" aria-label="">
                                            <option selected>ключевому слову</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <label class="bkt-select__subtitle" for="sortSelect2">сортировать по</label>
                                    </div>
                                    <button class="bkt-button-ellipse">
                                        <bkt-icon name="Bars"></bkt-icon>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-5 d-flex justify-content-center bkt-pagination-items">
                                <nav>
                                    <ul class="pagination m-0">
                                        <li class="page-item d-flex align-items-center"><a
                                            class="page-link bkt-text-yellow" href="#">
                                            < </a></li>
                                        <li class="page-item page-item__num active"><a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">...</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">450</a></li>
                                        <li class="page-item page-item__next d-flex align-items-center"><a
                                            class="page-link bkt-text-yellow" href="#"> > </a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-floating bkt-select__wrapper bkt-bg-light-gray bkt-item-rounded">
                                    <select class="form-select bkt-select bkt-item-rounded" id="sortSelect3" aria-label="">
                                        <option selected>20</option>
                                        <option value="1">30</option>
                                        <option value="2">50</option>
                                        <option value="3">100</option>
                                    </select>
                                    <label class="bkt-select__subtitle" for="sortSelect3">выводить по</label>
                                </div>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>

                <bkt-collapse main_class="bkt-register-collapse mb-2" collapse_button_class="bkt-bg-white" id="register3">
                    <template #title>
                        <div class="bkt-register-collapse__header">
                            <div class="bkt-bg-primary-lighter bkt-icon-frame-small bkt-icon-frame-sm">
                                <bkt-icon :name="'Law'" class="bkt-icon-frame__item" color="primary"></bkt-icon>
                            </div>
                            <h4 class="bkt-register-collapse__title">Арбитражные управляющие</h4>
                        </div>
                    </template>
                    <template #collapse>
                        <hr>
                        <div class="bkt-search position-relative bg-white bkt-bg-item-neutral pt-0 pb-0">
                            <input class="w-100 bkt-search__input" type="text"
                                   :placeholder="'Введите нужное слово или фразу'">
                            <button class="bkt-button green bkt-search__button">
                                <span class="d-none d-md-block">Найти</span>
                                <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
                            </button>
                        </div>
                        <hr>
                        <div class="bkt-table-debtors p-3 m-3 overflow-auto">
                            <table class="table table-borderless bkt-table text-left">
                                <tr>
                                    <th>№</th>
                                    <th>Наименование</th>
                                    <th>ИНН</th>
                                    <th>Регион</th>
                                    <th>СРО</th>
                                </tr>
                                <tbody>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>Союз арбитражных управляющих "Саморегулируемая организация "ДЕЛО""</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>458</td>
                                    <td>Абакумов Иван Иванович</td>
                                    <td>500100732259</td>
                                    <td>Ярославская обл.</td>
                                    <td>-</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bkt-register-filters bkt-row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="d-flex w-100 mx-auto justify-content-around">
                                     <div class="form-floating bkt-select__wrapper bkt-bg-light-gray bkt-item-rounded">
                                        <select class="form-select bkt-select bkt-item-rounded" id="sortSelect2" aria-label="">
                                            <option selected>ключевому слову</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <label class="bkt-select__subtitle" for="sortSelect2">сортировать по</label>
                                    </div>
                                    <button class="bkt-button-ellipse">
                                        <bkt-icon name="Bars"></bkt-icon>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-5 d-flex justify-content-center bkt-pagination-items">
                                <nav>
                                    <ul class="pagination m-0">
                                        <li class="page-item d-flex align-items-center"><a
                                            class="page-link bkt-text-yellow" href="#">
                                            < </a></li>
                                        <li class="page-item page-item__num active"><a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">...</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">450</a></li>
                                        <li class="page-item page-item__next d-flex align-items-center"><a
                                            class="page-link bkt-text-yellow" href="#"> > </a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-floating bkt-select__wrapper bkt-item-rounded">
                                    <select class="form-select bkt-select bkt-item-rounded" id="sortSelect4" aria-label="">
                                        <option selected>20</option>
                                        <option value="1">30</option>
                                        <option value="2">50</option>
                                        <option value="3">100</option>
                                    </select>
                                    <label class="bkt-select__subtitle" for="sortSelect4">выводить по</label>
                                </div>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>

                <bkt-collapse main_class="bkt-register-collapse mb-2" collapse_button_class="bkt-bg-white" id="register4">
                    <template #title>
                        <div class="bkt-register-collapse__header">
                            <div class="bkt-bg-pink-lighter bkt-icon-frame-small bkt-icon-frame-sm">
                                <bkt-icon :name="'MenuOutline'" class="bkt-icon-frame__item" color="pink"></bkt-icon>
                            </div>
                            <h4 class="bkt-register-collapse__title">Торговые площадки</h4>
                        </div>
                    </template>
                    <template #collapse>
                        <hr>
                        <div class="bkt-search position-relative bg-white bkt-bg-item-neutral pt-0 pb-0">
                            <input class="w-100 bkt-search__input" type="text"
                                   :placeholder="'Введите нужное слово или фразу'">
                            <button class="bkt-button green bkt-search__button">
                                <span class="d-none d-md-block">Найти</span>
                                <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
                            </button>
                        </div>
                        <hr>
                        <div class="bkt-table-debtors p-3 m-3 overflow-auto">
                            <table class="table table-borderless bkt-table text-left">
                                <tr>
                                    <th>№</th>
                                    <th>Наименование</th>
                                    <th>Адрес</th>
                                    <th></th>
                                    <th>Заметка</th>
                                </tr>
                                <tbody>
                                <tr>
                                    <td>0001</td>
                                    <td>РТС Тендер</td>
                                    <td>https://www.rts-tender.ru</td>
                                    <td>
                                        <bkt-checkbox name="check"></bkt-checkbox>
                                    </td>
                                    <td><i class="text-muted">Нажмите для добавления заметки</i></td>
                                </tr>
                                <tr>
                                    <td>0001</td>
                                    <td>РТС Тендер</td>
                                    <td>https://www.rts-tender.ru</td>
                                    <td>
                                        <bkt-checkbox name="check"></bkt-checkbox>
                                    </td>
                                    <td><i class="text-muted">Нажмите для добавления заметки</i></td>
                                </tr>
                                <tr>
                                    <td>0001</td>
                                    <td>РТС Тендер</td>
                                    <td>https://www.rts-tender.ru</td>
                                    <td>
                                        <bkt-checkbox name="check"></bkt-checkbox>
                                    </td>
                                    <td><i class="text-muted">Нажмите для добавления заметки</i></td>
                                </tr>
                                <tr>
                                    <td>0001</td>
                                    <td>РТС Тендер</td>
                                    <td>https://www.rts-tender.ru</td>
                                    <td>
                                        <bkt-checkbox name="check"></bkt-checkbox>
                                    </td>
                                    <td><i class="text-muted">Нажмите для добавления заметки</i></td>
                                </tr>
                                <tr>
                                    <td>0001</td>
                                    <td>РТС Тендер</td>
                                    <td>https://www.rts-tender.ru</td>
                                    <td>
                                        <bkt-checkbox name="check"></bkt-checkbox>
                                    </td>
                                    <td><i class="text-muted">Нажмите для добавления заметки</i></td>
                                </tr>
                                <tr>
                                    <td>0001</td>
                                    <td>РТС Тендер</td>
                                    <td>https://www.rts-tender.ru</td>
                                    <td>
                                        <bkt-checkbox name="check"></bkt-checkbox>
                                    </td>
                                    <td><i class="text-muted">Нажмите для добавления заметки</i></td>
                                </tr>
                                <tr>
                                    <td>0001</td>
                                    <td>РТС Тендер</td>
                                    <td>https://www.rts-tender.ru</td>
                                    <td>
                                        <bkt-checkbox name="check"></bkt-checkbox>
                                    </td>
                                    <td><i class="text-muted">Нажмите для добавления заметки</i></td>
                                </tr>
                                <tr>
                                    <td>0001</td>
                                    <td>РТС Тендер</td>
                                    <td>https://www.rts-tender.ru</td>
                                    <td>
                                        <bkt-checkbox name="check"></bkt-checkbox>
                                    </td>
                                    <td><i class="text-muted">Нажмите для добавления заметки</i></td>
                                </tr>
                                <tr>
                                    <td>0001</td>
                                    <td>РТС Тендер</td>
                                    <td>https://www.rts-tender.ru</td>
                                    <td>
                                        <bkt-checkbox name="check"></bkt-checkbox>
                                    </td>
                                    <td><i class="text-muted">Нажмите для добавления заметки</i></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bkt-register-filters bkt-row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="d-flex w-100 mx-auto justify-content-around">
                                    <div class="form-floating bkt-select__wrapper bkt-item-rounded">
                                        <select class="form-select bkt-select bkt-item-rounded" id="sortSelect8" aria-label="">
                                            <option selected>ключевому слову</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <label class="bkt-select__subtitle" for="sortSelect8">сортировать по</label>
                                    </div>
                                    <button class="bkt-button-ellipse">
                                        <bkt-icon name="Bars"></bkt-icon>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-5 d-flex justify-content-center bkt-pagination-items">
                                <nav>
                                    <ul class="pagination m-0">
                                        <li class="page-item d-flex align-items-center"><a
                                            class="page-link bkt-text-yellow" href="#">
                                            < </a></li>
                                        <li class="page-item page-item__num active"><a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">...</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">450</a></li>
                                        <li class="page-item page-item__next d-flex align-items-center"><a
                                            class="page-link bkt-text-yellow" href="#"> > </a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-floating bkt-select__wrapper bkt-item-rounded">
                                    <select class="form-select bkt-select bkt-item-rounded" id="sortSelect7" aria-label="">
                                        <option selected>20</option>
                                        <option value="1">30</option>
                                        <option value="2">50</option>
                                        <option value="3">100</option>
                                    </select>
                                    <label class="bkt-select__subtitle" for="sortSelect7">выводить по</label>
                                </div>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>

                <bkt-collapse main_class="bkt-register-collapse mb-2" collapse_button_class="bkt-bg-white" id="register5">
                    <template #title>
                        <div class="bkt-register-collapse__header">
                            <div class="bkt-bg-blue-lighter bkt-icon-frame-small bkt-icon-frame-sm">
                                <bkt-icon :name="'Chat'" class="bkt-icon-frame__item" color="blue"></bkt-icon>
                            </div>
                            <h4 class="bkt-register-collapse__title">Сообщения</h4>
                        </div>
                    </template>
                    <template #collapse>
                        <hr>
                        <div class="bkt-register-filters p-3 m-3">
                            <div class="row mb-2">
                                <div class="col-lg-2 d-flex align-items-center">
                                    <span>поиск по тексту</span>
                                </div>
                                <div class="col-12 col-lg-10">
                                    <div class="w-100 bkt-search position-relative bkt-bg-neutral-light pt-0 pb-0 p-2">
                                        <input class="w-100 bkt-search__input" type="text">
                                        <button class="bkt-button green bkt-search__button">
                                            <span class="d-none d-md-block">Найти</span>
                                            <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-2 d-flex align-items-center">
                                    <span>должник</span>
                                </div>
                                <div class="col-12 col-lg-10">
                                    <div class="w-100 bkt-search position-relative bkt-bg-neutral-light pt-0 pb-0 p-2">
                                        <input class="w-100 bkt-search__input" type="text">
                                        <button class="bkt-button green bkt-search__button">
                                            <span class="d-none d-md-block">Найти</span>
                                            <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-2 d-flex align-items-center">
                                    <span>типы сообщения</span>
                                </div>
                                <div class="col-12 col-lg-10 text-left">
                                    <button class="bkt-button bkt-bg-primary bkt-search__button">
                                        <span class="d-none d-md-block">Выбрать</span>
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-2 d-flex align-items-center">
                                    <span>регион должника</span>
                                </div>
                                <div class="col-12 col-lg-auto text-left">
                                    <button class="bkt-button bkt-bg-primary bkt-search__button">
                                        <span class="d-none d-md-block">Выбрать</span>
                                    </button>
                                </div>
                                <div class="col-12 col-lg-7 col-md-5">
                                    <div class="bkt-tag__list">
                                        <div class="bkt-region__item bkt-tag justify-content-between flex-fill">
                                            <span class="bkt-item-rounded__text mr-2">title</span>
                                            <span class="bkt-tag__icon bkt-cursor-pointer">
                                                <bkt-icon name="Cancel" color="red"></bkt-icon>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-2 d-flex align-items-center">
                                    <span>дата публикации</span>
                                </div>
                                <div class="col-12 col-lg-10">
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <bkt-datepicker field_name="с" name="dateStart"></bkt-datepicker>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <bkt-datepicker field_name="по" name="dateEnd"></bkt-datepicker>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-2">
                                </div>
                                <div class="col-12 col-lg-10 text-left">
                                    <bkt-checkbox name="check" :value="true"
                                                  :label="'в сообщении есть файлы'"></bkt-checkbox>
                                </div>
                            </div>
                        </div>
                        <div class="bkt-table-debtors p-3 m-3 overflow-auto">
                            <table class="table table-borderless bkt-table text-left">
                                <tr>
                                    <th>Дата</th>
                                    <th>Тип</th>
                                    <th>Должник</th>
                                </tr>
                                <tbody>
                                <tr>
                                    <td>03.04.2022</td>
                                    <td>Сообщение о собрании кредиторов</td>
                                    <td>ЗАО ПК "ЛАЭС" Самарская область</td>
                                </tr>
                                <tr>
                                    <td>03.04.2022</td>
                                    <td>Сообщение о собрании кредиторов</td>
                                    <td>ЗАО ПК "ЛАЭС" Самарская область</td>
                                </tr>
                                <tr>
                                    <td>03.04.2022</td>
                                    <td>Сообщение о собрании кредиторов</td>
                                    <td>ЗАО ПК "ЛАЭС" Самарская область</td>
                                </tr>
                                <tr>
                                    <td>03.04.2022</td>
                                    <td>Сообщение о собрании кредиторов</td>
                                    <td>ЗАО ПК "ЛАЭС" Самарская область</td>
                                </tr>
                                <tr>
                                    <td>03.04.2022</td>
                                    <td>Сообщение о собрании кредиторов</td>
                                    <td>ЗАО ПК "ЛАЭС" Самарская область</td>
                                </tr>
                                <tr>
                                    <td>03.04.2022</td>
                                    <td>Сообщение о собрании кредиторов</td>
                                    <td>ЗАО ПК "ЛАЭС" Самарская область</td>
                                </tr>
                                <tr>
                                    <td>03.04.2022</td>
                                    <td>Сообщение о собрании кредиторов</td>
                                    <td>ЗАО ПК "ЛАЭС" Самарская область</td>
                                </tr>
                                <tr>
                                    <td>03.04.2022</td>
                                    <td>Сообщение о собрании кредиторов</td>
                                    <td>ЗАО ПК "ЛАЭС" Самарская область</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bkt-register-filters bkt-row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="d-flex w-100 mx-auto justify-content-around">
                                     <div class="form-floating bkt-select__wrapper bkt-item-rounded">
                                        <select class="form-select bkt-select bkt-item-rounded" id="sortSelect5" aria-label="">
                                            <option selected>ключевому слову</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                        <label class="bkt-select__subtitle" for="sortSelect5">сортировать по</label>
                                    </div>
                                    <button class="bkt-button-ellipse">
                                        <bkt-icon name="Bars"></bkt-icon>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-5 d-flex justify-content-center bkt-pagination-items">
                                <nav>
                                    <ul class="pagination m-0">
                                        <li class="page-item d-flex align-items-center"><a
                                            class="page-link bkt-text-yellow" href="#">
                                            < </a></li>
                                        <li class="page-item page-item__num active"><a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">...</a></li>
                                        <li class="page-item page-item__num"><a class="page-link" href="#">450</a></li>
                                        <li class="page-item page-item__next d-flex align-items-center"><a
                                            class="page-link bkt-text-yellow" href="#"> > </a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-floating bkt-select__wrapper bkt-item-rounded">
                                    <select class="form-select bkt-select bkt-item-rounded" id="sortSelect6" aria-label="">
                                        <option selected>20</option>
                                        <option value="1">30</option>
                                        <option value="2">50</option>
                                        <option value="3">100</option>
                                    </select>
                                    <label class="bkt-select__subtitle" for="sortSelect6">выводить по</label>
                                </div>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>
            </div>
        </div>
    </div>
</template>

<script>
    // import MainParamsModal from "./MainParamsModal";
    import BktCollapse from '../components/Collapse.vue'

    export default {
        name: "Registries",
        components: {
            // MainParamsModal,
            BktCollapse,
        }
    }
</script>

<style scoped>

</style>
