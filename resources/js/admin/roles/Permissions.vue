<template>
    <fragment>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Редактирование роли и прав</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/admin/roles"
                                             style="color: #007bff; text-decoration: none; background-color: transparent;">
                                    Роли
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">Редактирование</li>
                        </ol>
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
                                    <label>Название роли</label>
                                    <input required name="name" type="text" class="form-control" v-model="item.name">
                                </div>
                                <div class="form-group">
                                    <label>Права роли</label>
                                    <div :id="'accordion'+index" v-for="(permission, index) in permissions">
                                        <div class="card card-light" >
                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a class="d-block w-100 collapsed" data-toggle="collapse"
                                                       :href="'#collapse'+index" aria-expanded="true">
                                                       {{permission.group}}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div :id="'collapse'+index" class="collapse" :data-parent="'#accordion'+index" style="">
                                                <div class="card-body">
                                                    <div class="custom-control custom-checkbox" v-for="item in permission.permissions">
                                                        <input class="custom-control-input" type="checkbox" :id="'customCheckbox'+item.id" name="customCheckbox">
                                                        <label :for="'customCheckbox'+item.id" class="custom-control-label">{{item.visible_name}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success float-right" @click="updateData(item)">
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
    </fragment>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import axios from "axios";

export default {
    name: "Permissions",
    data() {
        return {
            permissions: []
        }
    },
    async created() {
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
        await this.editItem()
        await this.getPermissions()
    },
    mounted() {
        window.onload = () => {
            setTimeout(() => {
                $('[id*="collapse"]').each((index) => {
                    $('#collapse'+index).collapse()
                });
            }, 400);
        };
    },
    computed: {
        ...mapGetters(['item', 'types'])
    },
    methods: {
        ...mapActions(['editItem', 'updateData']),
        async getPermissions() {
            await axios({
                method: 'get',
                url: '/api/admin/roles/permissions',
                data: {},
            })
                .then((response) => {
                    this.permissions = response.data
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>

</style>
