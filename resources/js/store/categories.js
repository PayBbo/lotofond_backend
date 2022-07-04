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
            console.log('setCategories', payload)
            state.categories = payload;
        },
        setCategoriesLoading(state, payload) {
            return (state.categories_loading = payload);
        },
    },
    actions: {
        async getCategories({commit, state}, payload) {
            try {
                commit('setCategoriesLoading', true)
                await axios({
                    method: 'get',
                    url: '/api/trades/filter/categories',
                    data: {},
                })
                    .then((response) => {
                        commit('setCategories', response.data)
                        commit('setCategoriesLoading', false)
                    });
            } catch (error) {
                console.log(error);
                commit('setCategoriesLoading', false)
                // commit('setCategories', []);
                throw error
            }
        },
    },

};
