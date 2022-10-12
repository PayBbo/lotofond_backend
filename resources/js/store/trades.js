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
        controllers: [],
        signals:[]
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
        controllers(state) {
            return state.controllers;
        },
        signals(state) {
            return state.signals;
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
            let trade = state.trades.findIndex(item => item.id == payload.id);
        // && state.trades[trade].hasOwnProperty(payload.key)
            if (trade >= 0) {
                Vue.set(state.trades[trade], payload.key, payload.value)
            }
        },
        setNearestTrades(state, payload) {
            state.nearest_trades = payload.data;
            state.nearest_trades_pagination = payload.pagination;
        },
        setNearestLoading(state, payload) {
            return (state.nearest_trades_loading = payload);
        },
        setWins(state, payload) {
            state.wins = [];
            payload.data.forEach(item => {
                let tmp_item = item;
                if (item.winner) {
                    if (item.winner.person !== null) {
                        tmp_item.winner.fullName = Object.values(item.winner.person).reduce((prev, cur) => {
                            if (cur) {
                                prev += cur + ' '
                            }
                            return prev;
                        }, '').trim();
                        tmp_item.winner.shortName = item.winner.person.firstName + ' ' + item.winner.person.lastName;

                    } else {
                        tmp_item.winner.fullName = item.winner.company.fullName;
                        tmp_item.winner.shortName = item.winner.company.shortName;
                    }
                }

                state.wins.push(tmp_item)
            });
            state.wins_pagination = payload.pagination;
        },
        setWinsLoading(state, payload) {
            return (state.wins_loading = payload);
        },
        changeTradeFavouritePaths(state, payload)
        {
            let lot = state.trades.findIndex(item => item.id === payload.lotId);
            if (lot >= 0) {
                if(state.trades[lot].favouritePaths) {
                    let lot_path = state.trades[lot].favouritePaths.findIndex(item => item.pathId === payload.currentPathId);
                    if (lot_path >= 0) {
                        state.trades[lot].favouritePaths.splice(lot_path, 1);
                    }
                    lot_path = state.trades[lot].favouritePaths.findIndex(item => item.pathId === payload.newPathId);
                    if (lot_path < 0) {
                        if (payload.newPath) {
                            state.trades[lot].favouritePaths.push(payload.newPath);
                        }
                    }
                }
            }
        },
        setTradeAborts(state, payload) {
            state.controllers[payload.method] = payload.controller;
            state.signals[payload.method] = payload.signal;
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
            if (state.signals['getFilteredTrades']) {
                state.controllers['getFilteredTrades'].abort();
            }
            await setTimeout(() => {
                let tmp_controller = new AbortController();
                commit('setTradeAborts', {
                    controller: tmp_controller,
                    signal: tmp_controller.signal,
                    method: 'getFilteredTrades'
                });
                commit('setTradesLoading', true);
                // let filters = JSON.parse(JSON.stringify(payload.filters));
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
                axios({
                    method: 'put',
                    url: '/api/trades/filter',
                    data: payload.filters,
                    signal: tmp_controller.signal,
                    params: {page: payload.page}
                })
                    .then((response) => {
                        commit('setTrades', response.data);
                    }).catch((error) => {
                    console.log(error);
                    commit('setTrades', {data: [], pagination: {}});

                }).finally(() => {
                    commit('setTradesLoading', false);
                })
            }, 100)
            // await axios.put('/api/trades/filter?page=' + payload.page, filters, payload.options)
            //     .then((response) => {
            //         commit('setTrades', response.data);
            //     }).catch((error) => {
            //         if (axios.isCancel(error)) {
            //             console.log('Request canceled');
            //             console.log('Request canceled', error.message);
            //         } else {
            //             // handle errors
            //         }
            //         console.log(error);
            //         commit('setTrades', {data: [], pagination: {}});
            //     }).finally(()=>{
            //         commit('setTradesLoading', false);
            //     })

        },
        async getTradeLots({commit}, payload) {
            return await axios.put('/api/trades/' + payload.auctionId + '?page=' + payload.page);
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
                    url: '/api/trades/lot/toggle-'+payload.type+'/'+payload.lotId,
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
        async getNearestTrades({commit, state}, payload) {
            if (state.signals['getNearestTrades']) {
                state.controllers['getNearestTrades'].abort();
            }
            await setTimeout(() => {
                let tmp_controller = new AbortController();
                commit('setTradeAborts', {
                    controller: tmp_controller,
                    signal: tmp_controller.signal,
                    method: 'getNearestTrades'
                });
                commit('setNearestLoading', true);
                // let filters = JSON.parse(JSON.stringify(payload.filters));
                 axios.put('/api/trades/nearest?page=' + payload.page, payload.filters, {signal: tmp_controller.signal})
                    .then((response) => {
                        commit('setNearestTrades', response.data);
                        commit('setNearestLoading', false);
                    }).catch((error) => {
                        commit('setNearestTrades', {data: [], pagination: {}});
                        commit('setNearestLoading', false);
                    })
            },100);
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
        async searchTrades({commit, state}, payload) {
            return await axios({
                method: 'put',
                url: '/api/trades/short/lots?page=' + payload.page,
                data: payload,
            })
        },
    },

};
