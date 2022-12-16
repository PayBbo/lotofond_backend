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
                <td>{{ item.paymentId ? item.paymentId : "Отсутствует" }}</td>
                <td>
                    <select v-can="'application-edit'" class="form-control" v-model="item.status"
                            @change="updateData(item)">
                        <option v-for="status in statuses" :value="status.code">{{ status.title }}</option>
                    </select>
                </td>
                <td>
                    <button :id="'button-'+item.id" type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalView"
                            @click="showModal(index, modalColumns)">
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
import axios from "axios";

export default {
    name: "Applications",
    components: {AdminViewModal, AdminTable},
    mixins: [main],
    data() {
        return {
            columns: ['#', 'Имя пользователя', 'Почта', 'Телефон', 'Тип обращения', 'Номер платежа', 'Статус', 'Действия'],
            param: '',

            modalColumns: {
                'id': 'Номер', 'name': 'Имя пользователя', 'email': 'Почта', 'phone': 'Телефон',
                'socials': 'Социальные сети для ответа', 'files': 'Прикрепленные файлы', 'topic': 'Тема',
                'question': 'Вопрос', 'dateForAnswer': 'Время для ответа', 'type': 'Тип заявки',
                'lotUrl': 'Ссылка на лот', 'paymentId': 'Номер платежа', 'showStatus': 'Статус заявки'
            },
            statuses: [
                {'title': 'Не обработана', 'code': 'notProcessed'},
                {'title': 'В процессе', 'code': 'inProgress'},
                {'title': 'Отлонена системой', 'code': 'rejectedBySystem'},
                {'title': 'Отклонена пользователем', 'code': 'rejectedByUser'},
                {'title': 'Завершена', 'code': 'completed'}
            ]
        }
    },
    created() {
        let uri = window.location.search.substring(1)
        let params = new URLSearchParams(uri)
        let id = params.get("id")
        if (id !== null) {
            setTimeout(() => {
                let existsIndex = this.dataItems.map(item => item.id).indexOf(Number(id))
                console.log(existsIndex);
                if (existsIndex !== -1) {
                    this.showModal(existsIndex, this.modalColumns)
                    $("#modalView").modal('show');
                } else {
                    let index = 0
                    console.log(index);
                    axios({
                        method: 'get',
                        url: '/api/admin/applications/' + id,
                        data: {},
                    })
                        .then((response) => {
                            this.dataItems[index] = response.data
                            this.showModal(index, this.modalColumns)
                            $("#modalView").modal('show');
                        })
                        .catch((error) => {
                            console.log(error);
                        });

                }
            }, 400);
        }

    },
    methods: {
        ...mapActions(['updateData']),
        showModal(index, modalColumns) {
            this.dataItems[index]['showStatus'] = this.statuses.find(status => status.code === this.dataItems[index]['status']).title
            this.setModalData(index, modalColumns)
        }
    }
}
</script>

<style scoped>

</style>
