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
        this.$store.commit('setParam', this.param)
        await this.getData()
    },
    methods: {
        ...mapActions(['getData', 'updateData', 'deleteItem'])
    }
}
