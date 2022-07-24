<template>
    <bkt-modal :id="'addTaskModal'" ref="addTaskModal" modal_class="bkt-category-modal bkt-add-task-modal modal-lg"
               :title="new Date() | moment('D MMM YYYY')" right_button="Добавить">
        <template #body>
            <div>
                <div class="bkt-content-tasks">
                    <div class="bkt-content-tasks__item d-flex">
                        <div class="bkt-border-neutral">
                            <div class="bkt-content-tasks__item-task d-flex">
                                <div class="bkt-bg-red">status</div>
                                <p>Прием заявок по лоту "Рено Кангу" до 15.04.2022 15:00</p>
                            </div>
                            <bkt-icon name="Settings"/>
                        </div>
                    </div>
                </div>
                <div class="text-left mb-3 bkt-input d-flex">
                    <button type="button" class="bkt-button w-100"@click="selBtn = 1"
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
                </div>

                <bkt-input label="добавить описание" name="description" />
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
    data() {
        return {
            selBtn: 1,
        }
    }
}
</script>

<style scoped>

</style>
