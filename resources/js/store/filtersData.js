export default {
    state: {
        filters_data: {
            categories: {
                data: [],
                loading: false
            },
            regions: {
                data: [],
                loading: false
            },
            bidders: {
                debtors: {
                    data: [],
                    pagination: null,
                    loading: false
                },
                organizers: {
                    data: [],
                    pagination: null,
                    loading: false
                },
                arbitrationManagers: {
                    data: [],
                    pagination: null,
                    loading: false
                },
                tradePlaces: {
                    data: [],
                    pagination: null,
                    loading: false
                },
            },
            tradePlaces: {
                data: [],
                pagination: null,
                loading: false
            },
            prices: null,
            messages_types: []
        }
    },

    getters: {
        filters_data(state) {
            return state.filters_data;
        },
        categories(state) {
            return state.filters_data.categories.data;
        },
        categories_loading(state) {
            return state.filters_data.categories.loading;
        },
        regions(state) {
            return state.filters_data.regions.data;
        },
        regions_loading(state) {
            return state.filters_data.regions.loading;
        },
        filters_debtors(state) {
            return state.filters_data.bidders.debtors.data;
        },
        filters_debtors_pagination(state) {
            return state.filters_data.bidders.debtors.pagination;
        },
        filters_debtors_loading(state) {
            return state.filters_data.bidders.debtors.loading;
        },
        filters_organizers(state) {
            return state.filters_data.bidders.organizers.data;
        },
        filters_organizers_pagination(state) {
            return state.filters_data.bidders.organizers.pagination;
        },
        filters_organizers_loading(state) {
            return state.filters_data.bidders.organizers.loading;
        },
        filters_arbitration_managers(state) {
            return state.filters_data.bidders.arbitrationManagers.data;
        },
        filters_arbitration_managers_pagination(state) {
            return state.filters_data.bidders.arbitrationManagers.pagination;
        },
        filters_arbitration_managers_loading(state) {
            return state.filters_data.bidders.arbitrationManagers.loading;
        },
        messages_types(state) {
            return state.filters_data.messages_types;
        },
    },
    mutations: {
        setCategories(state, payload) {
            payload.forEach(item => {
                let category = state.filters_data.categories.data.findIndex(el => el.key === item.key);
                if (category < 0) {
                    Vue.set(item, 'status', false);
                    state.filters_data.categories.data.push(item)
                }
            });
        },
        setRegions(state, payload) {
            payload.forEach(item => {
                let region = state.filters_data.regions.data.findIndex(el => el.regionGroup === item.regionGroup);
                if (region < 0) {
                    Vue.set(item, 'status', false)
                    state.filters_data.regions.data.push(item)
                }
            });
        },
        setFiltersBidders(state, payload) {
            payload.data.data.forEach(item => {
                let bidder = state.filters_data.bidders[payload.type].data.findIndex(el => el.id === item.id);
                if (bidder < 0) {
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
                    state.filters_data.bidders[payload.type].data.push(tmp_item)
                }
            });
            state.filters_data.bidders[payload.type].pagination = payload.data.pagination;
        },
        setMessagesTypes(state, payload) {
            payload.forEach(item => {
                let region = state.filters_data.messages_types.findIndex(el => el.messagesGroup === item.messagesGroup);
                if (region < 0) {
                    Vue.set(item, 'status', false)
                    state.filters_data.messages_types.push(item)
                }
            });
        },
        saveFiltersDataProperty(state, payload) {
            Vue.set(state.filters_data, payload.key, payload.value);
        },
        saveFilterDataProperty(state, payload) {
            let schema = state.filters_data[payload.filter];  // a moving reference to internal objects within obj
            let pList = payload.key.split('.');
            let len = pList.length;
            for (let i = 0; i < len - 1; i++) {
                let elem = pList[i];
                if (!schema[elem]) schema[elem] = {};
                schema = schema[elem];
            }
            // schema[pList[len-1]] = payload.value;
            Vue.set(schema, pList[len - 1], payload.value);
        }
    },
    actions: {
        /*
        GET
        /trades/filter/trade-places
        Получение информации о торговых площадках для отображения в фильтрах

        GET
        /trades/filter/categories
        Получение информации о категориях для отображения в фильтрах

        GET
        /trades/filter/regions
        Получение информации о регионах для отображения в фильтрах

        GET
        /messages/filter/types
        Получение информации о типах сообщений о должниках

        GET
        /trades/filter/prices
        Получение информации о минимальных/максимальных ценах для отображения в фильтрах

        PUT
        /trades/filter/bidders/{type}
        Получение информации о должниках/организаторах торгов/арбитражных управляющих
         */
        async getCategories({commit, state}, payload) {
            if (state.filters_data.categories.data.length == 0 && !state.filters_data.categories.loading) {
                commit('saveFilterDataProperty', {filter: 'categories', key: 'loading', value: true});
                await axios({
                    method: 'get',
                    url: '/api/trades/filter/categories',
                    data: {},
                })
                    .then((response) => {
                        commit('setCategories', response.data.sort(function (one, other) {
                            return other.subcategories.length - one.subcategories.length;
                        }))
                        commit('saveFilterDataProperty', {filter: 'categories', key: 'loading', value: false});
                    }).catch(error => {
                        commit('saveFilterDataProperty', {filter: 'categories', key: 'loading', value: false});
                    });
            }
        },
        async getRegions({commit, state}) {
            if (state.filters_data.regions.data.length == 0 && !state.filters_data.regions.loading) {
                commit('saveFilterDataProperty', {filter: 'regions', key: 'loading', value: true});
                await axios({
                    method: 'get',
                    url: '/api/trades/filter/regions',
                    data: {},
                })
                    .then((response) => {
                        commit('setRegions', response.data);
                        commit('saveFilterDataProperty', {filter: 'regions', key: 'loading', value: false});
                    }).catch(error => {
                        commit('saveFilterDataProperty', {filter: 'regions', key: 'loading', value: false});
                    });
            }
        },
        async getFiltersBidders({commit, state}, payload) {
            commit('saveFilterDataProperty', {filter: 'bidders', key: payload.type + '.loading', value: true});
            try {
                await axios({
                    method: 'put',
                    url: '/api/trades/filter/bidders/' + payload.type + '?page=' + payload.page,
                    data: payload
                })
                    .then((response) => {
                        commit('setFiltersBidders', {type: payload.type, data: response.data});
                        commit('saveFilterDataProperty', {
                            filter: 'bidders',
                            key: payload.type + '.loading',
                            value: false
                        });
                    });
            } catch (error) {
                commit('saveFilterDataProperty', {filter: 'bidders', key: payload.type + '.loading', value: false});
                throw error
            }
        },
        async getFiltersTradePlaces({commit, state}) {
            commit('saveFilterDataProperty', {filter: 'tradePlaces', key: 'loading', value: true});
            await axios({
                method: 'get',
                url: '/api/trades/filter/trade-places',
                data: {},
            })
                .then((response) => {
                    commit('saveFilterDataProperty', {filter: 'tradePlaces', key: 'data', value: response.data});
                    commit('saveFilterDataProperty', {filter: 'tradePlaces', key: 'loading', value: false});
                }).catch(error => {
                    commit('saveFilterDataProperty', {filter: 'tradePlaces', key: 'loading', value: false});
                });
        },
        async getFiltersPrices({commit, state}) {
            if (!state.filters_data.prices) {
                await axios({
                    method: 'get',
                    url: '/api/trades/filter/prices',
                    data: {},
                })
                    .then((response) => {
                        commit('saveFiltersDataProperty', {key: 'prices', value: response.data});
                    }).catch(error => {
                    });

            }
        },
        async getFiltersMessagesTypes({commit, state}) {
            if (state.filters_data.messages_types.length == 0) {
                await axios({
                    method: 'get',
                    url: '/api/messages/filter/types',
                    data: {},
                })
                    .then((response) => {
                        commit('setMessagesTypes', response.data);
                    }).catch(error => {
                    });

            }
        },
    }
};
