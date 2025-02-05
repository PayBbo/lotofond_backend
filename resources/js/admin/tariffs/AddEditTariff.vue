<template>
    <fragment v-if="item">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ isEdit ? 'Редактирование ' + ((item.type === 'tariff' || item.type === 'bot_tariff') ? 'тарифа' : 'услуги') : 'Добавление нового тарифа' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/admin/tariffs"
                                             style="color: #007bff; text-decoration: none; background-color: transparent;">
                                    Тарифы и услуги
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">{{ isEdit ? 'Редактирование' : 'Добавление' }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Название {{ ((item.type === 'tariff' || item.type === 'bot_tariff') || !isEdit ? 'тарифа' : 'услуги') }}</label>
                                    <div class="table-responsive max-h-350px">
                                        <table class="table table-hover table-head-fixed text-nowrap mb-0">
                                            <thead>
                                            <tr>
                                                <th style="width: 30%">Русский (ru)</th>
                                                <th style="width: 30%">Английский (en)</th>
                                                <th style="width: 30%">Китайский (zh_CN)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td v-for="(row, index) in item.title">
                                                    <input required :name="'title'+index" type="text"
                                                           class="form-control" v-model="item.title[index]">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="bkt-wrapper bkt-gap-medium bkt-nowrap">
                                    <div class="form-group w-100" v-if="(item.type === 'tariff' || item.type === 'bot_tariff') || !isEdit">
                                        <label>Период действия тарифа (в днях)</label>
                                        <div class="input-group">
                                            <input required name="period" class="form-control"
                                                   type="text" data-min="1" v-model="item.period"
                                                   @keyup="onlyNumber($event, 'period')">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">дн.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group w-100" v-if="(item.type === 'tariff' || item.type === 'bot_tariff' ) && !isEdit" >
                                        <label>Тип тарифа</label>
                                        <select class="form-control custom-select rounded-0" v-model="item.type">
                                            <option :value="'tariff'">
                                                Тариф для сайта
                                            </option>
                                            <option :value="'bot_tariff'">
                                                Тариф для бота
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Цена</label>
                                    <div class="input-group">
                                        <input required name="price" class="form-control"
                                               type="text" data-min="1" v-model="item.price"
                                               @keyup="onlyNumber($event, 'price')">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₽</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Описание {{ ((item.type === 'tariff' || item.type === 'bot_tariff' ) || !isEdit ? 'тарифа' : 'услуги') }}</label>
                                    <div class="table-responsive max-h-350px">
                                        <table class="table table-hover table-head-fixed text-nowrap mb-0">
                                            <thead>
                                            <tr>
                                                <th style="width: 30%">Русский (ru)</th>
                                                <th style="width: 30%">Английский (en)</th>
                                                <th style="width: 30%">Китайский (zh_CN)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td v-for="(row, index) in item.description">
                                                  <textarea required :name="'description'+index" class="form-control"
                                                            v-model="item.description[index]" rows="10"></textarea>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label> {{ ((item.type === 'tariff' || item.type === 'bot_tariff' ) || !isEdit ? 'Возможности, которые предоставляет тариф' : 'Детальное описание услуги по пунктам') }}</label>
                                    <div class="table-responsive max-h-350px">
                                        <table class="table table-hover table-head-fixed text-nowrap mb-0">
                                            <thead>
                                            <tr>
                                                <th style="width: 30%">Русский (ru)</th>
                                                <th style="width: 30%">Английский (en)</th>
                                                <th style="width: 30%">Китайский (zh_CN)</th>
                                                <th style="width: 10%">
                                                    <button @click.prevent="addNewOneItem('includedDetails')"
                                                            type="button"
                                                            class="btn btn-outline-primary">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(row, index) in item.includedDetails.ru">
                                                <td>
                                                    <input v-model="item.includedDetails.ru[index]" class="form-control"
                                                           required>
                                                </td>
                                                <td>
                                                    <input v-model="item.includedDetails.en[index]" class="form-control"
                                                           required>
                                                </td>
                                                <td>
                                                    <input v-model="item.includedDetails.zh_CN[index]"
                                                           class="form-control" required>
                                                </td>
                                                <td>
                                                    <button @click="removeOneItem('includedDetails', index)"
                                                            type="button"
                                                            class="btn btn-outline-danger">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group" v-if="(item.type === 'tariff' || item.type === 'bot_tariff' ) || !isEdit" >
                                    <label>Возможности, которых нет в тарифе</label>
                                    <div class="table-responsive max-h-350px">
                                        <table class="table table-hover table-head-fixed text-nowrap mb-0">
                                            <thead>
                                            <tr>
                                                <th style="width: 30%">Русский (ru)</th>
                                                <th style="width: 30%">Английский (en)</th>
                                                <th style="width: 30%">Китайский (zh_CN)</th>
                                                <th style="width: 10%">
                                                    <button @click.prevent="addNewOneItem('excludedDetails')"
                                                            type="button"
                                                            class="btn btn-outline-primary">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(row, index) in item.excludedDetails.ru">
                                                <td>
                                                    <input v-model="item.excludedDetails.ru[index]" class="form-control"
                                                           required>
                                                </td>
                                                <td>
                                                    <input v-model="item.excludedDetails.en[index]" class="form-control"
                                                           required>
                                                </td>
                                                <td>
                                                    <input v-model="item.excludedDetails.zh_CN[index]"
                                                           class="form-control" required>
                                                </td>
                                                <td>
                                                    <button @click="removeOneItem('excludedDetails',index)"
                                                            type="button"
                                                            class="btn btn-outline-danger">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success float-right"
                                        @click="isEdit ? updateData(item) : addData(item)">Сохранить
                                </button>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </fragment>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "AddEditTariff",
    async created() {
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
        if (this.isEdit) {
            await this.editItem()
        } else {
            this.$store.commit('setItem',
                {
                    title: {ru: null, en: null, zh_CN: null},
                    period: null,
                    price: null,
                    description: {ru: null, en: null, zh_CN: null},
                    includedDetails: {en: [], ru: [], zh_CN: []},
                    excludedDetails: {en: [], ru: [], zh_CN: []},
                    type: 'tariff'
                }
            )
        }
    },
    computed: {
        ...mapGetters(['item']),
        isEdit() {
            return !this.$route.path.includes('add')
        }
    },
    methods: {
        ...mapActions(['editItem', 'updateData', 'addData']),

        onlyNumber(e, item) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value < $(e.target).data('min')) {
                e.target.value = $(e.target).data('min');
            } else {
                e.target.value = value;
            }
            this.item[item] = e.target.value
        },
        addNewOneItem(nameItem) {
            this.item[nameItem].en.push('');
            this.item[nameItem].ru.push('');
            this.item[nameItem].zh_CN.push('');
        },
        removeOneItem(nameItem, index) {
            this.item[nameItem].en.splice(index, 1);
            this.item[nameItem].ru.splice(index, 1);
            this.item[nameItem].zh_CN.splice(index, 1);
        }
    }
}
</script>

<style scoped>
.max-h-350px {
    max-height: 350px
}
</style>
