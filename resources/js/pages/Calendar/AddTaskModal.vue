<template>
    <bkt-modal :id="'addTaskModal'" ref="addTaskModal" modal_class="bkt-add-task-modal"
               :title="selDate | moment('D MMM YYYY')" right_button="Добавить">
        <template #body>
            <div>
                <div class="bkt-content-tasks">
                    <div class="d-flex align-items-center" style="margin-bottom: 6px" v-for="task in tasks">
                        <div class="bkt-border-body bkt-border-rounded d-flex align-items-center
                        justify-content-between bkt-content-tasks__item w-100">
                            <div class="bkt-content-tasks__item-task d-flex">
                                <div class="bkt-item__status" :class="'bkt-bg-'+task.color">{{ task.status }}</div>
                                <span class="bkt-item__description">
                                    {{ task.description }}
                                </span>
                            </div>
                            <button type="button" class="btn bkt-btn">
                                <bkt-icon name="Settings" color="primary"/>
                            </button>
                        </div>
                        <button type="button" class="btn bkt-btn">
                            <bkt-icon name="Trash" color="red" width="22px"/>
                        </button>
                    </div>
                </div>
                <div class="text-left mb-3 bkt-input d-flex">
                    <button type="button" class="bkt-button w-100" @click="selBtn = 1"
                            :class="[selBtn == 1 ? 'shadow green' : 'bkt-text-main']">
                        Событие
                    </button>
                    <button type="button" class="bkt-button w-100" @click="selBtn = 2"
                            :class="[selBtn == 2 ? 'shadow green' : 'bkt-text-main']">
                        Задача
                    </button>
                    <button type="button" class="bkt-button w-100" @click="selBtn = 3"
                            :class="[selBtn == 3 ? 'shadow green' : 'bkt-text-main']">
                        Напоминание
                    </button>
                </div>
                <div class="bkt-date">
                    <label for="" class="bkt-input__label">дата и время</label>
                    <div class="d-flex">
                        <bkt-select class="w-50 pe-2"></bkt-select>
                        <bkt-select class="w-100 pe-2"></bkt-select>
                        <bkt-select class="w-50 pe-2"></bkt-select>
                        <bkt-select class="w-50"></bkt-select>
                    </div>
                </div>

                <bkt-input v-model="description" label="добавить описание" name="description"/>
            </div>
        </template>
        <template #left_button>
            <span></span>
        </template>
    </bkt-modal>
</template>

<script>
export default {
    name: "AddTaskModal",
    props: {
        date: {
            type: String,
            default: null
        }

    },
    data() {
        return {
            selBtn: 1, description: '',
            tasks: [{
                status: 'событие',
                color: 'red',
                description: 'Прием заявок по лоту "Рено Кангу" до 15.04.2022 15:00',
                date: ''
            },
                {status: 'напоминание', color: 'blue', description: 'Написать организатору', date: ''},
                {status: 'задача', color: 'green', description: 'Необходимо что-то сделать', date: ''}],
            datetime: ''
        }
    },
    computed: {
        selDate() {
            return this.date;
        }
    },
    methods: {

    }
}
</script>

<style scoped>

</style>
