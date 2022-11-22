<template>
    <fragment>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Добавление новой роли</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Название</label>
                                    <input required name="name" type="text" class="form-control"
                                           onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 48 && event.charCode <= 57)"
                                           v-model="item.name">
                                </div>
                                <button type="submit" class="btn btn-success float-right" @click="storeData(item)">
                                    Сохранить
                                </button>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <AdminTable header="Роли" :columns="columns" :pagination="pagination" :getData="getData">
            <template v-slot:raws-block>
                <tr v-for="role in dataItems">
                    <td>{{ role.id }}</td>
                    <td>{{ role.name }}</td>
                    <td>
                        <router-link :to="'/admin/roles/'+role.id" class="btn btn-primary btn-sm">
                            <i class="fas fa-pencil-alt"> </i>
                        </router-link>
                        <button v-if="role.name !== 'admin' && role.name !== 'user'" class="btn btn-danger btn-sm" @click="deleteItem(role.id)">
                            <i class="fas fa-trash-alt"> </i>
                        </button>
                    </td>
                </tr>
            </template>
        </AdminTable>
    </fragment>
</template>

<script>
import AdminTable from "../AdminTable";
import main from "../mixins/main";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Roles",
    components: {AdminTable},
    mixins: [main],
    data() {
        return {
            columns: ['ID', 'Название', 'Действия'],
            param: ''
        }
    },
    computed: {
        ...mapGetters(['item'])
    },
    async created() {
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
        this.$store.commit('setItem',
            {name: ''}
        )
    },
    methods: {
        ...mapActions(['addData', 'getData']),
        storeData(item){
            this.addData(item)
            this.getData()
            this.$store.commit('setItem', {name: ''})

        }
    }
}
</script>

<style scoped>

</style>
