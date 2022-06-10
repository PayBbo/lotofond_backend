@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="container bkt-main">
        <h1 class="text-center">Электронные торги по банкротству</h1>
        <div class="bkt-main-search d-flex bkt-card position-relative">
            <input class="w-100 bkt-main-search__input" type="text" placeholder="Введите нужное слово или фразу">
            <button class="bkt-button green">
                <span class="d-none d-md-block">Найти</span>
                <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
            </button>
        </div>
        <div class="bkt-main-categories bkt-card__list">
            <div class="bkt-card">
                <div class="col-10">
                    <h4>Выберите<br> нужные категории</h4>
                    <h5 class="bkt-card__subtitle bkt-text-green">выбрано 4</h5>
                    <button class="bkt-button primary-lighter">Изменить</button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bg-green">
                        <span class="bkt-card__category-icon">
                            <bkt-icon :name="'Category'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card">
                <div class="col-10">
                    <h4>Выберите<br> регион</h4>
                    <h5 class="bkt-card__subtitle">ничего не выбрано</h5>
                    <button class="bkt-button primary">Выбрать</button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bg-red-lighter">
                        <span class="bkt-card__category-icon">
                             <bkt-icon :name="'Location'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card">
                <div class="col-10">
                    <h4>Выберите основные<br> параметры объекта</h4>
                    <h5 class="bkt-card__subtitle">ничего не выбрано</h5>
                    <button class="bkt-button primary">Выбрать</button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bg-purple-lighter">
                        <span class="bkt-card__category-icon">
                             <bkt-icon :name="'Options'" :fill="'#ff41be'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card">
                <div class="col-10">
                    <h4>Выберите<br> стоимость объекта</h4>
                    <h5 class="bkt-card__subtitle">ничего не выбрано</h5>
                    <button class="bkt-button primary">Выбрать</button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bg-yellow-lighter">
                        <span class="bkt-card__category-icon">
                            <bkt-icon :name="'Wallet'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card">
                <div class="col-10">
                    <h4>Выберите<br> дату торгов</h4>
                    <h5 class="bkt-card__subtitle bkt-text-green">выбрано 2</h5>
                    <button class="bkt-button primary-lighter">Изменить</button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bg-blue">
                        <span class="bkt-card__category-icon">
                            <bkt-icon :name="'Date'" :fill="'#fff'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card">

                <div class="col-10">
                    <h4>Выберите<br> доп. параметры</h4>
                    <h5 class="bkt-card__subtitle">ничего не выбрано</h5>
                    <button class="bkt-button primary">Выбрать</button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bg-primary-lighter">
                        <span class="bkt-card__category-icon">
                            <bkt-icon :name="'Clone'"></bkt-icon>
                        </span>
                    </div>
                </div>

            </div>
        </div>
        <div class="bkt-main-statistic bkt-card__list">
            <div class="bkt-card bg-red-light position-relative">
                <h5 class="bkt-card__text">Всего лотов</h5>
                <h1 class="bkt-card__title">58 961</h1>
                <div class="bkt-card bkt-card__background-figure-1">
                </div>
                <div class="bkt-card bkt-card__background-figure-2 bg-red-light">
                </div>
            </div>
            <div class="bkt-card bg-yellow position-relative">
                <h5 class="bkt-card__text">Активных лотов</h5>
                <h1 class="bkt-card__title">4 372</h1>
                <div class="bkt-card bkt-card__background-figure-1 bg-yellow-lighter">
                </div>
                <div class="bkt-card bkt-card__background-figure-2 bg-yellow">
                </div>
            </div>
            <div class="bkt-card bg-blue position-relative">
                <h5 class="bkt-card__text">Добавлено сегодня</h5>
                <h1 class="bkt-card__title">64</h1>
                <div class="bkt-card bkt-card__background-figure-1 bg-blue-light">
                </div>
                <div class="bkt-card bkt-card__background-figure-2 bg-blue">
                </div>
            </div>
        </div>
        <div class="bkt-main-filters bkt-card bg-main">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="d-flex w-100 mx-auto justify-content-around">
                    <div class="form-floating bkt-select__wrapper">
                        <select class="form-select bkt-select main" id="sortSelect" aria-label="">
                            <option selected>ключевому слову</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <label class="bkt-select__subtitle" for="sortSelect">сортировать по</label>
                    </div>
                    <button class="bkt-button-ellipse main d-none d-md-block">
                        <bkt-icon name="Bars"></bkt-icon>
                    </button>
                    <button class="bkt-button-ellipse main d-md-none">
                        <bkt-icon name="Funnel" :width="'18px'" :height="'18px'"></bkt-icon>
                    </button>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 d-none d-md-block">
                <div class="form-floating bkt-select__wrapper ">
                    <select class="form-select bkt-select main" id="periodSelect" aria-label="">
                        <option selected>все</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <label class="bkt-select__subtitle" for="periodSelect">показывать за период</label>
                </div>
            </div>
            <div class="col-md-12 col-lg-5 d-none d-md-block">
                <div class="d-flex">
                    <div class="bkt-check__list">
                        <div class="form-check bkt-check">
                            <input class="form-check-input bkt-check__input" type="checkbox" value="" id="">
                            <label class="form-check-label bkt-check__label" for="">
                                только с фото
                            </label>
                        </div>
                        <div class="form-check bkt-check">
                            <input class="form-check-input bkt-check__input" type="checkbox" value="" id="">
                            <label class="form-check-label bkt-check__label" for="">
                                удалённые
                            </label>
                        </div>
                    </div>
                    <div class="bkt-check__list">
                        <div class="form-check bkt-check">
                            <input class="form-check-input bkt-check__input" type="checkbox" value="" id="">
                            <label class="form-check-label bkt-check__label" for="">
                                получен ответ организатора
                            </label>
                        </div>
                        <div class="form-check bkt-check form-check-inline">
                            <input class="form-check-input bkt-check__input" type="checkbox" value="" id="">
                            <label class="form-check-label bkt-check__label" for="">
                                завершённые
                            </label>
                        </div>
                        <div class="form-check bkt-check form-check-inline">
                            <input class="form-check-input bkt-check__input" type="checkbox" value="" id="">
                            <label class="form-check-label bkt-check__label" for="">
                                приостановленные
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bkt-main-cards bkt-card__list">
            <Card></Card>
        </div>
    </div>
@endsection
