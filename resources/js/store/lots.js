export default {
    state: {
        lots_statistic: {
            "activeLotsCount": 0,
            "nonactiveLotsCount": 0,
            "allLotsCount": 0
        },
        categories_statistic: {
            "realEstate": {
                "allLotsCount": 100,
                "activeLotsCount": 90
            },
            "commercialRealEstate": {
                "allLotsCount": 100,
                "activeLotsCount": 90
            }
        },
    },

    getters: {
        lots_statistic(state) {
            return state.lots_statistic;
        },
        categories_statistic(state) {
            return state.categories_statistic;
        },
    },
    mutations: {
        setLotsStatistic(state, payload) {
            return (state.lots_statistic = payload);
        },
        setCategoriesStatistic(state, payload) {
            return (state.categories_statistic = payload);
        },
    },

    actions: {
        /*
        * GET
        * /statistics/categories
        * Получение информации о количестве лотов по категориям

        * GET
        * /statistics/lots
        * Получение информации о количестве активных/неактивных лотов
        *
        * GET
        * /bidders/{type}/{bidderType}/{bidderId}
        * Получение активных/неактивных торгов выбранного участника
        *
        * GET
        * /bidders/{bidderId}
        * Получение данных об арбитражном управляющем/организаторе/должнике
        *
        * GET
        * /files/{lotId}
        * Получение списка файлов для лота
        *
        * POST
        * /files/store
        * Загрузка файлов на сервер
        *
        * DELETE
        * /files/{id}
        * Удаление пользовательского файла/картинки
        */
        getCategoriesStatistic({commit}, payload) {
            return axios.get('/api/statistics/categories', payload);
        },
        getLotsStatistic({commit}, payload) {
            return axios.get('/api/statistics/lots', payload)
                .then(resp => {
                    console.log('resp', resp)
                    commit('setLotsStatistic', resp.data)
                });
        },
        async getBidder({commit, state}, payload) {
            return await axios({
                method: 'get',
                url: '/api/bidders/' + payload,
                data: {},
            })
        },
        async getBidderLots({commit, state}, payload) {
            return await axios({
                method: 'get',
                url: `/api/bidders/${payload.type}/${payload.bidderType}/${payload.bidderId}`,
                data: {
                    page: payload.page,
                },
            })
        },
        async getLotFiles({commit, state}, payload) {

            return await axios({
                method: 'get',
                url: `/api/files/${payload}`,
                data: {},
            })
            // .then((response) => {
            //     commit('setFiles', response.data)
            // });
        },
        async addLotFile({commit}, payload) {
            return await axios.post('/api/files/store', payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            });
            // .then((response) => {
            //     commit('addFile', response.data)
            // }).catch(error => {
            //     console.log(error);
            //     throw error
            // });
        },
        async removeLotFile({dispatch, commit}, payload) {
            return await axios.delete(`/api/files/${payload.id}`)
            // .then(response => {
            //     commit('removeFile', payload.id);
            // }).catch(error => {
            // });
        },
    },

};
