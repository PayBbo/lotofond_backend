export default {
    state: {
        categories: [],
        categories_loading: false,
    },

    getters: {
        categories(state) {
            return state.categories;
        },
        categories_loading(state) {
            return state.categories_loading;
        },

    },
    mutations: {
        setCategories(state, payload) {
            payload.forEach(item => {
                Vue.set(item, 'status', false)
                state.categories.push(item)
            });
        },
        setCategoriesLoading(state, payload) {
            return (state.categories_loading = payload);
        },
    },
    actions: {
        async getCategories({commit, state}, payload) {
            if (state.categories.length == 0) {
                commit('setCategoriesLoading', true)
                await axios({
                    method: 'get',
                    url: '/api/trades/filter/categories',
                    data: {},
                })
                    .then((response) => {
                        commit('setCategories', response.data)
                        commit('setCategoriesLoading', false)
                    }).catch(error => {
                        commit('setCategoriesLoading', false)

                    });
            }
        },
    }
};
