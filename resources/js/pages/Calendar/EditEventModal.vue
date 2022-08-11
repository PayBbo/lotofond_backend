<template>
    <bkt-modal :id="'editEventModal'" modal_class="bkt-filters-modal"
               :right_button="'Сохранить'" @right_action="editEvent" @left_action="removeEvent" :loading="loading"
    >
        <template #title>
            <h3 class="bkt-modal__title">Редактировать событие {{event.date | moment('D MMMM YYYY')}}</h3>
        </template>
        <template #body>
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
            <bkt-textarea rows="2" v-model="event.title" label="описание" name="description" rules="required" no_group_item/>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "EditEventModal",
        data() {
            return {
                event: {type: 'event', date: '', time: '00:00', title: ''},
                loading: false,
            }
        },
        methods: {
            setEvent(event) {
                this.event = JSON.parse(JSON.stringify(event));
            },
            async editEvent() {
                this.loading = true;
                await this.$store.dispatch("updateEvent", this.event).then(resp => {
                    this.loading = false;
                    this.$store.dispatch('sendNotification',
                        {self: this, message: 'Событие успешно изменено'});
                    this.$store.commit('closeModal', '#editEventModal');
                }).catch(err => {
                    this.loading = false;
                });
            },
            async removeEvent(event) {
                this.loading = true;
                await this.$store.dispatch('removeEvent', event).then(resp => {
                    this.loading = false;
                    this.$store.dispatch('sendNotification',
                        {self: this, message: 'Событие успешно удалено'});
                    this.$store.commit('closeModal', '#editEventModal');
                }).catch(err => {
                    this.loading = false;
                });
            },
        },
    }
</script>

<style scoped>

</style>
