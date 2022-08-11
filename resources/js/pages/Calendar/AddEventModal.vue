<template>
    <bkt-modal :id="'addEventModal'" ref="addEventModal" modal_class="bkt-filters-modal"
               :title="event.date | moment('D MMMM YYYY')" :right_button="'Добавить'"
               @right_action="addEvent" :loading="loading"
    >
        <template #body>
            <div class="bkt-calendar__events d-none d-sm-flex" v-if="day_events.length>0">
<!--                <div class="bkt-wrapper-between bkt-nowrap" v-for="event in day_events" :key="event.id">-->
<!--                    <div class="bkt-border-body bkt-row bkt-calendar__event-wrapper">-->
<!--                        <div class="bkt-calendar__event">-->
<!--                            <div class="bkt-calendar__event-type"-->
<!--                                 :class="{'bkt-bg-red': event.type == 'event', 'bkt-bg-green': event.type == 'task',-->
<!--                                     'bkt-bg-blue': event.type == 'reminder'}">-->
<!--                                {{ event.type == 'event' ? 'событие' : null }}-->
<!--                                {{ event.type == 'task' ? 'задача' : null }}-->
<!--                                {{ event.type == 'reminder' ? 'напоминание' : null }}-->
<!--                            </div>-->
<!--                            <span class="bkt-calendar__event-text bkt-text-truncate">-->
<!--                                {{ event.title }}-->
<!--                            </span>-->
<!--                        </div>-->
<!--                        <button type="button" class="bkt-button p-0" @click="editEvent(event)">-->
<!--                            <bkt-icon name="Settings" color="primary"/>-->
<!--                        </button>-->
<!--                    </div>-->
<!--                    <button type="button" class="bkt-button-icon" @click="removeEvent(event)">-->
<!--                        <bkt-icon name="Trash" color="red" width="22px"/>-->
<!--                    </button>-->
<!--                </div>-->
                <event-card :event="event" v-for="event in day_events" :key="event.id" @edit="editEvent"></event-card>
            </div>
            <ul class="bkt-navbar__nav bkt-navbar__nav-pills bkt-wrapper-down-sm-column">
                <li class="bkt-navbar__nav-item bkt-w-down-sm-100" @click="event.type = 'event'"
                    :class="[event.type == 'event' ? 'active' : 'bkt-text-main']">
                    Событие
                </li>
                <li class="bkt-navbar__nav-item bkt-w-down-sm-100" @click="event.type = 'task'"
                    :class="[event.type == 'task' ? 'active' : 'bkt-text-main']">
                    Задача
                </li>
                <li class="bkt-navbar__nav-item bkt-w-down-sm-100" @click="event.type = 'reminder'"
                    :class="[event.type == 'reminder' ? 'active' : 'bkt-text-main']">
                    Напоминание
                </li>
            </ul>
            <bkt-datepicker type="date" v-model="event.date" label="дата" name="date"
                            value_type="YYYY-MM-DD" format="D MMMM YYYY" rules="required"
            ></bkt-datepicker>
            <bkt-datepicker type="time" value_type="HH:mm" format="HH:mm" v-model="event.time"
                            label="время" name="time" icon_name="Clock" rules="required"
            ></bkt-datepicker>
            <bkt-textarea rows="2" v-model="event.title" label="добавить описание"
                          name="description" rules="required" no_group_item/>

        </template>
        <template #left_button>
            <span></span>
        </template>
    </bkt-modal>
</template>

<script>
    import EventCard from "./EventCard";
    export default {
        name: "AddTaskModal",
        components: {
            EventCard
        },
        data() {
            return {
                event: {type: 'event', date: '', time: '00:00', title: ''},
                loading: false,
            }
        },
        computed: {
            events() {
                return this.$store.getters.events;
            },
            day_events() {
                if (this.event.date) {
                    return this.events.filter(item => {
                        return this.$moment(item.date).format('YYYY-MM-DD') == this.event.date;
                    });
                }
                return [];
            },
        },
        methods: {
            setDate(date) {
              this.event.date = date;
              this.event.time = '00:00';
              this.event.type = 'event';
              this.event.title = '';
            },
            async addEvent() {
                this.loading = true;
                    await this.$store.dispatch("addEvent", this.event).then(resp => {
                        this.loading = false;
                        this.$store.dispatch('sendNotification',
                            {self: this, message: 'Событие успешно создано'});
                        this.$store.commit('closeModal', '#addEventModal');
                    }).catch(err => {
                        this.loading = false;
                    });
            },
            async editEvent(event) {
                this.$parent.$refs.editEventModal.setEvent(event);
                this.$store.commit('closeModal', '#addEventModal');
                this.$store.commit('openModal', '#editEventModal');
            },
        },
    }
</script>

<style scoped>

</style>
