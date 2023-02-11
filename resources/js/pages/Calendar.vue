<template>
    <div class="bkt-page bkt-calendar bkt-container">
        <add-event-modal ref="addEventModal"/>
        <edit-event-modal ref="editEventModal"/>
        <h1 class="bkt-page__title">Календарь</h1>
        <div class="bkt-content">
            <div class="bkt-form bkt-form_wide">
                <div class="col-12 col-lg-4 col-xl-3 bkt-form__offset-right">
                    <div
                        class="bkt-calendar-checkboxes bkt-card bkt-card__body bkt-gap-down-sm-row-mini bkt-gap-down-sm-column-large">
                        <bkt-checkbox label="События" :name="'events'" v-model="event_types" val="event"
                                      wrapper_class="bkt-check__wrapper-inline" class="events_check order-1"/>
                        <bkt-checkbox label="Задачи" :name="'tasks'" v-model="event_types" val="task"
                                      wrapper_class="bkt-check__wrapper-inline"
                                      class="tasks_check order-last order-sm-2"/>
                        <bkt-checkbox label="Напоминания" :name="'reminders'" v-model="event_types"
                                      val="reminder"
                                      wrapper_class="bkt-check__wrapper-inline"
                                      class="reminders_check order-2"/>
                    </div>
                </div>
                <div class="col-12 col-lg-8 col-xl-9">
                    <div class="bkt-month-calendar d-none d-sm-flex">
                        <v-calendar class="bkt-border-none custom-calendar max-w-full" :masks="masks"
                                    :attributes="current_items" is-expanded @update:from-page="changePage"
                                    ref="bkt-custom-calendar" :class="'is-today-'+new Date().getDay()"
                        >
                            <!--                            <template #header>-->
                            <!--                                <div class="vc-grid-container vc-weeks d-grid"-->
                            <!--                                     style="grid-template-columns: repeat(7,1fr); gap: 0px;">-->
                            <!--                                    <div :class="[new Date().getDay() == 1 ? 'is-today' : '']"-->
                            <!--                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row&#45;&#45;7 vc-grid-cell-col-1 vc-grid-cell-col&#45;&#45;7"-->
                            <!--                                         style="grid-area: 1 / 1 / auto / auto;">-->
                            <!--                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">пн-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                    <div :class="[new Date().getDay() == 2 ? 'is-today' : '']"-->
                            <!--                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row&#45;&#45;7 vc-grid-cell-col-2 vc-grid-cell-col&#45;&#45;6"-->
                            <!--                                         style="grid-area: 1 / 2 / auto / auto;">-->
                            <!--                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">вт-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                    <div :class="[new Date().getDay() == 3 ? 'is-today' : '']"-->
                            <!--                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row&#45;&#45;7 vc-grid-cell-col-3 vc-grid-cell-col&#45;&#45;5"-->
                            <!--                                         style="grid-area: 1 / 3 / auto / auto;">-->
                            <!--                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">ср-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                    <div :class="[new Date().getDay() == 4 ? 'is-today' : '']"-->
                            <!--                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row&#45;&#45;7 vc-grid-cell-col-4 vc-grid-cell-col&#45;&#45;4"-->
                            <!--                                         style="grid-area: 1 / 4 / auto / auto;">-->
                            <!--                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">чт-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                    <div :class="[new Date().getDay() == 5 ? 'is-today' : '']"-->
                            <!--                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row&#45;&#45;7 vc-grid-cell-col-5 vc-grid-cell-col&#45;&#45;3"-->
                            <!--                                         style="grid-area: 1 / 5 / auto / auto;">-->
                            <!--                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">пт-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                    <div :class="[new Date().getDay() == 6 ? 'is-today' : '']"-->
                            <!--                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row&#45;&#45;7 vc-grid-cell-col-6 vc-grid-cell-col&#45;&#45;2"-->
                            <!--                                         style="grid-area: 1 / 6 / auto / auto;">-->
                            <!--                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">сб-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                    <div :class="[new Date().getDay() == 0 ? 'is-today' : '']"-->
                            <!--                                         class="vc-grid-cell vc-grid-cell-row vc-grid-cell-row&#45;&#45;7 vc-grid-cell-col-7 vc-grid-cell-col&#45;&#45;1"-->
                            <!--                                         style="grid-area: 1 / 7 / auto / auto;">-->
                            <!--                                        <div class="vc-weekday vc-text-sm vc-font-bold vc-text-gray-500">вс-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </template>-->
                            <template v-slot:day-content="{ day, attributes }">
                                <div class="bkt-calendar__day position-relative" @click="addEvent(day)">
                                    <span class="bkt-calendar__day-label">
                                        {{day.id | moment("D MMM")}}
                                    </span>
                                    <div class="bkt-calendar__day-events bkt-cursor-pointer">
<!--                                        @click.capture="editEvent(attr_date.customData)"-->
                                        <template v-for="attr_date in attributes">
                                            <VDropdown disposeTimeout="0" theme="bkt" handle-resize instant-move>
                                                <div class="bkt-calendar__day-event text-truncate bkt-cursor-pointer position-relative"
                                                     style="z-index: 12;"
                                                     v-if="attr_date.customData"
                                                     :key="attr_date.key"
                                                     :class="attr_date.customData.class"
                                                >
                                                    {{ attr_date.customData.title }}
                                                </div>
                                                <template #popper>
                                                    <div class="bkt-popover__wrapper">
                                                        <div class="bkt-popover__status"
                                                             :class="attr_date.customData.color? 'bkt-bg-'+ attr_date.customData.color : 'bkt-bg-primary'"
                                                        >
                                                            {{ attr_date.customData.subtitle }}
                                                        </div>
                                                        <div class="bkt-popover__text">
                                                            {{ attr_date.customData.title }}
                                                        </div>
                                                    </div>
                                                </template>
                                            </VDropdown>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </v-calendar>
                    </div>
                    <div class="bkt-month-calendar d-sm-none">
                        <v-calendar is-expanded class="bkt-left-calendar bkt-border-none"
                                    :attributes="dot_items" @update:from-page="changePage"
                                    :masks="masks" @dayclick="setDate" ref="bkt-left-calendar"
                                    :class="'is-today-'+new Date().getDay()">
                        </v-calendar>
                    </div>
                </div>
                <div class="col-12 d-sm-none" v-if="selected_date">
                    <div class="bkt-wrapper-between">
                        <div>
                            <h4 class="bkt-text-primary bkt-calendar__date" v-if="selected_date">
                                {{ selected_date.id | moment('D MMMM YYYY') }}
                            </h4>
                            <h6 v-if="day_events.length==0" class="bkt-text-neutral">нет событий</h6>
                        </div>
                        <button class="bkt-button primary" @click="addEvent(null)">
                            Добавить
                        </button>
                    </div>
                </div>
                <div class="col-12 d-sm-none">
                    <div class="bkt-calendar__events" v-show="day_events.length>0">
                        <event-card :event="event" v-for="event in day_events" :key="event.id"
                                    @edit="editEvent"></event-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Calendar from "v-calendar";
    import AddEventModal from "./Calendar/AddEventModal";
    import EditEventModal from "./Calendar/EditEventModal";
    import EventCard from "./Calendar/EventCard";

    export default {
        name: "Calendar",
        components: {
            AddEventModal,
            EditEventModal,
            Calendar,
            EventCard
        },
        data() {
            return {
                masks: {
                    weekdays: 'WWW',
                    data: ['YYYY-MM-DDTHH:mm:ss.SSSZ', 'L', 'YYYY-MM-DD'],
                },
                event_types: ['event', 'task', 'reminder'],
                nowDate: {month: 1, year: 2022},
                colors: [{type: 'event', color: 'red'},
                    {type: 'task', color: 'green'},
                    {type: 'reminder', color: 'blue'}],
                events: [{type: 'event', title: 'событие'},
                    {type: 'task', title: 'задача'},
                    {type: 'reminder', title: 'напоминание'}],
                selected_event: {},
                selected_date: ''
            }
        },
        created() {
            this.nowDate.month = new Date().getMonth();
            this.nowDate.year = new Date().getFullYear();
        },
        computed: {
            items() {
                return this.$store.getters.events.filter(item => this.event_types.indexOf(item.type) >= 0);
            },
            events_loading() {
                return this.$store.getters.events_loading;
            },
            current_items() {
                return this.items.map(item =>
                    ({
                        key: item.id,
                        dates: item.date,
                        customData: {
                            id: item.id ?? 0,
                            title: item.title,
                            subtitle: this.events.find(event => event.type == item.type).title,
                            type: item.type,
                            date: item.date,
                            time: item.time,
                            color: this.colors.find(color => color.type == item.type).color ?? '',
                            class: "bkt-bg-" + this.colors.find(color => color.type == item.type).color ?? '',
                            lot_info: item.lot_info
                        },
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
                            class: 'bkt-border-primary d-none d-md-block'
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
                        },
                        dates: [
                            ...new Set(this.items
                                .filter(item => item.type == color.type)
                                .map(item => item.date)
                            )
                        ],
                    })
                });
                return events;
            },
            day_events() {
                if (this.selected_date) {
                    return this.items.filter(item => {
                        return this.$moment(item.date).format('YYYY-MM-DD') == this.selected_date.id;
                    });
                }
                return [];
            },
            isMobile() {
                return this.$store.getters.isMobile
            }
        },
        methods: {
            async getData(month = 1, year = 2022, type = 'all') {
                await this.$store.dispatch('getEvents', {month: month, year: year, type: type});
            },
            addEvent(date = null) {
                if (this.$refs.addEventModal) {
                    if (date == null) {
                        this.$refs.addEventModal.setDate(this.selected_date.id)
                    } else {
                        this.$refs.addEventModal.setDate(date.id);
                    }
                    this.$nextTick(() => {
                        this.$store.commit('openModal', '#addEventModal');
                    })
                }
            },
            editEvent(event) {
                this.selected_event = event;
                console.log('event', event)
                this.$refs.editEventModal.setEvent(event);
                this.$nextTick(() => {
                    this.$store.commit('openModal', '#editEventModal');
                });
            },
            changePage(date) {
                this.nowDate.month = date.month;
                this.nowDate.year = date.year;
                this.selected_date = '';
                // if (this.$refs['bkt-custom-calendar']) {
                //     this.$refs['bkt-custom-calendar'].move(date)
                // }
                this.getData(this.nowDate.month, this.nowDate.year);
            },
            setDate(date) {
                this.selected_date = date;
                if (!this.isMobile) {
                    this.addEvent(null)
                }
            }
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
