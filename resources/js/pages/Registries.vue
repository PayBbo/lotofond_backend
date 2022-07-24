<template>
    <div class="bkt-register bkt-page bkt-container">
        <h1 class="bkt-page__title">Реестры</h1>

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
                <bkt-registry method_name="getBidders" :method_params="{type:'debtors'}"
                              :loading="debtors_loading" :pagination_data="debtors_pagination"
                              :items="debtors" :sort="debtors_sort"
                >
                    <template #tr>
                        <th width="84px">№</th>
                        <th width="260px">Должник</th>
                        <th width="150px">ИНН</th>
                        <th width="210px">Регион</th>
                        <th width="394px">Адрес</th>
                    </template>
                    <template #tbody_tr="{item}">
                        <td>{{item.id}}</td>
                        <td><router-link custom :to="'/registries/debtor/'+item.id">{{item.fullName}}</router-link></td>
                        <td>{{item.inn ? item.inn : ''}}</td>
                        <td>{{item.region ? $t('regions.'+item.region) : ''}}</td>
                        <td>{{item.address ? item.address : ''}}</td>
                    </template>
                </bkt-registry>
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
                <bkt-registry method_name="getBidders" :method_params="{type:'organizers'}"
                              :loading="organizers_loading" :pagination_data="organizers_pagination"
                              :items="organizers" :sort="organizers_sort"
                >
                    <template #tr>
                        <th>№</th>
                        <th width="60%">Наименование</th>
                        <th>ИНН</th>
                        <th>Регион</th>
                    </template>
                    <template #tbody_tr="{item}">
                        <td>{{item.id}}</td>
                        <td><router-link custom :to="'/registries/organizer/'+item.id">{{item.fullName}}</router-link></td>
                        <td>{{item.inn ? item.inn : ''}}</td>
                        <td>{{item.region ? $t('regions.'+item.region) : ''}}</td>
                    </template>
                </bkt-registry>
            </template>
        </bkt-collapse>

        <bkt-collapse main_class="bkt-register-collapse mb-2" collapse_button_class="bkt-bg-white" id="register3">
            <template #title>
                <div class="bkt-register-collapse__header">
                    <div class="bkt-bg-primary-lighter bkt-icon-frame-small bkt-icon-frame-sm">
                        <bkt-icon :name="'Scale'" class="bkt-icon-frame__item" color="primary"></bkt-icon>
                    </div>
                    <h4 class="bkt-register-collapse__title">Арбитражные управляющие</h4>
                </div>
            </template>
            <template #collapse>
                <bkt-registry method_name="getBidders" :method_params="{type:'arbitrationManagers'}"
                              :loading="arbitration_managers_loading" :pagination_data="arbitration_managers_pagination"
                              :items="arbitration_managers" :sort="arbitration_managers_sort"
                >
                    <template #tr>
                        <th>№</th>
                        <th>Наименование</th>
                        <th>ИНН</th>
                        <th>Регион</th>
                        <th>СРО</th>
                    </template>
                    <template #tbody_tr="{item}">
                        <td>{{item.id}}</td>
                        <td><router-link custom :to="'/registries/arbitrationManager/'+item.id">{{item.fullName}}</router-link></td>
                        <td>{{item.inn ? item.inn : ''}}</td>
                        <td>{{item.region ? $t('regions.'+item.region) : ''}}</td>
                        <td>{{item.sroAU ? item.sroAU : ''}}</td>
                    </template>
                </bkt-registry>
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
                <bkt-registry method_name="getTradePlaces"
                              :loading="trade_places_loading" :pagination_data="trade_places_pagination"
                              :items="trade_places" :sort="trade_places_sort"
                >
                    <template #tr>
                        <th>№</th>
                        <th>Наименование</th>
                        <th>Адрес</th>
                        <th></th>
                        <th>Заметка</th>
                    </template>
                    <template #tbody_tr="{item}">
                        <td>{{item.id ? item.id : ''}}</td>
                        <td><router-link custom :to="'/registries/trade-place/'+item.id">{{item.name ? item.name : ''}}</router-link></td>
                        <td>{{item.site ? item.site : ''}}</td>
                        <td></td>
                        <td>{{item.note ? item.note : ''}}</td>
                    </template>
                </bkt-registry>
            </template>
        </bkt-collapse>

<!--        <bkt-collapse main_class="bkt-register-collapse mb-2" collapse_button_class="bkt-bg-white" id="register5">-->
<!--            <template #title>-->
<!--                <div class="bkt-register-collapse__header">-->
<!--                    <div class="bkt-bg-blue-lighter bkt-icon-frame-small bkt-icon-frame-sm">-->
<!--                        <bkt-icon :name="'Chat'" class="bkt-icon-frame__item" color="blue"></bkt-icon>-->
<!--                    </div>-->
<!--                    <h4 class="bkt-register-collapse__title">Сообщения</h4>-->
<!--                </div>-->
<!--            </template>-->
<!--            <template #collapse>-->
<!--                <bkt-registry method_name="getDebtorMessages" :method_params="messages_params"-->
<!--                              :loading="messages_loading" :pagination_data="messages_pagination"-->
<!--                              :items="messages" :sort="messages_sort"-->
<!--                >-->
<!--                    <template #filters>-->
<!--                        <div class="bkt-register-filters p-3 m-3">-->
<!--                            <div class="row mb-2">-->
<!--                                <div class="col-lg-2 d-flex align-items-center">-->
<!--                                    <span>поиск по тексту</span>-->
<!--                                </div>-->
<!--                                <div class="col-12 col-lg-10">-->
<!--                                    <bkt-search v-model="messages_params.searchString"-->
<!--                                                method_name="getDebtorMessages" :method_params="messages_params"-->
<!--                                                :loading="messages_loading" search_field="searchString" no_dropdown-->
<!--                                    >-->
<!--                                    </bkt-search>-->
<!--&lt;!&ndash;                                    <div class="w-100 bkt-search position-relative bkt-bg-neutral-light pt-0 pb-0 p-2">&ndash;&gt;-->
<!--&lt;!&ndash;                                        <input class="w-100 bkt-search__input" type="text">&ndash;&gt;-->
<!--&lt;!&ndash;                                        <button class="bkt-button green bkt-search__button">&ndash;&gt;-->
<!--&lt;!&ndash;                                            <span class="d-none d-md-block">Найти</span>&ndash;&gt;-->
<!--&lt;!&ndash;                                            <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>&ndash;&gt;-->
<!--&lt;!&ndash;                                        </button>&ndash;&gt;-->
<!--&lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="row mb-2">-->
<!--                                <div class="col-lg-2 d-flex align-items-center">-->
<!--                                    <span>должник</span>-->
<!--                                </div>-->
<!--                                <div class="col-12 col-lg-10">-->
<!--                                    <bkt-search v-model="messages_params.debtor"-->
<!--                                                method_name="getDebtorMessages" :method_params="messages_params"-->
<!--                                                :loading="messages_loading" search_field="searchString" no_dropdown-->
<!--                                    >-->
<!--                                    </bkt-search>-->
<!--&lt;!&ndash;                                    <div class="w-100 bkt-search position-relative bkt-bg-neutral-light pt-0 pb-0 p-2">&ndash;&gt;-->
<!--&lt;!&ndash;                                        <input class="w-100 bkt-search__input" type="text">&ndash;&gt;-->
<!--&lt;!&ndash;                                        <button class="bkt-button green bkt-search__button">&ndash;&gt;-->
<!--&lt;!&ndash;                                            <span class="d-none d-md-block">Найти</span>&ndash;&gt;-->
<!--&lt;!&ndash;                                            <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>&ndash;&gt;-->
<!--&lt;!&ndash;                                        </button>&ndash;&gt;-->
<!--&lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="row mb-2">-->
<!--                                <div class="col-lg-2 d-flex align-items-center">-->
<!--                                    <span>типы сообщения</span>-->
<!--                                </div>-->
<!--                                <div class="col-12 col-lg-10 text-left">-->
<!--                                    <button class="bkt-button bkt-bg-primary bkt-search__button">-->
<!--                                        <span class="d-none d-md-block">Выбрать</span>-->
<!--                                    </button>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="row mb-2">-->
<!--                                <div class="col-lg-2 d-flex align-items-center">-->
<!--                                    <span>регион должника</span>-->
<!--                                </div>-->
<!--                                <div class="col-12 col-lg-auto text-left">-->
<!--                                    <button class="bkt-button bkt-bg-primary bkt-search__button">-->
<!--                                        <span class="d-none d-md-block">Выбрать</span>-->
<!--                                    </button>-->
<!--                                </div>-->
<!--                                <div class="col-12 col-lg-7 col-md-5">-->
<!--                                    <div class="bkt-tag__list">-->
<!--                                        <div class="bkt-region__item bkt-tag justify-content-between flex-fill">-->
<!--                                            <span class="bkt-item-rounded__text mr-2">title</span>-->
<!--                                            <span class="bkt-tag__icon bkt-cursor-pointer">-->
<!--                                                <bkt-icon name="Cancel" color="red"></bkt-icon>-->
<!--                                            </span>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="row mb-2">-->
<!--                                <div class="col-lg-2 d-flex align-items-center">-->
<!--                                    <span>дата публикации</span>-->
<!--                                </div>-->
<!--                                <div class="col-12 col-lg-10">-->
<!--                                    <div class="row">-->
<!--                                        <div class="col-12 col-lg-4">-->
<!--                                            <bkt-datepicker field_name="с" name="dateStart"></bkt-datepicker>-->
<!--                                        </div>-->
<!--                                        <div class="col-12 col-lg-4">-->
<!--                                            <bkt-datepicker field_name="по" name="dateEnd"></bkt-datepicker>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="row">-->
<!--                                <div class="col-lg-2">-->
<!--                                </div>-->
<!--                                <div class="col-12 col-lg-10 text-left">-->
<!--                                    <bkt-checkbox name="check" :value="true"-->
<!--                                                  :label="'в сообщении есть файлы'"></bkt-checkbox>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </template>-->
<!--                    <template #tr>-->
<!--                        <th>Дата</th>-->
<!--                        <th>Тип</th>-->
<!--                        <th>Должник</th>-->
<!--                    </template>-->
<!--                    <template #tbody_tr="{item}">-->
<!--                        <td>{{item.created_at | moment('DD.MM.YYYY')}}</td>-->
<!--                        <td>{{item.type ? item.type : ''}}</td>-->
<!--                        <td>{{item.debtor ? item.debtor : ''}}</td>-->
<!--                    </template>-->
<!--                </bkt-registry>-->
<!--            </template>-->
<!--        </bkt-collapse>-->

    </div>
</template>

<script>
    import BktCollapse from '../components/Collapse.vue'
    import BktRegistry from "./Registries/Registry";

    export default {
        name: "Registries",
        components: {
            // MainParamsModal,
            BktCollapse, BktRegistry
        },
        data() {
            return {
                messages_params: {
                    searchString:'',
                    debtor: '',
                    types: [],
                    regions: [],
                    publishDate: {
                        start: '',
                        end: ''
                    },
                    messageHasFiles: true
                },
                debtors_sort: [
                    {title: 'идентификатору', value: 'id'},
                    {title: 'ИНН', value: 'inn'},
                    {title: 'имени', value: 'name'},
                    {title: 'региону', value: 'region'},
                    {title: 'адресу', value: 'address'},
                ],
                organizers_sort: [
                    {title: 'идентификатору', value: 'id'},
                    {title: 'ИНН', value: 'inn'},
                    {title: 'наименованию', value: 'name'},
                    {title: 'региону', value: 'region'},
                ],
                arbitration_managers_sort: [
                    {title: 'идентификатору', value: 'id'},
                    {title: 'ИНН', value: 'inn'},
                    {title: 'наименованию', value: 'name'},
                    {title: 'региону', value: 'region'},
                ],
                trade_places_sort: [
                    {title: 'идентификатору', value: 'id'},
                    // {title: 'наименованию', value: 'name'},
                ],
                messages_sort: [
                    {title: 'идентификатору', value: 'id'},
                ],
            }
        },
        computed: {
            debtors() {
                return this.$store.getters.debtors;
            },
            debtors_pagination() {
                // return {
                //     pagination: this.$store.getters.debtors_pagination,
                //     method_name: 'getDebtors',
                //     method_params:{
                //         type:'filters'
                //     }
                // }
                return this.$store.getters.debtors_pagination;
            },
            debtors_loading() {
                return this.$store.getters.debtors_loading;
            },
            organizers() {
                return this.$store.getters.organizers
            },
            organizers_pagination() {
                // return {
                //     pagination: this.$store.getters.organizers_pagination,
                //     method_name: 'getOrganizers',
                //     method_params:{
                //         type:'filters'
                //     }
                // }
                return this.$store.getters.organizers_pagination;
            },
            organizers_loading() {
                return this.$store.getters.organizers_loading;
            },
            arbitration_managers() {
                return this.$store.getters.arbitration_managers;
            },
            arbitration_managers_pagination() {
                // return {
                //     pagination: this.$store.getters.arbitration_managers_pagination,
                //     method_name: 'getArbitrManagers',
                //     method_params:{
                //         type:'filters'
                //     }
                // }
                return this.$store.getters.arbitration_managers_pagination;
            },
            arbitration_managers_loading() {
                return this.$store.getters.arbitration_managers_loading;
            },
            trade_places() {
                return this.$store.getters.trade_places;
            },
            trade_places_pagination() {
                return this.$store.getters.trade_places_pagination;
            },
            trade_places_loading() {
                return this.$store.getters.trade_places_loading;
            },
            messages() {
                return this.$store.getters.messages;
            },
            messages_pagination() {
                return this.$store.getters.messages_pagination;
            },
            messages_loading() {
                return this.$store.getters.messages_loading;
            },
        }
    }
</script>

<style scoped>

</style>
