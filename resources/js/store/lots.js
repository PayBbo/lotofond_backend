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
        selected_lot: null
    },

    getters: {
        lots_statistic(state) {
            return state.lots_statistic;
        },
        categories_statistic(state) {
            return state.categories_statistic;
        },
        selected_lot(state) {
            return state.selected_lot;
        },
    },
    mutations: {
        setLotsStatistic(state, payload) {
            return (state.lots_statistic = payload);
        },
        setCategoriesStatistic(state, payload) {
            return (state.categories_statistic = payload);
        },
        setSelectedLot(state, payload) {
            return (state.selected_lot = payload);
        },
        addSelectedLotMark(state, payload) {
            if(!state.selected_lot.marks) {
                state.selected_lot.marks = [];
            }
            let mark_index =  state.selected_lot.marks.findIndex(mark => mark.id == payload.id);
            if(mark_index<0){
                state.selected_lot.marks.push(payload);
            }
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
        *
        * POST
        * /note
        * Добавление заметки к лоту/организатору торгов
        *
        *  PUT
        *  /note/edit
        * Редактирование заметки к лоту/организатору торгов
        *
        * DELETE
        * /note/delete
        *  Удаление заметки к лоту/организатору торгов
        */
        getCategoriesStatistic({commit}, payload) {
            return axios.get('/api/statistics/categories', payload);
        },
        getLotsStatistic({commit}, payload) {
            return axios.get('/api/statistics/lots', payload)
                .then(resp => {
                    commit('setLotsStatistic', resp.data)
                });
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
            return await axios.delete(`/api/files/${payload}`)
            // .then(response => {
            //     commit('removeFile', payload.id);
            // }).catch(error => {
            // });
        },
        async addLotNote({commit}, payload) {
            return await axios.post('/api/note', payload);
            // .then((response) => {
            //     commit('addFile', response.data)
            // }).catch(error => {
            //     console.log(error);
            //     throw error
            // });
        },
        async editLotNote({commit}, payload) {
            return await axios.put('/api/note/edit', payload);
            // .then((response) => {
            //     commit('addFile', response.data)
            // }).catch(error => {
            //     console.log(error);
            //     throw error
            // });
        },
        async removeLotNote({dispatch, commit}, payload) {
            return await axios.delete(`/api/note/delete`, {params:payload})
            // .then(response => {
            //     commit('removeFile', payload.id);
            // }).catch(error => {
            // });
        },

    },

};
