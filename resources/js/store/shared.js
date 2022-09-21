import { localize, localeChanged } from "vee-validate";
import DatePicker from "vue2-datepicker";
export default {
    state: {
        user: {
            name:'',
            surname:'',
            // email:'',
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
            if (!payload.title){ payload.title='LotoFond';}
           this._vm.$notify({
                // group: 'message',
                type: payload.type,
                title: payload.title,
                text: payload.message,
                duration: payload.duration|5000
            });
        },
        sendAuthNotification({commit}, payload) {
            this._vm.$notify({
                type: 'error',
                title: 'LotoFond',
                text: 'Необходима авторизация',
                duration: 5000
            });
        },
        saveDataProperty({commit, rootState}, payload) {
            let schema = rootState[payload.module_key];
            if(payload.state_key) {
                schema = rootState[payload.module_key][payload.state_key]
            }
            if(schema) {
                let pList = payload.key.split('.');
                let len = pList.length;
                for (let i = 0; i < len - 1; i++) {
                    let elem = pList[i];
                    if (!schema[elem]) schema[elem] = {};
                    schema = schema[elem];
                }
                // schema[pList[len-1]] = payload.value;
                // if (pList[len - 1]) {
                    Vue.set(schema, pList[len - 1], payload.value);
                // }
            }

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
