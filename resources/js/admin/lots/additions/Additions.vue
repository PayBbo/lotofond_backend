<template>
    <AdminTable header="Ответы на запросы доп. информации по лотам" :columns="columns" :pagination="pagination"
                :getData="getData">
        <template v-slot:inline-block>
            <div class="row">
                <div class="col-4 text-left">
                    <admin-datepicker v-model="param.date" @input="searchParam(param)"></admin-datepicker>
                </div>
                <div class="col-4 text-center">
                    <input type="checkbox" class="form-check-input" v-model="param.isModerated" id="is-moderated" @change="searchParam(param)">
                    <label  class="form-check-label" for="is-moderated">Показывать только непроверенные ответы</label>
                </div>
                <div class="col-4 text-end">
                    <router-link v-can="'additions-add'" to="/admin/additions/store" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i>
                    </router-link>
                </div>

            </div>
        </template>
        <template v-slot:raws-block>
            <tr v-for="(item, index) in dataItems">
                <td>{{item.id}}</td>
                <td>{{item.message}}</td>
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
                        Перейти к лоту
                    </a>
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

export default {
    name: "Additions",
    components: {AdminSwitch, AdminTable, AdminDatepicker},
    mixins: [main],
    data() {
        return {
            columns: {
                columns_title: ['ID', 'Ответ', 'Количество файлов', 'Проверен?', 'Дата', 'Лот', 'Действия'],
                columns_sort: ['id', 'message', 'files_count', 'is_moderated', 'created_at', 'lot_id', null]
            },
            param: {'isModerated': false, 'date': null}
        }
    },
    methods: {
        ...mapActions(['changeStatusAdmin', 'getData']),
    }
}
</script>

<style scoped>

</style>
