<template>
    <fragment>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Статистика</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ usersCount }}</h3>
                                <p>Пользователи</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person"></i>
                            </div>
                            <router-link to="/admin/users"  class="small-box-footer">
                                Перейти
                                <i class="fas fa-arrow-circle-right"></i>
                            </router-link>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="small-box bg-gradient-success">
                            <div class="inner">
                                <h3>{{ newUsersCount }}</h3>
                                <p>Новые регистрации</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <router-link to="/admin/users"  class="small-box-footer">
                                Перейти
                                <i class="fas fa-arrow-circle-right"></i>
                            </router-link>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="small-box bg-gradient-warning">
                            <div class="inner">
                                <h3>{{ lotsCount }}</h3>
                                <p>Лоты</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-bookmark"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                Перейти <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="small-box bg-gradient-danger">
                            <div class="inner">
                                <h3>{{ newLotsCount }}</h3>
                                <p>Новые лоты</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-bookmark"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                Перейти <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Почты для рассылки</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Почта для отправки заявок на покупку без ЕЦП</label>
                                    <input required name="email0" v-model="contacts[0].contact" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Почта для отправки вопросов</label>
                                    <input required name="email1"  v-model="contacts[1].contact" type="text" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-success float-right" @click="updateContacts({'contacts':contacts})">Сохранить</button>
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

export default {
    name: "Dashboard",
    computed: {
        ...mapGetters(['newLotsCount','newLotsCount', 'lotsCount', 'usersCount', 'newUsersCount', 'contacts'])
    },
    created() {
        this.getDashboardData()
    },
    methods: {
        ...mapActions(['getDashboardData', 'updateContacts'])
    }
}
</script>

<style scoped>

</style>
