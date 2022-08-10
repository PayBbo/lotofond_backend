<template>
    <div class="bkt-wrapper-between bkt-nowrap">
        <div class="bkt-border-body bkt-row bkt-calendar__event-wrapper">
            <div class="bkt-calendar__event">
                <div class="bkt-calendar__event-type"
                     :class="{'bkt-bg-red': event.type == 'event',
                                         'bkt-bg-green': event.type == 'task', 'bkt-bg-blue': event.type == 'reminder'}"
                >
                    {{ event.type == 'event' ? 'событие' : null }}
                    {{ event.type == 'task' ? 'задача' : null }}
                    {{ event.type == 'reminder' ? 'напоминание' : null }}
                </div>
                <span class="bkt-calendar__event-text bkt-text-truncate">
                    {{ event.title }}
                </span>
            </div>
            <button type="button" class="bkt-button p-0 bkt-bg-transparent" @click="editEvent(event)" :disabled="loading">
                <bkt-icon name="Settings" color="primary"/>
            </button>
        </div>
        <button type="button" class="bkt-button-icon bkt-bg-transparent" @click="removeEvent(event)" :disabled="loading">
            <bkt-icon v-show="!loading" name="Trash" color="red" width="22px"/>
            <span  v-show="loading" class="spinner-border spinner-border-sm bkt-text-red" role="status"></span>
        </button>
    </div>
</template>

<script>
    export default {
        name: "EventCard",
        props: ['event'],
        data() {
            return {
                loading: false,
            }
        },
        methods: {
            editEvent(event) {
               this.$emit('edit', event)
            },
            async removeEvent(event) {
                this.loading = true;
                await this.$store.dispatch('removeEvent', event).then(resp => {
                    this.loading = false;
                    this.$store.dispatch('sendNotification',
                        {self: this, message: 'Событие успешно удалено'});
                }).catch( error => {
                    this.loading = false;
                });
            },
        }
    }
</script>

<style scoped>

</style>
