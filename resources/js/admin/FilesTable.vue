<template>
    <div class="form-group">
        <label>Прикрепленные {{ isImages ? 'изображения' : 'файлы' }}</label>
        <input ref="fileSelect" type="file" style="display: none" @change="uploadFile()"
               :accept="isImages ? '.jpg, .jpeg, .png .bmp' : '.*'">
        <button type="button" class="btn btn-outline-primary bkt-button-icon primary-outline bkt-hover-primary"
                @click.prevent="selectFile()">
            <bkt-icon name="Plus" color="primary" :width="'16px'" :height="'16px'"/>
<!--            <i class="fas fa-plus"></i>-->
        </button>
        <div class="table-responsive max-h-350px">
            <table class="table table-hover table-head-fixed text-nowrap mb-0">
                <thead>
                <tr>
                    <th style="width: 5%">№</th>
                    <th style="width: 25%">Наименование</th>
                    <th style="width: 60%">{{ isImages ? 'Изображение' : 'Ссылка на файл' }}</th>
                    <th style="width: 10%"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(file, index) in files">
                    <td>{{ index + 1 }}</td>
                    <td>{{ file.name ? file.name : ''}}</td>
                    <td>
                        <a v-if="!isImages" type="button" class="btn btn-secondary" :href="file.url"
                           target="_blank">
                            <bkt-icon name="Download"  color="primary"/>
                        </a>
                        <img v-else :src="file.url[0]" width="50%" alt="image"/>
                    </td>
                    <td>
                        <button v-can="'additions-delete'" class="btn btn-danger" @click="deleteFile(file.id)">
                            <bkt-icon name="Trash" color="white" :width="'22px'" :height="'22px'"/>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";

export default {
    name: "FilesTable",
    props: ['files', 'isImages', 'type', 'id'],
    methods: {
        selectFile() {
            this.$refs.fileSelect.click()
        },
        async uploadFile() {
            let file = this.$refs.fileSelect.files[0]
            let formData = new FormData()
            if (this.isImages) {
                formData.append('image', file)
            } else {
                formData.append('file', file)
            }
            formData.append('type', this.type)
            formData.append('id', this.id)

            await axios.post(
                '/api/admin/files/upload',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(response => {
                if (response.status === 200) {
                    this.$emit('change');
                    this.$store.commit('setModal', {data: 'success', text: 'Файл успешно загружен'})
                } else {
                    this.$store.commit('setModal', {data: 'error', text: 'Произошла ошибка при загрузке файла'})
                }
            }).catch(error => {
                this.$store.commit('setModal', {data: 'error', text: 'Произошла ошибка при загрузке файла'})
            })
        },
        deleteFile(id) {
            Vue.swal.fire({
                title: 'Вы уверены, что хотите удалить выбранный файл?',
                text: 'Отменить действие будет невозможно',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085D6',
                cancelButtonColor: '#D33',
                confirmButtonText: 'Да',
                cancelButtonText: 'Отменить',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await axios({
                        method: 'delete',
                        url: '/api/admin/files/' + id,
                        data: {},
                    })
                        .then((response) => {
                            if (response.status === 200) {
                                this.$emit('change');
                                this.$store.commit('setModal', {data: 'success', text: 'Файл успешно удален'})
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$store.commit('setModal', {data: 'error', text: 'Произошла ошибка при удалении файла'})
                        });
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
