<template>
    <bkt-modal :id="'fieldsToDocumentModal'" ref="fieldsToDocumentModal" :modal_class="'bkt-fields-document-modal'"
               :title="'Какие поля добавить в документ? (Excel)'" :loading="loading"
               :right_button="'Скачать'" :right_action="download"
               right_button_class="bkt-button bkt-bg-primary bkt-modal-save bkt-button_plump"
    >
        <template v-slot:left_button>
            <span></span>
        </template>
        <template #body="{ invalid }">
            <div class="text-left">
                <div class="bkt-fields-actions">
                    <span class="bkt-fields-action bkt-text-red me-2" @click="removeAllFields">Выключить все</span>
                    <span class="bkt-fields-action bkt-text-green"
                          @click="selectAllFields">Включить все</span>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6" v-for="(field, index)  in fields">
                        <bkt-checkbox v-model="doc[field.code]" :label="field.title" :name="'field-'+index">
                        </bkt-checkbox>
                    </div>
                </div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>

    export default {
        name: "AddFieldsToDocument",
        data() {
            return {
                loading: false,
                fields: [
                    {"title": "Номер торгов", code: 'addTradeNumber'},
                    {"title": "Ссылка ЕФРС", code: 'addEfrsbLink'},
                    {"title": "Наименование лота", code: 'addDescription'},
                    {"title": "Текущая цена", code: 'addCurrentPrice'},
                    {"title": "Тип торгов", code: 'addAuctionType'},
                    {"title": "Должник", code: 'addDebtor'},
                    {"title": "Арбитражный управляющий", code: 'addArbitrationManager'},
                    {"title": "Начало подачи заявок", code: 'addApplicationStart'},
                    {"title": "Окончание подачи заявок", code: 'addApplicationEnd'},
                    {"title": "Победитель торгов", code: 'addWinner'},
                    {"title": "Номер лота", code: 'addLotNumber'},
                    {"title": "Ссылка и название ЭТП", code: 'addTradePlace'},
                    {"title": "Начальная цена", code: 'addStartPrice'},
                    {"title": "Минимальная цена", code: 'addMinPrice'},
                    {"title": "Регион", code: 'addRegion'},
                    {"title": "Организатор", code: 'addOrganizer'},
                    {"title": "Начало торгов", code: 'addEventStart'},
                    {"title": "Окончание торгов", code: 'addEventEnd'},
                    {"title": "Заметка по лоту", code: 'addNote'}
                ],
                doc: {
                    "addTradeNumber": false,
                    "addEfrsbLink": false,
                    "addDescription": false,
                    "addCurrentPrice": false,
                    "addAuctionType": false,
                    "addDebtor": false,
                    "addArbitrationManager": false,
                    "addApplicationStart": false,
                    "addApplicationEnd": false,
                    "addWinner": false,
                    "addLotNumber": false,
                    "addTradePlace": false,
                    "addStartPrice": false,
                    "addMinPrice": false,
                    "addRegion": false,
                    "addOrganizer": false,
                    "addEventStart": false,
                    "addEventEnd": false,
                    "addNote": false
                }

            }
        },
        computed: {
            current_path() {
                return this.$store.getters.current_path;
            },
        },
        methods: {
            selectAllFields() {
                this.fields.forEach(item => {
                    this.doc[item.code] = true;
                })
            },
            removeAllFields() {
                this.fields.forEach(item => {
                    this.doc[item.code] = false;
                })
            },
            download() {
                this.loading=true;
                this.doc.pathId = this.current_path;
                this.$store.dispatch('downloadFavouritePath', this.doc)
                    .then( resp => {
                        var fileURL = window.URL.createObjectURL(resp.data.url);
                        var fileLink = document.createElement("a");

                        fileLink.href = resp.data.url;
                        fileLink.setAttribute("download", "summary.xlsx");
                        document.body.appendChild(fileLink);

                        fileLink.click();
                        this.$store.commit('closeModal', '#fieldsToDocumentModal')
                    })
                    .finally(()=> {
                    this.loading=false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
