<template>
    <div class="container bkt-main bkt-container">
        <bkt-modal></bkt-modal>
        <h1 class="bkt-main-title text-center">Электронные торги по банкротству</h1>
        <div class="bkt-search position-relative bg-white">
            <input class="w-100 bkt-search__input" type="text" placeholder="Введите нужное слово или фразу">
            <button class="bkt-button green bkt-search__button">
                <span class="d-none d-md-block">Найти</span>
                <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
            </button>
        </div>
        <div class="bkt-main-categories bkt-card__list">
            <div class="bkt-card__row">
                <div class="col-10">
                    <h4 class="bkt-card__title">Выберите<br> нужные категории</h4>
                    <h5 class="bkt-card__subtitle bkt-text-green">выбрано 4</h5>
                    <button class="bkt-button primary-lighter" data-bs-toggle="modal" data-bs-target="#bkt-modal">
                        Изменить
                    </button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bkt-bg-green ms-auto">
                        <span class="bkt-card__category-icon">
                            <bkt-icon :name="'Category'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card__row">
                <div class="col-10">
                    <h4 class="bkt-card__title">Выберите<br> регион</h4>
                    <h5 class="bkt-card__subtitle">ничего не выбрано</h5>
                    <button class="bkt-button primary">Выбрать</button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bkt-bg-red-lighter ms-auto">
                        <span class="bkt-card__category-icon">
                             <bkt-icon :name="'Location'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card__row">
                <div class="col-10">
                    <h4 class="bkt-card__title">Выберите основные<br> параметры объекта</h4>
                    <h5 class="bkt-card__subtitle">ничего не выбрано</h5>
                    <button class="bkt-button primary">Выбрать</button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bkt-bg-purple-lighter  ms-auto">
                        <span class="bkt-card__category-icon">
                             <bkt-icon :name="'Options'" :fill="'#ff41be'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card__row">
                <div class="col-10">
                    <h4 class="bkt-card__title">Выберите<br> стоимость объекта</h4>
                    <h5 class="bkt-card__subtitle">ничего не выбрано</h5>
                    <button class="bkt-button primary">Выбрать</button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bkt-bg-yellow-lighter ms-auto">
                        <span class="bkt-card__category-icon">
                            <bkt-icon :name="'Wallet'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card__row">
                <div class="col-10">
                    <h4 class="bkt-card__title">Выберите<br> дату торгов</h4>
                    <h5 class="bkt-card__subtitle bkt-text-green">выбрано 2</h5>
                    <button class="bkt-button primary-lighter">Изменить</button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bkt-bg-blue ms-auto">
                        <span class="bkt-card__category-icon">
                            <bkt-icon :name="'Date'" :fill="'#fff'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
            <div class="bkt-card__row">
                <div class="col-10">
                    <h4 class="bkt-card__title">Выберите<br> доп. параметры</h4>
                    <h5 class="bkt-card__subtitle">ничего не выбрано</h5>
                    <button class="bkt-button primary">Выбрать</button>
                </div>
                <div class="col-2">
                    <div class="bkt-card__category bkt-bg-primary-lighter ms-auto">
                        <span class="bkt-card__category-icon">
                            <bkt-icon :name="'Clone'"></bkt-icon>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bkt-main-statistic bkt-card__list">
            <div class="bkt-card__row bkt-bg-red-light position-relative">
                <h5 class="bkt-card__text">Всего лотов</h5>
                <h1 class="bkt-card__title">58 961</h1>
                <div class="bkt-card bkt-card__background-figure-1">
                </div>
                <div class="bkt-card bkt-card__background-figure-2 bkt-bg-red-light">
                </div>
            </div>
            <div class="bkt-card__row bkt-bg-yellow position-relative">
                <h5 class="bkt-card__text">Активных лотов</h5>
                <h1 class="bkt-card__title">4 372</h1>
                <div class="bkt-card bkt-card__background-figure-1">
                </div>
                <div class="bkt-card bkt-card__background-figure-2 bkt-bg-yellow">
                </div>
            </div>
            <div class="bkt-card__row bkt-bg-blue position-relative">
                <h5 class="bkt-card__text">Добавлено сегодня</h5>
                <h1 class="bkt-card__title">64</h1>
                <div class="bkt-card bkt-card__background-figure-1">
                </div>
                <div class="bkt-card bkt-card__background-figure-2 bkt-bg-blue">
                </div>
            </div>
        </div>
        <div class="bkt-main-filters bkt-row bkt-bg-main">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="d-flex w-100 mx-auto justify-content-around">
                    <div class="form-floating bkt-select__wrapper main">
                        <select class="form-select bkt-select" id="sortSelect" aria-label="">
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
                <div class="form-floating bkt-select__wrapper main">
                    <select class="form-select bkt-select" id="periodSelect" aria-label="">
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
                        <div class="bkt-check__wrapper">
                            <div class="bkt-check">
                                <div class="bkt-check__input">
                                    <input class="" type="checkbox">
                                    <div class="bkt-check__input-check"></div>
                                </div>
                                <label class="bkt-check__label">
                                    только с фото
                                </label>
                            </div>
                        </div>
                        <div class="bkt-check__wrapper">
                            <div class="bkt-check">
                                <div class="bkt-check__input">
                                    <input class="" type="checkbox">
                                    <div class="bkt-check__input-check"></div>
                                </div>
                                <label class="bkt-check__label">
                                    удалённые
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="bkt-check__list">
                        <div class="bkt-check__wrapper">
                            <div class="bkt-check">
                                <div class="bkt-check__input">
                                    <input class="" type="checkbox">
                                    <div class="bkt-check__input-check"></div>
                                </div>
                                <label class="bkt-check__label">
                                    получен ответ организатора
                                </label>
                            </div>
                        </div>
                        <div class="bkt-check__wrapper bkt-check__wrapper-inline">
                            <div class="bkt-check">
                                <div class="bkt-check__input">
                                    <input class="" type="checkbox">
                                    <div class="bkt-check__input-check"></div>
                                </div>
                                <label class="bkt-check__label">
                                    завершённые
                                </label>
                            </div>
                        </div>
                        <div class="bkt-check__wrapper bkt-check__wrapper-inline">
                            <div class="bkt-check">
                                <div class="bkt-check__input">
                                    <input class="" type="checkbox">
                                    <div class="bkt-check__input-check"></div>
                                </div>
                                <label class="bkt-check__label">
                                    приостановленные
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <bkt-card-list :current_component="'BktCard'" :items="items" :loading="loading"
                       no_pagination :pagination_data="pagination_data">
        </bkt-card-list>
    </div>
</template>

<script>
    export default {
        name: "Main",
        mounted() {
            this.getData()
        },
        data() {
            return {
                loading: false,
                // pagination
                pagination_data: {},
                // table
                items: [{id: 1, label: 'Test'}],
                in_process: []
            };
        },
        methods: {
            async getData(page = 1) {
                this.loading = true;
                await axios
                    .get('/api/trades?page=' + page, {
                        params: {
                            page: page,
                        },
                    })
                    .then((resp) => {
                        this.loading = false;
                        // if (resp.data.data) {
                            this.items = resp.data;
                            // this.pagination_data = resp.data;
                        // }
                    })
                    .catch((error) => {
                        this.loading = false;
                    });
            },
        }
    }
</script>

<style scoped>

</style>
