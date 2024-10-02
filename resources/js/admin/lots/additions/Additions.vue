<template>
    <AdminTable header="Ответы на запросы доп. информации по лотам" :columns="columns" :pagination="pagination"
                :getData="getData">
        <template v-slot:inline-block>
            <div class="row">
                <div class="col-3 text-left">
                    <admin-datepicker v-model="param.date" @input="startFilter"/>
                </div>
                <div class="col-3 text-left">
                    <div class="input-group input-group-sm w-100">
                        <input type="text" v-model="param.pattern" name="table_search" class="form-control float-right"
                               placeholder="Поиск">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default" @click="startFilter">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-4 text-center">
                    <input type="checkbox" class="form-check-input" v-model="param.isModerated" id="is-moderated" @change="startFilter">
                    <label  class="form-check-label" for="is-moderated">Показывать только непроверенные ответы</label>
                </div>
                <div class="col text-end">
                    <router-link v-can="'additions-add'" to="/admin/additions/store" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i>
                    </router-link>
                </div>
            </div>
        </template>
        <template v-slot:raws-block>
            <tr v-for="(item, index) in dataItems">
                <td>{{item.id}}</td>
                <td><div class="bkt-text-truncate-5">{{item.message}}</div></td>
                <td>{{ item.filesCount }}</td>
                <td>
                    <admin-switch v-can="'additions-edit'" :index="index" :model="item.isModerated"
                                  @change="changeStatusAdmin('additions/change/status/'+item.id)"></admin-switch>
                    <p v-cannot="'additions-edit'">{{ item.isModerated ? 'Да' : 'Нет' }}</p>
                </td>
                <td>{{ item.date }}</td>
                <td>
                    <a :href="'/admin/lots/'+ item.lotId" target="_blank"
                       style="color: #007bff; text-decoration: none; background-color: transparent;">
                        {{item.lotId}}
                    </a>
                </td>
                <td>
                    {{item.tradeId}}
                </td>
                <td>
                    <router-link v-can="'additions-edit'" :to="'/admin/additions/'+item.id"
                                 class="btn btn-primary btn-sm">
                        <i class="fas fa-pencil-alt"> </i>
                    </router-link>
                    <button v-can="'additions-delete'" class="btn btn-danger btn-sm" @click="deleteItem(item.id)">
                        <i class="fas fa-trash-alt"> </i>
                    </button>
                </td>
            </tr>
        </template>
    </AdminTable>
</template>

<script>
import AdminTable from "../../AdminTable";
import main from "../../mixins/main";
import AdminDatepicker from "../../AdminDatepicker";
import AdminSwitch from "../../AdminSwitch";
import {mapActions} from "vuex";
import _ from 'lodash'

export default {
    name: "Additions",
    components: {AdminSwitch, AdminTable, AdminDatepicker},
    mixins: [main],
    data() {
        return {
            columns: {
                columns_title: ['ID', 'Ответ', 'Количество файлов', 'Проверен?', 'Дата', 'Лот', 'Номер торгов', 'Действия'],
                columns_sort: ['id', 'message', 'files_count', 'is_moderated', 'created_at', 'lot_id', 'trade_id', null]
            },
            param: {'isModerated': false, 'date': null}
        }
    },
    methods: {
        ...mapActions(['changeStatusAdmin', 'getData']),
        search: _.debounce(function (value) {
            this.startFilter();
        }, 500),
        startFilter() {
            let result = this.serializeParams(this.param);
            this.searchParam(result)
        },
        serializeParams(obj) {
            let str = [];
            for (let p in obj)
                if (obj.hasOwnProperty(p)) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
            return str.join("&");
        },
    }
}
</script>

<style scoped>

</style>
