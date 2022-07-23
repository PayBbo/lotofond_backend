<template>
    <div class="container bkt-page bkt-container">
        <h1 class="bkt-page__title">Избранное</h1>
        <div class="bkt-favourites">
            <div class="bkt-favourites__filters bkt-wrapper-column bkt-wrapper-down-md-column-reverse">
                <div class="bkt-favourites__filters-inner bkt-nowrap bkt-wrapper-between bkt-wrapper-down-md bkt-gap">
                    <div class="d-flex bkt-wrapper-down-md-between bkt-w-md-100 bkt-gap-small bkt-gap-down-sm-mini">
                        <button class="bkt-button-icon bkt-favourites__filters-action d-none d-md-block"
                                :class="search_mode ? 'bkt-bg-primary shadow': 'bkt-bg-white'"
                                @click="search_mode = !search_mode">
                            <bkt-icon class="bkt-button__icon" :name="'Search'"
                                      :color="search_mode ? 'white': 'primary'"></bkt-icon>
                        </button>
                        <button
                            class="bkt-button bkt-favourites__filters-action"
                            data-bs-toggle="modal"
                            data-bs-target="#addPathModal"
                            :disabled="loading"
                        >
                            <span>
                                 <bkt-icon :name="'FolderAdd'" :color="'green'"
                                           width="16px" height="16px"></bkt-icon>
                            </span>
                            <span class="d-none d-xl-block">Создать папку</span>
                        </button>
                        <!--                        <button :disabled="loading"-->
                        <!--                            class="bkt-button bkt-favourites__filters-action">-->
                        <!--                             <span>-->
                        <!--                            <bkt-icon :name="'FileArrowLeft'" :color="'blue'"-->
                        <!--                                      width="16px" height="16px"></bkt-icon>-->
                        <!--                             </span>-->
                        <!--                            <span class="d-none d-xl-block">Переместить</span>-->
                        <!--                        </button>-->
                        <button :disabled="loading" data-bs-toggle="modal"
                                data-bs-target="#fieldsToDocumentModal"
                                class="bkt-button bkt-favourites__filters-action">
                             <span>
                            <bkt-icon :name="'Download'" :color="'yellow'"
                                      width="16px" height="16px"></bkt-icon>
                             </span>
                            <span class="d-none d-xl-block">Скачать</span>
                        </button>
                        <button
                            class="bkt-button bkt-favourites__filters-action"
                            data-bs-toggle="modal" data-bs-target="#editPathModal"
                            :disabled="loading"
                        >
                             <span>
                            <bkt-icon :name="'Settings'" :color="'pink'"
                                      width="16px" height="16px"></bkt-icon>
                             </span>
                            <span class="d-none d-xl-block">Редактировать</span>
                        </button>
                        <button
                            class="bkt-button bkt-favourites__filters-action"
                            @click="removeFavouritePath"
                            :disabled="loading"
                        >
                             <span>
                            <bkt-icon :name="'FolderDelete'" :color="'red'"
                                      width="16px" height="16px"></bkt-icon>
                             </span>
                            <span class="d-none d-xl-block">Удалить</span>
                        </button>
                    </div>
                    <bkt-select
                        v-model="group"
                        class="d-none d-md-block"
                        select_class="bkt-v-select_material w-100 main"
                        name="sort"
                        subtitle="сгруппировать"
                        :reduce="item => item.value"
                        :option_label="'title'"
                        :options="to_group"
                        :clearable="false"
                    >
                    </bkt-select>
                </div>
                <div class="bkt-favourites__filters-card bkt-wrapper-column bkt-gap-large" v-if="search_mode">
                    <div class="bkt-menu__search">
                        <div class="bkt-search position-relative">
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
                        <div class="bkt-form">
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
                <div class="bkt-wrapper-between bkt-nowrap d-md-none bkt-gap">
                    <button class="bkt-button-icon" :class="search_mode ? 'bkt-bg-primary shadow': 'bkt-bg-white'"
                            @click="search_mode = !search_mode">
                        <bkt-icon class="bkt-button__icon" :name="'Search'"
                                  :color="search_mode ? 'white': 'primary'"></bkt-icon>
                    </button>
                    <bkt-select
                        v-model="group"
                        class="w-100"
                        select_class="bkt-v-select_material w-100 main"
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
            <div class="bkt-favourites__paths-list">
                <div class="d-md-block d-none">
                    <slick v-bind="settings" v-if="items_paths.length>0">
                        <div v-for="(path, index) in items_paths" :key="index">
                            <button
                                @click="setCurrentPath(path.pathId)"
                                class="bkt-button bkt-favourites__path bkt-button_plump text-uppercase"
                                :class="[current_path === path.pathId && path.color ? 'bkt-bg-'+path.color : '',
                                {'bkt-bg-primary': current_path === path.pathId && !path.color,
                                'bkt-bg-white bkt-text-main': current_path !== path.pathId}]"
                            >
                                {{path.name}}
                                <span class="bkt-badge"
                                      :class="[
                                          path.color ? 'bkt-text-'+path.color : 'bkt-text-primary',
                                          current_path !== path.pathId && path.color ? 'bkt-bg-'+path.color+'-lighter' : '',
                                          {
                                              'bkt-bg-white': current_path === path.pathId,
                                              'bkt-bg-primary-lighter': current_path !== path.pathId && !path.color
                                          }
                                      ]"
                                >
                                    {{path.lotCount ? path.lotCount : '0'}}
                                </span>
                            </button>
                        </div>
                        <template #prevArrow="arrowOption">
                            <svg
                                width="8"
                                height="12"
                                viewBox="0 0 8 12"
                                fill="#ffc515"
                            >
                                <path
                                    d="M8 1.42L3.42 6L8 10.59L6.59 12L0.59 6L6.59 1.23266e-07L8 1.42Z"
                                ></path>
                            </svg>
                        </template>
                        <template #nextArrow="arrowOption">
                            <svg
                                fill="#ffc515"
                                width="8"
                                height="12"
                                viewBox="0 0 8 12"
                            >
                                <path
                                    d="M0 10.5801L4.58 6.00012L0 1.41012L1.41 0.00012207L7.41 6.00012L1.41 12.0001L0 10.5801Z"
                                ></path>
                            </svg>
                        </template>
                    </slick>
                </div>
                <div class="d-block d-md-none">
                    <bkt-collapse id="collapsePaths" main_class="bkt-favourites__path-collapse"
                                  :header_class="current_path_object.color ? 'bkt-bg-'+current_path_object.color : 'bkt-bg-primary'"
                                  :collapse_button_class="items_paths.length>1 ? 'bkt-bg-white' : 'd-none'"
                    >
                        <template #title v-if="items_paths.length>0">
                            <h6 class="mx-auto">
                                {{current_path_object.name}}
                                <span class="bkt-badge bkt-bg-white"
                                      :class="current_path_object.color ? 'bkt-text-'+current_path_object.color : 'bkt-text-primary'"
                                >
                                    {{current_path_object.lotCount ? current_path_object.lotCount : '0'}}
                                </span>
                            </h6>
                        </template>
                        <template #collapse v-if="items_paths.length>0">
                            <div class="bkt-wrapper-column bkt-gap">
                                <button v-for="(path, index) in items_paths" :key="index"
                                        @click="setCurrentPath(path.pathId)"
                                        v-if="path.pathId !== current_path"
                                        class="w-100 bkt-button bkt-button_plump text-uppercase bkt-bg-white bkt-text-main text-center"
                                >
                                    {{path.name}}
                                    <span class="bkt-badge"
                                          :class="path.color ? 'bkt-bg-'+path.color+'-lighter bkt-text-'+path.color
                                      : 'bkt-text-primary bkt-bg-primary-lighter'"
                                    >
                                    {{path.lotCount ? path.lotCount : '0'}}
                                </span>
                                </button>
                            </div>

                        </template>
                    </bkt-collapse>
                </div>
            </div>
            <bkt-card-list :current_component="'BktCard'" :items="items" :loading="loading"
                           :pagination_data="pagination_data" @change-page="getData"
                           infinite method_name="getFavourites" :method_params="method_params"
            >
            </bkt-card-list>
        </div>

        <bkt-add-path-modal></bkt-add-path-modal>
        <bkt-edit-path-modal></bkt-edit-path-modal>
        <bkt-excel-modal></bkt-excel-modal>
    </div>
</template>

<script>
    import AddPathModal from "./Favourites/AddPathModal";
    import EditPathModal from "./Favourites/EditPathModal";
    import MoveFavouriteModal from "./Favourites/MoveFavouriteModal";
    import Select from "../components/Select";
    import BktCollapse from "../components/Collapse";
    import AddFieldsToDocument from "./Favourites/AddFieldsToDocument";

    export default {
        name: "Favourites",
        components: {
            'bkt-select': Select,
            'bkt-add-path-modal': AddPathModal,
            'bkt-edit-path-modal': EditPathModal,
            'bkt-move-favourite-modal': MoveFavouriteModal,
            'bkt-excel-modal': AddFieldsToDocument,
            BktCollapse
        },
        created() {
            this.getFavouritePaths();
            // this.getData();
        },

        mounted() {
        },
        data() {
            return {
                loading: false,
                search_mode: false,
                selectedBtn: 0,
                group: 'по порядку добавления',
                to_group: [
                    {title: 'по порядку добавления', value: "publishDate"},
                    {title: 'по порядку добавления2', value: "publishDate1"},
                    {title: 'по порядку добавления3s', value: "publishDate2"},
                ],
                settings: {
                    "dots": false,
                    "infinite": false,
                    "centerMode": false,
                    "centerPadding": "20px",
                    "slidesToShow": 1,
                    "slidesToScroll": 1,
                    "variableWidth": true
                }
            };
        },
        computed: {
            items() {
                return this.$store.getters.current_favourites;
            },
            pagination_data() {
                return this.$store.getters.favourites_pagination;
            },
            // favourites_loading() {
            //     return this.$store.getters.favourites_loading;
            // },
            items_paths() {
                return this.$store.getters.favourites_paths;
            },
            current_path() {
                return this.$store.getters.current_path;
            },
            current_path_object() {
                let index = this.items_paths.findIndex(item => item.pathId == this.current_path)
                if (index >= 0) {
                    return this.items_paths[index];
                }
                return {}
            },
            // current_path: {
            //     get() {
            //         return this.$store.getters.current_path;
            //     },
            //     set(value) {
            //         this.$store.dispatch('setCurrentPath', value);
            //     }
            // },
            method_params() {
                return {
                    pathId:this.current_path
                }
            }
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
            async setCurrentPath(value) {
                this.loading = true;
                await this.$store.dispatch('setCurrentPath', value)
                    .finally(() => {
                        this.loading = false;
                    });
            },
            async removeFavouritePath() {
                await this.$store.dispatch('removeFavouritePath', this.current_path)
                    .then(resp => {
                        this.setCurrentPath(this.items_paths[0].pathId)
                    });
            }

        }
    }
</script>

<style scoped>

</style>
