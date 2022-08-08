<template>
    <div class="bkt-page bkt-calendar bkt-container">
        <add-task-modal :date="sel_date"/>
        <div class="bkt-main-title bkt-auctions__title">
            <h1 class="bkt-page__title">Календарь</h1>
        </div>
        <div class="bkt-content">
            <div class="bkt-form bkt-form_wide">
                <div class="col-12 col-lg-4 col-xl-3 bkt-form__offset-right">
                    <div class="bkt-form bkt-gap-row bkt-wrapper-down-sm-column-reverse">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="bkt-month-calendar">
                                <v-calendar is-expanded class="bkt-left-calendar bkt-calendar-none-border"
                                            :attributes="dot_items" @update:from-page="changePage"
                                            :masks="masks" @dayclick="addEvent" ref="bkt-left-calendar"
                                            :class="'is-today-'+new Date().getDay()">
                                </v-calendar>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="bkt-calendar-checkboxes bkt-card bkt-card__body">
                                <bkt-checkbox label="События" :name="'events'" v-model="event_types" val="event"
                                              wrapper_class="bkt-check__wrapper-inline" class="events_check mr-2"/>
                                <bkt-checkbox label="Задачи" :name="'tasks'" v-model="event_types" val="task"
                                              wrapper_class="bkt-check__wrapper-inline" class="tasks_check mr-2"/>
                                <bkt-checkbox label="Напоминания" :name="'reminders'" v-model="event_types" val="reminder"
                                              wrapper_class="bkt-check__wrapper-inline" class="reminders_check mr-2"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 col-xl-9 d-none d-sm-flex">
                    <div class="bkt-month-calendar">
                        <v-calendar class="bkt-calendar-none-border custom-calendar max-w-full" :masks="masks"
                                    :attributes="current_items" is-expanded
                                    ref="bkt-custom-calendar"
                        >
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
                                              :class="['bkt-bg-'+ attr_date.customData.color]">
                                            {{ attr_date.customData.subtitle }}
                                        </span>
                                    </div>
                                    <div class="bkt-text-popover">
                                        <span>{{ attr_date.customData.title }} до {{ attr_date.customData.date }}
                                            {{ attr_date.customData.time }}
                                        </span>
                                    </div>
                                </div>
                            </template>

                            <template v-slot:day-content="{ day, attributes }">
                                <div class="bkt-calendar__day" @dblclick="addEvent(day)">
                                    <span class="bkt-calendar__day-label" @dblclick="addEvent(day)">
                                        {{day.id | moment("D MMM")}}
                                    </span>
                                    <div class="bkt-calendar__day-events">
                                        <div class="bkt-calendar__day-event text-truncate" v-if="attr_date.customData"
                                             v-for="attr_date in attributes" :key="attr_date.key"
                                             :class="attr_date.customData.class"
                                        >
                                            {{ attr_date.customData.title }}
                                        </div>
                                    </div>
                                    <!--                                    <div class="flex-grow overflow-y-auto overflow-x-auto">-->
                                    <!--                                        <p v-if="attr_date.customData" v-for="attr_date in attributes" :key="attr_date.key"-->
                                    <!--                                           class="text-xs leading-tight rounded-sm p-1 mt-0 mb-1"-->
                                    <!--                                           :class="attr_date.customData.class">-->
                                    <!--                                            {{ attr_date.customData.title }}-->
                                    <!--                                        </p>-->
                                    <!--                                    </div>-->
                                </div>
                            </template>
                        </v-calendar>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Calendar from "v-calendar";
    import AddTaskModal from "./Calendar/AddTaskModal";

    export default {
        name: "Calendar",
        components: {
            AddTaskModal,
            Calendar,
        },
        data() {
            return {
                sel_date: null,
                event: null,
                masks: {
                    weekdays: 'WWW',
                },
                event_types: ['event', 'task', 'reminder'],
                nowDate: {month: 1, year: 2022},
                colors: [{type: 'event', color: 'red'},
                    {type: 'task', color: 'green'},
                    {type: 'reminder', color: 'blue'}],
                events: [{type: 'event', title: 'событие'},
                    {type: 'task', title: 'задача'},
                    {type: 'reminder', title: 'напоминание'}]
            }
        },
        computed: {
            items() {
                return this.$store.getters.events.filter( item => this.event_types.indexOf(item.type)>=0);
            },
            events_loading() {
                return this.$store.getters.events_loading;
            },
            current_items() {
                return this.items.map(item =>
                    ({
                        key: item.id,
                        // highlight: {
                        //     color: this.colors.find(color => color.type == item.type)?.color ?? '',
                        //     fillMode: "solid"
                        // },
                        dates: new Date(item.date).toLocaleString(),
                        customData: {
                            title: item.title,
                            subtitle: this.events.find(event => event.type == item.type).title,
                            event_type: item.type,
                            date: new Date(item.date).getDate() + '.' + new Date(item.date).getMonth() + '.' + new Date(item.date).getFullYear(),
                            time: item.time.slice(0, -3),
                            color: this.colors.find(color => color.type == item.type).color ?? '',
                            class: "bkt-bg-" + this.colors.find(color => color.type == item.type).color ?? '',
                        },
                        popover: {
                            visibility: "hover",
                        }
                    })
                );
            },
            dot_items() {
                let events = [
                    {
                        highlight: {
                            color: 'primary',
                            fillMode: "light",
                            // class: 'd-none d-md-flex'
                            class: 'bkt-border-primary'
                        },
                        dates: [
                            new Date()
                        ],
                    }
                ];
                this.colors.forEach(color => {
                    // let unique = this.items.filter(item => item.type == color.type).map(item => new Date(item.date))
                    //     .filter((v, i, a) => a.indexOf(v) === i)
                    events.push({
                        dot: {
                            color: color.color ?? '',
                            // class: 'd-md-none'
                        },
                        // highlight: {
                        //     color: color.color ?? '',
                        //     fillMode: "solid",
                        //     class: 'd-none d-md-flex'
                        // },
                        dates: [
                            ...new Set(this.items
                                .filter(item => item.type == color.type)
                                .map(item => new Date(item.date))
                            )
                        ],
                    })
                });
                return events;
            }
        },
        methods: {
            async getData(month = 1, year = 2022, type = 'all') {
                await this.$store.dispatch('getEvents', {month: month, year: year, type: type});
            },
            addEvent(date) {
                this.sel_date = date;
                this.$nextTick(() => {
                    this.$store.commit('openModal', '#addTaskModal');
                })
            },
            changePage(date) {
                this.nowDate.month = date.month;
                this.nowDate.year = date.year;
                if(this.$refs['bkt-custom-calendar'])
                {
                    this.$refs['bkt-custom-calendar'].move(date)
                }
                this.getData(this.nowDate.month, this.nowDate.year);

            },
        },
        created() {
            this.nowDate.month = new Date().getMonth();
            this.nowDate.year = new Date().getFullYear();
        },
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
