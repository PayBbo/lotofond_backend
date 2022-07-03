<template>
    <div class="bkt-register">
        <div class="bkt-register__title">
            <span>Реестры</span>
        </div>
        <div class="container">
            <div class="bkt-register__menu">
                <div class="accordion" role="tablist">
                    <div class="bkt-card mb-2">
                        <div class="p-3" role="tab">
                            <a class="nav-link d-flex justify-content-between p-2 align-items-center" href="#register1"
                               data-toggle="collapse" role="button" aria-controls="sidebar-register"
                               data-target="#register1">
                                <div class="d-flex align-items-center">
                                    <div class="bkt-bg-red-lighter bkt-item-rounded p-2 mr-2">
                                        <bkt-icon :name="'User'" :width="'20'" :height="'20'"></bkt-icon>
                                    </div>
                                    <span>Должники</span>
                                </div>
                                <bkt-icon :width="'50'" name="ArrowDown" class="bkt-button__icon"></bkt-icon>
                            </a>
                        </div>
                        <div class="collapse" id="register1">
                            <hr>
                            <div class="bkt-search position-relative bg-white bkt-bg-item-neutral pt-0 pb-0">
                                <input class="w-100 bkt-search__input" type="text" :placeholder="'Введите нужное слово или фразу'">
                                <button class="bkt-button green bkt-search__button">
                                    <span class="d-none d-md-block">Найти</span>
                                    <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
                                </button>
                            </div>
                            <hr>
                            <div class="bkt-table-debtors p-3 m-3 overflow-auto">
                                <table class="table table-borderless bkt-rounded-table">
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
                                        <div class="form-floating bkt-select__wrapper main bkt-bg-light-gray bkt-item-rounded">
                                            <label class="bkt-select__subtitle float-left pl-3 m-0">сортировать
                                                по</label>
                                            <select class="form-select bkt-select bkt-select-register bkt-bg-light-gray pl-3"
                                                    aria-label="" style="color:black;">
                                                <option selected>алфавиту</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                        <button class="bkt-button-ellipse">
                                            <bkt-icon name="Bars"></bkt-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-5 d-flex justify-content-center bkt-pagination-items">
                                    <nav>
                                        <ul class="pagination m-0">
                                            <li class="page-item d-flex align-items-center"><a class="page-link bkt-text-yellow" href="#">
                                                < </a></li>
                                            <li class="page-item page-item__num active"><a class="page-link" href="#">1</a></li>
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
                                    <div class="form-floating bkt-select__wrapper main bkt-bg-light-gray bkt-item-rounded">
                                        <label class="bkt-select__subtitle float-left pl-3 m-0" for="sortPages">выводить
                                            по</label>
                                        <select class="form-select bkt-select bkt-select-register bkt-bg-light-gray pl-3"
                                                id="sortPages" aria-label="" style="color:black;">
                                            <option selected>20</option>
                                            <option value="1">30</option>
                                            <option value="2">50</option>
                                            <option value="3">100</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bkt-card mb-2">
                        <header class="p-3">
                            <a class="nav-link d-flex justify-content-between p-2 align-items-center" href="#register2"
                               data-toggle="collapse" role="button" aria-controls="sidebar-register"
                               data-target="#register2">
                                <div class="d-flex align-items-center">
                                    <div class="bkt-bg-yellow-lighter bkt-item-rounded p-2 mr-2">
                                        <bkt-icon :name="'Star'" :width="'20'" :height="'20'" color="yellow"></bkt-icon>
                                    </div>
                                    <span>Организаторы торгов</span>
                                </div>
                                <bkt-icon :width="'50'" name="ArrowDown" class="bkt-button__icon"></bkt-icon>
                            </a>
                        </header>
                        <div class="collapse" id="register2">
                            <hr>
                            <div class="bkt-search position-relative bg-white bkt-bg-item-neutral pt-0 pb-0">
                                <input class="w-100 bkt-search__input" type="text" :placeholder="'Введите нужное слово или фразу'">
                                <button class="bkt-button green bkt-search__button">
                                    <span class="d-none d-md-block">Найти</span>
                                    <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
                                </button>
                            </div>
                            <hr>
                            <div class="bkt-table-debtors p-3 m-3 overflow-auto">
                                <table class="table table-borderless bkt-rounded-table text-left">
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
                                        <div class="form-floating bkt-select__wrapper main bkt-bg-neutral-light bkt-item-rounded">
                                            <label class="bkt-select__subtitle float-left p-2 pl-3 m-0" for="sortSelect">сортировать
                                                по</label>
                                            <select class="form-select bkt-select bkt-select-register bkt-bg-neutral-light" id="sortSelect"
                                                    aria-label="" style="color:black;">
                                                <option selected>ключевому слову</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                        <button class="bkt-button-ellipse">
                                            <bkt-icon name="Bars"></bkt-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-5 d-flex justify-content-center bkt-pagination-items">
                                    <nav>
                                        <ul class="pagination m-0">
                                            <li class="page-item d-flex align-items-center"><a class="page-link bkt-text-yellow" href="#">
                                                < </a></li>
                                            <li class="page-item page-item__num active"><a class="page-link" href="#">1</a></li>
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
                                    <div class="form-floating bkt-select__wrapper main bkt-bg-light-gray bkt-item-rounded">
                                        <label class="bkt-select__subtitle float-left pl-3 m-0" for="sortPages">выводить
                                            по</label>
                                        <select class="form-select bkt-select bkt-select-register bkt-bg-light-gray pl-3"
                                                id="sortPages" aria-label="" style="color:black;">
                                            <option selected>20</option>
                                            <option value="1">30</option>
                                            <option value="2">50</option>
                                            <option value="3">100</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bkt-card mb-2">
                        <header class="p-3">
                            <a class="nav-link d-flex justify-content-between p-2 align-items-center" href="#register3"
                               data-toggle="collapse" role="button" aria-controls="sidebar-register"
                               data-target="#register3">
                                <div class="d-flex align-items-center">
                                    <div class="bkt-bg-blue-lighter bkt-item-rounded p-2 mr-2">
                                        <bkt-icon :name="'Law'" :width="'20'" :height="'20'" color="blue"></bkt-icon>
                                    </div>
                                    <span>Арбитражные управляющие</span>
                                </div>
                                <bkt-icon :width="'50'" name="ArrowDown" class="bkt-button__icon"></bkt-icon>
                            </a>
                        </header>
                        <div class="collapse" id="register3">
                            <hr>
                            <div class="bkt-search position-relative bg-white bkt-bg-item-neutral pt-0 pb-0">
                                <input class="w-100 bkt-search__input" type="text" :placeholder="'Введите нужное слово или фразу'">
                                <button class="bkt-button green bkt-search__button">
                                    <span class="d-none d-md-block">Найти</span>
                                    <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
                                </button>
                            </div>
                            <hr>
                            <div class="bkt-table-debtors p-3 m-3 overflow-auto">
                                <table class="table table-borderless bkt-rounded-table text-left">
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
                                        <div class="form-floating bkt-select__wrapper main bkt-bg-neutral-light bkt-item-rounded">
                                            <label class="bkt-select__subtitle float-left p-2 pl-3 m-0" for="sortSelect">сортировать
                                                по</label>
                                            <select class="form-select bkt-select bkt-select-register bkt-bg-neutral-light" id="sortSelect"
                                                    aria-label="" style="color:black;">
                                                <option selected>ключевому слову</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                        <button class="bkt-button-ellipse">
                                            <bkt-icon name="Bars"></bkt-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-5 d-flex justify-content-center bkt-pagination-items">
                                    <nav>
                                        <ul class="pagination m-0">
                                            <li class="page-item d-flex align-items-center"><a class="page-link bkt-text-yellow" href="#">
                                                < </a></li>
                                            <li class="page-item page-item__num active"><a class="page-link" href="#">1</a></li>
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
                                    <div class="form-floating bkt-select__wrapper main bkt-bg-light-gray bkt-item-rounded">
                                        <label class="bkt-select__subtitle float-left pl-3 m-0" for="sortPages">выводить
                                            по</label>
                                        <select class="form-select bkt-select bkt-select-register bkt-bg-light-gray pl-3"
                                                id="sortPages" aria-label="" style="color:black;">
                                            <option selected>20</option>
                                            <option value="1">30</option>
                                            <option value="2">50</option>
                                            <option value="3">100</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bkt-card mb-2">
                        <header class="p-3">
                            <a class="nav-link d-flex justify-content-between p-2 align-items-center" href="#register4"
                               data-toggle="collapse" role="button" aria-controls="sidebar-register"
                               data-target="#register4">
                                <div class="d-flex align-items-center">
                                    <div class="bkt-bg-pink-lighter bkt-item-rounded p-2 mr-2">
                                        <bkt-icon :name="'MenuOutline'" :width="'20'" :height="'20'" color="pink"></bkt-icon>
                                    </div>
                                    <span>Торговые площадки</span>
                                </div>
                                <bkt-icon :width="'50'" name="ArrowDown" class="bkt-button__icon"></bkt-icon>
                            </a>
                        </header>
                        <div class="collapse" id="register4">
                            <hr>
                            <div class="bkt-search position-relative bg-white bkt-bg-item-neutral pt-0 pb-0">
                                <input class="w-100 bkt-search__input" type="text" :placeholder="'Введите нужное слово или фразу'">
                                <button class="bkt-button green bkt-search__button">
                                    <span class="d-none d-md-block">Найти</span>
                                    <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
                                </button>
                            </div>
                            <hr>
                            <div class="bkt-table-debtors p-3 m-3 overflow-auto">
                                <table class="table table-borderless bkt-rounded-table text-left">
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
                                        <div class="form-floating bkt-select__wrapper main bkt-bg-light-gray bkt-item-rounded">
                                            <label class="bkt-select__subtitle float-left pl-3 m-0" for="sortPages">сортировать
                                                по</label>
                                            <select class="form-select bkt-select bkt-select-register bkt-bg-light-gray pl-3"
                                                    id="sortPages" aria-label="" style="color:black;">
                                                <option selected>ключевому слову</option>
                                                <option value="1">one</option>
                                                <option value="2">two</option>
                                                <option value="3">three</option>
                                            </select>
                                        </div>
                                        <button class="bkt-button-ellipse">
                                            <bkt-icon name="Bars"></bkt-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-5 d-flex justify-content-center bkt-pagination-items">
                                    <nav>
                                        <ul class="pagination m-0">
                                            <li class="page-item d-flex align-items-center"><a class="page-link bkt-text-yellow" href="#">
                                                < </a></li>
                                            <li class="page-item page-item__num active"><a class="page-link" href="#">1</a></li>
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
                                    <div class="form-floating bkt-select__wrapper main bkt-bg-light-gray bkt-item-rounded">
                                        <label class="bkt-select__subtitle float-left pl-3 m-0" for="sortPages">выводить
                                            по</label>
                                        <select class="form-select bkt-select bkt-select-register bkt-bg-light-gray pl-3"
                                                id="sortPages" aria-label="" style="color:black;">
                                            <option selected>20</option>
                                            <option value="1">30</option>
                                            <option value="2">50</option>
                                            <option value="3">100</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bkt-card mb-2">
                        <header class="p-3">
                            <a class="nav-link d-flex justify-content-between p-2 align-items-center" href="#register5"
                               data-toggle="collapse" role="button" aria-controls="sidebar-register"
                               data-target="#register5">
                                <div class="d-flex align-items-center">
                                    <div class="bkt-bg-blue-lighter bkt-item-rounded p-2 mr-2">
                                        <bkt-icon :name="'Chat'" :width="'20'" :height="'20'" color="blue"></bkt-icon>
                                    </div>
                                    <span>Сообщения</span>
                                </div>
                                <bkt-icon :width="'50'" name="ArrowDown" class="bkt-button__icon"></bkt-icon>
                            </a>
                        </header>
                        <div class="collapse" id="register5">
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
                                        <div class="bkt-selected-region-items float-left d-flex">
                                            <div class="bkt-region__item bkt-item-rounded mr-2">
                                                <div class="mb-1 p-2 w-100 pl-4 pr-4 text-left">
                                                    <span class="bkt-item-rounded__text mr-2">title</span>
                                                    <span class="bkt-cursor-pointer">
                              <img src="/images/cancel.svg" alt="cancel">
                            </span>
                                                </div>
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
                                        <bkt-checkbox name="check" :value="true" :label="'в сообщении есть файлы'"></bkt-checkbox>
                                    </div>
                                </div>
                            </div>
                            <div class="bkt-table-debtors p-3 m-3 overflow-auto">
                                <table class="table table-borderless bkt-rounded-table text-left">
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
                                        <div class="form-floating bkt-select__wrapper main bkt-bg-neutral-light bkt-item-rounded">
                                            <label class="bkt-select__subtitle float-left p-2 pl-3 m-0" for="sortSelect">сортировать
                                                по</label>
                                            <select class="form-select bkt-select bkt-select-register bkt-bg-neutral-light" id="sortSelect"
                                                    aria-label="" style="color:black;">
                                                <option selected>ключевому слову</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                        <button class="bkt-button-ellipse">
                                            <bkt-icon name="Bars"></bkt-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-5 d-flex justify-content-center bkt-pagination-items">
                                    <nav>
                                        <ul class="pagination m-0">
                                            <li class="page-item d-flex align-items-center"><a class="page-link bkt-text-yellow" href="#">
                                                < </a></li>
                                            <li class="page-item page-item__num active"><a class="page-link" href="#">1</a></li>
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
                                    <div class="form-floating bkt-select__wrapper main bkt-bg-light-gray bkt-item-rounded">
                                        <label class="bkt-select__subtitle float-left pl-3 m-0" for="sortPages">выводить
                                            по</label>
                                        <select class="form-select bkt-select bkt-select-register bkt-bg-light-gray pl-3"
                                                id="sortPages" aria-label="" style="color:black;">
                                            <option selected>20</option>
                                            <option value="1">30</option>
                                            <option value="2">50</option>
                                            <option value="3">100</option>
                                        </select>
                                    </div>
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
// import MainParamsModal from "./MainParamsModal";

export default {
  name: "Registries",
  // components: {MainParamsModal}
}
</script>

<style scoped>

</style>
