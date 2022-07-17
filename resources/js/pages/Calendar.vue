<template>
    <div class="container bkt-calendar bkt-container">
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
                            <template v-slot:day-content="{ day, attributes }">
                                <div class="flex flex-col h-full z-10 overflow-hidden">
                                    <span class="day-label text-sm text-gray-900">{{ day.day }}</span>
                                    <div class="flex-grow overflow-y-auto overflow-x-auto">
                                        <p v-for="attr in attributes" :key="attr.key" v-if="attr.customData"
                                           class="text-xs leading-tight rounded-sm p-1 mt-0 mb-1"
                                           :class="attr.customData.class">
                                            {{ attr.customData.title }}
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

export default {
    name: "Calendar",
    components: {
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
                    highlight: {color: 'blue', fillMode: 'none'},
                    dates: date,
                    class: 'bkt-border-rounded',
                },
                {
                    key: 2,
                    highlight: {color: 'red', fillMode: 'solid'},
                    dates: new Date(year, month, 5),
                },
                {
                    key: 3,
                    highlight: {color: 'green', fillMode: 'solid'},
                    dates: new Date(year, month, 14),
                },
                {
                    key: 4,
                    highlight: {color: 'green', fillMode: 'solid'},
                    dates: new Date(year, month, 15),
                },
                {
                    key: 5,
                    highlight: {color: 'red', fillMode: 'solid'},
                    dates: new Date(year, month, 15),
                },
                {
                    key: 5,
                    highlight: {color: 'blue', fillMode: 'solid'},
                    dates: new Date(year, month, 28),
                },
            ],

            masks: {
                weekdays: 'WWW',
            },
            attributes: [
                {
                    key: 1,
                    customData: {
                        title: 'Lunch with mom.',
                        class: 'bg-red-600 text-white',
                    },
                    dates: new Date(year, month, 1),
                },
                {
                    key: 2,
                    customData: {
                        title: 'Take Noah to basketball practice',
                        class: 'bg-blue-500 text-white',
                    },
                    dates: new Date(year, month, 2),
                },
                {
                    key: 3,
                    customData: {
                        title: "Noah's basketball game.",
                        class: 'bg-blue-500 text-white',
                    },
                    dates: new Date(year, month, 5),
                },
                {
                    key: 4,
                    customData: {
                        title: 'Take car to the shop',
                        class: 'bg-indigo-500 text-white',
                    },
                    dates: new Date(year, month, 5),
                },
                {
                    key: 4,
                    customData: {
                        title: 'Meeting with new client.',
                        class: 'bg-teal-500 text-white',
                    },
                    dates: new Date(year, month, 7),
                },
                {
                    key: 5,
                    customData: {
                        title: "Mia's gymnastics practice.",
                        class: 'bg-pink-500 text-white',
                    },
                    dates: new Date(year, month, 11),
                },
                {
                    key: 6,
                    customData: {
                        title: 'Cookout with friends.',
                        class: 'bg-orange-500 text-white',
                    },
                    dates: {months: 5, ordinalWeekdays: {2: 1}},
                },
                {
                    key: 7,
                    customData: {
                        title: "Mia's gymnastics recital.",
                        class: 'bg-pink-500 text-white',
                    },
                    dates: new Date(year, month, 22),
                },
                {
                    key: 8,
                    customData: {
                        title: 'Visit great grandma.',
                        class: 'bg-red-600 text-white',
                    },
                    dates: new Date(year, month, 25),
                },
            ],
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
