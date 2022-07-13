<template>
    <div class="container bkt-page bkt-favourites bkt-container">
        <h1 class="bkt-page__title">Избранное</h1>
        <div class="bkt-favourites__menu">
            <div class="bkt-menu__actions">
                <div class="bkt-actions__title d-flex justify-content-between align-items-center">
                    <div class="bkt-actions-search">
                        <button class="btn bkt-btn" :class="{'active shadow': selectedBtn === 1}"
                                @click="selectedBtn = 1">
                            <bkt-icon class="bkt-button__icon" :name="'Search'" :color="'primary'"></bkt-icon>
                        </button>
                    </div>
                    <div class="bkt-actions-buttons">
                        <button class="btn bkt-btn d-flex align-items-center" @click="selectedBtn = 2">
                            <bkt-icon class="bkt-button__icon mr-2" :name="'FolderAdd'" :color="'green'"
                                      :width="'20px'" :height="'20px'"></bkt-icon>
                            <span class="d-none d-md-block">Создать папку</span>
                        </button>
                        <button class="btn bkt-btn d-flex align-items-center" @click="selectedBtn = 3">
                            <bkt-icon class="bkt-button__icon mr-2" :name="'FileArrowLeft'" :color="'blue'"
                                      :width="'16px'"></bkt-icon>
                            <span class="d-none d-md-block">Переместить</span>
                        </button>
                        <button class="btn bkt-btn d-flex align-items-center" @click="selectedBtn = 4">
                            <bkt-icon class="bkt-button__icon mr-2" :name="'Download'" :color="'yellow'"
                                      :width="'16px'"></bkt-icon>
                            <span class="d-none d-md-block">Скачать</span>
                        </button>
                        <button class="btn bkt-btn d-flex align-items-center" @click="selectedBtn = 5">
                            <bkt-icon class="bkt-button__icon mr-2" :name="'Settings'" :color="'pink'"
                                      :width="'16px'"></bkt-icon>
                            <span class="d-none d-md-block">Редактировать</span>
                        </button>
                        <button class="btn bkt-btn d-flex align-items-center" @click="selectedBtn = 6">
                            <bkt-icon class="bkt-button__icon mr-2" :name="'FolderDelete'" :color="'red'" width="20px"
                                      height="20px"></bkt-icon>
                            <span class="d-none d-md-block">Удалить</span>
                        </button>
                    </div>
                    <!--                    <div class="bkt-favourites-group position-relative">-->
                    <!--                        <bkt-icon class="bkt-group-arrow bkt-button__icon position-absolute" :name="'ArrowDown'" width="20px"-->
                    <!--                                  height="20px"></bkt-icon>-->
                    <!--                        <div class="bkt-select__wrapper">-->
                    <!--                            <label class="bkt-select__subtitle position-absolute" for="sortSelect">сгруппировать</label>-->
                    <!--                            <select class="form-select bkt-select form-floating main" id="sortSelect" aria-label="">-->
                    <!--                                <option selected>по порядку добавления</option>-->
                    <!--                                <option value="1">One</option>-->
                    <!--                                <option value="2">Two</option>-->
                    <!--                                <option value="3">Three</option>-->
                    <!--                            </select>-->

                    <!--                        </div>-->
                    <!--                    </div>-->
                    <div class="bkt-favourites-group position-relative">
                        <bkt-select
                            v-model="group"
                            select_class="form-floating main"
                            name="sort"
                            subtitle="сгруппировать"
                            :reduce="item => item.value"
                            :option_label="'title'"
                            :options="to_group"
                            :clearable="false"
                        >
                        </bkt-select>
                    </div>

                </div>

                <div class="bkt-sort-and-search" v-if="selectedBtn === 1">
                    <div class="bkt-menu__search">
                        <div class="bkt-search position-relative bg-white bkt-bg-item-neutral">
                            <input class="w-100 bkt-search__input d-md-block d-none" type="text"
                                   placeholder="Введите нужное слово или фразу">
                            <input class="w-100 bkt-search__input d-md-none d-block" type="text" placeholder="Поиск...">
                            <button class="bkt-button green bkt-search__button">
                                <span class="d-none d-md-block">Найти</span>
                                <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
                            </button>
                        </div>
                    </div>

                    <div class="bkt-menu__group-fields">
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="bkt-select__wrapper text-left">
                                    <label for="group" class="bkt-select__label">группа</label>
                                    <select id="group" class="bkt-select">
                                        <option selected value="">Текущая</option>
                                        <option>One</option>
                                        <option>Two</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="bkt-select__wrapper text-left">
                                    <label for="label" class="bkt-select__label">метка</label>
                                    <select id="label" class="bkt-select">
                                        <option selected value="">Метка 1</option>
                                        <option>One</option>
                                        <option>Two</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="bkt-select__wrapper text-left bkt-sort-by">
                                    <label for="sort" class="bkt-select__label">сортировать по</label>
                                    <select id="sort" class="bkt-select">
                                        <option selected value="">Добавлению в избранное</option>
                                        <option>One</option>
                                        <option>Two</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bkt-menu">
                <div class="bkt-monitoring__menu d-flex justify-content-between">
                    <div class="bkt-monitoring__menu-buttons d-md-block d-none">
                        <button v-for="path in items_paths"
                            class="bkt-button bkt-bg-primary bkt-button_plump">
                            {{path.name}}
                            <span class="bkt-text-primary bkt-bg-white bkt-badge">{{pagination_data.total}}</span>
                        </button>
<!--                        <button class="bkt-button bkt-button-menu bkt-menu-button bkt-menu-button__monitoring bkt-card__text d-inline-flex-->
<!--                        align-items-center position-relative mr-2">-->
<!--                            <span>АВТО</span>-->
<!--                            <div class="bkt-count p-1 ml-2">-->
<!--                                <span class="p-1">5</span>-->
<!--                            </div>-->
<!--                        </button>-->
<!--                        <button class="bkt-button bkt-button-menu bkt-menu-button bkt-menu-button__flats bkt-bg-white bkt-card__text-->
<!--                         position-relative d-inline-flex align-items-center mr-2">-->
<!--                            <span>КВАРТИРЫ</span>-->
<!--                            <div class="bkt-count p-1 ml-2">-->
<!--                                <span class="">2</span>-->
<!--                            </div>-->
<!--                        </button>-->
                    </div>
                    <div class="d-flex d-md-none">
                        <div class="mr-2 w-100">
                            <button class="d-flex position-relative bkt-btn-folder w-100 bkt-button
                  p-4 align-items-center justify-content-center">
                                <div class="d-flex justify-content-center">
                                    <span class="d-flex align-items-center p-1 text-uppercase">Общая папка</span>
                                    <div class="bkt-bg-white bkt-text-primary rounded-pill p-1">
                                        <span class="p-1">{{pagination_data.total}}</span>
                                    </div>
                                </div>
                                <div class="bkt-arrow bkt-bg-white rounded position-absolute">
                                    <bkt-icon :name="'ArrowDown'" :color="'primary'"></bkt-icon>
                                </div>
                            </button>

<!--                            <div class="bkt-menu-monitoring bkt-bg-white d-none shadow">-->
<!--                                <ul class="list-inline bkt-menu-monitoring-list">-->
<!--                                    <li class="bkt-menu-monitoring-list__item">-->
<!--                                        <div class="d-flex justify-content-center">-->
<!--                                            <span class="d-flex align-items-center p-1 text-uppercase">Квартиры</span>-->
<!--                                            <div class="bkt-bg-blue-lighter bkt-text-blue rounded-pill p-1">-->
<!--                                                <span class="p-1">2</span>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li class="bkt-menu-monitoring-list__item">-->
<!--                                        <div class="d-flex justify-content-center">-->
<!--                                            <span class="d-flex align-items-center p-1 text-uppercase">Квартиры</span>-->
<!--                                            <div class="bkt-bg-red-lighter bkt-text-red rounded-pill p-1">-->
<!--                                                <span class="p-1">2</span>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <bkt-card-list :current_component="'BktCard'" :items="items" :loading="loading"
                       :pagination_data="pagination_data" @change-page="getData">
        </bkt-card-list>
    </div>
</template>

<script>
    import Select from "../components/Select";

    export default {
        name: "Favourites",
        components: {
            'bkt-select': Select
        },
        created() {
            this.getFavouritePaths();
            // this.getData();
        },

        mounted() {
            // $(".bkt-arrow").click(function () {
            //     $(this).toggleClass("bkt-rotate-180");
            //     $(".bkt-btn-monitoring").toggleClass("bkt-border-bottom-rounded-none");
            //     $(".bkt-menu-monitoring").toggleClass("d-none");
            // });
            // $(".bkt-button-menu").click(function () {
            //     $(".bkt-button-menu").removeClass("active").removeClass("shadow");
            //     $(this).addClass("active").addClass("shadow");
            // });
        },
        data() {
            return {
                loading: false,
                selectedBtn: 0,
                group: 'по порядку добавления',
                to_group: [
                    {title: 'по порядку добавления', value: "publishDate"},
                ]
            };
        },
        computed: {
            items() {
                return this.$store.getters.favourites;
            },
            pagination_data() {
                return this.$store.getters.favourites_pagination;
            },
            favourites_loading() {
                return this.$store.getters.favourites_loading;
            },
            items_paths() {
                return this.$store.getters.favourites_paths;
            },
            current_path() {
                return this.$store.getters.current_path;
            },
        },
        methods: {
            async getData(page = 1, pathId) {
                await this.$store.dispatch('getFavourites', {page: page, pathId: pathId});
            },
            async getFavouritePaths() {
                this.loading = true;
                await this.$store.dispatch('getFavouritePaths').then(response => {
                    // this.$store.commit('setFavouritePaths', response.data)
                    // this.$store.commit('setCurrentPath', response.data[0].pathId)
                    // this.getData(1, this.current_path)
                    this.$store.dispatch('getFavourites', {page: 1, pathId: this.current_path})
                        .finally(() => {
                            this.loading = false;
                        });

                }).catch(err => {
                    this.loading = false;
                });
            },
        }
    }
</script>

<style scoped>

</style>
