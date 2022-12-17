<template>
    <AdminTable header="Пользователи" :columns="columns" :pagination="pagination" :getData="getData">
        <template v-slot:inline-block>
            <div class="row">
                <div class="col">
                    <router-link v-can="'user-add'" :to="'/admin/users/add'" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i>
                    </router-link>
                </div>
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
            <tr v-for="user in dataItems">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.surname }}</td>
                <td>{{ user.email ? user.email : "Не указано" }}</td>
                <td v-if="user.phone"><input style="border: none; background: transparent"
                                             v-mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
                                             readonly disabled  v-model="user.phone"></td>
                <td v-else >Не указано</td>
                <td>{{ user.registrationDate }}</td>
                <td>
                    <router-link v-can="'user-edit'" :to="'/admin/users/'+user.id" class="btn btn-primary btn-sm">
                        <i class="fas fa-pencil-alt"> </i>
                    </router-link>

                    <button v-can="'user-delete'" class="btn btn-danger  btn-sm" @click="deleteItem(user.id)">
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
import {mask} from 'vue-the-mask'
export default {
    name: "Users",
    components: {AdminTable},
    mixins: [main],
    directives:{mask},
    data() {
        return {
            columns: ['ID', 'Имя', 'Фамилия', 'Почта', 'Телефон', 'Дата регистрации', 'Действия'],
            param: ''
        }
    }
}
</script>
<style scoped>

</style>
