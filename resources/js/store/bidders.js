export default {
    state: {
        bidders: {
            debtors: {
                data: [],
                pagination: {},
                loading: false
            },
            organizers: {
                data: [],
                pagination: {},
                loading: false
            },
            arbitrationManagers: {
                data: [],
                pagination: {},
                loading: false
            },
        },
        tradePlaces: {
            data: [],
            pagination: {},
            loading: false
        },
        messages: {
            data: [],
            pagination: {},
            loading: false
        },
    },

    getters: {
        debtors(state) {
            return state.bidders.debtors.data;
        },
        debtors_pagination(state) {
            return state.bidders.debtors.pagination;
        },
        debtors_loading(state) {
            return state.bidders.debtors.loading;
        },
        arbitration_managers(state) {
            return state.bidders.arbitrationManagers.data;
        },
        arbitration_managers_pagination(state) {
            return state.bidders.arbitrationManagers.pagination;
        },
        arbitration_managers_loading(state) {
            return state.bidders.arbitrationManagers.loading;
        },
        organizers(state) {
            return state.bidders.organizers.data;
        },
        organizers_pagination(state) {
            return state.bidders.organizers.pagination;
        },
        organizers_loading(state) {
            return state.bidders.organizers.loading;
        },
        trade_places(state) {
            return state.tradePlaces.data;
        },
        trade_places_pagination(state) {
            return state.tradePlaces.pagination;
        },
        trade_places_loading(state) {
            return state.tradePlaces.loading;
        },
        messages(state) {
            return state.messages.data;
        },
        messages_pagination(state) {
            return state.messages.pagination;
        },
        messages_loading(state) {
            return state.messages.loading;
        },
    },
    mutations: {
        setBidders(state, payload) {
            state.bidders[payload.type].data = [];
            payload.data.forEach(item => {
                let trade = state.bidders[payload.type].data.findIndex(el => el.id === item.id);
                if (trade < 0) {
                    let tmp_item = item;
                    if (item.type === 'person') {
                        tmp_item.fullName = Object.values(tmp_item.person).reduce((prev, cur) => {
                            if (cur) {
                                prev += cur + ' '
                            }
                            return prev;
                        }, '').trim();
                        tmp_item.shortName = item.person.firstName + ' ' + item.person.lastName;

                    } else {
                        tmp_item.fullName = item.company.fullName;
                        tmp_item.shortName = item.company.shortName;
                    }
                    state.bidders[payload.type].data.push(tmp_item)
                }
            });
            state.bidders[payload.type].pagination = payload.pagination;
        },
        setCookie(state, payload){
            state.cookie = payload
        }
    },
    actions: {
        /*
        * PUT
        * /bidders/trades
        * Получение активных/неактивных торгов выбранного участника

        * GET
        * /bidders/{bidderId}/{type}
        * Получение данных об арбитражном управляющем/организаторе/должнике

        * PUT
        * /bidders/get/{type}
        * Получение информации о должниках/организаторах торгов/арбитражных управляющих

        * PUT
        * /bidders/trade-places
        * Получение информации о торговых площадках для отображения в реестрах

        * GET
        * /bidders/{tradePlaceId}
        * Получение данных о торговой площадке

        * POST
        * /bidders/estimate
        * Оценка организатора/арбитражного управляющего

        * PUT
        * /bidders/debtor/messages
        * Сообщения о должнике
        *
        * POST
        * /bidders/debtor/message
        * Сообщение html о должнике
        */
        async getBidderLots({commit, state}, payload) {
            return await axios({
                method: 'put',
                url: `/api/bidders/trades?page=` + payload.page,
                data: payload,
            })
        },
        async getBidders({dispatch, commit, state}, payload) {
            dispatch('saveDataProperty', {
                module_key: 'bidders',
                state_key: 'bidders',
                key: payload.type + '.loading',
                value: true
            }, {root: true});
            try {
                await axios({
                    method: 'put',
                    url: '/api/bidders/get/' + payload.type + '?page=' + payload.page,
                    data: payload
                })
                    .then((response) => {
                        commit('setBidders', {
                            type: payload.type,
                            data: response.data.data,
                            pagination: response.data.pagination
                        })
                        dispatch('saveDataProperty', {
                            module_key: 'bidders', state_key: 'bidders',
                            key: payload.type + '.loading',
                            value: false
                        }, {root: true});
                    });
            } catch (error) {
                dispatch('saveDataProperty', {
                    module_key: 'bidders',
                    state_key: 'bidders',
                    key: payload.type + '.loading',
                    value: false
                }, {root: true});
                throw error
            }
        },
        async getBidder({commit, state}, payload) {
            return await axios({
                method: 'get',
                url: '/api/bidders/' + payload.id + '/' + payload.type,
                data: payload,
            })
        },
        async getTradePlaces({dispatch, commit, state}, payload) {
            dispatch('saveDataProperty', {module_key: 'bidders', state_key: 'tradePlaces', key: 'loading', value: true}, {root: true});
            try {
                await axios({
                    method: 'put',
                    url: '/api/bidders/trade-places?page=' + payload.page,
                    data: payload
                })
                    .then((response) => {
                        dispatch('saveDataProperty', {
                            module_key: 'bidders',
                            state_key: 'tradePlaces',
                            key: 'data',
                            value: response.data.data
                        }, {root: true});
                        dispatch('saveDataProperty', {
                            module_key: 'bidders',
                            state_key: 'tradePlaces',
                            key: 'pagination',
                            value: response.data.pagination
                        }, {root: true});
                        dispatch('saveDataProperty', {
                            module_key: 'bidders',
                            state_key: 'tradePlaces',
                            key: 'loading',
                            value: false
                        }, {root: true});
                    });
            } catch (error) {
                dispatch('saveDataProperty', {module_key: 'bidders', state_key: 'tradePlaces', key: 'loading', value: false}, {root: true});
                throw error
            }
        },
        async getTradePlace({commit, state}, payload) {
            return await axios({
                method: 'GET',
                url: '/api/bidders/' + payload,
                data: payload
            })
        },
        async estimateBidder({commit, state}, payload) {
            return await axios({
                method: 'post',
                url: '/api/bidders/estimate',
                data: payload
            })
        },
        async estimateAnswer({commit, state}, payload) {
            return await axios({
                method: 'post',
                url: '/api/bidders/estimate-answer',
                data: payload
            })
        },
        async getDebtorMessages({dispatch, commit, state}, payload) {
            dispatch('saveDataProperty', {module_key: 'bidders', state_key: 'messages', key: 'loading', value: true}, {root: true});
            if(payload.filters) {
                payload = {
                    ...payload,
                    ...payload.filters
                }
            }
            try {
                await axios({
                    method: 'put',
                    url: '/api/bidders/debtor/messages?page=' + payload.page,
                    data: payload
                })
                    .then((response) => {
                        // dispatch('saveDataProperty', {
                        //     module_key: 'filters',
                        //     key: 'messages_filters',
                        //     value: payload
                        // }, {root: true});
                        dispatch('saveDataProperty', {
                            module_key: 'bidders',
                            state_key: 'messages',
                            key: 'data',
                            value: response.data.data
                        }, {root: true});
                        dispatch('saveDataProperty', {
                            module_key: 'bidders',
                            state_key: 'messages',
                            key: 'pagination',
                            value: response.data.pagination
                        }, {root: true});
                        dispatch('saveDataProperty', {
                            module_key: 'bidders',
                            state_key: 'messages',
                            key: 'loading',
                            value: false
                        }, {root: true});
                    });
            } catch (error) {
                dispatch('saveDataProperty', {module_key: 'bidders', state_key: 'messages', key: 'loading', value: false}, {root: true});
                throw error
            }
        },
        async getDebtorMessagePage({dispatch, commit, state}, payload) {
             return await axios({
                method: 'post',
                url: '/api/bidders/debtor/message',
                data: {
                    guid: payload,
                }
            })
        },
    },
};
