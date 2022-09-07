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
                        <td>
                            <router-link custom :to="'/registries/debtor/'+item.id">{{item.fullName}}</router-link>
                        </td>
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
                        <td>
                            <router-link custom :to="'/registries/organizer/'+item.id">{{item.fullName}}</router-link>
                        </td>
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
                        <td>
                            <router-link custom :to="'/registries/arbitrationManager/'+item.id">{{item.fullName}}
                            </router-link>
                        </td>
                        <td>{{item.inn ? item.inn : ''}}</td>
                        <td>{{item.region ? $t('regions.'+item.region) : ''}}</td>
                        <td>{{item.sro ? item.sro : ''}}</td>
                    </template>
                </bkt-registry>
            </template>
        </bkt-collapse>

        <bkt-collapse v-if="isLoggedIn" main_class="bkt-register-collapse mb-2" collapse_button_class="bkt-bg-white"
                      id="register4">
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
                        <!--                        <th></th>-->
                        <!--                        <th>Заметка</th>-->
                    </template>
                    <template #tbody_tr="{item}">
                        <td>{{item.id ? item.id : ''}}</td>
                        <td>
                            <router-link custom :to="'/registries/trade-place/'+item.id">
                                {{item.name ? item.name : ''}}
                            </router-link>
                        </td>
                        <td>{{item.site ? item.site : ''}}</td>
                        <!--                        <td></td>-->
                        <!--                        <td>{{item.note ? item.note : ''}}</td>-->
                    </template>
                </bkt-registry>
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
                <bkt-registry method_name="getDebtorMessages" :method_params="messages_filters"
                              :loading="messages_loading" :pagination_data="messages_pagination"
                              :items="messages" :sort="messages_sort" @changeParam="saveMessagesFilters"
                >
                    <template #filters>
                        <div class="bkt-register-filters bkt-register-filters__body bkt-form">
                            <div class="col-lg-2 d-flex align-items-center">
                                <h5 class="bkt-form__label">поиск по тексту</h5>
                            </div>
                            <div class="col-12 col-lg-10">
                                <bkt-search v-model="messages_params.searchString"
                                            method_name="getDebtorMessages" :method_params="messages_filters"
                                            :loading="messages_loading" search_field="searchString" no_dropdown
                                            placeholder="Поиск..."
                                >
                                </bkt-search>
                            </div>
<!--                            <div class="col-lg-2 d-flex align-items-center">-->
<!--                                <h5 class="bkt-form__label">должник</h5>-->
<!--                            </div>-->
<!--                            <div class="col-12 col-lg-10">-->
<!--                                <bkt-search v-model="messages_params.debtor"-->
<!--                                            method_name="getDebtorMessages" :method_params="messages_filters"-->
<!--                                            :loading="messages_loading" search_field="debtor" no_dropdown-->
<!--                                            placeholder="Поиск..."-->
<!--                                >-->
<!--                                </bkt-search>-->
<!--                            </div>-->


                            <div class="col-7 col-md-3 col-lg-2 d-flex align-items-center">
                                <div class="d-flex align-items-center bkt-gap-small">
                                    <h5 class="bkt-form__label">типы сообщения</h5>
                                    <span class="bkt-badge d-md-none bkt-bg-primary-lighter bkt-text-primary m-0">
                                        {{messages_filters.types.length}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-5 col-md-9 col-lg-10 d-flex">
                                <button class="bkt-button bkt-bg-primary bkt-register-filters__button ms-auto ms-md-0"
                                        data-bs-toggle="modal" data-bs-target="#messagesTypesModal"
                                >
                                    {{messages_filters.types.length > 0 ? 'Изменить' : 'Выбрать'}}
                                </button>
                            </div>
                            <div class="col-7 col-md-3 col-lg-2 d-flex align-items-center">
                                <div class="d-flex align-items-center bkt-gap-small">
                                    <h5 class="bkt-form__label">регион должника</h5>
                                    <span class="bkt-badge d-md-none bkt-bg-primary-lighter bkt-text-primary m-0">
                                        {{messages_filters.regions.length}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-5 col-md-9 col-lg-10">
                                <div class="bkt-wrapper-between">
                                    <button
                                        class="bkt-button bkt-bg-primary bkt-register-filters__button ms-auto ms-md-0"
                                        data-bs-toggle="modal" data-bs-target="#regionModal"
                                    >
                                        {{messages_filters.regions.length > 0 ? 'Изменить' : 'Выбрать'}}
                                    </button>
                                    <button class="bkt-button-icon bkt-bg-red-lighter d-none d-md-flex"
                                            v-if="messages_filters.regions.length > 0"
                                            @click="clearRegions"
                                    >
                                        <bkt-icon name="Trash"></bkt-icon>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 d-none d-md-flex">
                                <div class="bkt-tag__list ">
                                    <div class="bkt-region__item bkt-tag justify-content-between flex-fill"
                                         v-for="(item, index) in messages_filters.regions">
                                        <span class="bkt-item-rounded__text mr-2">{{ $t('regions.' + item) }}</span>
                                        <span class="bkt-tag__icon bkt-cursor-pointer" @click="removeRegion(item)">
                                                <bkt-icon name="Cancel" color="red"></bkt-icon>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 d-flex align-items-center">
                                <h5 class="bkt-form__label">дата публикации</h5>
                            </div>
                            <div class="col-12 col-lg-10">
                                <div class="bkt-form mx-auto w-100">
                                    <div class="col-12 col-md-6 col-lg-5">
                                        <bkt-datepicker v-model="messages_filters.publishDate.start" @input="getDebtorMessages"
                                                        field_name="с" name="dateStart" placeholder="с"
                                        >
                                        </bkt-datepicker>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-5">
                                        <bkt-datepicker v-model="messages_filters.publishDate.end" @input="getDebtorMessages"
                                                        field_name="по" name="dateEnd" placeholder="по"
                                        >
                                        </bkt-datepicker>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                            </div>
                            <div class="col-12 col-lg-10 text-left">
                                <bkt-checkbox name="check" v-model="messages_filters.messageHasFiles"
                                              :label="'в сообщении есть файлы'"
                                              @input="getDebtorMessages"></bkt-checkbox>
                            </div>
                        </div>
                    </template>
                    <template #tr>
                        <th width="110px">Дата</th>
                        <th width="543px">Тип</th>
                        <th>Должник</th>
                    </template>
                    <template #tbody_tr="{item}">
                        <td>{{item.date | moment('DD.MM.YYYY')}}</td>
                        <td>{{item.type ? item.type : ''}}
                            <span @click="seeMessagePage(item.guid)" v-if="item.files.length>0">
                                <bkt-icon name="Clip" color="primary" height="22px" width="15px"></bkt-icon>
                            </span>
                        </td>
                        <td>
                            <p class="mb-0">
                                <span v-if="item.debtor.type=='person'">
                                <template v-for="(value, key, index) in item.debtor.person">
                                     {{value ? value+' ' : ''}}
                                </template>
                            </span>
                                <span v-else-if="item.debtor.type=='company'">
                                {{item.debtor.company.fullName ? item.debtor.company.fullName : item.debtor.company.shortName}}
                            </span>
                            </p>

                            <p class="mb-0" v-if="item.debtor.region">
                                {{ $t('regions.' + item.debtor.region) }}
                            </p>
                        </td>
                    </template>
                </bkt-registry>
            </template>
        </bkt-collapse>

        <bkt-region-modal filter_name="messages_filters" method_name="getDebtorMessages"/>
        <bkt-message-page-modal ref="messagePageModal"></bkt-message-page-modal>
        <bkt-messages-types-modal></bkt-messages-types-modal>
    </div>
</template>

<script>
    import BktCollapse from '../components/Collapse.vue'
    import BktRegistry from "./Registries/Registry";
    import BktRegionModal from "../components/SharedModals/RegionModal";
    import BktMessagePageModal from "./Registries/MessagePageModal";
    import BktMessagesTypesModal from "./Registries/MessagesTypesModal";

    export default {
        name: "Registries",
        components: {
            // MainParamsModal,
            BktCollapse, BktRegistry, BktRegionModal, BktMessagePageModal,
            BktMessagesTypesModal
        },
        data() {
            return {
                messages_params: {
                    searchString: '',
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
                    // {title: 'идентификатору', value: 'id'},
                    {title: 'дате', value: 'date'},
                ],
                message_page_loading: false,
            }
        },
        computed: {
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
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
            messages_filters: {
                get() {
                    return this.$store.getters.messages_filters;
                },
                set(value) {
                    this.$store.dispatch('saveDataProperty', {
                        module_key: 'filters',
                        key: 'messages_filters',
                        value: value
                    });
                    this.getDebtorMessages()
                }
            },
        },
        methods: {
            removeRegion(region) {
                let item_index = this.messages_filters.regions.findIndex(el => el === region);
                if (item_index >= 0) {
                    this.messages_filters.regions.splice(item_index, 1);
                }
            },
            clearRegions() {
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters',
                    key: 'messages_filters.regions',
                    value: []
                });
                this.getDebtorMessages(1)
            },
            getDebtorMessages(page = 1) {
                this.$store.dispatch('getDebtorMessages', this.messages_filters);
            },
            seeMessagePage(guid) {
                // var newWin = window.open(url, 'example', 'width=600,height=400')
                console.log('guid', guid)
                this.$refs.messagePageModal.setGuid(guid);
                this.$store.commit('openModal', '#messagePageModal');
            },
            saveMessagesFilters(payload) {
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters',
                    key: 'messages_filters.'+payload.key,
                    value: payload.value
                });
            }
        }
    }
</script>

<style scoped>

</style>
