<template>
    <AdminTable header="Лоты" :columns="columns" :pagination="pagination" :getData="getData">
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
            <tr v-for="(lot, index) in dataItems">
                <td>{{ lot.id }}</td>
                <td style=" max-width: 500px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ lot.description }}</td>
                <td>{{ lot.startPrice | priceFormat}} ₽</td>
                <td>{{ lot.status }}</td>
                <td>{{ lot.tradeNumber }}</td>
                <td>{{ $t('trades.type.'+ lot.tradeType) }}</td>
                <td>
                    <router-link :to="'/admin/lots/'+lot.id" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"> </i>
                    </router-link>
                    <button v-can="'lot-delete'" class="btn btn-danger  btn-sm" @click="deleteItem(lot.id)" >
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
    name: "Lots",
    components: {AdminTable},
    mixins: [main],
    data() {
        return {
            columns: ['ID', 'Описание', 'Начальная цена', 'Статус',  'Номер торгов', 'Тип торгов', 'Действия'],
            param: ''
        }
    }
}
</script>

<style scoped>

</style>
