<template>
    <fragment>
        <div v-can="'emails-add'" class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Добавление новой контактной почты</h1>
                    </div>
                </div>
            </div>
        </div>
        <section v-can="'emails-add'" class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Почта</label>
                                    <input required name="title" type="text" class="form-control"
                                           v-model="item.contact">
                                </div>
                                <div class="form-group">
                                    <label>Выберите назначение</label>
                                    <select class="form-control" v-model="item.type" required>
                                        <option value="">Выберите назначение новой почты</option>
                                        <option v-for="type in types" :value="type">{{ type }}</option>
                                    </select>
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
        <AdminTable header="Почты для рассылки" :columns="columns" :pagination="pagination" :getData="getData">
            <template v-slot:inline-block>
                <div class="card-tools w-25">
                    <div class="input-group input-group-sm w-100">
                        <select class="form-control" v-model="compParam">
                            <option value="">Выберите назначение почты</option>
                            <option v-for="type in types" :value="type">{{ type }}</option>
                        </select>
                    </div>
                </div>
            </template>
            <template v-slot:raws-block>
                <tr v-for="item in dataItems">
                    <td>{{ item.contact }}</td>
                    <td>{{ item.type }}</td>
                    <td>
                        <button v-can="'emails-delete'" class="btn btn-danger btn-sm" @click="deleteItem(item.id)">
                            <i class="fas fa-trash-alt"> </i>
                        </button>
                    </td>
                </tr>
            </template>
        </AdminTable>
    </fragment>
</template>

<script>
import AdminTable from "./AdminTable";
import main from "./mixins/main";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Contacts",
    components: {AdminTable},
    mixins: [main],
    data() {
        return {
            columns: ['Почта', 'Назначение'],
            param: ''
        }
    },
    computed: {
        ...mapGetters(['item', 'types'])
    },
    async created() {
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
        this.$store.commit('setItem',
            {contact: '', type: ''}
        )
    },
    methods: {
        ...mapActions(['addData', 'getData']),
        storeData(item){
            this.addData(item)
            this.getData()
            this.$store.commit('setItem', {contact: '', type: ''})

        }
    }
}
</script>

<style scoped>

</style>
