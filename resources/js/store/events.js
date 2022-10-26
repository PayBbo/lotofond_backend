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
            payload.forEach(item => {
                item.lot_info = item.dataFavourite ?? null;
                let event = state.events.findIndex(el => el.id == item.id);
                if (event >= 0) {
                    Vue.set(state.events, event, item)
                }
                else {
                    state.events.push(item)
                }
            })

            // state.events = payload;
        },
        setEventsLoading(state, payload) {
            return state.events_loading = payload;
        },
        addEvent(state, payload) {
            state.events.push(payload)
        },
        saveEvent(state, payload) {
            let event = state.events.findIndex(item => item.id === payload.id);
            if (event >= 0) {
                Vue.set(state.events, event, payload)
            }
        },
        removeEvent(state, payload) {
            let event = state.events.findIndex(item => item.id === payload);
            if (event >= 0) {
                state.events.splice(event, 1);
            }
        },
    },
    actions: {
        async getEvents({commit, state}, payload) {
            commit('setEventsLoading', true);
            return await axios
                .post('/api/events', payload)
                .then((response) => {
                    commit('setEvents', response.data);
                    commit('setEventsLoading', false)
                }).catch(error => {
                    commit('setEventsLoading', false)
                });
        },
        async addEvent({commit}, payload) {
            await axios.post('/api/event', payload).then((response) => {
                commit('addEvent', response.data)
            }).catch(error => {
                throw errors
            });
        },
        async updateEvent({commit}, payload) {
            await axios.put('/api/event/edit', payload)
                .then((response) => {
                    commit('saveEvent', payload);
                }).catch(error => {
                    throw error
                });
        },
        async removeEvent({dispatch, commit}, payload) {
            await axios({
                method: 'delete',
                url: '/api/event/delete',
                data: payload,
            })
                .then(response => {
                    commit('removeEvent', payload.id);
                    /*dispatch('sendNotification',
                        {
                            self: payload.self,
                            title: 'Календарь',
                            message: 'Событие успешно удалено'
                        });*/
                }).catch(error => {
                    /*dispatch('sendNotification',
                        {
                            self: payload.self,
                            title: 'Календарь',
                            type: 'error',
                            message: 'Произошла ошибка'
                        });*/
                });
        },
    }
}
