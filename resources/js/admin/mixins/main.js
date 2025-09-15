import {mapActions, mapGetters} from "vuex";

export function changeRole(user, action) {
    this.$swal.fire({
        title: 'Вы уверены?',
        text: 'Вы уверены, что хотите '+ action +' роль администратора?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085D6',
        cancelButtonColor: '#D33',
        confirmButtonText: 'Да',
        cancelButtonText: 'Отменить',
    }).then((result) => {
        if (result.isConfirmed) {
           this.updateData(user)
        }
    })
}

export default {
    data() {
        return {
            modalData: {},
            mColumns: {}
        }
    },
    computed: {
        ...mapGetters(['dataItems', 'pagination']),
        compParam: {
            get() { return String(this.$store.getters.param) },
            set(value) { this.$store.commit('setParam', value); this.getData() }
        },
    },
    async created() {
        this.$store.commit('resetState')
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
    },
    async mounted() {
        this.$store.commit('setParam', this.param)
        await this.getData()
    },
    methods: {
        ...mapActions(['getData', 'updateData', 'deleteItem']),
        setModalData(index, columns) {
            this.mColumns = { ...columns }
            this.modalData = { ...this.dataItems[index] }
            Object.keys(this.dataItems[index]).forEach( (key) => {
                if (this.modalData[key] === null || this.modalData[key].length === 0
                    || this.modalData[key] === undefined || this.modalData[key] === ''
                    || !this.mColumns[key]
                ) {
                    delete this.modalData[key];
                    delete this.mColumns[key];
                }
            })
        },
        searchParam(value) {
            if(typeof(value) === 'object'){
                value = JSON.stringify(value)
            }
            this.$store.commit('setParam', value);
            this.getData()
        }
    }
}
