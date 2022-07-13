export default {
    state: {
        debtors: [],
        debtors_pagination: {},
        debtors_loading: false,
    },

    getters: {
        debtors(state) {
            return state.debtors;
        },
        debtors_pagination(state) {
            return state.debtors_pagination;
        },
        debtors_loading(state) {
            return state.debtors_loading;
        },

    },
    mutations: {
        setDebtors(state, payload) {
            // state.debtors = payload.data;
            payload.data.forEach(item => {
                let debtor = state.debtors.findIndex(el => el.id === item.id);
                if (debtor < 0) {
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
                    state.debtors.push(tmp_item)
                }
            });
            state.debtors_pagination = payload.pagination;
        },
        addDebtor(state, payload) {
            state.debtors.push(payload)
        },
        saveDebtor(state, payload) {
            let debtor = state.debtors.findIndex(item => item.id === payload.id);
            if (debtor >= 0) {
                Vue.set(state.debtors, debtor, payload)
            }
        },
        removeDebtor(state, payload) {
            let debtor = state.debtors.findIndex(item => item.id === payload);
            if (debtor >= 0) {
                state.debtors.splice(debtor, 1);
            }
        },
        setDebtorsLoading(state, payload) {
            return (state.debtors_loading = payload);
        },
        saveDebtorProperty(state, payload) {
            let debtor = state.debtors.findIndex(item => item.id === payload.id);
            if (debtor >= 0 && state.debtors[debtor].hasOwnProperty(payload.key)) {
                Vue.set(state.debtors[debtor], payload.key, payload.value)
            }
        },
    },
    actions: {
        async getDebtors({commit, state}, payload) {
            try {
                await axios({
                    method: 'get',
                    url: '/api/trades/filter/bidders/debtors?page='+payload,
                    data: {},
                })
                    .then((response) => {
                        commit('setDebtors', response.data)
                    });
            } catch (error) {
                console.log(error);
                // commit('setDebtors', []);
                throw error
            }
        },
        async addDebtor({commit}, payload) {
            await axios.post('/api/debtors', payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then((response) => {
                commit('addDebtor', response.data)
            }).catch(error => {
                console.log(error);
                throw error
            });
        },
        async updateDebtor({commit}, payload) {
            await axios.post('/api/debtors/' + payload.id, payload.formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then((response) => {
                    commit('saveDebtor', response.data);
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
        async removeDebtor({dispatch, commit}, payload) {
            await axios.delete(`/api/debtors/${payload.id}`)
                .then(response => {
                    commit('removeDebtor', payload.id);
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
        async saveDebtor({commit}, payload) {
            await axios
                .post(`/api/debtors/save/${payload.id}`, {
                        key: payload.key,
                        value: payload.value
                    }
                ).then((response) => {
                    commit('saveDebtor', response.data.debtor)
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
    },

};
