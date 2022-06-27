export default {
    state: {
        arbitr_managers: [],
        arbitr_managers_pagination: {},
        arbitr_managers_loading: false,
    },

    getters: {
        arbitr_managers(state) {
            return state.arbitr_managers;
        },
        arbitr_managers_pagination(state) {
            return state.arbitr_managers_pagination;
        },
        arbitr_managers_loading(state) {
            return state.arbitr_managers_loading;
        },
    },
    mutations: {
        setArbitrManagers(state, payload) {
            // state.arbitr_managers = payload.data;
            payload.data.forEach(item => {
                let trade = state.arbitr_managers.findIndex(el => el.id === item.id);
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
                    state.arbitr_managers.push(tmp_item)
                }
            });
            state.arbitr_managers_pagination = payload.pagination;
        },
        addArbitrManager(state, payload) {
            state.arbitr_managers.push(payload)
        },
        saveArbitrManager(state, payload) {
            let trade = state.arbitr_managers.findIndex(item => item.id === payload.id);
            if (trade >= 0) {
                Vue.set(state.arbitr_managers, trade, payload)
            }
        },
        removeArbitrManager(state, payload) {
            let trade = state.arbitr_managers.findIndex(item => item.id === payload);
            if (trade >= 0) {
                state.arbitr_managers.splice(trade, 1);
            }
        },
        setArbitrManagersLoading(state, payload) {
            return (state.arbitr_managers_loading = payload);
        },
        saveArbitrManagerProperty(state, payload) {
            let trade = state.arbitr_managers.findIndex(item => item.id === payload.id);
            if (trade >= 0 && state.arbitr_managers[trade].hasOwnProperty(payload.key)) {
                Vue.set(state.arbitr_managers[trade], payload.key, payload.value)
            }
        },
    },
    actions: {
        async getArbitrManagers({commit, state}, payload) {
            try {
                await axios({
                    method: 'get',
                    url: '/api/trades/filter/bidders/arbitrManager?page='+payload,
                    data: {},
                })
                    .then((response) => {
                        commit('setArbitrManagers', response.data)
                    });
            } catch (error) {
                console.log(error);
                // commit('setArbitrManagers', []);
                throw error
            }
        },
        async addArbitrManager({commit}, payload) {
            await axios.post('/api/arbitrManagers', payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then((response) => {
                commit('addArbitrManager', response.data)
            }).catch(error => {
                console.log(error);
                throw error
            });
        },
        async updateArbitrManager({commit}, payload) {
            await axios.post('/api/arbitrManagers/' + payload.id, payload.formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then((response) => {
                    commit('saveArbitrManager', response.data);
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
        async removeArbitrManager({dispatch, commit}, payload) {
            await axios.delete(`/api/arbitrManagers/${payload.id}`)
                .then(response => {
                    commit('removeArbitrManager', payload.id);
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
        async saveArbitrManager({commit}, payload) {
            await axios
                .post(`/api/arbitrManagers/save/${payload.id}`, {
                        key: payload.key,
                        value: payload.value
                    }
                ).then((response) => {
                    commit('saveArbitrManager', response.data.trade)
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
    },

};
