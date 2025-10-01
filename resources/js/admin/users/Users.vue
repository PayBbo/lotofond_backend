<template>
    <AdminTable header="Пользователи" :columns="columns" :pagination="pagination" :getData="getData">
        <template v-slot:inline-block>
            <div class="row justify-content-end">
                <div class="col">
                    <router-link v-can="'user-add'" :to="'/admin/users/add'" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i>
                    </router-link>
                </div>
                <div class="col-4">
                    <p class="mb-0">Регион</p>
                    <div class="input-group input-group-sm w-100">
                        <select class="form-control" v-model="param.region" @input="chooseRegion">
                            <option v-for="region in region_options" :value="region.value">{{ region.label }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <p class="mb-0">Поиск</p>
                    <div class="input-group input-group-sm w-100">
                        <input type="text" v-model="param.search" name="table_search" class="form-control float-right"
                               placeholder="Поиск">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default" @click="startFilter">
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
                <td>{{ user.name ? user.name : "Не указано"}}</td>
                <td>{{ user.surname ? user.surname : "Не указано"}}</td>
                <td>{{ user.email ? user.email : "Не указано" }}</td>
                <td v-if="user.phone"><input style="border: none; background: transparent"
                                             v-mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
                                             readonly disabled  v-model="user.phone"></td>
                <td v-else >Не указано</td>
                <td>{{ user.region ? user.region : "Не указано" }}</td>
                <td>{{ user.registrationDate }}</td>
                <td>
                    <div>Сайт: {{ user.finishedAt ? user.finishedAt : 'Нет тарифа' }} {{user.finishedAt ? '('+ user.diffInDays +' дней)' : ''}}</div>
                    <div>Бот: {{ user.botFinishedAt ? user.botFinishedAt : 'Нет тарифа' }} {{user.botFinishedAt ? '('+ user.botDiffInDays +' дней)' : ''}}</div>
                </td>
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
            columns: {
                columns_title: ['ID', 'Имя', 'Фамилия', 'Почта', 'Телефон', 'Регион', 'Дата регистрации', 'Окончание подписки', 'Действия'],
                columns_sort: ['id', 'name', 'surname', 'email', 'phone', 'regions.title', 'email_verified_at', 'user_tariff.finished_at', null]
            },
            param: {'search': null, region: null},
        }
    },
    created() {
        this.getRegions();
    },
    computed: {
        region_options() {
            let tmp = [].concat.apply([], this.$store.getters.regions.map(item => item.regions));
            let result =[];
            tmp.forEach(item => {
                result.push({label: this.$t('regions.'+item), value: item});
            });
            result = result.sort((a, b) => a.label.localeCompare(b.label));
            result.unshift({label: 'Не выбрано', value: null});
            return result
        },
    },
    methods: {
        startFilter() {
            let result = this.serializeParams(this.param);
            this.searchParam(result)
        },
        serializeParams(obj) {
            let str = [];
            for (let p in obj)
                if (obj.hasOwnProperty(p) && obj[p] != null) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
            return 'null&'+str.join("&");
        },
        async getRegions() {
            await this.$store.dispatch('getRegions')
        },
        chooseRegion(event) {
            this.param.region = event.target.value;
            this.startFilter()
        }
    }
}
</script>
<style scoped>

</style>
