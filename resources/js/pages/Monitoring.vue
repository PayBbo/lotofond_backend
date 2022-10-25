<template>
    <div class="bkt-page bkt-container">
        <add-monitoring-modal/>
        <edit-monitoring-modal/>
        <h1 class="bkt-page__title">Мониторинг</h1>
        <section class="bkt-monitoring">
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
                            data-bs-target="#addMonitoringModal"
                            :disabled="loading"
                        >
                            <span class="">
                                <bkt-icon :name="'FolderAdd'" :color="'green'" width="20px" height="20px"></bkt-icon>
                            </span>
                            Создать мониторинг
                        </button>
                        <button
                            class="bkt-button bkt-favourites__filters-action bkt-w-down-md-100"
                            data-bs-toggle="modal" data-bs-target="#editMonitoringModal"
                            :disabled="loading"
                        >
                            <span class="">
                                <bkt-icon :name="'Settings'" :color="'pink'" width="16px" height="16px"></bkt-icon>
                            </span>
                            Редактировать мониторинг
                        </button>
                        <button
                            class="bkt-button bkt-favourites__filters-action bkt-w-down-md-100"
                            @click="removeMonitoringPath"
                            :disabled="loading"
                        >
                            <span class="">
                                <bkt-icon :name="'FolderDelete'" :color="'red'" width="20px" height="20px"></bkt-icon>
                            </span>
                            Удалить мониторинг
                        </button>
                    </div>
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
                                    multiple
                                    v-model="params.marks"
                                    class="w-100"
                                    select_class="white w-100"
                                    name="mark"
                                    label="метки"
                                    label_class="bkt-form__label"
                                    :option_label="'title'"
                                    :options="marks"
                                    :reduce="item => item.id"
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
                    <!--                    <slick v-bind="settings" v-if="items_paths.length>0">-->
                    <!--                        <div v-for="(path, index) in items_paths" :key="index">-->
                    <!--                            <button-->
                    <!--                                @click="setCurrentMonitoringPath(path.pathId)"-->
                    <!--                                class="bkt-button bkt-favourites__path bkt-button_plump text-uppercase"-->
                    <!--                                :class="[current_path === path.pathId && path.color ? 'bkt-bg-'+path.color : '',-->
                    <!--                                {'bkt-bg-primary': current_path === path.pathId && !path.color,-->
                    <!--                                'bkt-bg-white bkt-text-main': current_path !== path.pathId}]"-->
                    <!--                            >-->
                    <!--                                {{path.name}}-->
                    <!--                                <span class="bkt-badge" v-if="path.newLotCount>0"-->
                    <!--                                      :class="[-->
                    <!--                                          path.color ? 'bkt-text-'+path.color : 'bkt-text-primary',-->
                    <!--                                          current_path !== path.pathId && path.color ? 'bkt-bg-'+path.color+'-lighter' : '',-->
                    <!--                                          {-->
                    <!--                                              'bkt-bg-white': current_path === path.pathId,-->
                    <!--                                              'bkt-bg-primary-lighter': current_path !== path.pathId && !path.color-->
                    <!--                                          }-->
                    <!--                                      ]"-->
                    <!--                                >-->
                    <!--                                    {{path.newLotCount ? path.newLotCount : '0'}}-->
                    <!--                                </span>-->
                    <!--                            </button>-->
                    <!--                        </div>-->
                    <!--                        <template #prevArrow="arrowOption">-->
                    <!--                            <svg-->
                    <!--                                width="8"-->
                    <!--                                height="12"-->
                    <!--                                viewBox="0 0 8 12"-->
                    <!--                                fill="#ffc515"-->
                    <!--                            >-->
                    <!--                                <path-->
                    <!--                                    d="M8 1.42L3.42 6L8 10.59L6.59 12L0.59 6L6.59 1.23266e-07L8 1.42Z"-->
                    <!--                                ></path>-->
                    <!--                            </svg>-->
                    <!--                        </template>-->
                    <!--                        <template #nextArrow="arrowOption">-->
                    <!--                            <svg-->
                    <!--                                fill="#ffc515"-->
                    <!--                                width="8"-->
                    <!--                                height="12"-->
                    <!--                                viewBox="0 0 8 12"-->
                    <!--                            >-->
                    <!--                                <path-->
                    <!--                                    d="M0 10.5801L4.58 6.00012L0 1.41012L1.41 0.00012207L7.41 6.00012L1.41 12.0001L0 10.5801Z"-->
                    <!--                                ></path>-->
                    <!--                            </svg>-->
                    <!--                        </template>-->
                    <!--                    </slick>-->
                    <div class="bkt-wrapper my-0 align-items-center w-100 bkt-nowrap">
                        <div class="p-3" v-show="items_paths.length > 1" @click="showPrev">
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
                        </div>
                        <div class="bkt-monitoring__paths-list"
                             :class="{'p-0' : items_paths.length==1}" v-if="items_paths.length>0">
                            <slick v-bind="settings" ref="carousel" style="overflow: hidden">
                                <div v-for="(path, index) in items_paths" :key="index">
                                    <!--                                    <div-->
                                    <!--                                        class="bkt-monitoring__path"-->
                                    <!--                                        :class="[current_path === path.pathId && path.color ? 'bkt-bg-'+path.color : '',-->
                                    <!--                                                {'bkt-bg-primary': current_path === path.pathId && !path.color,-->
                                    <!--                                                'bkt-bg-white bkt-text-main': current_path !== path.pathId}]"-->
                                    <!--                                    >-->
                                    <!--                                        <span  v-if="path.pathId === 0"-->
                                    <!--                                               @click="setCurrentMonitoringPath(path.pathId)"-->
                                    <!--                                               class=" bkt-cursor-pointer"-->
                                    <!--                                        >-->
                                    <!--                                            {{path.name}}-->
                                    <!--                                        </span>-->
                                    <!--                                        <div class="d-flex bkt-gap h-100 align-items-center bkt-cursor-pointer" v-if="path.pathId !== 0"-->
                                    <!--                                             @click="setCurrentMonitoringPath(path.pathId)"-->
                                    <!--                                        >-->
                                    <!--                                            <span>{{path.name}}</span>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="bkt-icon-frame-small bkt-bg-primary-lighter bkt-cursor-pointer"-->
                                    <!--                                             v-if="path.pathId !== 0"-->
                                    <!--                                             @click="editMonitoringPath(path.pathId)"-->
                                    <!--                                        >-->
                                    <!--                                            <bkt-icon :name="'Settings'" :color="'primary'" class="bkt-icon"></bkt-icon>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <button
                                        @click="setCurrentMonitoringPath(path.pathId)"
                                        class="bkt-button bkt-favourites__path bkt-button_plump text-uppercase"
                                        :class="[current_path === path.pathId && path.color ? 'bkt-bg-'+path.color : '',
                                                                        {'bkt-bg-primary': current_path === path.pathId && !path.color,
                                                                        'bkt-bg-white bkt-text-main': current_path !== path.pathId}]"
                                    >
                                        {{path.name}}
                                        <span class="bkt-badge" v-if="path.newLotCount>0"
                                              :class="[path.color ? 'bkt-text-'+path.color : 'bkt-text-primary',
                                              current_path !== path.pathId && path.color ? 'bkt-bg-'+path.color+'-lighter' : '',
                                              {
                                                  'bkt-bg-white': current_path === path.pathId,
                                                  'bkt-bg-primary-lighter': current_path !== path.pathId && !path.color
                                              }
                                              ]"
                                        >
                                            {{path.newLotCount ? path.newLotCount : '0'}}
                                        </span>
                                    </button>
                                </div>
                            </slick>
                        </div>
                        <div class="p-3" v-show="items_paths.length > 1" @click="showNext">
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
                        </div>
                    </div>
                </div>
                <div class="d-block d-md-none">
                    <bkt-collapse id="collapsePaths" main_class="bkt-favourites__path-collapse"
                                  :header_class="current_path_object.color ? 'bkt-bg-'+current_path_object.color : 'bkt-bg-primary'"
                                  :collapse_button_class="items_paths.length>1 ? 'bkt-bg-white' : 'd-none'"
                    >
                        <template #title v-if="items_paths.length>0">
                            <h6 class="mx-auto">
                                {{current_path_object.name}}
                                <span class="bkt-badge bkt-bg-white" v-if="current_path_object.newLotCount>0"
                                      :class="current_path_object.color ? 'bkt-text-'+current_path_object.color : 'bkt-text-primary'"
                                >
                                    {{current_path_object.newLotCount ? current_path_object.newLotCount : '0'}}
                                </span>
                            </h6>
                        </template>
                        <template #collapse v-if="items_paths.length>0">
                            <div class="bkt-wrapper-column bkt-gap">
                                <button v-for="(path, index) in items_paths" :key="index"
                                        @click="setCurrentMonitoringPath(path.pathId)"
                                        v-if="path.pathId !== current_path"
                                        class="w-100 bkt-button bkt-button_plump text-uppercase bkt-bg-white bkt-text-main text-center"
                                >
                                    {{path.name}}
                                    <span class="bkt-badge" v-if="path.newLotCount>0"
                                          :class="path.color ? 'bkt-bg-'+path.color+'-lighter bkt-text-'+path.color
                                      : 'bkt-text-primary bkt-bg-primary-lighter'"
                                    >
                                    {{path.newLotCount ? path.newLotCount : '0'}}
                                </span>
                                </button>
                            </div>
                        </template>
                    </bkt-collapse>
                </div>
            </div>
            <!--            <div class="row w-100 mx-auto">-->
            <!--                <div class="col-12 d-md-block d-none" :class="{'p-0' : items_paths.length==1}">-->
            <!--                    <div class="bkt-wrapper my-0 align-items-center w-100 bkt-nowrap">-->
            <!--                        <div class="p-3" v-show="items_paths.length > 1" @click="showPrev">-->
            <!--                            <svg-->
            <!--                                width="8"-->
            <!--                                height="12"-->
            <!--                                viewBox="0 0 8 12"-->
            <!--                                fill="#ffc515"-->
            <!--                            >-->
            <!--                                <path-->
            <!--                                    d="M8 1.42L3.42 6L8 10.59L6.59 12L0.59 6L6.59 1.23266e-07L8 1.42Z"-->
            <!--                                ></path>-->
            <!--                            </svg>-->
            <!--                        </div>-->
            <!--                        <div class="bkt-monitoring__paths-list"-->
            <!--                             :class="{'p-0' : items_paths.length==1}" v-if="items_paths.length>0">-->
            <!--                            <slick v-bind="settings" ref="carousel" style="overflow: hidden">-->
            <!--                                <div v-for="(path, index) in items_paths" :key="index">-->
            <!--                                    <div-->
            <!--                                        class="bkt-monitoring__path"-->
            <!--                                        :class="[current_path === path.pathId && path.color ? 'bkt-bg-'+path.color : '',-->
            <!--                                                {'bkt-bg-primary': current_path === path.pathId && !path.color,-->
            <!--                                                'bkt-bg-white bkt-text-main': current_path !== path.pathId}]"-->
            <!--                                    >-->
            <!--                                        <span v-if="path.pathId === 0"-->
            <!--                                              @click="setCurrentMonitoringPath(path.pathId)"-->
            <!--                                              class=" bkt-cursor-pointer"-->
            <!--                                        >-->
            <!--                                            {{path.name}}-->
            <!--                                        </span>-->
            <!--                                        <div class="d-flex bkt-gap h-100 align-items-center bkt-cursor-pointer"-->
            <!--                                             v-if="path.pathId !== 0"-->
            <!--                                             @click="setCurrentMonitoringPath(path.pathId)"-->
            <!--                                        >-->
            <!--                                            <span>{{path.name}}</span>-->
            <!--                                        </div>-->
            <!--                                        <div class="bkt-icon-frame-small bkt-bg-primary-lighter bkt-cursor-pointer"-->
            <!--                                             v-if="path.pathId !== 0"-->
            <!--                                             @click="editMonitoringPath(path.pathId)"-->
            <!--                                        >-->
            <!--                                            <bkt-icon :name="'Settings'" :color="'primary'" class="bkt-icon"></bkt-icon>-->
            <!--                                        </div>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                                &lt;!&ndash;                            <template #prevArrow="arrowOption">&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                <div class="custom-arrow">&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                    <div v-show="items_paths.length > 1">&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                        <svg&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                            width="8"&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                            height="12"&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                            viewBox="0 0 8 12"&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                            fill="#ffc515"&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                        >&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                            <path&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                                d="M8 1.42L3.42 6L8 10.59L6.59 12L0.59 6L6.59 1.23266e-07L8 1.42Z"&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                            ></path>&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                        </svg>&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                    </div>&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                </div>&ndash;&gt;-->
            <!--                                &lt;!&ndash;                            </template>&ndash;&gt;-->
            <!--                                &lt;!&ndash;                            <template #nextArrow="arrowOption">&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                <div class="custom-arrow">&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                    <div v-show="items_paths.length > 1">&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                        <svg&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                            fill="#ffc515"&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                            width="8"&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                            height="12"&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                            viewBox="0 0 8 12"&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                        >&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                            <path&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                                d="M0 10.5801L4.58 6.00012L0 1.41012L1.41 0.00012207L7.41 6.00012L1.41 12.0001L0 10.5801Z"&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                            ></path>&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                        </svg>&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                    </div>&ndash;&gt;-->

            <!--                                &lt;!&ndash;                                </div>&ndash;&gt;-->
            <!--                                &lt;!&ndash;                            </template>&ndash;&gt;-->
            <!--                            </slick>-->
            <!--                        </div>-->
            <!--                        <div class="p-3" v-show="items_paths.length > 1" @click="showNext">-->
            <!--                            <svg-->
            <!--                                fill="#ffc515"-->
            <!--                                width="8"-->
            <!--                                height="12"-->
            <!--                                viewBox="0 0 8 12"-->
            <!--                            >-->
            <!--                                <path-->
            <!--                                    d="M0 10.5801L4.58 6.00012L0 1.41012L1.41 0.00012207L7.41 6.00012L1.41 12.0001L0 10.5801Z"-->
            <!--                                ></path>-->
            <!--                            </svg>-->
            <!--                        </div>-->
            <!--                    </div>-->

            <!--                </div>-->
            <!--                <div class="col px-0">-->
            <!--                    <button class="bkt-button__new-monitoring bkt-button primary bkt-w-md-100"-->
            <!--                            @click="openModal"-->
            <!--                    >-->
            <!--                        Новый мониторинг-->
            <!--                    </button>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="bkt-wrapper my-0 bkt-nowrap align-items-start bkt-gap d-md-none w-100"-->
            <!--                 v-if="items_paths.length>0">-->
            <!--                <bkt-collapse id="collapseMonitoringPaths" main_class="bkt-monitoring__paths-collapse"-->
            <!--                              :header_class="current_path_object.color ? 'bkt-bg-'+current_path_object.color : 'bkt-bg-primary'"-->
            <!--                              :collapse_button_class="items_paths.length>1 ? 'bkt-bg-white' : 'd-none'"-->
            <!--                >-->
            <!--                    <template #title v-if="items_paths.length>0">-->
            <!--                        <h6 class="mx-auto">-->
            <!--                            {{current_path_object.name}}-->
            <!--                        </h6>-->
            <!--                    </template>-->
            <!--                    <template #collapse v-if="items_paths.length>0">-->
            <!--                        <div class="bkt-wrapper-column bkt-gap">-->
            <!--                            <button v-for="(path, index) in items_paths" :key="index"-->
            <!--                                    @click="setCurrentMonitoringPath(path.pathId)"-->
            <!--                                    v-if="path.pathId !== current_path"-->
            <!--                                    class="w-100 bkt-button bkt-button_plump text-uppercase bkt-bg-white bkt-text-main text-center"-->
            <!--                            >-->
            <!--                                {{path.name}}-->
            <!--                                &lt;!&ndash;                            <span class="bkt-badge"&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                  :class="path.color ? 'bkt-bg-'+path.color+'-lighter bkt-text-'+path.color&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                      : 'bkt-text-primary bkt-bg-primary-lighter'"&ndash;&gt;-->
            <!--                                &lt;!&ndash;                            >&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                    {{path.lotCount ? path.lotCount : '0'}}&ndash;&gt;-->
            <!--                                &lt;!&ndash;                                </span>&ndash;&gt;-->
            <!--                            </button>-->
            <!--                        </div>-->
            <!--                    </template>-->
            <!--                </bkt-collapse>-->
            <!--                <button class="bkt-button-icon bkt-bg-primary-lighter" @click="editMonitoringPath(current_path)">-->
            <!--                    <bkt-icon :name="'Settings'" :color="'primary'" class=""></bkt-icon>-->
            <!--                </button>-->
            <!--            </div>-->
            <bkt-card-list v-if="items_paths.length>0" :current_component="'BktCard'" :items="items" :loading="loading"
                           :pagination_data="pagination_data" @change-page="getData"
                           :no_pagination="items_paths.length==0" @changeStatus="changeStatus"
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
        </section>
    </div>
</template>

<script>
    import AddMonitoringModal from "./Monitoring/AddMonitoringModal";
    import EditMonitoringModal from "./Monitoring/EditMonitoringModal";

    export default {
        name: "Monitoring",
        components: {AddMonitoringModal, EditMonitoringModal},
        data() {
            return {
                loading: false,
                settings: {
                    "arrows": false,
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
                search_mode: false,
                params: {
                    pathId: 0,
                    marks: [],
                    searchField: '',
                    includedWords: '',
                    sort: {
                        direction: "desc",
                        type: "publishDate"
                    }
                },
                signal: null,
                controller: null,
            }
        },
        created() {
            this.getMonitoringPaths();
        },
        mounted() {
            // this.getData();
        },
        computed: {
            filters() {
                return this.$store.getters.filters;
            },
            items() {
                return this.$store.getters.current_monitorings;
            },
            pagination_data() {
                return this.$store.getters.monitorings_pagination;
            },
            items_paths() {
                // let monitorings_paths =  this.$store.getters.monitorings_paths;
                // monitorings_paths.unshift({pathId: 0, name:'Все', color: 'primary'});
                return this.$store.getters.monitorings_paths;
            },
            current_path() {
                return this.$store.getters.monitoring_current_path;
            },
            current_path_object() {
                let index = this.items_paths.findIndex(item => item.pathId == this.current_path)
                if (index >= 0) {
                    return this.items_paths[index];
                }
                return {}
            },
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
            getData(page = 1, pathId = 0) {
                this.loading = true;
                this.params.page = page;
                this.params.pathId = this.current_path;
                sessionStorage.setItem('monitoring'+this.current_path+'_page', page+'');
                this.$store.dispatch('getMonitorings', {params: this.params, signal:this.signal}).then(resp => {
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
                })
            },

            openModal() {
                this.$store.commit('openModal', '#addMonitoringModal');
            },
            async getMonitoringPaths() {
                this.loading = true;
                await this.$store.dispatch('getMonitoringPaths').then(response => {
                    // this.$store.commit('setMonitoringPaths', response.data)
                    // this.$store.commit('setCurrentPath', response.data[0].pathId)
                    // this.getData(1, this.current_path)
                    if (this.items_paths.length > 0) {
                        this.params.pathId = this.current_path;
                        this.params.page =  1;
                        if(sessionStorage.getItem('monitoring'+this.current_path+'_page'))
                        {
                            this.params.page = sessionStorage.getItem('monitoring'+this.current_path+'_page')
                        }
                        this.controller = new AbortController();
                        this.signal = this.controller.signal;
                        this.$store.dispatch('getMonitorings', {pathId:this.current_path, params: this.params, signal: this.signal})
                            .finally(() => {
                                this.loading = false;
                            });
                    }
                }).catch(err => {
                    this.loading = false;
                });
            },
            async setCurrentMonitoringPath(value) {
                if (this.signal) {
                    this.controller.abort();
                }
                await setTimeout(() => {
                    this.loading = true;
                    this.params.page = 1;
                    sessionStorage.setItem('monitoring_path_id', value);
                    if (sessionStorage.getItem('monitoring' + value + '_page')) {
                        this.params.page = sessionStorage.getItem('monitoring' + value + '_page')
                    }
                    this.params.pathId = value;
                    this.controller = new AbortController();
                    this.signal = this.controller.signal;
                    this.$store.dispatch('setCurrentMonitoringPath', {pathId: value, params: this.params, signal:this.signal})
                        .finally(() => {
                            this.loading = false;
                        });
                }, 50)
            },
            async removeMonitoringPath() {
                this.$swal.fire({
                    title: 'Вы уверены?',
                    text: 'Вы уверены, что хотите удалить этот мониторинг?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2953ff',
                    cancelButtonColor: '#ec4c27',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Отменить',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$store.dispatch('removeMonitoringPath', this.current_path)
                            .then(resp => {
                                if (this.items_paths.length > 0) {
                                    this.setCurrentMonitoringPath(this.items_paths[0].pathId)
                                }
                            });
                    }
                })
            },
            editMonitoringPath(value) {
                if (!this.loading) {
                    this.setCurrentMonitoringPath(value)
                    this.$store.commit('setCurrentMonitoringPath', value)
                    this.$store.commit('openModal', '#editMonitoringModal');
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
            changeStatus(payload) {
                if (payload.key === 'isHide') {
                    let page = null;
                    if (payload.page) {
                        page = payload.page
                    }
                    this.$store.dispatch('removeMonitoring', {pathId: this.current_path, lotId: payload.lotId})
                        .then(resp => {
                            this.$store.dispatch('sendNotification',
                                {self: this, message: 'Лот успешно удален из мониторинга'});
                        }).catch(error => {

                    })
                    this.getData(page)
                }
            }
        },
    }
</script>

<style scoped>
    .custom-arrow {
        content: '';
    }

    .custom-arrow:before {
        content: '';
    }
</style>
