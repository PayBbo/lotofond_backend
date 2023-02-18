<template>
    <AdminTable header="Ограничения доступа к контенту на бесплатном тарифе"
                :columns="columns" :pagination="pagination" :getData="getData">
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
            <tr v-for="(item, index) in dataItems">
                <td>{{ item.title }}</td>
                <td>
                    <admin-switch v-can="'content-rules-edit'" :index="index" :model="item.isAvailable"
                                  @change="updateData(item)"></admin-switch>
                    <p v-cannot="'content-rules-edit'">{{ item.isAvailable ? 'Да' : 'Нет' }}</p>
                </td>
            </tr>
        </template>
    </AdminTable>

</template>

<script>
import {mapActions, mapGetters} from "vuex";
import main from "./mixins/main";
import AdminTable from "./AdminTable";
import AdminSwitch from "./AdminSwitch";

export default {
    name: "ContentRules",
    components: {AdminTable,AdminSwitch},
    methods: {
        ...mapActions(['updateData']),
    },
    mixins: [main],
    data() {
        return {
            columns: ['Контент', 'Доступно ли на бесплатном тарифе?'],
            param: ''
        }
    },
    async created() {
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
    }
}
</script>

<style scoped>

</style>
