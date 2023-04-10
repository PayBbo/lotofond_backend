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
                            <router-link to="/admin/users" class="small-box-footer">
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
                            <router-link to="/admin/users" class="small-box-footer">
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
                            <router-link to="/admin/lots" class="small-box-footer">
                                Перейти
                                <i class="fas fa-arrow-circle-right"></i>
                            </router-link>
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
                            <router-link to="/admin/lots" class="small-box-footer">
                                Перейти
                                <i class="fas fa-arrow-circle-right"></i>
                            </router-link>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>

        <div v-can="'change-watermark'" class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Изменение фото и текста водяного знака</h1>
                    </div>
                </div>
            </div>
        </div>
        <section v-can="'change-watermark'" class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Текст водяного знака</label>
                                    <input required name="text" type="text" class="form-control"
                                           v-model="watermark.text">
                                </div>
                                <div class="form-group">
                                    <label>Изображение</label>
                                    <input ref="fileSelect" type="file" style="display: none">
                                    <img :src="watermark.image" width="15%" alt="image"/>
                                    <button type="button" class="btn btn-outline-primary"
                                            @click.prevent="selectFile()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <button type="submit" class="btn btn-success float-right" @click="saveWatermark()">
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

        <div v-can="'change-trial-period'" class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Изменение длительности тестового периода</h1>
                    </div>
                </div>
            </div>
        </div>
        <section v-can="'change-trial-period'"  class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Длительность тестового периода</label>
                                    <div class="input-group">
                                        <input name="trialPeriod" type="number" min="0" class="form-control"
                                               v-model="trialPeriod">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">дней</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success float-right" @click="saveTrialPeriod()">
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

import {mapActions, mapGetters, mapMutations} from "vuex";
import axios from "axios";

export default {
    name: "Dashboard",
    computed: {
        ...mapGetters(['newLotsCount', 'newLotsCount', 'lotsCount', 'usersCount', 'newUsersCount', 'watermark']),
        trialPeriod:{
                get(){ return this.$store.getters.trialPeriod; },
                set( value ){ this.$store.commit("setTrialPeriod", value );}
        }
    },
    created() {
        this.getDashboardData()
    },
    methods: {
        ...mapMutations(['setTrialPeriod']),
        ...mapActions(['getDashboardData']),
        selectFile() {
            this.$refs.fileSelect.click()
        },
        saveWatermark() {
            let file = this.$refs.fileSelect.files[0]
            let formData = new FormData()
            if (file !== undefined) {
                formData.append('image', file)
            }
            formData.append('text', this.watermark.text)

            axios.post('/api/admin/change-watermark', formData).then(response => {
                this.$store.commit('setModal', {data: 'success', text: 'Водяной знак успешно изменен'})
                this.getDashboardData()
            }).catch(error => {
                this.$store.commit('setModal', {data: 'error', text: error.response.data.detail})
            })
        },
        saveTrialPeriod() {
            axios.post('/api/admin/change-trial-period', {trialPeriod: this.trialPeriod}).then(response => {
                this.$store.commit('setModal', {data: 'success', text: 'Тестовый период успешно изменен'})
            }).catch(error => {
                this.$store.commit('setModal', {data: 'error', text: error.response.data.detail})
            })
        }
    }
}
</script>

<style scoped>

</style>
