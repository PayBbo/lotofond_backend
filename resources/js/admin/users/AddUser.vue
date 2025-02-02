<template>
    <fragment>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            {{ isEdit ? 'Редактирование данных пользователя ' : 'Добавление нового пользователя' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/admin/users"
                                             style="color: #007bff; text-decoration: none; background-color: transparent;">
                                    Пользователи
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">{{ isEdit ? 'Редактирование' : 'Добавление' }}</li>
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
                                    <label>Имя пользователя</label>
                                    <input required name="name" type="text" class="form-control" v-model="item.name"
                                           placeholder="Введите имя пользователя">
                                </div>
                                <div class="form-group">
                                    <label>Фамилия пользователя</label>
                                    <input required name="surname" type="text" class="form-control"
                                           v-model="item.surname"
                                           placeholder="Введите фамилию пользователя">
                                </div>
                                <div class="form-group">
                                    <label>Отчество пользователя</label>
                                    <input name="middleName" type="text" class="form-control" v-model="item.middleName"
                                           placeholder="Введите отчество пользователя">
                                </div>
                                <div class="form-group">
                                    <label>Почта (обязательно, если не задан телефон)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input name="email" type="text" class="form-control" v-model="item.email"
                                               placeholder="Введите почту пользователя">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Телефон (обязательно, если не задана почта)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                        </div>
                                        <input name="phone" type="tel" class="form-control" v-model="item.phone"
                                               v-mask="['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
                                               placeholder="Введите телефон пользователя">
                                    </div>
                                </div>
                                <div class="form-group" v-if="!isEdit">
                                    <label>Пароль пользователя (не менее 8 символов)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                                        </div>
                                        <input name="password" type="text" class="form-control" v-model="item.password"
                                               placeholder="Введите пароль пользователя" required>
                                        <span class="input-group-append">
                                        <button type="button" class="btn btn-info btn-flat"
                                                @click="generatePassword">Сгенерировать</button>
                                    </span>
                                    </div>

                                </div>

                                <div class="form-group" v-if="!isEdit">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                               id="notificationsFromFavourite"
                                               v-model="item.notificationsFromFavourite">
                                        <label class="custom-control-label" for="notificationsFromFavourite">
                                            {{
                                                item.notificationsFromFavourite ? 'Уведомления от избранного активированы для пользователя' :
                                                    'Уведомления от избранного отключены для пользователя'
                                            }}
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group" v-if="!isEdit">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                               id="notificationsFromMonitoring"
                                               v-model="item.notificationsFromMonitoring">
                                        <label class="custom-control-label" for="notificationsFromMonitoring">
                                            {{
                                                item.notificationsFromMonitoring ? 'Уведомления от мониторинга активированы для пользователя' :
                                                    'Уведомления от мониторинга отключены для пользователя'
                                            }}
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group" v-if="!isEdit">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="notificationsToEmail"
                                               v-model="item.notificationsToEmail">
                                        <label class="custom-control-label" for="notificationsToEmail">
                                            {{
                                                item.notificationsToEmail ? 'Уведомления на почту активированы для пользователя' :
                                                    'Уведомления на почту отключены для пользователя'
                                            }}
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Выберите тариф для пользователя</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-tags"></i></span>
                                        </div>
                                        <select class="form-control custom-select rounded-0" v-model="item.tariff">
                                            <option :value="null">Выберите тариф для пользователя</option>
                                            <option v-for="tariff in tariffs" :value="tariff.id">{{
                                                    tariff.title
                                                }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Выберите регион для пользователя</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-location-arrow"></i></span>
                                        </div>
                                    <v-select
                                        class="my-v-select"
                                        v-model="item.region"
                                        :options="regions"
                                    >
                                    </v-select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Роли</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-users"></i></span>
                                        </div>
                                        <v-select
                                            class="my-v-select"
                                            multiple
                                            v-model="item.roles"
                                            :options="roles.map(role=>role.name)"

                                        >
                                        </v-select>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-success float-right"
                                        @click="isEdit ? updateData(item) : storeData(item)">Сохранить
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
import {mask} from 'vue-the-mask'
export default {
    name: "AddUser",
    data() {
        return {
            roles: [],
            tariffs: [],
            regions: []
        }
    },
    directives:{mask},
    async created() {
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
        if (this.isEdit) {
            await this.editItem()
        } else {
            this.$store.commit('setItem',
                {
                    name: '', surname: '', middleName: '', email: null, region: null,
                    phone: null, password: '', notificationsFromFavourite: true, notificationsFromMonitoring: true,
                    notificationsToEmail: true, roles: ['user'], tariff: null
                }
            )
        }
        await this.getRoles()
        await this.getTariffs()
        await this.getRegions()
    },
    computed: {
        ...mapGetters(['item', 'types']),
        isEdit() {
            return !this.$route.path.includes('add')
        }
    },
    methods: {
        ...mapActions(['editItem', 'updateData', 'addData']),
        storeData(item) {
            this.addData(item)

        },
        generatePassword() {
            let length = 8,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                retVal = "";
            for (let i = 0, n = charset.length; i < length; ++i) {
                retVal += charset.charAt(Math.floor(Math.random() * n));
            }
            this.item.password = retVal;
        },
        async getRoles() {
            await axios({
                method: 'get',
                url: '/api/admin/roles',
                data: {},
            })
                .then((response) => {
                    this.roles = response.data.data
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async getTariffs() {
            await axios({
                method: 'get',
                url: '/api/admin/tariffs',
                data: {
                    type: 'tariff',
                    active: true
                },
            })
                .then((response) => {
                    this.tariffs = response.data.data
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async getRegions() {
            await axios({
                method: 'get',
                url: '/api/admin/regions',
                data: {},
            })
                .then((response) => {
                    this.regions = response.data
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }

}
</script>

<style scoped>
.my-v-select {
    position: relative;
    flex: 1 1 auto;
    width: 1%;
    min-width: 0;
}
</style>
