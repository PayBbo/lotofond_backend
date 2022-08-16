<template>
    <bkt-modal :id="'noteModal'" title="Заметка по лоту" modal_class="bkt-filters-modal"
               @left_action="clearNote" @right_action="saveNote" :loading="loading"
    >
        <template #title>
            <div class="bkt-wrapper-between w-100 flex-wrap">
                <h3 class="bkt-modal__title">Заметка по лоту</h3>
                <h6 class="bkt-modal__subtitle bkt-text-neutral" v-if="item && item.trade && item.trade.externalId">
                    торги № {{item.trade.externalId ? item.trade.externalId : '0'}}
                </h6>
            </div>
        </template>
        <template #body>
<!--            <div class="bkt-form w-100 mx-auto align-items-start">-->
                <!--                <div class="col-12 col-lg-3 p-0">-->
                <!--                    <h5 class="bkt-form__label">название заметки</h5>-->
                <!--                </div>-->
                <!--                <div class="col-12 col-lg-9 m-0">-->
                <!--                    <bkt-input v-model="note.title"-->
                <!--                               type="number"-->
                <!--                               field_name="'Название заметки'"-->
                <!--                               label="название заметки"-->
                <!--                               label_class="bkt-form__label"-->
                <!--                               name="startPriceMin" icon_name="Check"-->
                <!--                               :group_item_class="note.title ? 'bkt-bg-green': 'bkt-bg-white'"-->
                <!--                               :icon_color="note.title ? 'white': 'main-lighter'"-->
                <!--                    >-->
                <!--                    </bkt-input>-->
                <!--                </div>-->
<!--                <div class="col-12 col-lg-3 p-0 d-none d-lg-flex">-->
<!--                    <h5 class="bkt-form__label">заметка</h5>-->
<!--                </div>-->
<!--                <div class="col-12 col-lg-9 m-0">-->
                    <bkt-textarea v-model="note.title"
                                  type="text"
                                  field_name="'Заметка'"
                                  label="заметка"
                                  label_class="bkt-form__label d-none"
                                  name="title" icon_name="Check"
                                  rules="required|max:255"
                                  no_group_item
                    >
                    </bkt-textarea>
<!--                </div>-->
                <!--                <div class="col-12 col-lg-3">-->
                <!--                    <h5 class="bkt-form__label">дата и время</h5>-->
                <!--                </div>-->
                <!--                <div class="col-12 col-lg-9">-->
                <!--                    <bkt-datepicker v-model="note.datetime"-->
                <!--                                    field_name="'Начало приёма заявок'"-->
                <!--                                    label="дата и время"-->
                <!--                                    label_class="bkt-form__label"-->
                <!--                                    name="applicationTimeStart"-->
                <!--                                    type="datetime"-->
                <!--                    ></bkt-datepicker>-->
                <!--                </div>-->
                <!--                <div class="col-12 col-lg-3">-->
                <!--                    <h5 class="bkt-form__label bkt-text-green">напомнить</h5>-->
                <!--                </div>-->
                <!--                <div class="col-12 col-lg-9">-->
                <!--                    <bkt-datepicker v-model="note.reminder"-->
                <!--                                    label="напомнить"-->
                <!--                                    label_class="bkt-form__label bkt-text-green"-->
                <!--                                    field_name="'Начало приёма заявок'"-->
                <!--                                    name="applicationTimeStart"-->
                <!--                                    type="datetime"-->
                <!--                    ></bkt-datepicker>-->
                <!--                </div>-->
<!--            </div>-->
        </template>
        <template #left_button_inner>
            <bkt-icon v-show="!edit_mode" :name="'Cancel'" :width="'22px'" :height="'22px'" color="red"></bkt-icon>
            <bkt-icon v-show="edit_mode" :name="'Trash'" :width="'22px'" :height="'22px'"></bkt-icon>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "NoteModal",
        data() {
            return {
                loading: false,
                // dates: null,
                // item: {},
                template: {
                    title: '',
                    description: '',
                    datetime: '',
                    reminder: '',
                },
                edit_note: {
                    id: 0,
                    title: '',
                    description: '',
                    datetime: '',
                    reminder: '',
                },
            };
        },
        computed: {
            item() {
                return this.$store.getters.selected_lot
            },
            edit_mode() {
                if(this.item && this.item.note){
                    return true;
                }
                return false;
            },
            note: {
                get() {
                    if (!this.edit_mode) {
                        return JSON.parse(JSON.stringify(this.template));
                    }
                    return JSON.parse(JSON.stringify(this.item.note));
                },
                set(value) {
                    this.edit_note = value;
                }
            }
        },
        methods: {
            // setItem(item) {
            //     this.item = item
            // },
            clearNote() {
                if (!this.edit_mode) {
                    this.$store.dispatch('saveDataProperty', {
                        module_key: 'lots', state_key: 'selected_lot',
                        key: 'note',
                        value: null
                    }, {root: true});
                    this.$store.commit('closeModal', '#noteModal')
                } else {
                    this.loading = true;
                    this.$store.dispatch('removeLotNote', {noteId: this.note.id})
                        .then(resp => {
                            this.loading = false;
                            this.$store.dispatch('saveDataProperty', {
                                module_key: 'lots', state_key: 'selected_lot',
                                key: 'note',
                                value: null
                            }, {root: true});
                            this.$store.commit('closeModal', '#noteModal')
                        }).catch(error => {
                        this.loading = false;
                    })
                }

            },
            saveNote() {
                this.loading = true;
                if (!this.edit_mode) {
                    this.$store.dispatch('addLotNote', {
                        itemType: "lot",
                        itemId: this.item.id,
                        title: this.note.title,
                    })
                        .then(resp => {
                            this.loading = false;
                            this.$store.dispatch('saveDataProperty', {
                                module_key: 'lots', state_key: 'selected_lot',
                                key: 'note',
                                value: resp.data
                            }, {root: true});
                            this.$store.commit('closeModal', '#noteModal');
                        }).catch(error => {
                        this.loading = false;
                    })
                }
                else {
                    this.$store.dispatch('editLotNote', {
                        noteId: this.note.id,
                        title: this.note.title,
                    })
                        .then(resp => {
                            this.loading = false;
                            this.$store.dispatch('saveDataProperty', {
                                module_key: 'lots', state_key: 'selected_lot',
                                key: 'note',
                                value: this.note
                            }, {root: true});
                            this.$store.commit('closeModal', '#noteModal');
                        }).catch(error => {
                        this.loading = false;
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
