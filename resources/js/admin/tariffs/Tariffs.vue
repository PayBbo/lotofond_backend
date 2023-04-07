<template>
    <AdminTable header="Тарифы и услуги" :columns="columns" :pagination="pagination" :getData="getData">
        <template v-slot:inline-block>
            <div class="row">
                <div class="col">
                    <router-link v-can="'tariff-add'" :to="'/admin/tariffs/add'" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i>
                    </router-link>
                </div>
            </div>
        </template>
        <template v-slot:raws-block>
            <tr v-for="item in dataItems">
                <td>{{ item.id }}</td>
                <td>{{ item.title }}</td>
                <td>{{ item.period === null ? 'Не задано' : item.period + ' дн.' }}</td>
                <td>{{ item.price  | priceFormat }} ₽</td>
                <td>{{ item.description }}</td>
                <td>
                    <router-link v-can="'tariff-edit'" :to="'/admin/tariffs/'+item.id" class="btn btn-primary btn-sm">
                        <i class="fas fa-pencil-alt"> </i>
                    </router-link>
                    <button v-can="'tariff-delete'" class="btn btn-danger btn-sm" @click="deleteItem(item.id)">
                        <i class="fas fa-trash-alt"> </i>
                    </button>
                </td>
            </tr>
        </template>
    </AdminTable>
</template>

<script>
import AdminTable from "../AdminTable";
import main from "../mixins/main";

export default {
    name: "Tariffs",
    components: {AdminTable},
    mixins: [main],
    data() {
        return {
            columns: {
                columns_title: ['ID', 'Заголовок', 'Период действия', 'Цена', 'Описание', 'Действия'],
                columns_sort: ['id', 'title', 'period', 'price','description', null]
            },
        }
    }
}
</script>

<style scoped>

</style>
