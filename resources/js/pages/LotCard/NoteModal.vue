<template>
    <bkt-modal :id="'noteModal'" title="Заметка по лоту" modal_class="bkt-filters-modal"
               @left_action="clearNote" @right_action="saveNote"
    >
        <template #title>
            <h3 class="bkt-modal__title">Заметка по лоту</h3>
            <h6 class="bkt-modal__subtitle">торги № {{item.tradingNumber}}</h6>
        </template>
        <template #body>
            <div class="bkt-form w-100 mx-auto align-items-start">
                <div class="col-12 col-lg-3 p-0">
                    <h5 class="bkt-form__label">название заметки</h5>
                </div>
                <div class="col-12 col-lg-9 m-0">
                    <bkt-input v-model="note.title"
                               type="number"
                               field_name="'Название заметки'"
                               label="название заметки"
                               label_class="bkt-form__label"
                               name="startPriceMin" icon_name="Check"
                               :group_item_class="note.title ? 'bkt-bg-green': 'bkt-bg-white'"
                               :icon_color="note.title ? 'white': 'main-lighter'"
                    >
                    </bkt-input>
                </div>
                <div class="col-12 col-lg-3 p-0">
                    <h5 class="bkt-form__label">описание заметки</h5>
                </div>
                <div class="col-12 col-lg-9 m-0">
                    <bkt-textarea v-model="note.description"
                               type="text"
                               field_name="'Описание заметки'"
                               label="описание заметки"
                               label_class="bkt-form__label"
                               name="exception_words" icon_name="Check"
                               :group_item_class="note.description ? 'bkt-bg-green': 'bkt-bg-white'"
                               :icon_color="note.description ? 'white': 'main-lighter'"
                    >
                    </bkt-textarea>
                </div>
                <div class="col-12 col-lg-3">
                    <h5 class="bkt-form__label">дата и время</h5>
                </div>
                <div class="col-12 col-lg-9">
                    <bkt-datepicker v-model="note.datetime"
                                    field_name="'Начало приёма заявок'"
                                    label="дата и время"
                                    label_class="bkt-form__label"
                                    name="applicationTimeStart"
                                    type="datetime"
                    ></bkt-datepicker>
                </div>
                <div class="col-12 col-lg-3">
                    <h5 class="bkt-form__label bkt-text-green">напомнить</h5>
                </div>
                <div class="col-12 col-lg-9">
                    <bkt-datepicker v-model="note.reminder"
                                    label="напомнить"
                                    label_class="bkt-form__label bkt-text-green"
                                    field_name="'Начало приёма заявок'"
                                    name="applicationTimeStart"
                                    type="datetime"
                    ></bkt-datepicker>
                </div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "NoteModal",
        props:['item'],
        data() {
            return {
                loading: false,
                dates: null,
                template: {
                    title: '',
                    description: '',
                    datetime: '',
                    reminder: '',
                },
                note: {
                    title: '',
                    description: '',
                    datetime: '',
                    reminder: '',
                },
            };
        },
        computed: {
        },
        methods: {
            clearNote(){
                this.note = this.template;
            },
            saveNote() {
                this.$store.dispatch('addLotNote', this.item.id)
            }
        }
    }
</script>

<style scoped>

</style>
