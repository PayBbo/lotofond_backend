<template>
    <div class="container bkt-calendar bkt-container">
        <add-task-modal :date="sel_date"/>
        <div class="bkt-main-title bkt-auctions__title">
            <h1 class="bkt-page__title">Календарь</h1>
        </div>

        <div class="bkt-content">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <div class="bkt-month-calendar mb-2">
                        <v-calendar class="bkt-left-calendar bkt-calendar-none-border m-1" :attributes='attr'
                                    :masks="masks">
                            <template v-slot:header-left-button>
                            </template>
                        </v-calendar>
                    </div>
                    <div class="bkt-calendar-checkboxes d-flex flex-wrap flex-column pl-4 pt-4 pb-4">
                        <bkt-checkbox label="События" :name="'events'" value="true"
                                      wrapper_class="bkt-check__wrapper-inline" class="events_check mr-2"/>
                        <bkt-checkbox label="Задачи" :name="'tasks'" value="true"
                                      wrapper_class="bkt-check__wrapper-inline" class="tasks_check mr-2"/>
                        <bkt-checkbox label="Напоминания" :name="'reminders'" value="true"
                                      wrapper_class="bkt-check__wrapper-inline" class="reminders_check mr-2"/>
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="bkt-month-calendar">
                        <v-calendar class="bkt-calendar-none-border custom-calendar max-w-full" :masks="masks"
                                    :attributes="attr" is-expanded>
                            <template #header>
                                <div class="vc-grid-container vc-weeks d-grid"
                                     style="grid-template-columns: repeat(7,1fr); gap: 0px;">
                                    <div :class="[new Date().getDay() == 1 ? 'is-today' : '']"
                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row--7 vc-grid-cell-col-1 vc-grid-cell-col--7"
                                         style="grid-area: 1 / 1 / auto / auto;">
                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">пн
                                        </div>
                                    </div>
                                    <div :class="[new Date().getDay() == 2 ? 'is-today' : '']"
                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row--7 vc-grid-cell-col-2 vc-grid-cell-col--6"
                                         style="grid-area: 1 / 2 / auto / auto;">
                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">вт
                                        </div>
                                    </div>
                                    <div :class="[new Date().getDay() == 3 ? 'is-today' : '']"
                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row--7 vc-grid-cell-col-3 vc-grid-cell-col--5"
                                         style="grid-area: 1 / 3 / auto / auto;">
                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">ср
                                        </div>
                                    </div>
                                    <div :class="[new Date().getDay() == 4 ? 'is-today' : '']"
                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row--7 vc-grid-cell-col-4 vc-grid-cell-col--4"
                                         style="grid-area: 1 / 4 / auto / auto;">
                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">чт
                                        </div>
                                    </div>
                                    <div :class="[new Date().getDay() == 5 ? 'is-today' : '']"
                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row--7 vc-grid-cell-col-5 vc-grid-cell-col--3"
                                         style="grid-area: 1 / 5 / auto / auto;">
                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">пт
                                        </div>
                                    </div>
                                    <div :class="[new Date().getDay() == 6 ? 'is-today' : '']"
                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row--7 vc-grid-cell-col-6 vc-grid-cell-col--2"
                                         style="grid-area: 1 / 6 / auto / auto;">
                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">сб
                                        </div>
                                    </div>
                                    <div :class="[new Date().getDay() == 0 ? 'is-today' : '']"
                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row--7 vc-grid-cell-col-7 vc-grid-cell-col--1"
                                         style="grid-area: 1 / 7 / auto / auto;">
                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">вс
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template v-slot:day-popover="{ day, attributes }">
                                <div class="bkt-popover" v-for="attr_date in attributes">
                                    <div class="bkt-status">
                                        <span class="text-white bkt-border-rounded"
                                              :class="'bkt-bg-' + attr_date.popover.color">
                                            {{ attr_date.popover.title }}
                                        </span>
                                    </div>
                                    <div class="bkt-text-popover">
                                        <span>{{ attr_date.popover.description }} до {{
                                                attr_date.popover.date
                                            }}</span>
                                    </div>
                                </div>
                            </template>

                            <template v-slot:day-content="{ day, attributes }">
                                <div class="flex flex-col h-full z-10 overflow-hidden" @click="openModal(day.id)">
                                    <span class="day-label text-sm text-gray-900">{{
                                            day.id | moment("D MMM")
                                        }}</span>
                                    <div class="flex-grow overflow-y-auto overflow-x-auto" style="margin-bottom: 35px"
                                         v-for="attr_date in attributes" :key="attr_date.key">
                                        <p v-if="attr_date.customData"
                                           class="text-xs leading-tight rounded-sm p-1 mt-0 mb-1"
                                           :class="attr_date.customData.class">
                                            {{ attr_date.customData.title }}
                                        </p>
                                    </div>
                                </div>
                            </template>
                            <template #default="{ inputValue, inputEvents }">
                                <input class="px-3 py-1 border rounded" :value="inputValue" v-on="inputEvents"/>
                            </template>
                        </v-calendar>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Checkbox from "../components/Checkbox";
import Calendar from "v-calendar";
import AddTaskModal from "./Calendar/AddTaskModal";

export default {
    name: "Calendar",
    components: {
        AddTaskModal,
        'bkt-checkbox': Checkbox,
        Calendar,
    },
    data() {
        const date = new Date();
        const month = new Date().getMonth();
        const year = new Date().getFullYear();
        return {
            attr: [
                {
                    key: 'today',
                    highlight: {fillMode: 'none'},
                    dates: date,
                },
                {
                    key: 2,
                    highlight: {class: 'bkt-bg-red', fillMode: 'solid'},
                    dates: new Date(year, month, 5),
                    customData: {
                        title: 'окончание приема заявок',
                        class: 'bkt-bg-red text-white vc-task',
                    },
                    popover: {
                        visibility: 'hover',
                        title: 'окончание приема заявок',
                        description: 'Прием заявок по лоту "Рено Кангу"',
                        color: 'red',
                        date: '15.04.2022 15:00',
                    }
                },
            ], sel_date: null,
            masks: {
                weekdays: 'WWW',
            }, event: null,
        }
    },
    computed: {
        items(){
          return this.$store.getters.events;
        },
        events_loading() {
            return this.$store.getters.events_loading;
        }
    },
    methods: {
        async getData(month = 1, year = 2022, type = 'all') {
            await this.$store.dispatch('getEvents', {month: month, year: year, type: type});
        },
        openModal(date) {
            this.sel_date = date;
            this.$store.commit('openModal', '#addTaskModal');
        },
    },
    created() {
        this.getData();
    }
}
</script>

<style lang="postcss" scoped>

/*::-webkit-scrollbar {
    width: 0px;
}

::-webkit-scrollbar-track {
    display: none;
}*/
</style>
