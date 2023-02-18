<template>
    <fragment>
        <div v-can="'holidays-add'" class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Добавление праздничного дня</h1>
                    </div>
                </div>
            </div>
        </div>
        <section v-can="'holidays-add'" class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Дата праздничного дня</label>
                                    <admin-datepicker v-model="item.date"></admin-datepicker>
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
        <AdminTable header="Праздничные дни" :columns="columns" :pagination="pagination" :getData="getData">
            <template v-slot:inline-block>
                <div class="row justify-content-end">
                    <div class="col-4">
                        <div class="input-group input-group-sm w-100 justify-content-end">
                            <admin-datepicker v-model="param"></admin-datepicker>
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
                <tr v-for="item in dataItems">
                    <td>{{ item.date }}</td>
                    <td>
                        <button v-can="'holidays-delete'" class="btn btn-danger btn-sm" @click="deleteItem(item.id)">
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
import AdminDatepicker from "./AdminDatepicker";

export default {
    name: "HolidaysDates",
    components: {AdminTable, AdminDatepicker},
    mixins: [main],
    data() {
        return {
            columns: ['Дата праздника', 'Действия'],
            param: ''
        }
    },
    computed: {
        ...mapGetters(['item'])
    },
    async created() {
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
        this.$store.commit('setItem',
            {date: ''}
        )
    },
    methods: {
        ...mapActions(['addData', 'getData']),
        storeData(item) {
            this.addData(item)
            this.getData()
            this.$store.commit('setItem', {contact: '', type: ''})

        }
    }
}
</script>

<style scoped>

</style>
