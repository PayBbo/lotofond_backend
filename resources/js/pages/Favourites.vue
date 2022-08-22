<template>
    <div class="container bkt-page bkt-container">
        <h1 class="bkt-page__title">Избранное</h1>
        <div class="bkt-favourites">
            <div class="bkt-favourites__filters bkt-wrapper-column bkt-wrapper-down-md-column-reverse">
                <div class="bkt-favourites__filters-inner bkt-nowrap bkt-wrapper-between bkt-wrapper-down-md bkt-gap">
                    <div class="d-flex bkt-wrapper-down-md-between bkt-w-md-100 bkt-gap-small bkt-gap-down-sm-mini">
                        <button class="bkt-button-icon bkt-favourites__filters-action d-none d-md-block"
                                :class="search_mode ? 'bkt-bg-primary shadow': 'bkt-bg-white'"
                                @click="search_mode = !search_mode" :disabled="loading">
                            <bkt-icon class="bkt-button__icon" :name="'Search'"
                                      :color="search_mode ? 'white': 'primary'"></bkt-icon>
                        </button>
                        <button
                            class="bkt-button bkt-favourites__filters-action bkt-w-down-md-100"
                            data-bs-toggle="modal"
                            data-bs-target="#addPathModal"
                            :disabled="loading"
                        >
                            <span>
                                 <bkt-icon :name="'FolderAdd'" :color="'green'"
                                           width="16px" height="16px"></bkt-icon>
                            </span>
                            Создать папку
                        </button>
                        <!--                        <button :disabled="loading"-->
                        <!--                            class="bkt-button bkt-favourites__filters-action bkt-w-down-md-100">-->
                        <!--                             <span>-->
                        <!--                            <bkt-icon :name="'FileArrowLeft'" :color="'blue'"-->
                        <!--                                      width="16px" height="16px"></bkt-icon>-->
                        <!--                             </span>-->
                        <!--                            <span class="d-none d-xl-block">Переместить</span>-->
                        <!--                        </button>-->
                        <button :disabled="loading" data-bs-toggle="modal"
                                data-bs-target="#fieldsToDocumentModal"
                                class="bkt-button bkt-favourites__filters-action bkt-w-down-md-100">
                             <span>
                            <bkt-icon :name="'Download'" :color="'yellow'"
                                      width="16px" height="16px"></bkt-icon>
                             </span>
                            Скачать папку
                        </button>
                        <button
                            class="bkt-button bkt-favourites__filters-action bkt-w-down-md-100"
                            data-bs-toggle="modal" data-bs-target="#editPathModal"
                            :disabled="loading"
                        >
                             <span>
                            <bkt-icon :name="'Settings'" :color="'pink'"
                                      width="16px" height="16px"></bkt-icon>
                             </span>
                            Редактировать папку
                        </button>
                        <button
                            class="bkt-button bkt-favourites__filters-action bkt-w-down-md-100"
                            @click="removeFavouritePath"
                            :disabled="loading"
                        >
                             <span>
                            <bkt-icon :name="'FolderDelete'" :color="'red'"
                                      width="16px" height="16px"></bkt-icon>
                             </span>
                            Удалить папку
                        </button>
                    </div>
<!--                    <bkt-select-->
<!--                        v-model="group"-->
<!--                        class="d-none d-md-block"-->
<!--                        select_class="bkt-v-select_material w-100 main"-->
<!--                        name="sort"-->
<!--                        subtitle="сгруппировать"-->
<!--                        :reduce="item => item.value"-->
<!--                        :option_label="'title'"-->
<!--                        :options="to_group"-->
<!--                        :clearable="false"-->
<!--                    >-->
<!--                    </bkt-select>-->
                </div>
                <div class="bkt-favourites__filters-card bkt-wrapper-column bkt-gap-large" v-if="search_mode">
                    <div class="bkt-menu__search">
                        <bkt-search v-model="params.includedWords" no_dropdown :loading="loading" simple
                                    @runSearch="getData(1)" search_class="bkt-register-collapse__search"
                                    placeholder="Нужные слова через запятую" :disabled="loading"
                        >
                        </bkt-search>
                    </div>
                    <div class="bkt-menu__group-fields">
                        <div class="bkt-form">
                            <div class="col-12 col-md-6 d-none d-md-block">
                                <bkt-select
                                    v-model="params.sort.type"
                                    class="w-100"
                                    select_class="white w-100 bkt-wrapper bkt-nowrap bkt-gap"
                                    additional_class=" w-100 "
                                    name="sort"
                                    label="сортировать по"
                                    label_class="bkt-form__label"
                                    :option_label="'title'"
                                    :options="sort"
                                    :reduce="item => item.value"
                                    :clearable="false"
                                    @input="getData(1)"
                                >
                                    <template #subtitle>
                                        <button class="bkt-button-icon bkt-bg-white flex-shrink-0 order-3"
                                                :class="{'bkt-mirror-vertical' : params.sort.direction =='desc'}"
                                                @click="toggleDirection"
                                        >
                                            <bkt-icon name="Bars"></bkt-icon>
                                        </button>
                                    </template>
                                </bkt-select>
                            </div>
                            <div class="col-12 col-md-6">
                                <bkt-select
                                    v-model="params.mark"
                                    class="w-100"
                                    select_class="white w-100"
                                    name="mark"
                                    label="метка"
                                    label_class="bkt-form__label"
                                    :option_label="'title'"
                                    :options="marks"
                                    :reduce="item => item.value"
                                    :clearable="false"
                                    :method_name="'getMarks'"
                                    @input="getData(1)"
                                >
                                </bkt-select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bkt-wrapper-between bkt-nowrap d-md-none bkt-gap">
                    <button class="bkt-button-icon flex-shrink-0"
                            :class="search_mode ? 'bkt-bg-primary shadow': 'bkt-bg-white'"
                            @click="search_mode = !search_mode"
                    >
                        <bkt-icon class="bkt-button__icon" :name="'Search'"
                                  :color="search_mode ? 'white': 'primary'"></bkt-icon>
                    </button>
                    <button class="bkt-button-icon bkt-bg-white flex-shrink-0"
                            :class="{'bkt-mirror-vertical' : params.sort.direction =='desc'}"
                            @click="toggleDirection"
                    >
                        <bkt-icon name="Bars"></bkt-icon>
                    </button>
                    <bkt-select
                        v-model="params.sort.type"
                        class="w-100"
                        select_class="bkt-v-select_material w-100 main"
                        name="sort"
                        subtitle="сортировать по"
                        :option_label="'title'"
                        :options="sort"
                        :reduce="item => item.value"
                        :clearable="false"
                        @input="getData(1)"
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
                           :pagination_data="pagination_data" @change-page="getData" @updateData="updateData"
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
                group: 'по порядку добавления',
                to_group: [
                    {title: 'по порядку добавления', value: "publishDate"},
                ],
                settings: {
                    "dots": false,
                    "infinite": false,
                    "centerMode": false,
                    "centerPadding": "20px",
                    "slidesToShow": 1,
                    "slidesToScroll": 1,
                    "variableWidth": true
                },
                sort: [
                    {title: 'Дате добавления', value: "publishDate"},
                    {title: 'Цене', value: "currentPrice"},
                    {title: 'Дате начала торгов', value: "eventStart"},
                    {title: 'Дате окончания торгов', value: "eventEnd"},
                    {title: 'Дате начала приема заявок', value: "applicationStart"},
                    {title: 'Дате окончания приема заявок', value: "applicationEnd"},
                ],
                params: {
                    pathId: 0,
                    marks:[],
                    searchField:'',
                    includedWords: '',
                    sort: {
                        direction: "asc",
                        type: "publishDate"
                    }
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
            },
            marks() {
                return this.$store.getters.marks;
            },
        },
        methods: {
            async getData(page = 1) {
                this.loading = true;
                this.params.page = page;
                this.params.pathId = this.current_path;
                await this.$store.dispatch('getFavourites', this.params).finally(() => {
                    this.loading = false;
                });
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
                await this.$store.dispatch('setCurrentPath', {pathId: value, params: this.params})
                    .finally(() => {
                        this.loading = false;
                    });
            },
            async removeFavouritePath() {
                await this.$store.dispatch('removeFavouritePath', this.current_path)
                    .then(resp => {
                        this.setCurrentPath(this.items_paths[0].pathId)
                    });
            },
            updateData(payload) {
                if(payload.key ==='isHide' || payload.key ==='inFavourite' || payload.key === 'moveFavourite') {
                    let page = null;
                    if(payload.page) {
                        page = payload.page
                    }
                    this.getData(page)
                }
            },
            toggleDirection() {
                if (this.params.sort.direction == 'asc') {
                    this.params.sort.direction = 'desc';
                } else {
                    this.params.sort.direction = 'asc';
                }
                this.getData(1)
            },
        }
    }
</script>

<style scoped>

</style>
