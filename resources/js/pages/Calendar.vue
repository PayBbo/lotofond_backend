<template>
    <div class="container bkt-calendar bkt-container">
        <add-task-modal />
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
                                    :attributes="attr" disable-page-swipe is-expanded>

                            <template slot='day-popover-header' slot-scope='{ day }' class='popover-header'>
                                day
                            </template>
                            <template slot='show-notification' slot-scope='{ day }' class='show-notification'>
                                <p>dddddddddddd</p>
                            </template>

                            <template v-slot:day-content="{ day, attributes }">
                                <div class="flex flex-col h-full z-10 overflow-hidden" @click="openModal">
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
        Calendar
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
                        label: 'Lunch with mom.',
                        visibility: 'hover',
                        hideIndicator: true,
                        slot: 'show-notification',
                        isInteractive: true
                    }
                },
                {
                    key: 3,
                    highlight: {class: 'bkt-bg-green', fillMode: 'solid'},
                    dates: new Date(year, month, 14),
                    customData: {
                        title: 'Take Noah to basketball practice',
                        class: 'bkt-bg-green text-white vc-task',
                    },
                },
                {
                    key: 4,
                    highlight: {class: 'bkt-bg-green', fillMode: 'solid'},
                    dates: new Date(year, month, 15),
                    customData: {
                        title: 'Take Noah to basketball practice',
                        class: 'bkt-bg-green text-white vc-task',
                    },
                },
                {
                    key: 5,
                    highlight: {class: 'bkt-bg-red', fillMode: 'solid'},
                    dates: new Date(year, month, 15),
                    customData: {
                        title: 'Какой-то длинный текст',
                        class: 'bkt-bg-red text-white vc-task',
                    },
                },
                {
                    key: 5,
                    highlight: {class: 'bkt-bg-blue'},
                    dates: new Date(year, month, 28),
                    /*customData: {
                        title: 'Take Noah to basketball practice',
                        class: 'bkt-bg-blue text-white vc-task w-75',
                    },*/
                },
            ],

            masks: {
                weekdays: 'WWW',
            },
        }
    },
    methods: {
        getDayMonth(date) {
            return date | moment("MMMM");
        },
        openModal() {
            this.$store.commit('openModal', '#addTaskModal');
        }
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
