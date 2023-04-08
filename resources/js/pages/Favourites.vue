<template>
    <div class="container bkt-page bkt-container">
        <h1 class="bkt-page__title">Избранное</h1>
        <div class="bkt-collection">
            <div
                class="bkt-collection__filters bkt-wrapper-column bkt-wrapper-down-md-column-reverse bkt-gap-down-md-mini">
                <div class="bkt-collection__filters-inner bkt-nowrap bkt-wrapper-between bkt-wrapper-down-md bkt-gap">
                    <div class="d-flex bkt-wrapper-down-md-between w-100 bkt-gap bkt-gap-down-md-mini px-1">
                        <!--                        <button class="bkt-button-icon bkt-collection__filters-action d-none d-md-block"-->
                        <!--                                :class="search_mode ? 'bkt-bg-primary shadow': 'bkt-bg-white'"-->
                        <!--                                @click="search_mode = !search_mode" :disabled="favourites_loading">-->
                        <!--                            <bkt-icon class="bkt-button__icon" :name="'Search'"-->
                        <!--                                      :color="search_mode ? 'white': 'primary'"></bkt-icon>-->
                        <!--                        </button>-->
                        <button
                            class="bkt-button bkt-collection__filters-action bkt-w-100"
                            data-bs-toggle="modal"
                            data-bs-target="#addPathModal"
                            :disabled="favourites_loading"
                        >
                            <span>
                                 <bkt-icon :name="'FolderAdd'" :color="'green'"
                                           width="16px" height="16px"></bkt-icon>
                            </span>
                            Создать папку
                        </button>
                        <button :disabled="favourites_loading" data-bs-toggle="modal"
                                data-bs-target="#fieldsToDocumentModal"
                                class="bkt-button bkt-collection__filters-action bkt-w-100">
                             <span>
                            <bkt-icon :name="'Download'" :color="'yellow'"
                                      width="16px" height="16px"></bkt-icon>
                             </span>
                            Скачать папку
                        </button>
                        <button
                            class="bkt-button bkt-collection__filters-action bkt-w-100"
                            data-bs-toggle="modal" data-bs-target="#editPathModal"
                            :disabled="favourites_loading"
                        >
                             <span>
                            <bkt-icon :name="'Settings'" :color="'pink'"
                                      width="16px" height="16px"></bkt-icon>
                             </span>
                            Редактировать папку
                        </button>
                        <button
                            class="bkt-button bkt-collection__filters-action bkt-w-100"
                            @click="removeFavouritePath"
                            :disabled="favourites_loading"
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
                <div class="bkt-form">
                    <div class="col-12">
                        <div class="bkt-menu__search">
                            <bkt-search v-model="params.includedWords" no_dropdown :loading="favourites_loading" simple
                                        @runSearch="getData(1)" search_class="bkt-register-collapse__search"
                                        placeholder="Нужные слова через запятую" :disabled="favourites_loading"
                            >
                            </bkt-search>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <bkt-select
                            v-model="params.sort.type"
                            class="w-100"
                            select_class="bkt-v-select_material white w-100"
                            name="sort"
                            subtitle="сортировать по"
                            :option_label="'title'"
                            :options="sort"
                            :reduce="item => item.value"
                            :clearable="false"
                            @input="getData(1)"
                        >
                            <!--                                    <template #subtitle>-->
                            <!--                                        <button class="bkt-button-icon bkt-bg-white flex-shrink-0 order-3"-->
                            <!--                                                :class="{'bkt-mirror-vertical' : params.sort.direction =='desc'}"-->
                            <!--                                                @click="toggleDirection"-->
                            <!--                                        >-->
                            <!--                                            <bkt-icon name="Bars"></bkt-icon>-->
                            <!--                                        </button>-->
                            <!--                                    </template>-->
                        </bkt-select>
                    </div>
                    <div class="col-12 col-md-6">
                        <!--                                <bkt-select-->
                        <!--                                    multiple-->
                        <!--                                    v-model="params.marks"-->
                        <!--                                    class="w-100"-->
                        <!--                                    select_class="white w-100"-->
                        <!--                                    name="mark"-->
                        <!--                                    label="метки"-->
                        <!--                                    label_class="bkt-form__label"-->
                        <!--                                    :option_label="'title'"-->
                        <!--                                    :options="marks"-->
                        <!--                                    :reduce="item => item.id"-->
                        <!--                                    :clearable="false"-->
                        <!--                                    :method_name="'getMarks'"-->
                        <!--                                    @input="getData(1)"-->
                        <!--                                >-->
                        <!--                                </bkt-select>-->
                        <bkt-select
                            v-model="params.sort.direction"
                            class="w-100"
                            select_class="bkt-v-select_material white w-100"
                            name="sort"
                            subtitle="направление сортировки"
                            :option_label="'title'"
                            :options="sort_directions"
                            :reduce="item => item.value"
                            :clearable="false"
                            @input="getData(1)"
                        >
                        </bkt-select>
                    </div>
                </div>
                <!--                <div class="bkt-wrapper-column bkt-nowrap d-md-none bkt-gap bkt-gap-down-md-mini">-->
                <!--&lt;!&ndash;                    <button class="bkt-button-icon flex-shrink-0"&ndash;&gt;-->
                <!--&lt;!&ndash;                            :class="search_mode ? 'bkt-bg-primary shadow': 'bkt-bg-white'"&ndash;&gt;-->
                <!--&lt;!&ndash;                            @click="search_mode = !search_mode"&ndash;&gt;-->
                <!--&lt;!&ndash;                    >&ndash;&gt;-->
                <!--&lt;!&ndash;                        <bkt-icon class="bkt-button__icon" :name="'Search'"&ndash;&gt;-->
                <!--&lt;!&ndash;                                  :color="search_mode ? 'white': 'primary'"></bkt-icon>&ndash;&gt;-->
                <!--&lt;!&ndash;                    </button>&ndash;&gt;-->
                <!--&lt;!&ndash;                    <button class="bkt-button-icon bkt-bg-white flex-shrink-0"&ndash;&gt;-->
                <!--&lt;!&ndash;                            :class="{'bkt-mirror-vertical' : params.sort.direction =='desc'}"&ndash;&gt;-->
                <!--&lt;!&ndash;                            @click="toggleDirection"&ndash;&gt;-->
                <!--&lt;!&ndash;                    >&ndash;&gt;-->
                <!--&lt;!&ndash;                        <bkt-icon name="Bars"></bkt-icon>&ndash;&gt;-->
                <!--&lt;!&ndash;                    </button>&ndash;&gt;-->
                <!--                    <bkt-select-->
                <!--                        v-model="params.sort.type"-->
                <!--                        class="w-100"-->
                <!--                        select_class="bkt-v-select_material w-100 main"-->
                <!--                        name="sort"-->
                <!--                        subtitle="сортировать по"-->
                <!--                        :option_label="'title'"-->
                <!--                        :options="sort"-->
                <!--                        :reduce="item => item.value"-->
                <!--                        :clearable="false"-->
                <!--                        @input="getData(1)"-->
                <!--                    >-->
                <!--                    </bkt-select>-->
                <!--                </div>-->
            </div>
            <!--            <div class="bkt-collection__paths-list">-->
            <div class="d-md-block d-none">
                <div class="bkt-wrapper my-0 align-items-center w-100 bkt-nowrap">
                    <div class="py-3 pe-3" v-show="items_paths.length > 1" @click="showPrev">
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 8 12"
                            fill="#ffc515"
                        >
                            <path
                                d="M8 1.42L3.42 6L8 10.59L6.59 12L0.59 6L6.59 1.23266e-07L8 1.42Z"
                            ></path>
                        </svg>
                    </div>
                    <div class="bkt-collection__paths-list"
                         :class="{'p-0' : items_paths.length==1}" v-if="items_paths.length>0">
                        <slick v-bind="settings" ref="carousel" style="overflow: hidden">
                            <div v-for="(path, index) in items_paths" :key="index">
                                <button
                                    @click="setCurrentPath(path.pathId)"
                                    class="bkt-button bkt-collection__path bkt-button_plump text-uppercase"
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
                        </slick>
                    </div>
                    <div class="py-3 ps-3" v-show="items_paths.length > 1" @click="showNext">
                        <svg
                            fill="#ffc515"
                            width="20"
                            height="20"
                            viewBox="0 0 8 12"
                        >
                            <path
                                d="M0 10.5801L4.58 6.00012L0 1.41012L1.41 0.00012207L7.41 6.00012L1.41 12.0001L0 10.5801Z"
                            ></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="d-block d-md-none">
                <bkt-collapse id="collapsePaths" main_class="bkt-collection__paths-collapse"
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
            <!--            </div>-->
            <bkt-card-list :current_component="'BktCard'" :items="items" :loading="favourites_loading" ref="card_list"
                           :pagination_data="pagination_data" @change-page="getData" @updateData="updateData"
            >
                <template #no_results>
                    <div class="bkt-shadow-card bkt-shadow-card_primary w-100">
                        <div class="bkt-shadow-card__inner bkt-gap">
                            <h3 class="bkt-shadow-card__title bkt-text-white">
                                Пока ничего нет
                            </h3>
                            <div class="bkt-shadow-card__shadow-1">
                            </div>
                            <div class="bkt-shadow-card__shadow-2">
                            </div>
                        </div>
                    </div>
                </template>
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
                sort_directions: [
                    {title: 'По возрастанию', value: "asc"},
                    {title: 'По убыванию', value: "desc"},
                ],
                params: {
                    pathId: 0,
                    marks: [],
                    searchField: '',
                    includedWords: '',
                    sort: {
                        direction: "desc",
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
            favourites_loading() {
                return this.$store.getters.favourites_loading || this.loading;
            },
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
                    pathId: this.current_path
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
                sessionStorage.setItem('favourite' + this.current_path + '_page', page+'');
                if (this.$refs.card_list) {
                    this.$refs.card_list.scrollToElement();
                }
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
                    let page = 1;
                    if (sessionStorage.getItem('favourite' + this.current_path + '_page')) {
                        page = sessionStorage.getItem('monitoring' + this.current_path + '_page')
                    }
                    this.params.page = page;
                    this.params.pathId = this.current_path;
                    this.$store.dispatch('getFavourites', this.params)
                        .finally(() => {
                            this.loading = false;
                        });

                }).catch(err => {
                    this.loading = false;
                });
            },
            async setCurrentPath(value) {
                this.loading = true;
                sessionStorage.setItem('favourite_path_id', value);
                await this.$store.dispatch('setCurrentPath', {pathId: value, params: this.params})
                    .finally(() => {
                        this.loading = false;
                    });
            },
            async removeFavouritePath() {
                this.$swal.fire({
                    title: 'Вы уверены?',
                    text: 'Вы уверены, что хотите удалить эту папку?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2953ff',
                    cancelButtonColor: '#ec4c27',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Отменить',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$store.dispatch('removeFavouritePath', this.current_path)
                            .then(resp => {
                                this.setCurrentPath(this.items_paths[0].pathId)
                            })
                    }
                })
            },
            updateData(payload) {
                if (payload.key === 'isHide' || payload.key === 'inFavourite' || payload.key === 'moveFavourite') {
                    let page = null;
                    if (payload.page) {
                        page = payload.page
                    }
                    this.getData(page)
                }
            },
            showPrev() {
                this.$refs.carousel.prev()
            },
            showNext() {
                this.$refs.carousel.next()
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
