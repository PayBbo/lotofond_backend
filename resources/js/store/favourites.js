export default {
    state: {
        favourites: [],
        favourites_pagination: {},
        favourites_loading: false,
        favourites_paths: [],
        current_path: 0,
    },

    getters: {
        favourites(state) {
            return state.favourites;
        },
        favourites_pagination(state) {
            return state.favourites_pagination;
        },
        favourites_loading(state) {
            return state.favourites_loading;
        },
        favourites_paths(state) {
            return state.favourites_paths;
        },
        current_path(state) {
            return state.current_path;
        },

    },
    mutations: {
        setFavourites(state, payload) {
            state.favourites = payload.data;
            // payload.data.forEach(item => {
            //     let favourite = state.favourites.findIndex(el => el.id === item.id);
            //     if (favourite < 0) {
            //         state.favourites.push(item)
            //     }
            // });
            state.favourites_pagination = payload.pagination;
        },
        setFavouritePaths(state, payload) {
            state.favourites_paths = payload;
        },
        setCurrentPath(state, payload) {
            state.current_path = payload;
        },
        addFavourite(state, payload) {
            state.favourites.push(payload)
        },
        saveFavourite(state, payload) {
            let favourite = state.favourites.findIndex(item => item.id === payload.id);
            if (favourite >= 0) {
                Vue.set(state.favourites, favourite, payload)
            }
        },
        removeFavourite(state, payload) {
            let favourite = state.favourites.findIndex(item => item.id === payload);
            if (favourite >= 0) {
                state.favourites.splice(favourite, 1);
            }
        },
        setFavouritesLoading(state, payload) {
            return (state.favourites_loading = payload);
        },
        saveFavouriteProperty(state, payload) {
            let favourite = state.favourites.findIndex(item => item.id === payload.id);
            if (favourite >= 0 && state.favourites[favourite].hasOwnProperty(payload.key)) {
                Vue.set(state.favourites[favourite], payload.key, payload.value)
            }
        },
    },
    actions: {
        /*
        POST
        /favourite/add/edit/path
        Создание/редактирование папки в избранном

        DELETE
        /favourite/delete/path/{id}
        Удаление папки в избранном

        POST
        /favourite/download/path
        Скачивание в эксель файл папки в избранном

        PUT
        /favourite
        Получение данных о лотах в папке избранного

        POST
        /favourite/add/lots
        Добавление лотов в папку избранного

        GET
        /favourite/get/paths
        Получение данных о папках избранного авторизованного пользователя

        DELETE
        /favourite/delete/{pathId}/lot/{lotId}
        Удаление лота из папки избранного

        PUT
        /favourite/move/lot
        Перемещение лота из одной папки избранного в другую

         */
        async saveFavouritePath({commit}, payload) {
            await axios
                .post('/api/favourite/add/edit/path', {
                        key: payload.key,
                        value: payload.value
                    }
                ).then((response) => {

                }).catch(error => {
                    console.log(error);

                });
        },
        async removeFavouritePath({commit}, payload) {
            await axios
                .delete('/api/favourite/delete/path/' + payload.id
                ).then((response) => {

                }).catch(error => {
                    console.log(error);

                });
        },
        async downloadFavouritePath({commit}, payload) {
            await axios
                .post('/api/favourite/download/path', {
                        key: payload.key,
                        value: payload.value
                    }
                ).then((response) => {

                }).catch(error => {
                    console.log(error);
                });
        },
        async getFavourites({commit, state}, payload) {
            await axios({
                method: 'put',
                url: '/api/favourite?page=' + payload.page,
                data: payload,
            })
                .then((response) => {
                    commit('setFavourites', response.data)
                });

        },
        async addFavourite({commit}, payload) {
             return await axios.post('/api/favourite/add/lots', payload)
            //     .then((response) => {
            //     commit('addFavourite', response.data)
            // }).catch(error => {
            //     console.log(error);
            //     throw error
            // });
        },
        async getFavouritePaths({commit, state}, payload) {
            await axios({
                method: 'get',
                url: '/api/favourite/get/paths',
                data: {},
            })
                .then((response) => {
                    commit('setFavouritePaths', response.data)
                    commit('setCurrentPath', response.data[0].pathId)
                });
        },
        async updateFavourite({commit}, payload) {
            await axios.post('/api/favourites/' + payload.id, payload.formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then((response) => {
                    commit('saveFavourite', response.data);
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
        async removeFavourite({dispatch, commit}, payload) {
            await axios.delete(`/api/favourite/delete/${payload.path_id}/lot/${payload.lot_id}`)
                .then(response => {
                    commit('removeFavourite', payload.lot_id);
                }).catch(error => {
                });
        },
        async moveFavourite({commit}, payload) {
            await axios
                .put(`/api/favourite/move/lot/`, {
                        key: payload.key,
                        value: payload.value
                    }
                ).then((response) => {
                }).catch(error => {
                    console.log(error);
                });
        },
    },

};
