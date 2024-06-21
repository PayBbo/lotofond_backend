export default {
    state: {
        selected_order: null,
        orders: [],
        orders_pagination: {},
        orders_loading: false,
    },
    getters: {
        orders(state) {
            return state.orders;
        },
        orders_pagination(state) {
            return state.orders_pagination;
        },
        orders_loading(state) {
            return state.orders_loading;
        },
        selected_order(state) {
            return state.selected_order;
        },
    },
    mutations: {
        setOrders(state, payload) {
            state.orders = payload.data;
            state.orders_pagination = payload.pagination;
        },
        addOrder(state, payload) {
            state.orders.push(payload)
        },
        saveOrder(state, payload) {
            let order = state.orders.findIndex(item => item.id === payload.id);
            if (order >= 0) {
                Vue.set(state.orders, order, payload)
            }
        },
        removeOrder(state, payload) {
            let order = state.orders.findIndex(item => item.id === payload);
            if (order >= 0) {
                state.orders.splice(order, 1);
            }
        },
        setSelectedLot(state, payload) {
            return (state.selected_order = payload);
        },
        setOrdersLoading(state, payload) {
            return (state.orders_loading = payload);
        },
    },
    actions: {
        async addOrder({commit}, payload) {
            return await axios.post('/api/trades/orders', payload);
        },
        async editOrder({commit}, payload) {
            return await axios.put('/api/trades/orders/edit', payload);
        },
        async removeOrder({dispatch, commit}, payload) {
            return await axios.delete(`/api/trades/orders/delete`, {params:payload})
        },
        async getOrders({commit, state, dispatch}, payload) {
            dispatch('checkAbort','getOrders');
            let tmp_controller = new AbortController();
            dispatch('setAborts', {
                controller: tmp_controller,
                signal: tmp_controller.signal,
                method: 'getOrders'
            });
            commit('setOrdersLoading', true);
            return await axios({
                method: 'get',
                url: `/api/trades/orders?page=${payload.page}`,
                data: payload.params ?? {},
                signal: tmp_controller.signal
            }).then((response) => {
                commit('setOrders', response.data);
                commit('setOrdersLoading', false);
            }).catch((error) => {
                commit('setOrders', {data: [], pagination: {}});
                commit('setOrdersLoading', false);
                if (error.message === 'canceled') {
                    commit('setOrdersLoading', true);
                }
            })
        },
    },
};
