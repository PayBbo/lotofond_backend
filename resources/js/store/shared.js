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
        }
    },

    getters: {
        user(state) {
            return state.user;
        },
    },

    actions: {
        sendNotification({commit}, payload) {
            if (!payload.type){ payload.type='success';}
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
        }
    }
};
