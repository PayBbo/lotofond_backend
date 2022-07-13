export default {
    state: {
        organizers: [],
        organizers_pagination: {},
        organizers_loading: false,
    },

    getters: {
        organizers(state) {
            return state.organizers;
        },
        organizers_pagination(state) {
            return state.organizers_pagination;
        },
        organizers_loading(state) {
            return state.organizers_loading;
        },

    },
    mutations: {
        setOrganizers(state, payload) {
            // state.organizers = payload.data;
            payload.data.forEach(item => {
                let trade = state.organizers.findIndex(el => el.id === item.id);
                if (trade < 0) {
                    let tmp_item = item;
                    if(item.type === 'person')
                    {
                        tmp_item.fullName = Object.values(tmp_item.person).reduce((prev, cur) => {
                            if(cur){
                                prev+= cur+' '
                            }
                            return prev;
                        }, '').trim();
                        tmp_item.shortName = item.person.firstName+' '+item.person.lastName;

                    }
                    else {
                        tmp_item.fullName = item.company.fullName;
                        tmp_item.shortName = item.company.shortName;
                    }
                    state.organizers.push(tmp_item)
                }
            });
            state.organizers_pagination = payload.pagination;
        },
        addOrganizer(state, payload) {
            state.organizers.push(payload)
        },
        saveOrganizer(state, payload) {
            let trade = state.organizers.findIndex(item => item.id === payload.id);
            if (trade >= 0) {
                Vue.set(state.organizers, trade, payload)
            }
        },
        removeOrganizer(state, payload) {
            let trade = state.organizers.findIndex(item => item.id === payload);
            if (trade >= 0) {
                state.organizers.splice(trade, 1);
            }
        },
        setOrganizersLoading(state, payload) {
            return (state.organizers_loading = payload);
        },
        saveOrganizerProperty(state, payload) {
            let trade = state.organizers.findIndex(item => item.id === payload.id);
            if (trade >= 0 && state.organizers[trade].hasOwnProperty(payload.key)) {
                Vue.set(state.organizers[trade], payload.key, payload.value)
            }
        },
    },
    actions: {
        async getOrganizers({commit, state}, payload) {
            try {
                await axios({
                    method: 'get',
                    url: '/api/trades/filter/bidders/organizers?page='+payload,
                    data: {},
                })
                    .then((response) => {
                        commit('setOrganizers', response.data)
                    });
            } catch (error) {
                console.log(error);
                // commit('setOrganizers', []);
                throw error
            }
        },
        async addOrganizer({commit}, payload) {
            await axios.post('/api/organizers', payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then((response) => {
                commit('addOrganizer', response.data)
            }).catch(error => {
                console.log(error);
                throw error
            });
        },
        async updateOrganizer({commit}, payload) {
            await axios.post('/api/organizers/' + payload.id, payload.formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then((response) => {
                    commit('saveOrganizer', response.data);
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
        async removeOrganizer({dispatch, commit}, payload) {
            await axios.delete(`/api/organizers/${payload.id}`)
                .then(response => {
                    commit('removeOrganizer', payload.id);
                    dispatch('sendNotification',
                        {
                            self: payload.self,
                            title: 'Должники',
                            message: 'Должник успешно удален'
                        });
                }).catch(error => {
                    dispatch('sendNotification',
                        {
                            self: payload.self,
                            title: 'Должники',
                            type: 'error',
                            message: 'Произошла ошибка'
                        });
                });
        },
        async saveOrganizer({commit}, payload) {
            await axios
                .post(`/api/organizers/save/${payload.id}`, {
                        key: payload.key,
                        value: payload.value
                    }
                ).then((response) => {
                    commit('saveOrganizer', response.data.trade)
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
    },

};
