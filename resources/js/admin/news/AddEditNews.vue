<template>

    <fragment>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            {{
                                isEdit ? 'Редактирование информационного сообщения' : 'Добавление информационного сообщения'
                            }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/admin/news"
                                             style="color: #007bff; text-decoration: none; background-color: transparent;">
                                    Информационные сообщения
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
                                    <label>Описание (необязательное поле, если есть изображение)</label>
                                    <textarea required name="description" type="text" class="form-control"
                                              v-model="item.description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Изображение (необязательное поле, если есть описание)</label>
                                    <input class="form-control"
                                           type="file"
                                           ref="imageInput"
                                           accept="image/*"
                                           @change="handleFileUpload"/>
                                    <br>
                                    <img v-if="item.image !== null && item.image !== undefined && isEdit" :src="item.image" width="50%"
                                         alt="image"/>
                                    <button v-if="typeof (item.image) === 'string' && isEdit"
                                            class="btn btn-danger" @click="deleteFile">
                                        <i class="fas fa-trash-alt"> </i>
                                    </button>
                                </div>

                                <div class="form-group">
                                    <label>Отображается на сайте?</label>
                                    <admin-switch
                                        index="1"
                                        :model="item.isBanner"
                                        @change="item.isBanner = !item.isBanner"
                                    >
                                    </admin-switch>
                                </div>

                                <button type="submit" class="btn btn-success float-right"
                                        @click="storeData(item)">Сохранить
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
import AdminSwitch from "../AdminSwitch";

export default {
    name: "AddEditNews", components: {AdminSwitch},

    async created() {
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
        if (this.isEdit) {
            await this.editItem()
        } else {
            this.$store.commit('setItem',
                {description: null, image: null, imageBinary: null, isBanner: true}
            )
        }
    },
    computed: {
        ...mapGetters(['item', 'types']),
        isEdit() {
            return !this.$route.path.includes('add')
        }
    },
    methods: {
        ...mapActions(['editItem', 'updateData']),
        handleFileUpload() {
            this.item.imageBinary = this.$refs.imageInput.files[0];
        },
        deleteFile() {
            this.item.image = ''
        },
        storeData() {
            let formData = new FormData();
            if (this.item.imageBinary !== null && this.item.imageBinary !== undefined) {
                formData.append('imageBinary', this.item.imageBinary);
            }
            if(this.item.image !== null && this.item.image !== undefined) {
                formData.append('image', this.item.image);
            }
            if(this.item.description !== null && this.item.description !== undefined) {
                formData.append('description', this.item.description);
            }
            if(this.item.isBanner) {
                formData.append('isBanner', this.item.isBanner);
            }
            const context = this
            axios.post('/api' + this.$route.path.replace(/(\/*$)/, ""),
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            )
                .then(() => {
                    context.$store.commit('setModal', {data: 'success', text: 'Операция прошла успешно'})
                    context.$refs.imageInput.value = null
                    this.editItem()
                })
                .catch(() => {
                    context.$store.commit('setModal', {data: 'error', text: 'Произошла ошибка'})
                });
        },
    }
}
</script>

<style scoped>

</style>
