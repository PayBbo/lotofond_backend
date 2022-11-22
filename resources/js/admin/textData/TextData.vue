<template>
    <AdminTable header="Текстовые данные" :columns="columns" :pagination="pagination" :getData="getData">
        <template v-slot:inline-block>
            <router-link v-can="'text-data-add'" :to="'/admin/text-data/add'" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i>
            </router-link>
            <div class="card-tools w-25">
                <div class="input-group input-group-sm w-100">
                    <select class="form-control" v-model="compParam">
                        <option v-for="type in types" :value="type.type">{{ type.screen }}</option>
                    </select>
                </div>
            </div>
        </template>
        <template v-slot:raws-block>
            <tr v-for="item in dataItems">
                <td>{{ item.header }}</td>
                <td>{{ item.value }}</td>
                <td>
                    <router-link v-can="'text-data-edit'" :to="'/admin/text-data/'+item.id" class="btn btn-primary btn-sm">
                        <i class="fas fa-pencil-alt"> </i>
                    </router-link>
                    <button v-can="'text-data-delete'" class="btn btn-danger btn-sm" @click="deleteItem(item.id)">
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
import {mapGetters} from "vuex";

export default {
    name: "TextData",
    components: {AdminTable},
    mixins: [main],
    data() {
        return {
            columns: ['Заголовок', 'Значение', 'Действия'],
            param: 'contacts'
        }
    },
    computed: {
        ...mapGetters(['types'])
    }
}
</script>

<style scoped>

</style>
