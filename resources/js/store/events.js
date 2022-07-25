export default {
    state: {
        events: [],
        events_loading: false,
    },
    getters: {
        events(state) {
            return state.events;
        },
        events_loading(state) {
            return state.events_loading;
        },

    },
    mutations: {
        setEvents(state, payload) {
            state.events = payload;
        },
        setEventsLoading(state, payload) {
            return state.events_loading = payload;
        },
        addEvent(state, payload) {
            state.events.push(payload)
        },
        saveEvent(state, payload) {
            let trade = state.events.findIndex(item => item.id === payload.id);
            if (trade >= 0) {
                Vue.set(state.events, trade, payload)
            }
        },
        removeEvent(state, payload) {
            let trade = state.events.findIndex(item => item.id === payload);
            if (trade >= 0) {
                state.events.splice(trade, 1);
            }
        },
    },
    actions: {
        async getEvents({commit, state}, payload) {
            commit('setEventsLoading', true);
            return await axios
                .post('/api/events', payload)
                .then((response) => {
                    commit('setEvents', response.data)
                    commit('setEventsLoading', false)
                }).catch(error => {
                    console.log(error);
                    commit('setEventsLoading', false)

                });
        },
        async addEvent({commit}, payload) {
            await axios.post('/api/event', payload).then((response) => {
                commit('addEvent', payload)
            }).catch(error => {
                console.log(error);
                throw error
            });
        },
        async updateEvent({commit}, payload) {
            await axios.post('/api/event/edit/' + payload.id, payload.formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then((response) => {
                    commit('saveEvent', response.data);
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
        async removeEvent({dispatch, commit}, payload) {
            await axios.delete(`/api/event/delete/${payload.id}`)
                .then(response => {
                    commit('removeEvent', payload.id);
                    dispatch('sendNotification',
                        {
                            self: payload.self,
                            title: 'Календарь',
                            message: 'Событие успешно удалено'
                        });
                }).catch(error => {
                    dispatch('sendNotification',
                        {
                            self: payload.self,
                            title: 'Календарь',
                            type: 'error',
                            message: 'Произошла ошибка'
                        });
                });
        },
    }
}
