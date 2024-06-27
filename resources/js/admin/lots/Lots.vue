<template>
    <AdminTable header="Лоты" :columns="columns" :pagination="pagination" :getData="getData">
        <template v-slot:inline-block>
            <div class="row justify-content-end">
                <div class="col-4">
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
            </div>
        </template>
        <template v-slot:raws-block>
            <tr v-for="(lot, index) in dataItems">
                <td>{{ lot.id }}</td>
                <td style=" max-width: 500px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ lot.description }}
                </td>
                <td>{{ lot.startPrice | priceFormat }} ₽</td>
                <td>{{ lot.status }}</td>
                <td>{{ lot.tradeNumber }}</td>
                <td>{{ $t('trades.type.' + lot.tradeType) }}</td>
                <td>
                    <a v-if="lot.additionalLotInfoId" :href="'/admin/additions/'+ lot.additionalLotInfoId" target="_blank"
                       class="d-flex justify-content-center"
                    >
                        <span
                            :title="lot.additionalLotInfoIsModerated===true ? 'Проверен' : 'Непроверен'"
                            class="bkt-cursor-pointer"
                            :class="{'bkt-bg-green': lot.additionalLotInfoIsModerated == true,
                            'bkt-bg-red': lot.additionalLotInfoIsModerated === false}"
                            style="width: 20px; height: 20px; border-radius: 50%"
                        />
                    </a>
                    {{lot.additionalLotInfoIsModerated === null ? 'Нет' : ''}}
                </td>
                <td>{{ lot.publishDate }}</td>
                <td>
                    <router-link v-can="'lot-edit'" :to="'/admin/lots/'+lot.id" class="btn btn-primary btn-sm">
                        <i class="fas fa-pencil-alt"> </i>
                    </router-link>
                    <button v-can="'lot-delete'" class="btn btn-danger  btn-sm" @click="deleteItem(lot.id)">
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
            columns: {
                columns_title: ['ID', 'Описание', 'Начальная цена', 'Статус', 'Номер торгов', 'Тип торгов', 'Ответ', 'Дата публикации', 'Действия'],
                columns_sort: ['id', 'description', 'start_price', 'status_value', 'trade_number', 'trade_type', 'additional_lot_info_is_moderated', 'publish_date',   null]
            },
            param: ''
        }
    }
}
</script>

<style scoped>

</style>
