<template>
    <fragment>
        <div class="content-header" v-if="!simple">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            {{ isEdit ? 'Редактирование ответа с доп.информацией' : 'Добавление нового ответа' }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/admin/additions"
                                             style="color: #007bff; text-decoration: none; background-color: transparent;">
                                    Ответы на запросы доп. информации по лотам
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
                                <template v-if="!simple">
                                    <div class="form-group" v-if="isEdit">
                                        <label>Ссылка на лот</label>
                                        <a :href="'/admin/lots/'+ item.lotId" target="_blank"
                                           style="color: #007bff; text-decoration: none; background-color: transparent;">
                                            Перейти к лоту
                                        </a>
                                    </div>
                                    <div class="form-group" v-else>
                                        <label>Выберите лот (для поиска введите номер торга или часть описания лота)</label>
                                        <admin-select :options="lots" @search="getLots" v-model="item.lotId" @selected="setLot"></admin-select>
                                    </div>
                                </template>

                                <div class="form-group">
                                    <label>Текст сообщения</label>
                                   <!--- <vue-editor v-model="item.message"
                                                :editor-toolbar="customToolbar"
                                                :editorOptions="editorOptions">
                                    </vue-editor> ----->
                                    <textarea v-model="item.message" class="form-control" required rows="10" name="message"></textarea>
                                </div>
                                <div class="form-group" v-if="isEdit">
                                    <files-table
                                                 :files="item.files"
                                                 :is-images="false"
                                                 type="additions"
                                                 :id="item.id"
                                                 @change="editItem">
                                    </files-table>
                                </div>
                                <div class="form-group" v-if="isEdit">
                                    <files-table
                                                 :files="item.images"
                                                 :is-images="true"
                                                 type="additions"
                                                 :id="item.id"
                                                 @change="editItem">
                                    </files-table>
                                </div>
                                <div class="form-group">
                                    <label>Отображать ответ на сайте?</label>
                                    <admin-switch
                                                  index="1"
                                                  :model="item.isModerated"
                                                  @change="item.isModerated = !item.isModerated"
                                    >
                                    </admin-switch>
                                </div>
                                <div class="bkt-wrapper bkt-gap-small justify-content-end">
                                    <button type="submit" class="btn btn-success float-right"
                                            @click="isEdit ? editLot(item) : addData(item)">
                                        Сохранить
                                    </button>
                                    <button type="submit" class="btn btn-default float-right" v-if="simple"
                                            @click="$emit('cancel')">
                                        Отмена
                                    </button>
                                </div>

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
import AdminSwitch from "../../AdminSwitch";
import {mapActions, mapGetters} from "vuex";
import FilesTable from "../../FilesTable";
import {VueEditor} from "vue2-editor";
import AdminSelect from "../../AdminSelect";
import axios from "axios";
import Textarea from "../../../components/Textarea";

export default {
    name: "AddEditAdditions",
    components: {Textarea, AdminSelect, VueEditor, FilesTable, AdminSwitch},
    props: {
        simple: {
            type: Boolean,
            default: false
        },
        answer_id: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
           /* customToolbar: [
                [{'header': [1, 2, 3, 4, 5, 6, false]}, 'bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'link', 'code-block'],
                [{'header': 1}, {'header': 2},],
                [{'list': 'ordered'}, {'list': 'bullet'}],
                [{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
                [{'color': []}, {'background': []}],
                ['clean']
            ],
            editorOptions: {
                formats: [
                    'background',
                    'bold',
                    'color',
                    'code',
                    'italic',
                    'link',
                    'size',
                    'strike',
                    'script',
                    'underline',
                    'blockquote',
                    'header',
                    'indent',
                    'list',
                    'align',
                    'code-block'
                ]
            },*/
            lot: null,
            lots: []
        }
    },
    async created() {
        this.$store.commit('setCurrentRoute', this.simple ? '/admin/additions/'+this.answer_id : this.$route.path.replace(/(\/*$)/, ""))
        this.$store.commit('setItem',
            {message: '', files: [], images: [], isModerated: false, lotId: null}
        )
        if (this.isEdit) {
            await this.editItem()
        }else{
            await this.getLots()
        }
    },
    computed: {
        ...mapGetters(['item']),
        isEdit() {
            return !this.$route.path.includes('store')
        }
    },
    methods: {
        ...mapActions(['changeStatusAdmin', 'editItem', 'updateData', 'addData']),
        async getLots(page = 1, search = '') {
            await axios({
                method: 'get',
                url: '/api/admin/lots/shorts?search='+search+'&page='+page,
                data: {},
            })
                .then((response) => {
                    this.lots = response.data
                })
                .catch((error) => {
                    console.log(error);
                    this.$store.commit('setModal', {data: 'error', text: 'Произошла ошибка при загрузке данных'})
                });
        },
        setLot(val){
            this.item.lotId = val.code
        },
        async editLot(item) {
            await this.updateData(item)
                .then(resp => {
                    this.$emit('update');
                });
        }
    }
}
</script>

<style scoped>

</style>
