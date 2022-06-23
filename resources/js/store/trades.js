export default {
    state: {
        trades:[],
        trades_pagination: null,
        trades_loading: false,
    },

    getters: {
        trades(state) {
            return state.trades;
        },
        trades_pagination(state) {
            return state.trades_pagination;
        },
        trades_loading(state) {
            return state.trades_loading;
        },

    },
    mutations: {
        setTrades(state, payload) {
            // state.trades = payload.data;
            payload.data.forEach(item => {
                let trade = state.trades.findIndex(el => el.id === item.id);
                if (trade < 0) {
                    state.trades.push(item)
                }
            });
            state.trades_pagination = payload;
        },
        addTrade(state, payload) {
            state.trades.push(payload)
        },
        saveTrade(state, payload) {
            let trade = state.trades.findIndex(item => item.id === payload.id);
            if (trade >= 0) {
                Vue.set(state.trades, trade, payload)
            }
        },
        removeTrade(state, payload) {
            let trade = state.trades.findIndex(item => item.id === payload);
            if (trade >= 0) {
                state.trades.splice(trade, 1);
            }
        },
        setTradesLoading(state, payload) {
            return (state.trades_loading = payload);
        },
        saveTradeProperty(state, payload){
            let trade = state.trades.findIndex(item => item.id === payload.id);
            if (trade >= 0 && state.trades[trade].hasOwnProperty(payload.key)) {
                Vue.set(state.trades[trade], payload.key, payload.value)
            }
        },
    },
    actions: {
        async getTrades({commit, state}, payload) {
            try {
                await axios({
                    method: 'get',
                    url: '/api/trades?page='+ payload,
                    data: {},
                })
                    .then((response) => {
                        commit('setTrades', response.data)
                    });
            } catch (error) {
                console.log(error);
                // commit('setTrades', []);
                throw error
            }
        },
        async getTradeLots({commit}, payload) {
            return await axios.get('/api/trades/'+ payload.auctionId+'?page='+payload.page);
            // .then((response) => {
            //     commit('addTrade', response.data)
            // }).catch (error=> {
            //     console.log(error);
            //     throw error
            // });
        },
        async getTradeLot({commit}, payload) {
            return await axios.get('/api/trades/lot/'+ payload);
            // .then((response) => {
            //     commit('addTrade', response.data)
            // }).catch (error=> {
            //     console.log(error);
            //     throw error
            // });
        },
        async changeTradeLotStatus({commit}, payload) {
            return await axios.put('/api/trades/lot/action', payload)
            .then((response) => {
                commit('saveTradeProperty', {id: payload.lot_id, key:payload.key, value:payload.value})
            }).catch (error=> {
                console.log(error);
                throw error
            });
        },
        async addTrade({commit}, payload) {
            await axios.post('/api/trades', payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then((response) => {
                commit('addTrade', response.data)
            }).catch (error=> {
                console.log(error);
                throw error
            });
        },
        async updateTrade({commit}, payload) {
            await axios.post('/api/trades/'+ payload.id, payload.formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then((response) => {
                    commit('saveTrade', response.data);
                }).catch (error=> {
                    console.log(error);
                    throw error
                });
        },
        async removeTrade({dispatch, commit}, payload) {
            await axios.delete(`/api/trades/${payload.id}`)
                .then(response => {
                    commit('removeTrade', payload.id);
                    dispatch('sendNotification',
                        {
                            self:payload.self,
                            title:'Торги',
                            message: 'Торги успешно удалены'
                        });
                }).catch(error => {
                    dispatch('sendNotification',
                        {
                            self:payload.self,
                            title:'Торги',
                            type:'error',
                            message: 'Произошла ошибка'
                        });
                });
        },
        async saveTrade({commit}, payload) {
            await axios
                .post(`/api/trades/save/${payload.id}`, {
                        key: payload.key,
                        value: payload.value
                    }
                ).then((response) => {
                    commit('saveTrade', response.data.trade)
                }).catch (error=> {
                    console.log(error);
                    throw error
                });
        },
    },

};
