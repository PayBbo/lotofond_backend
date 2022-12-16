<<template>
    <AdminTable header="Отчеты ЕГРН" :columns="columns" :pagination="pagination" :getData="getData">
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
            <tr v-for="(statement, index) in dataItems">
                <td>{{ statement.id }}</td>
                <td>{{ statement.orderId }}</td>
                <td>
                    <a type="button" class="btn btn-secondary" :href="statement.file" v-if="statement.file !== null" target="_blank">
                        <i class="fas fa-download"></i>
                    </a>
                    <p v-if="statement.file === null">Нет данных</p>
                </td>
                <td>
                    <span class="badge" :class="statement.status === 'Завершен' ? 'bg-success' : 'bg-primary'">
                        {{ statement.status }}
                    </span>
                </td>
                <td>{{ statement.cadastralNumber }}</td>
                <td>{{ statement.lastCheckDate }}</td>
                <td>
                    <a :href="'/admin/applications?id='+ statement.applicationId" target="_blank"
                                 style="color: #007bff; text-decoration: none; background-color: transparent;">
                       Перейти к заявке
                    </a>
                </td>

            </tr>
        </template>
    </AdminTable>
</template>

<script>
import AdminTable from "./AdminTable";
import main from "./mixins/main";
export default {
    name: "Statements",
    components: {AdminTable},
    mixins: [main],
    data() {
        return {
            columns: ['ID', 'Номер заказа', 'Файл отчета', 'Статус',  'Кадастровый номер', 'Дата последней проверки', 'Заявка'],
            param: ''
        }
    }
}
</script>

<style scoped>

</style>
