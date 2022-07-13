export default {
    state: {
        regions: [],
        regions_loading: false,
    },

    getters: {
        regions(state) {
            return state.regions;
        },
        regions_loading(state) {
            return state.regions_loading;
        },

    },
    mutations: {
        setRegions(state, payload) {
            payload.forEach(item => {
                Vue.set(item, 'status', false)
                state.regions.push(item)
            });
        },
        setRegionsLoading(state, payload) {
            return (state.regions_loading = payload);
        },
    },
    actions: {
        async getRegions({commit, state}) {
            if (state.regions.length == 0) {
                commit('setRegionsLoading', true)
                await axios({
                    method: 'get',
                    url: '/api/trades/filter/regions',
                    data: {},
                })
                    .then((response) => {
                        commit('setRegions', response.data)
                        commit('setRegionsLoading', false)
                    }).catch(error => {
                        commit('setRegionsLoading', false)
                    });
            }
        },
    },

};
