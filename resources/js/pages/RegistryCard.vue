<template>
    <div class="bkt-container bkt-page bkt-registry bkt-wrapper-column">
        <div class="bkt-wrapper mx-0">
            <nav class="bkt-wrapper bkt-nowrap m-0 bkt-breadcrumb" aria-label="breadcrumb">
                <button class="bkt-button-icon bkt-icon-frame bkt-bg-white" @click="goBack">
                    <bkt-icon :name="'ArrowDown'" class="bkt-button__icon bkt-rotate-90"></bkt-icon>
                </button>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item bkt-breadcrumb__item">
                        <router-link to="/">главная</router-link>
                    </li>
                    <li class="breadcrumb-item bkt-breadcrumb__item">
                        <router-link to="/registries" custom>реестры</router-link>
                    </li>
                    <li class="breadcrumb-item bkt-breadcrumb__item active" aria-current="page">
                         <span v-if="item.type=='person'">
                            <template v-for="(value, key, index) in item.person">
                                 {{value ? value+' ' : ''}}
                            </template>
                        </span>
                        <span v-else-if="item.type=='company'">
                            {{item.company.fullName ? item.company.fullName : item.company.shortName}}
                        </span>
                        <span v-else>
                            {{item.name ? item.name : ''}}
                        </span>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="bkt-card">
            <div class="bkt-card__body">
                <bkt-table :loading="loading" main_class="bkt-simple-table_list" :no_data_slot="false">
                    <template #tbody>
                        <tr>
                            <td>
                                Полное наименование/ФИО
                            </td>
                            <td>
                                <span v-if="item.type=='person'">
                                    <template v-for="(value, key, index) in item.person">
                                         {{value ? value+' ' : ''}}
                                    </template>
                                </span>
                                <span v-else-if="item.type=='company'">
                                    {{item.company.fullName ? item.company.fullName : item.company.shortName}}
                                </span>
                                <span v-else>
                                    {{item.name ? item.name : ''}}
                                </span>
                            </td>
                        </tr>
                        <tr v-if="item_type == 'debtor'">
                            <td>
                                Категория
                            </td>
                            <td>
                                <span v-if="item.type=='person'">Физическое лицо</span>
                                <span v-else>Юридическое лицо</span>
                            </td>
                        </tr>
                        <tr v-if="item_type == 'trade-place'">
                            <td>
                                Адрес сайта
                            </td>
                            <td>
                                {{item.site}}
                            </td>
                        </tr>
                        <tr v-if="item_type == 'trade-place'">
                            <td>
                                Собственник
                            </td>
                            <td>
                                {{item.ownerName}}
                            </td>
                        </tr>
                        <tr v-if="item_type == 'organizer'">
                            <td>
                                Организационная форма
                            </td>
                            <td>
                                -
                            </td>
                        </tr>
                        <tr v-if="item[item_type] && item[item_type].region">
                            <td>
                                Регион
                            </td>
                            <td>
                                {{item[item_type].region ? $t('regions.'+item[item_type].region) : '-'}}
                            </td>
                        </tr>
                        <tr v-if="item[item_type] && item[item_type].address">
                            <td>
                                Адрес
                            </td>
                            <td>
                                {{item[item_type].address ? item[item_type].address : '-'}}
                            </td>
                        </tr>
                        <tr v-if="item.inn">
                            <td>ИНН</td>
                            <td>
                                {{item.inn ? item.inn : '-'}}
                            </td>
                        </tr>
                        <tr v-if="item[item_type] && item[item_type].sro">
                            <td>
                                СРО
                            </td>
                            <td>
                                {{item[item_type].sro ? item[item_type].sro : '-'}}
                            </td>
                        </tr>
                        <tr v-if="item_type == 'arbitrationManager'">
                            <td>
                                Номер регистрации
                            </td>
                            <td>
                                {{item.arbitrationManager && item.arbitrationManager.regNum ? item.arbitrationManager.regNum : '-'}}
                            </td>
                        </tr>
                        <tr v-if="item_type == 'arbitrationManager'">
                            <td>
                                Дата регистрации
                            </td>
                            <td>
                                {{item.arbitrationManager && item.arbitrationManager.regDate ? item.arbitrationManager.regDate : '-'}}
                            </td>
                        </tr>
                        <tr v-if="item[item_type] && item[item_type].ogrn">
                            <td>
                                ОГРН
                            </td>
                            <td>
                                {{item[item_type].ogrn ? item[item_type].ogrn : '-'}}
                            </td>
                        </tr>
                        <tr v-if="item_type == 'arbitrationManager' || item_type == 'organizer'">
                            <td>
                                Оценка {{ item_type == 'arbitrationManager' ? 'арбитражного управляющего' : 'организатора'}}
                            </td>
                            <td>
                                <div class="bkt-wrapper-between align-items-center bkt-registry-rating">
<!--                                    <button v-if="item_type == 'organizer'" class="bkt-button next">-->
<!--                                        мои победы-->
<!--                                        <span class="bkt-text-red"-->
<!--                                              style="text-transform: initial"> (добавьте ИНН)  </span>-->
<!--                                        <bkt-icon name="ArrowDown" color="green"></bkt-icon>-->
<!--                                    </button>-->
                                    <div v-if="item[item_type] && item[item_type].rating" class="bkt-rating text-center">
                                        <h6>{{item[item_type].rating.estimate ? item[item_type].rating.estimate : 0}} / 5</h6>
                                        <star-rating :show-rating="false" :rating="item[item_type].rating.estimate" :read-only="true"
                                                     :star-size="16"
                                                     :increment="0.01" :rounded-corners="false"></star-rating>
                                    </div>
                                    <button class="bkt-button bkt-button_rating" data-bs-toggle="modal" data-bs-target="#ratingModal">
                                        оценить
                                        <bkt-icon name="ArrowDown" color="primary"
                                                  class="bkt-rotate-270"></bkt-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </bkt-table>
            </div>
        </div>
        <bkt-collapse v-if="item_type !== 'trade-place'" title="Активные торги" main_class="bkt-registry-collapse"
                      :count="active_lots_pagination.total ? active_lots_pagination.total : 0"
                      id="collapseBidderActiveLots" :loading="active_lots_loading"
                      :disabled="active_lots.length===0&&!active_lots_loading"
        >
            <template #collapse v-if="active_lots.length>0">
                <div class="bkt-form w-100 m-auto bkt-gap">
                    <div class="col-12 px-0 d-none d-md-block">
                        <div class="row w-100 mx-auto align-items-center justify-content-center">
                            <div class="col-2 pl-0">
                                <h6 class="bkt-text-neutral-dark">фото</h6>
                            </div>
                            <div class="col-3">
                                <h6 class="bkt-text-neutral-dark">описание лота</h6>
                            </div>
                            <div class="col-2">
                                <h6 class="bkt-text-neutral-dark">цена</h6>
                            </div>
                            <div class="col-2">
                                <h6 class="bkt-text-neutral-dark">даты торгов</h6>
                            </div>
                            <div class="col-3">
                                <h6 class="bkt-text-neutral-dark">ЭТП и организатор</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 px-0" v-for="active_lot in active_lots">
                        <mini-trade-card :item="active_lot"></mini-trade-card>
                    </div>
                    <div class="col-12 px-0">
                        <bkt-pagination
                            :limit="1"
                            :data="active_lots_pagination"
                            @change-page="getBidderActiveLots"
                        ></bkt-pagination>
                    </div>
                </div>
            </template>
        </bkt-collapse>
        <bkt-collapse v-if="item_type !== 'trade-place'" title="Завершённые торги" main_class="bkt-registry-collapse"
                      :count="completed_lots_pagination.total ? completed_lots_pagination.total : 0"
                      id="collapseCompletedLots" :loading="completed_lots_loading"
                      :disabled="completed_lots.length==0&&!completed_lots_loading"
        >
            <template #collapse v-if="completed_lots.length>0">
                <div class="row w-100 m-auto bkt-gap">
                    <div class="col-12 p-0 d-none d-md-block">
                        <div
                            style="padding-bottom: 10px"
                            class="row w-100 mx-auto align-items-center justify-content-center"
                        >
                            <div class="col-2 pl-0">
                                <h6 class="bkt-text-neutral-dark">фото</h6>
                            </div>
                            <div class="col-3">
                                <h6 class="bkt-text-neutral-dark">описание лота</h6>
                            </div>
                            <div class="col-2">
                                <h6 class="bkt-text-neutral-dark">цена</h6>
                            </div>
                            <div class="col-2">
                                <h6 class="bkt-text-neutral-dark">даты торгов</h6>
                            </div>
                            <div class="col-3">
                                <h6 class="bkt-text-neutral-dark">ЭТП и организатор</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 px-0" v-for="complete_lot in completed_lots">
                        <mini-trade-card :item="complete_lot"></mini-trade-card>
                    </div>
                    <div class="col-12 px-0">
                        <bkt-pagination
                            :limit="1"
                            :data="completed_lots_pagination"
                            @change-page="getBidderCompletedLots"
                        ></bkt-pagination>
                    </div>
                </div>
            </template>
        </bkt-collapse>
        <bkt-collapse v-if="item_type === 'debtor'" title="Сообщения по должнику" main_class="bkt-registry-collapse"
                      :count="messages_pagination.total ? messages_pagination.total : 0"
                      id="collapseMessages" :loading="messages_loading"
                      :disabled="messages.length==0&&!messages_loading"
        >
            <template #collapse v-if="messages.length>0">
              <bkt-table :loading="messages_loading" :items="messages">
                  <template #thead>
                      <tr>
                          <td>Сообщение</td>
                          <td width="30%">Дата</td>
                      </tr>
                  </template>
                  <template #tbody_tr="{item}">
                      <td>{{item.description}}</td>
                      <td>{{item.created_at | moment ('DD.MM.YYYY')}}</td>
                  </template>
              </bkt-table>
            </template>
        </bkt-collapse>
        <bkt-rating-modal v-if="item_type == 'arbitrationManager' || item_type == 'organizer'"
                          :type="item_type" :bidder-id="item.id" @estimated="estimated"
        >

        </bkt-rating-modal>
    </div>
</template>

<script>
    import BktTable from "../components/Table";
    import StarRating from "vue-star-rating";
    import BktRatingModal from "./LotCard/RatingModal";
    import {
        Hooper,
        Slide,
        Navigation as HooperNavigation
    } from 'hooper';
    import 'hooper/dist/hooper.css';
    import MiniTradeCard from "../components/MiniTradeCard";

    export default {
        name: "Registry",
        components: {
            BktTable,
            StarRating,
            Hooper,
            Slide,
            HooperNavigation,
            MiniTradeCard,
            BktRatingModal
        },
        data() {
            return {
                loading: false,
                item: '',
                item_type:'',
                active_lots: [],
                active_lots_loading: false,
                active_lots_pagination: {},
                completed_lots: [],
                completed_lots_loading: false,
                completed_lots_pagination: {},
                messages: [],
                messages_loading: false,
                messages_pagination: {},
            };
        },
        computed: {
            isLoggedIn() {
                return this.$store.getters.isLoggedIn
            },
        },
        async mounted() {
            this.item_type = this.$route.params.type;
            if(this.item_type !='trade-place') {
                this.getBidder();
            }
            else {
                this.getTradePlace();
            }

        },
        methods: {
            goBack() {
                window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/')
            },
            async getBidder() {
                this.loading = true;
                await this.$store.dispatch('getBidder', {id: this.$route.params.id, type: this.$route.params.type})
                    .then(resp => {
                        this.item = resp.data;
                        this.loading = false;
                        this.getBidderActiveLots();
                        this.getBidderCompletedLots();
                    })
                    .catch(error => {
                        this.loading = false;
                    });
                // }
            },
            async getBidderActiveLots(page = 1) {
                this.active_lots_loading = true;
                await this.$store.dispatch('getBidderLots', {
                    type: 'active',
                    bidderType: this.$route.params.type,
                    bidderId: this.$route.params.id,
                    page: page
                })
                    .then(resp => {
                        this.active_lots = resp.data.data;
                        this.active_lots_pagination = resp.data.pagination;
                    }).catch(error => {

                    }).finally(() => {
                        this.active_lots_loading = false;
                    })
            },
            async getBidderCompletedLots(page = 1) {
                this.completed_lots_loading = true;
                await this.$store.dispatch('getBidderLots', {
                    type: 'inactive',
                    bidderType: this.$route.params.type,
                    bidderId: this.$route.params.id,
                    page: page
                })
                    .then(resp => {
                        this.completed_lots = resp.data.data;
                        this.completed_lots_pagination = resp.data.pagination;
                    }).catch(error => {

                    }).finally(() => {
                        this.completed_lots_loading = false;
                    })
            },
            async getTradePlace() {
                this.loading = true;
                await this.$store.dispatch('getTradePlace', this.$route.params.id)
                    .then(resp => {
                        this.item = resp.data;
                        this.loading = false;
                    })
                    .catch(error => {
                        this.loading = false;
                    });
            },
            changeStatus(payload) {
                Vue.set(this.item, payload.key, payload.value)
            },
            estimated(value) {
                console.log('estimated', value)
                Vue.set(this.item[this.item_type], 'rating', value)
            }
        }
    }
</script>

<style scoped>

</style>
