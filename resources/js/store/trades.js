export default {
    state: {
        trades: [],
        trades_pagination: {},
        trades_loading: false,
        nearest_trades: [],
        nearest_trades_pagination: {},
        nearest_trades_loading: false,
        wins: [],
        wins_pagination: {},
        wins_loading: false,
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
        nearest_trades(state) {
            return state.nearest_trades;
        },
        nearest_trades_pagination(state) {
            return state.nearest_trades_pagination;
        },
        nearest_trades_loading(state) {
            return state.nearest_trades_loading;
        },
        wins(state) {
            return state.wins;
        },
        wins_pagination(state) {
            return state.wins_pagination;
        },
        wins_loading(state) {
            return state.wins_loading;
        },

    },
    mutations: {
        setTrades(state, payload) {
            state.trades = payload.data;
            // payload.data.forEach(item => {
            //     let trade = state.trades.findIndex(el => el.id === item.id);
            //     if (trade < 0) {
            //         state.trades.push(item)
            //     }
            // });
            state.trades_pagination = payload.pagination;
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
        saveTradeProperty(state, payload) {
            let trade = state.trades.findIndex(item => item.id === payload.id);
            if (trade >= 0 && state.trades[trade].hasOwnProperty(payload.key)) {
                Vue.set(state.trades[trade], payload.key, payload.value)
            }
        },
        setNearestTrades(state, payload) {
            state.nearest_trades = payload.data;
            state.nearest_trades_pagination = payload.pagination;
        },
        setNearestLoading(state, payload) {
            return (state.nearest_loading = payload);
        },
        setWins(state, payload) {
            state.wins = [];
            payload.data.forEach(item => {
                if (item.winner) {
                    if (item.winner.person !== null) {
                        item.winner.fullName = Object.values(item.winner.person).reduce((prev, cur) => {
                            if (cur) {
                                prev += cur + ' '
                            }
                            return prev;
                        }, '').trim();
                        item.winner.shortName = item.winner.person.firstName + ' ' + item.person.lastName;

                    } else {
                        item.winner.fullName = item.winner.company.fullName;
                        item.winner.shortName = item.winner.company.shortName;
                    }
                }

                state.wins.push(item)
            });
            state.wins_pagination = payload.pagination;
        },
        setWinsLoading(state, payload) {
            return (state.wins_loading = payload);
        },
    },
    actions: {
        async getTrades({commit, state}, payload) {
            try {
                await axios({
                    method: 'get',
                    url: '/api/trades?page=' + payload,
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
        async getFilteredTrades({commit, state}, payload) {
            commit('setTradesLoading', true);
            let filters = JSON.parse(JSON.stringify(payload.filters));
            // Object.keys(filters).forEach(key => {
            //     if (Array.isArray(filters[key]))
            //     {
            //         if(filters[key].length==0) {
            //             filters[key] = null;
            //         }
            //     }
            //     if (typeof filters[key] === 'object' && filters[key] != null ) {
            //         Object.keys(filters[key]).forEach(k => {
            //             if (typeof filters[key][k] === 'string') {
            //                 if (filters[key] === '') {
            //                     filters[key] = null
            //                 }
            //             }
            //             if (typeof filters[key][k] === 'object') {
            //                 let total = Object.values(filters[key][k])
            //                     .reduce((r, o) => {
            //                         if (r && o) {
            //                             Object.values(o).forEach(item => {
            //                                 if (item) {
            //                                     r++;
            //                                 }
            //                             });
            //                             return r;
            //                         }
            //                         return 0;
            //                     }, 0);
            //                 if (total == 0) {
            //                     filters[key][k] = null;
            //                 }
            //             }
            //         });
            //     }
            //     if (typeof filters[key] === 'string') {
            //         if (filters[key] === '') {
            //             filters[key] = null
            //         }
            //     }
            // });
            await axios.put('/api/trades/filter?page=' + payload.page, filters)
                .then((response) => {
                    commit('setTrades', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('setTrades', {data: [], pagination: {}});
                }).finally(()=>{
                    commit('setTradesLoading', false);
                })

        },
        async getTradeLots({commit}, payload) {
            return await axios.get('/api/trades/' + payload.auctionId + '?page=' + payload.page);
            // .then((response) => {
            //     commit('addTrade', response.data)
            // }).catch (error=> {
            //     console.log(error);
            //     throw error
            // });
        },
        async getTradeLot({commit}, payload) {
            return await axios.get('/api/trades/lot/' + payload);
            // .then((response) => {
            //     commit('addTrade', response.data)
            // }).catch (error=> {
            //     console.log(error);
            //     throw error
            // });
        },
        async changeTradeLotStatus({commit}, payload) {
            return await
                axios({
                    method: 'put',
                    url: '/api/trades/lot/action',
                    data: payload,
                })
                // .then((response) => {
                //     console.log('changeTradeLotStatus;', response)
                //     // commit('saveTradeProperty', {id: payload.lot_id, key: payload.key, value: payload.value})
                // }).catch(error => {
                //     console.log(error);
                //     throw error
                // });
        },
        async addTrade({commit}, payload) {
            await axios.post('/api/trades', payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then((response) => {
                commit('addTrade', response.data)
            }).catch(error => {
                console.log(error);
                throw error
            });
        },
        async updateTrade({commit}, payload) {
            await axios.post('/api/trades/' + payload.id, payload.formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then((response) => {
                    commit('saveTrade', response.data);
                }).catch(error => {
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
                            self: payload.self,
                            title: 'Торги',
                            message: 'Торги успешно удалены'
                        });
                }).catch(error => {
                    dispatch('sendNotification',
                        {
                            self: payload.self,
                            title: 'Торги',
                            type: 'error',
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
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
        async getNearestTrades({commit, state}, payload) {
            commit('setNearestTradesLoading', true);
            // let filters = JSON.parse(JSON.stringify(payload.filters));
            await axios.put('/api/trades/nearest?page=' + payload.page, payload.filters)
                .then((response) => {
                    commit('setNearestTrades', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('setNearestTrades', {data: [], pagination: {}});
                }).finally(()=>{
                    commit('setNearestTradesLoading', false);
                })

        },
        async getWins({commit, state}, payload) {
            commit('setWinsLoading', true);
            // let filters = JSON.parse(JSON.stringify(payload.filters));
            await axios.get('/api/trades/victories?page=' + payload.page)
                .then((response) => {
                    commit('setWins', response.data);
                }).catch((error) => {
                    console.log(error);
                    commit('setWins', {data: [], pagination: {}});
                }).finally(()=>{
                    commit('setWinsLoading', false);
                })

        },
    },

};
