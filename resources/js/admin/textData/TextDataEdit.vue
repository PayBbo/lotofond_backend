<template>
    <fragment>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{isEdit ? 'Редактирование раздела экрана '+item.screen : 'Добавление нового раздела'}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/admin/text-data" style="color: #007bff; text-decoration: none; background-color: transparent;">
                                    Текстовые данные
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">{{isEdit ? 'Редактирование' : 'Добавление'}}</li>
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
                                    <label>Название раздела</label>
                                    <input required name="title" type="text" class="form-control" v-model="item.header">
                                </div>
                                <div class="form-group">
                                    <label>Значение</label>
                                    <textarea required name="title" type="text" class="form-control" v-model="item.value"></textarea>
                                </div>
                                <div v-if="!isEdit" class="form-group">
                                    <label>Выберите экран</label>
                                    <select class="form-control" v-model="item.type" required>
                                        <option value="">Выберите экран для добавления раздела</option>
                                        <option v-for="type in types" :value="type.type">{{ type.screen }}</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success float-right" @click="isEdit ? updateData(item) : storeData(item)">Сохранить</button>
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
    name: "TextDataEdit",
    async created() {
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
        if (this.isEdit) {
            await this.editItem()
        }else{
            this.$store.commit('setItem',
                {header: '', value: '', 'type': '', 'screen': ''}
            )
        }
    },
    computed: {
        ...mapGetters(['item', 'types']),
        isEdit(){
            return !this.$route.path.includes('add')
        }
    },
    methods: {
        ...mapActions(['editItem', 'updateData', 'addData']),
        storeData(item){
            item.screen = this.types.find(type => type.type === item.type).screen
            this.addData(item)

        }
    }
}
</script>

<style scoped>

</style>

