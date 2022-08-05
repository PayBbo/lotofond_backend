<template>
    <AdminTable header="Пользователи" :columns="columns" :pagination="pagination" :getData="getData">
        <template v-slot:inline-block>
            <div class="card-tools w-25">
                <div class="input-group input-group-sm w-100">
                    <input type="text" v-model="param" name="table_search" class="form-control float-right"
                           placeholder="Поиск">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default" @click="getData">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:raws-block>
            <tr v-for="user in dataItems">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.lastName }}</td>
                <td>{{ user.email ? user.email : "Не указано" }}</td>
                <td>{{ user.phone ? user.phone : "Не указано" }}</td>
                <td>
                    <button type="submit" class="btn"
                            :class="user.isAdmin ? 'btn-danger' : 'btn-success' "
                            :disabled="user.id === user.authId"
                            @click="changeRole(user, user.isAdmin ? 'удалить' : 'добавить' )">
                        <i v-if="user.isAdmin" class="fas fa-minus-circle"></i>
                        <i v-else class="fas fa-plus-circle"></i>
                    </button>
                </td>
            </tr>
        </template>
    </AdminTable>
</template>

<script>
import AdminTable from "../AdminTable";
import main, {changeRole} from "../mixins/main";

export default {
    name: "Users",
    components: {AdminTable},
    mixins: [main],
    data() {
        return {
            columns: ['ID', 'Имя', 'Фамилия', 'Почта', 'Телефон', 'Администратор?'],
            param: ''
        }
    },
    methods: {
        changeRole,
    }
}
</script>
<style scoped>

</style>
