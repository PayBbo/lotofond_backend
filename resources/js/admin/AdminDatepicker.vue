<template>
    <datepicker
        :format="customFormatter"
        calendar-button-icon="fa fa-calendar"
        :calendar-button="true"
        monday-first
        typeable
        :bootstrap-styling="true"
        :clear-button="true"
        clear-button-icon="fa fa-times"
        v-model="param"
        :language="ru"
        :ref="refName"
    />
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import {ru} from 'vuejs-datepicker/dist/locale'
export default {
    name: "AdminDatepicker",
    components: {Datepicker},
    props: ['model', 'refName'],
    data() {
        return {
            ru: ru,
        }
    },
    computed: {
        param: {
            get() {
                return this.model;
            },
            set(val) {
                console.log('set val', val)
                if(val !== null) {
                    val = moment(val).format('DD.MM.YYYY');
                }
                this.$emit('input', val);
            }
        }
    },
    watch:{
        model: function(newValue, oldValue){
            this.param = newValue;
        },
    },
    methods: {
        customFormatter(date) {
            return moment(date).format('DD.MM.YYYY');
        },
        setDate(date) {
            if(this.refName && this.$refs[this.refName]) {
                this.$refs[this.refName].setValue(date);
            }

        }
    }
}
</script>

<style scoped>

</style>
