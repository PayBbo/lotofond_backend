export default {
    state: {
        monitorings: {},
        current_monitorings: [],
        monitorings_pagination: {},
        monitorings_loading: false,
        monitorings_paths: [],
        monitoring_current_path: 0,
    },

    getters: {
        monitorings(state) {
            return state.monitorings
        },
        current_monitorings(state) {
            return state.current_monitorings
        },
        monitorings_pagination(state) {
            // if(state.current_path) {
            //     return state.monitorings[state.current_path]['pagination'];
            // }
            // else {
            return state.monitorings_pagination
            // }
        },
        monitorings_loading(state) {
            return state.monitorings_loading;
        },
        monitorings_paths(state) {
            return state.monitorings_paths;
        },
        monitoring_current_path(state) {
            return state.monitoring_current_path;
        },

    },
    mutations: {
        setMonitorings(state, payload) {
            state.monitorings[payload.pathId] = payload.data;
            state.current_monitorings = state.monitorings[payload.pathId].data;
            state.monitorings_pagination = state.monitorings[payload.pathId].pagination;
            // state.monitorings = payload.data.data;
            // state.monitorings_pagination = payload.data.pagination;
            // payload.data.forEach(item => {
            //     let monitoring = state.monitorings.findIndex(el => el.id === item.id);
            //     if (monitoring < 0) {
            //         state.monitorings.push(item)
            //     }
            // });
        },
        addMonitorings(state, payload) {
            if (!state.monitorings[payload.pathId]) {
                state.monitorings[payload.pathId] = {
                    data: [],
                    pagination: {}
                }
            }
            payload.data.data.forEach(item => {
                let favourite = state.monitorings[payload.pathId].data.findIndex(el => el.id === item.id);
                if (favourite < 0) {
                    state.monitorings[payload.pathId].data.push(item)
                }
            });
            state.monitorings[payload.pathId].pagination = payload.data.pagination;
            state.current_monitorings = state.monitorings[payload.pathId].data;
            state.monitorings_pagination = state.monitorings[payload.pathId].pagination;
        },
        setMonitoringPaths(state, payload) {
            state.monitorings_paths = payload;
        },
        setCurrentMonitoringPath(state, payload) {
            state.monitoring_current_path = payload;
            // console.log('state.monitorings[payload].data', state.monitorings[payload].data)
            // console.log('state.monitorings[payload]', state.monitorings[payload])
            if (state.monitorings[payload]) {
                state.current_monitorings = state.monitorings[payload].data
                state.monitorings_pagination = state.monitorings[payload].pagination
            } else {
                state.current_monitorings = [];
                state.monitorings_pagination = {};
            }
        },
        saveMonitoringPath(state, payload) {
            // state.monitorings_paths.push(payload)
            let monitoring = state.monitorings_paths.findIndex(item => item.pathId === payload.pathId);
            if (monitoring < 0) {
                state.monitorings_paths.push(payload)
            } else {
                Vue.set(state.monitorings_paths, monitoring, payload);
            }
        },
        addMonitoring(state, payload) {
            state.monitorings.push(payload)
        },
        removeMonitoring(state, payload) {
            if (payload.pathId && state.monitorings[payload.pathId]) {
                let monitoring = state.monitorings[payload.pathId].data.findIndex(item => item.id === payload.lotId);
                if (monitoring >= 0) {
                    state.monitorings[payload.pathId].data.splice(monitoring, 1);
                }
                let path = state.monitorings_paths.findIndex(item => item.pathId === payload.pathId);
                if (path >= 0) {
                    Vue.set(state.monitorings_paths[path], 'lotCount', state.monitorings_paths[path].lotCount - 1)
                }
            }
        },
        removeMonitoringPath(state, payload) {
            let path = state.monitorings_paths.findIndex(item => item.pathId === payload);
            if (path >= 0) {
                state.monitorings_paths.splice(path, 1);
            }
        },
        setMonitoringsLoading(state, payload) {
            return (state.monitorings_loading = payload);
        },
    },
    actions: {
        /*
        POST
        /monitoring/add/edit/path
        Создание/редактирование папки в мониторинге

        DELETE
        /monitoring/delete/path/{id}
        Удаление папки в мониторинге

        PUT
        /monitoring
        Получение данных о лотах в папке мониторинга

        GET
        /monitoring/get/paths
        Получение данных о папках мониторинга авторизованного пользователя

        DELETE
        /monitoring/delete/lot
        Удаление лота из папки мониторинга
        */
        async saveMonitoringPath({dispatch, commit}, payload) {
            await axios
                .post('/api/monitoring/add/edit/path', payload
                ).then((response) => {
                    dispatch('setCurrentMonitoringPath', response.data.pathId)
                    commit('saveMonitoringPath', response.data)
                }).catch(error => {
                    console.log(error);

                });
        },
        async editMonitoringPath({dispatch, commit}, payload) {
            await axios
                .post('/api/monitoring/add/edit/path', payload
                ).then((response) => {
                    commit('saveMonitoringPath', response.data)
                    dispatch('saveDataProperty', {
                        module_key: 'monitoring',
                        state_key: 'monitorings',
                        key: ''+response.data.pathId,
                        value: null
                    }, {root: true});
                    dispatch('setCurrentMonitoringPath', response.data.pathId)
                }).catch(error => {
                    console.log(error);
                });
        },
        async removeMonitoringPath({dispatch, commit, state}, payload) {
            await axios
                .delete('/api/monitoring/delete/path/' + payload
                ).then((response) => {
                    commit('removeMonitoringPath', payload)
                    if(state.monitorings_paths.length>0)
                    {
                        dispatch('setCurrentMonitoringPath', state.monitorings_paths[0].pathId)
                    }

                }).catch(error => {
                    console.log(error);

                });
        },
        async getMonitorings({commit, state}, payload) {
            await axios({
                method: 'put',
                url: '/api/monitoring?page=' + payload.page,
                data: payload,
            })
                .then((response) => {
                    commit('addMonitorings', {pathId: payload.pathId, data: response.data})
                });

        },
        async getMonitoringPaths({dispatch, commit, state}, payload) {
            await axios({
                method: 'get',
                url: '/api/monitoring/get/paths',
                data: {},
            })
                .then((response) => {
                    // dispatch('getMonitorings', {page: 1, pathId: response.data[0].pathId});
                    commit('setMonitoringPaths', response.data)
                    commit('setCurrentMonitoringPath', response.data[0].pathId)
                });
        },
        async removeMonitoring({dispatch, commit}, payload) {
            await axios({
                method: 'delete',
                url: '/api/monitoring/delete/lot',
                data: payload,
            })
                .then(response => {
                    commit('removeMonitoring', payload);
                }).catch(error => {
                });
        },
        async setCurrentMonitoringPath({dispatch, commit, state}, payload) {
            if (state.monitorings[payload]) {
                commit('setCurrentMonitoringPath', payload);
            } else {
                await dispatch('getMonitorings', {page: 1, pathId: payload})
                    .then(resp => {
                        commit('setCurrentMonitoringPath', payload);
                    })
            }
        }
    },

};
