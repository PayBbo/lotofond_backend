import { localize, localeChanged } from "vee-validate";
import DatePicker from "vue2-datepicker";
export default {
    state: {
        user: {
            name:'',
            surname:'',
            email:'',
            // phone:'',
            code:'',
            password:'',
            confirm_password:'',
            grantType:'email'
        },
        locale: localStorage.getItem('locale') || 'ru',
        selected_item: null
    },

    getters: {
        user(state) {
            return state.user;
        },
        locale(state) {
            return state.locale;
        },
    },

    actions: {
        sendNotification({commit}, payload) {
            if (!payload.type){ payload.type='success';}
            if (!payload.message){ payload.message='Ошибка';}
            payload.self.$notify({
                // group: 'message',
                type: payload.type,
                title: payload.title,
                text: payload.message,
                duration: payload.duration|5000
            });
        },
        runGlobalSearch({commit}, payload) {
            return axios.post('/api/global-search', payload);
        },
    },

    mutations: {
        openModal(state, payload) {
            let modal = bootstrap.Modal.getOrCreateInstance(document.querySelector(''+payload));
            modal.show();
        },
        closeModal(state, payload) {
            let modal = bootstrap.Modal.getOrCreateInstance(document.querySelector(''+payload));
            modal.hide();
            let backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove()
            }
        },
        setUser(state, payload) {
            return (state.user = payload);
        },
        saveUserProperty(state, payload) {
            Vue.set(state.user, payload.key, payload.value)
        },
        changeLocale(state, payload) {
            state.locale = payload;
            localStorage.setItem('locale', payload);
            axios.defaults.headers.common['Content-Language'] = payload;
            // $moment.locale(payload);
            import('vee-validate/dist/locale/' + payload + '.json')
                .then(locale => {
                    localize(payload, locale);
                });
            DatePicker.locale(payload);
            localize(payload);
            localeChanged();
        }
    }
};
