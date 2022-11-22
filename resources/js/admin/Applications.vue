<template>
    <AdminTable header="Заявки" :columns="columns" :pagination="pagination" :getData="getData">
        <template v-slot:inline-block>
            <div class="card-tools w-25">
                <div class="input-group input-group-sm w-100">
                    <input type="text" v-model="param" name="table_search" class="form-control float-right"
                           placeholder="Поиск">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default" @click="searchParam(param)">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:raws-block>
            <tr v-for="(item, index) in dataItems">
                <td>{{ item.id }}</td>
                <td>{{ item.name ? item.name : "Не указано" }}</td>
                <td>{{ item.email ? item.email : "Не указано" }}</td>
                <td>{{ item.phone ? item.phone : "Не указано" }}</td>
                <td>{{ item.type }}</td>
                <td>
                    <button v-can="'application-edit'" type="submit" class="btn btn-sm"
                            :class="!item.isAnswered ? 'btn-danger' : 'btn-success' "
                            @click="updateData(item)">
                        <i v-if="!item.isAnswered" class="fas fa-minus-circle"></i>
                        <i v-else class="fas fa-plus-circle"></i>
                    </button>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalView"
                            @click="setModalData(index, modalColumns)">
                        <i class="fa fa-eye"></i>
                    </button>
                </td>
            </tr>
            <admin-view-modal :modalData="modalData" :mColumns="mColumns"></admin-view-modal>
        </template>
    </AdminTable>
</template>

<script>
import AdminTable from "./AdminTable";
import main from "./mixins/main";
import {mapActions} from "vuex";
import AdminViewModal from "./AdminViewModal";

export default {
    name: "Applications",
    components: {AdminViewModal, AdminTable},
    mixins: [main],
    data() {
        return {
            columns: ['#', 'Имя пользователя', 'Почта', 'Телефон', 'Тип обращения', 'Действия'],
            param: '',

            modalColumns: {'id':'Номер', 'name':'Имя пользователя', 'email':'Почта', 'phone':'Телефон',
                'socials':'Социальные сети для ответа', 'files':'Прикрепленные файлы', 'topic':'Тема',
                'question':'Вопрос', 'dateForAnswer':'Время для ответа',  'type':'Тип заявки',
                'lotUrl':'Ссылка на лот', 'isAnswered':'Заявка отвечена?'},
        }
    },
    methods: {
        ...mapActions([ 'updateData'])
    }
}
</script>

<style scoped>

</style>
