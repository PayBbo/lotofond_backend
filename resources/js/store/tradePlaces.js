export default {
    state: {
        trade_places: [],
        trade_places_pagination: {},
        trade_places_loading: false,
    },

    getters: {
        trade_places(state) {
            return state.trade_places;
        },
        trade_places_pagination(state) {
            return state.trade_places_pagination;
        },
        trade_places_loading(state) {
            return state.trade_places_loading;
        },

    },
    mutations: {
        setTradePlaces(state, payload) {
            // state.trade_places = payload.data;
            payload.forEach(item => {
                let trade = state.trade_places.findIndex(el => el.id === item.id);
                if (trade < 0) {
                    state.trade_places.push(item)
                }
            });
            state.trade_places_pagination = null;
        },
        addTradePlace(state, payload) {
            state.trade_places.push(payload)
        },
        saveTradePlace(state, payload) {
            let trade = state.trade_places.findIndex(item => item.id === payload.id);
            if (trade >= 0) {
                Vue.set(state.trade_places, trade, payload)
            }
        },
        removeTradePlace(state, payload) {
            let trade = state.trade_places.findIndex(item => item.id === payload);
            if (trade >= 0) {
                state.trade_places.splice(trade, 1);
            }
        },
        setTradePlacesLoading(state, payload) {
            return (state.trade_places_loading = payload);
        },
        saveTradePlaceProperty(state, payload) {
            let trade = state.trade_places.findIndex(item => item.id === payload.id);
            if (trade >= 0 && state.trade_places[trade].hasOwnProperty(payload.key)) {
                Vue.set(state.trade_places[trade], payload.key, payload.value)
            }
        },
    },
    actions: {
        async getTradePlaces({commit, state}, payload) {
            try {
                await axios({
                    method: 'get',
                    url: '/api/trades/filter/trade-places?page='+payload,
                    data: {},
                })
                    .then((response) => {
                        commit('setTradePlaces', response.data)
                    });
            } catch (error) {
                console.log(error);
                // commit('setTradePlaces', []);
                throw error
            }
        },
        async addTradePlace({commit}, payload) {
            await axios.post('/api/trade-places', payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then((response) => {
                commit('addTradePlace', response.data)
            }).catch(error => {
                console.log(error);
                throw error
            });
        },
        async updateTradePlace({commit}, payload) {
            await axios.post('/api/trade-places/' + payload.id, payload.formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then((response) => {
                    commit('saveTradePlace', response.data);
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
        async removeTradePlace({dispatch, commit}, payload) {
            await axios.delete(`/api/trade-places/${payload.id}`)
                .then(response => {
                    commit('removeTradePlace', payload.id);
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
        async saveTradePlace({commit}, payload) {
            await axios
                .post(`/api/trade-places/save/${payload.id}`, {
                        key: payload.key,
                        value: payload.value
                    }
                ).then((response) => {
                    commit('saveTradePlace', response.data.trade)
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
    },

};
