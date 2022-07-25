<template>
    <bkt-modal :id="'addTaskModal'" ref="addTaskModal" modal_class="bkt-add-task-modal"
               :title="date.id | moment('D MMMM YYYY')" right_button="Добавить" @right_action="addEvent">
        <template #body>
            <div>
                <div class="bkt-content-tasks" v-if="events">
                    <div class="d-flex align-items-center" style="margin-bottom: 6px" v-for="event in events">
                        <div class="bkt-border-body bkt-border-rounded d-flex align-items-center
                        justify-content-between bkt-content-tasks__item w-100">
                            <div class="bkt-content-tasks__item-task d-flex align-items-center">
                                <div class="bkt-item__status"
                                     :class="{'bkt-bg-red': event.type == 'event', 'bkt-bg-green': event.type == 'task', 'bkt-bg-blue': event.type == 'reminder'}">
                                    {{ event.type == 'event' ? 'событие' : null }}
                                    {{ event.type == 'task' ? 'задача' : null }}
                                    {{ event.type == 'reminder' ? 'напоминание' : null }}
                                </div>
                                <span class="bkt-item__description">
                                    {{ event.title }}
                                </span>
                            </div>
                            <button type="button" class="btn bkt-btn" @click="showEditEvent(event)">
                                <bkt-icon name="Settings" color="primary"/>
                            </button>
                        </div>
                        <button type="button" class="btn bkt-btn" @click="removeEvent(event)">
                            <bkt-icon name="Trash" color="red" width="22px"/>
                        </button>
                    </div>
                </div>
                <div class="text-left mb-3 bkt-input d-flex">
                    <button type="button" class="bkt-button w-100" @click="event.type = 'event'"
                            :class="[event.type == 'event' ? 'shadow green' : 'bkt-text-main']">
                        Событие
                    </button>
                    <button type="button" class="bkt-button w-100" @click="event.type = 'task'"
                            :class="[event.type == 'task' ? 'shadow green' : 'bkt-text-main']">
                        Задача
                    </button>
                    <button type="button" class="bkt-button w-100" @click="event.type = 'reminder'"
                            :class="[event.type == 'reminder' ? 'shadow green' : 'bkt-text-main']">
                        Напоминание
                    </button>
                </div>
                <div class="bkt-date">
                    <label for="" class="bkt-input__label">дата и время</label>
                    <div class="d-flex">
                        <bkt-select class="w-50 pe-2" name="daysEnum" :options="daysEnum" :clearable="false"
                                    :reduce="item => item.label" v-model="modelDate.day"></bkt-select>
                        <bkt-select class="w-100 pe-2" name="monthEnum" :options="monthEnum" :clearable="false"
                                    :reduce="item => item.label" v-model="modelDate.month"></bkt-select>
                        <bkt-select class="w-50 pe-2" name="hours" :options="timeHoursEnum" :clearable="false"
                                    :reduce="item => item.label" v-model="modelDate.hours"></bkt-select>
                        <bkt-select class="w-50" name="minutes" :options="timeMinutes" :clearable="false"
                                    :reduce="item => item.label" v-model="modelDate.minutes"></bkt-select>
                    </div>
                </div>

                <bkt-input v-model="event.title" label="добавить описание" name="description"/>
            </div>
        </template>
        <template #left_button>
            <span></span>
        </template>
    </bkt-modal>
</template>

<script>
import moment from 'vue-moment';

export default {
    name: "AddTaskModal",
    props: {
        date: {
            type: Object,
            default: null
        }

    },
    data() {
        return {
            moment: moment,
            event: {type: 'event', date: '', time: '', title: ''},
            modelDate: {day: null, month: null, hours: null, minutes: null},
            datetime: '',
            daysEnum: [],
            monthEnum: [],
            timeHoursEnum: [],
            timeMinutes: [],
            monthNamesShort: ["января", "февраля", "марта", "апреля", "мая", "июня", "июля",
                "августа", "сентября", "октября", "ноября", "декабря"]
        }
    },
    computed: {
        events() {
            if (this.date) {
                return this.$store.getters.events.filter(item => {
                    return new Date(item.date).toLocaleDateString() == new Date(this.date.date).toLocaleDateString();
                });
            }
        },
    },
    methods: {
        async addEvent() {
            let month = this.monthEnum.find(item => item.label == this.modelDate.month).id;
            this.event.date = new Date().getFullYear() + '-' + month + '-' + this.modelDate.day; //new Date("2022-07-14").toLocaleString();
            this.event.time = this.modelDate.hours + ':' + this.modelDate.minutes + ':00';
            await this.$store.dispatch("addEvent", this.event).then(resp => {
                this.event = {type: 'event', date: '', time: '', title: ''};
                this.modelDate = {day: null, month: null, hours: null, minutes: null}
                this.$store.commit('closeModal', '#addTaskModal');
            });
        },

        async removeEvent(event) {
            await this.$store.dispatch('removeEvent', event);
        },

        async showEditEvent(event) {
            this.modelDate.day = (new Date(event.date).getDate()).toString().padStart(2, '0');
            this.modelDate.hours = (new Date(event.date).getHours()).toString().padStart(2, '0');
            this.modelDate.minutes = (new Date(event.date).getMinutes()).toString().padStart(2, '0');
            this.event.title = event.title;
            this.event.type = event.type;
        },

        async editEvent(event) {
            await this.$store.dispatch('removeEvent', event);
        }
    },
    mounted() {
        for (let i = 1; i <= 31; i++) this.daysEnum.push({id: i, label: i.toString().padStart(2, '0')});
        for (let i = 1; i <= 12; i++) this.monthEnum.push({id: i, label: this.monthNamesShort[i - 1]});
        for (let i = 1; i <= 24; i++) this.timeHoursEnum.push({id: i, label: i.toString().padStart(2, '0')});
        for (let i = 0; i <= 59; i++) this.timeMinutes.push({id: i, label: i.toString().padStart(2, '0')});
    },
}
</script>

<style scoped>

</style>
