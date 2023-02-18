<template>
    <datepicker format="dd.MM.yyyy"
                      calendar-button-icon="fa fa-calendar"
                      :calendar-button="true"
                      :bootstrap-styling="true"
                      :clear-button="true"
                      clear-button-icon="fa fa-times"
                      v-model="param"
    ></datepicker>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
export default {
    name: "AdminDatepicker",
    components: {Datepicker},
    props: ['model'],
    computed: {
        param: {
            get() {
                return this.model;
            },
            set(val) {
                if(val !== null) {
                    let event = new Date(val);
                    let date = JSON.stringify(event)
                    val = date.slice(1, 11)
                }
                this.$emit('input', val);
            }
        }
    }
}
</script>

<style scoped>

</style>
