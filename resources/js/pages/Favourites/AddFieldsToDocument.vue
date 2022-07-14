<template>
  <bkt-modal :id="'fieldsToDocumentModal'" ref="fieldsToDocumentModal" :modal_class="'bkt-fields-document-modal'"
             :title="'Какие поля добавить в документ? (Excel)'" :loading="loading"
             :right_button="'Скачать'">
    <template v-slot:left_button>
      <span></span>
    </template>
    <template #body="{ invalid }">
      <div class="text-left">
        <div class="bkt-fields-action">
          <span class="text-uppercase bkt-text-red mr-2 bkt-cursor-pointer"
                @click="removeAllFields">Выключить все</span>
          <span class="text-uppercase bkt-text-green bkt-cursor-pointer" @click="selectAllFields">Включить все</span>
        </div>

        <div class="row">
          <div class="col-12 col-md-6">
            <div class="bkt-action-checkboxes__left">
              <div class="bkt-field-checkbox mb-2" v-for="(field, index) in fields_left">
                <bkt-checkbox :value="field.active" :label="field.title" :name="'field-'+index"
                              wrapper_class="bkt-check__wrapper-inline">
                </bkt-checkbox>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-6">
            <div class="bkt-action-checkboxes__right">
              <div class="bkt-field-checkbox mb-2" v-for="(field, index) in fields_right">
                <bkt-checkbox v-model="field.active"
                              :label="field.title" :name="'field-'+index"
                              wrapper_class="bkt-check__wrapper-inline">
                </bkt-checkbox>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </bkt-modal>
</template>

<script>
import Modal from "../../components/Modal";
import Checkbox from "../../components/Checkbox";
import Icon from "../../components/Icon";

export default {
  name: "AddFieldsToDocument",
  components: {
    'bkt-modal': Modal,
    'bkt-checkbox': Checkbox,
    'bkt-icon': Icon
  },
  data() {
    return {
      loading: false,
      fields_left: [{"title": "Номер торгов", active: false}, {"title": "Ссылка ЕФРС", active: false},
        {"title": "Наименование лота", active: false}, {"title": "Текущая цена", active: false},
        {"title": "Тип торгов", active: false}, {"title": "Должник", active: false},
        {"title": "Арбитражный управляющий", active: false}, {"title": "Начало подачи заявок", active: false},
        {"title": "Окончание подачи заявок", active: false}, {"title": "Победитель торгов", active: false}],
      fields_right: [{"title": "Номер лота", active: false}, {"title": "Ссылка и название ЭТП", active: false},
        {"title": "Начальная цена", active: false}, {"title": "Минимальная цена", active: false},
        {"title": "Регион", active: false}, {"title": "Организатор", active: false},
        {"title": "Начало торгов", active: false}, {"title": "Окончание торгов", active: false},
        {"title": "Заметка по лоту", active: false}]
    }
  },
  methods: {
    selectAllFields() {
      for (let i = 0; i < this.fields_left.length; i++)
        this.fields_left[i].active = true;

      for (let i = 0; i < this.fields_right.length; i++)
        this.fields_right[i].active = true;
    },
    removeAllFields() {
      for (let i = 0; i < this.fields_left.length; i++)
        this.fields_left[i].active = false;

      for (let i = 0; i < this.fields_right.length; i++)
        this.fields_right[i].active = false;
    }
  }
}
</script>

<style scoped>

</style>
