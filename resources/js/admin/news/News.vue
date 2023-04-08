<template>
    <AdminTable header="Информационные сообщения" :columns="columns" :pagination="pagination"
                :getData="getData">
        <template v-slot:inline-block>
            <div class="row">
                <div class="col-4 text-end">
                    <router-link v-can="'additions-add'" to="/admin/news/add" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i>
                    </router-link>
                </div>

            </div>
        </template>
        <template v-slot:raws-block>
            <tr v-for="(item, index) in dataItems">
                <td>{{item.id}}</td>
                <td>{{ item.description === null ? 'Нет' : item.description}}</td>
                <td>
                    <img v-if="item.image !== null"  :src="item.image" width="50%" alt="image"/>
                    <p v-else >Нет</p>
                </td>
                <td>
                    <admin-switch v-can="'news-edit'" :index="index" :model="item.isBanner"
                                  @change="changeStatusAdmin('news/change/status/'+item.id)"></admin-switch>
                    <p v-cannot="'news-edit'">{{ item.isBanner ? 'Да' : 'Нет' }}</p>
                </td>
                <td>{{ item.publishDate }}</td>

                <td>
                    <router-link v-can="'news-edit'" :to="'/admin/news/'+item.id"
                                 class="btn btn-primary btn-sm">
                        <i class="fas fa-pencil-alt"> </i>
                    </router-link>
                    <button v-can="'news-delete'" class="btn btn-danger btn-sm" @click="deleteItem(item.id)">
                        <i class="fas fa-trash-alt"> </i>
                    </button>
                </td>
            </tr>
        </template>
    </AdminTable>
</template>

<script>
import AdminSwitch from "../AdminSwitch";
import AdminTable from "../AdminTable";
import main from "../mixins/main";
import {mapActions} from "vuex";

export default {
    name: "News",
    components: {AdminSwitch, AdminTable},
    mixins: [main],
    data() {
        return {
            columns: {
                columns_title: ['№','Описание', 'Картинка', 'Отображается на сайте?', 'Дата',  'Действия'],
                columns_sort: ['id', 'description', 'image', 'is_banner', 'created_at', null]
            },
        }
    },
    methods: {
        ...mapActions(['changeStatusAdmin', 'getData']),
    }
}
</script>

<style scoped>

</style>
