export default {
    state: {
        favourites: {},
        current_favourites: [],
        favourites_pagination: {},
        favourites_loading: false,
        favourites_paths: [],
        current_path: 0,
    },

    getters: {
        favourites(state) {
            return state.favourites
        },
        current_favourites(state) {
            return state.current_favourites
        },
        favourites_pagination(state) {
            // if(state.current_path) {
            //     return state.favourites[state.current_path]['pagination'];
            // }
            // else {
            return state.favourites_pagination
            // }
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
            state.favourites[payload.pathId] = payload.data;
            // if(!state.favourites[payload.pathId])
            // {
            //     state.favourites[payload.pathId]={
            //         data:[],
            //         pagination:{},
            //         loading: false
            //     }
            // }
            // payload.data.data.forEach(item => {
            //     let favourite = state.favourites[payload.pathId].data.findIndex(el => el.id === item.id);
            //     if (favourite < 0) {
            //         state.favourites[payload.pathId].data.push(item)
            //     }
            // });
            // state.favourites[payload.pathId].pagination = payload.data.pagination;
            state.current_favourites = state.favourites[payload.pathId].data;
            state.favourites_pagination = state.favourites[payload.pathId].pagination;
            // state.favourites = payload.data.data;
            // state.favourites_pagination = payload.data.pagination;
        },
        setFavouritePaths(state, payload) {
            state.favourites_paths = payload;
        },
        setCurrentPath(state, payload) {
            state.current_path = payload;
            // console.log('state.favourites[payload].data', state.favourites[payload].data)
            // console.log('state.favourites[payload]', state.favourites[payload])
            if (state.favourites[payload]) {
                state.current_favourites = state.favourites[payload].data
                state.favourites_pagination = state.favourites[payload].pagination
            } else {
                state.current_favourites = [];
                state.favourites_pagination = {};
            }
        },
        saveFavouritePath(state, payload) {
            // state.favourites_paths.push(payload)
            let favourite = state.favourites_paths.findIndex(item => item.pathId === payload.pathId);
            if (favourite < 0) {
                state.favourites_paths.push(payload)
            } else {
                Vue.set(state.favourites_paths, favourite, payload);
            }
        },
        addFavourite(state, payload) {
            state.favourites.push(payload)
        },
        saveFavourite(state, payload) {
            let favourite = state.favourites.findIndex(item => item.id === payload.id);
            if (favourite >= 0) {
                Vue.set(state.favourites, favourite, payload);
            }
        },
        removeFavourite(state, payload) {
            if (payload.pathId && state.favourites[payload.pathId]) {
                let favourite = state.favourites[payload.pathId].data.findIndex(item => item.id === payload.lotId);
                if (favourite >= 0) {
                    state.favourites[payload.pathId].data.splice(favourite, 1);
                }
                let path = state.favourites_paths.findIndex(item => item.pathId === payload.pathId);
                if (path >= 0) {
                    Vue.set(state.favourites_paths[path], 'lotCount', state.favourites_paths[path].lotCount - 1)
                }
            }
        },
        moveFavourite(state, payload) {
            let new_path = state.favourites_paths.findIndex(item => item.pathId === payload.newPathId);
            if (new_path >= 0) {
                Vue.set(state.favourites_paths[new_path], 'lotCount', state.favourites_paths[new_path].lotCount + 1)
            }
            let old_path = state.favourites_paths.findIndex(item => item.pathId === payload.currentPathId);
            if (old_path >= 0) {
                Vue.set(state.favourites_paths[old_path], 'lotCount', state.favourites_paths[old_path].lotCount - 1)
            }
            if (state.favourites[payload.currentPathId]) {
                let favourite = state.favourites[payload.currentPathId].data.findIndex(item => item.id === payload.lotId);
                if (favourite >= 0) {
                    if (state.favourites[payload.newPathId]) {
                        let new_lot_index = state.favourites[payload.newPathId].data.findIndex(item => item.id === payload.lotId);
                        if(new_lot_index<0)
                        {
                            let item = state.favourites[payload.currentPathId].data[favourite];
                            if(item.favouritePaths) {
                                let item_path = item.favouritePaths.findIndex(item => item.pathId === payload.currentPathId)
                                if (item_path >= 0) {
                                    item.favouritePaths.splice(item_path, 1);
                                }
                                item_path = item.favouritePaths.findIndex(item => item.pathId === payload.newPathId)
                                if (item_path < 0) {
                                    if (new_path >= 0) {
                                        item.favouritePaths.push(state.favourites_paths[new_path]);
                                    }
                                }
                            }
                            state.favourites[payload.newPathId].data.push(state.favourites[payload.currentPathId].data[favourite]);
                        }
                    }
                    state.favourites[payload.currentPathId].data.splice(favourite, 1);
                }
            }
        },
        removeFavouritePath(state, payload) {
            let path = state.favourites_paths.findIndex(item => item.pathId === payload);
            if (path >= 0) {
                state.favourites_paths.splice(path, 1);
            }
            if(state.trades && state.trades.length>0)
            {
                state.trades.forEach( item => {
                    if(item.favouritePaths) {
                        let lot_path = item.favouritePaths.findIndex(item => item.pathId === payload);
                        if (lot_path >= 0) {
                            item.favouritePaths.splice(lot_path, 1);
                        }
                    }
                })
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
        /favourite/delete/lot
        Удаление лота из папки избранного

        PUT
        /favourite/move/lot
        Перемещение лота из одной папки избранного в другую

         */
        async saveFavouritePath({commit}, payload) {
            await axios
                .post('/api/favourite/add/edit/path', payload
                ).then((response) => {
                    commit('saveFavouritePath', response.data)
                }).catch(error => {
                    console.log(error);
                    throw error;
                });
        },
        async removeFavouritePath({commit}, payload) {
            await axios
                .delete('/api/favourite/delete/path/' + payload
                ).then((response) => {
                    commit('removeFavouritePath', payload)
                }).catch(error => {
                    console.log(error);
                    throw error;
                });
        },
        async downloadFavouritePath({commit}, payload) {
            return await axios
            // ({
            //     method: "post",
            //     url: "'/api/favourite/download/path",
            //     data: payload,
            //     // responseType: "arraybuffer"
            // })
                .post('/api/favourite/download/path', payload)
                // .then((response) => {
                //
                // }).catch(error => {
                //     console.log(error);
                // });
        },
        async getFavourites({commit, state, dispatch}, payload) {
            dispatch('checkAbort','getFavourites');
            let tmp_controller = new AbortController();
            dispatch('setAborts', {
                controller: tmp_controller,
                signal: tmp_controller.signal,
                method: 'getFavourites'
            });
            commit('setFavouritesLoading', true);
            await axios({
                method: 'put',
                url: '/api/favourite?page=' + payload.page,
                data: payload,
                signal: tmp_controller.signal,
            })
                .then((response) => {
                    commit('setFavourites', {pathId: payload.pathId, data: response.data})
                    commit('setFavouritesLoading', false);
                }).catch(error => {
                    commit('setFavouritesLoading', false);
                    if (error.message === 'canceled') {
                        commit('setFavouritesLoading', true);
                    }
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
        async getFavouritePaths({dispatch, commit, state}, payload) {
            await axios({
                method: 'get',
                url: '/api/favourite/get/paths',
                data: {},
            })
                .then((response) => {
                    // dispatch('getFavourites', {page: 1, pathId: response.data[0].pathId});
                    commit('setFavouritePaths', response.data);
                    let pathId = response.data[0].pathId
                    if(sessionStorage.getItem('favourite_path_id')){
                        pathId = sessionStorage.getItem('favourite_path_id')/1;
                    }
                    commit('setCurrentPath', pathId)
                });
        },
        async removeFavourite({dispatch, commit}, payload) {
            await axios({
                method: 'delete',
                url: '/api/favourite/delete/lot',
                data: payload,
            })
                .then(response => {
                    commit('removeFavourite', payload);
                }).catch(error => {
                    throw error;
                });
        },
        async moveFavourite({commit}, payload) {
            await axios
                .put(`/api/favourite/move/lot`, payload
                ).then((response) => {
                    commit('moveFavourite', payload);
                    commit('changeTradeFavouritePaths', payload);
                }).catch(error => {
                    console.log(error);
                    throw error;
                });
        },
        async setCurrentPath({dispatch, commit, state}, payload) {
            // if (state.favourites[payload.pathId]) {
            //     commit('setCurrentPath', payload.pathId);
            // } else {
                let params = payload.params;
                params.page = 1;
                params.pathId = payload.pathId;
                commit('setCurrentPath', payload.pathId);
                await dispatch('getFavourites', params)
                    // .then(resp => {
                    //
                    // })
            // }
        }
    },

};
