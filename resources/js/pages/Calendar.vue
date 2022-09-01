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
                                    :attributes="current_items" is-expanded
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
                                <div class="bkt-calendar__day" @click="addEvent(day)">
                                    <span class="bkt-calendar__day-label" @click="addEvent(day)">
                                        {{day.id | moment("D MMM")}}
                                    </span>
                                    <div class="bkt-calendar__day-events bkt-cursor-pointer">
                                        <template v-for="attr_date in attributes">
                                            <VDropdown disposeTimeout="0" theme="bkt" handle-resize instant-move>
                                                <div class="bkt-calendar__day-event text-truncate bkt-cursor-pointer"
                                                     v-if="attr_date.customData"
                                                     :key="attr_date.key"
                                                     :class="attr_date.customData.class"
                                                     @click="editEvent(attr_date.customData)"
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
                let check = false;
                (function (a) {
                    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
                })(navigator.userAgent || navigator.vendor || window.opera);
                return check;
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
                if (this.$refs['bkt-custom-calendar']) {
                    this.$refs['bkt-custom-calendar'].move(date)
                }
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
