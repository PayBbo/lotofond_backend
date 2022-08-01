export default {
    state: {
        marks: [],
        marks_pagination: {},
        marks_loading: false,
    },

    getters: {
        marks(state) {
            return state.marks;
        },
        marks_pagination(state) {
            return state.marks_pagination;
        },
        marks_loading(state) {
            return state.marks_loading;
        },

    },
    mutations: {
        setMarks(state, payload) {
            state.marks = payload;
            // state.marks_pagination = payload.pagination;
        },
        addMark(state, payload) {
            state.marks.push(payload)
        },
        saveMark(state, payload) {
            let trade = state.marks.findIndex(item => item.id === payload.id);
            if (trade >= 0) {
                Vue.set(state.marks, trade, payload)
            }
        },
        removeMark(state, payload) {
            let trade = state.marks.findIndex(item => item.id === payload);
            if (trade >= 0) {
                state.marks.splice(trade, 1);
            }
        },
        setMarksLoading(state, payload) {
            return (state.marks_loading = payload);
        },
        saveMarkProperty(state, payload) {
            let trade = state.marks.findIndex(item => item.id === payload.id);
            if (trade >= 0 && state.marks[trade].hasOwnProperty(payload.key)) {
                Vue.set(state.marks[trade], payload.key, payload.value)
            }
        },
    },
    actions: {
        /*
            POST
            /mark
            Добавление метки к лоту

            DELETE
            /mark/{markId}/lot/{lotId}
            Удаление метки

            GET
            /mark/lot/{lotId}
            Получение меток для лота

            GET
            /marks
            Получение всех меток пользователя
        */
        async getMarks({commit, state}, payload) {
            try {
                await axios({
                    method: 'get',
                    url: '/api/marks?page=' + payload,
                    data: {},
                })
                    .then((response) => {
                        commit('setMarks', response.data)
                    });
            } catch (error) {
                console.log(error);
                // commit('setMarks', []);
                throw error
            }
        },
        async addMark({commit}, payload) {
            await axios.post('/api/marks', payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then((response) => {
                commit('addMark', response.data)
            }).catch(error => {
                console.log(error);
                throw error
            });
        },
        async updateMark({commit}, payload) {
            await axios.post('/api/marks/' + payload.id, payload.formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then((response) => {
                    commit('saveMark', response.data);
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
        async removeMark({dispatch, commit}, payload) {
            await axios.delete(`/api/marks/${payload.id}`)
                .then(response => {
                    commit('removeMark', payload.id);
                    dispatch('sendNotification',
                        {
                            self: payload.self,
                            title: 'Должники',
                            message: 'Должник успешно удален'
                        });
                }).catch(error => {
                    dispatch('sendNotification',
                        {
                            self: payload.self,
                            title: 'Должники',
                            type: 'error',
                            message: 'Произошла ошибка'
                        });
                });
        },
        async saveMark({commit}, payload) {
            await axios
                .post(`/api/marks/save/${payload.id}`, {
                        key: payload.key,
                        value: payload.value
                    }
                ).then((response) => {
                    commit('saveMark', response.data.trade)
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
        async getLotMarks({commit, state}, payload) {
            try {
                await axios({
                    method: 'get',
                    url: `/api/mark/lot/${payload.id}`,
                    data: {},
                })
                    .then((response) => {
                        commit('setMarks', response.data)
                    });
            } catch (error) {
                console.log(error);
                // commit('setMarks', []);
                throw error
            }
        },
        async addLotMark({commit}, payload) {
            await axios.post('/api/marks', payload, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then((response) => {
                commit('addMark', response.data)
            }).catch(error => {
                console.log(error);
                throw error
            });
        },
        async removeLotMark({dispatch, commit}, payload) {
            await axios.delete(`/api/mark/${payload.markId}/lot/${payload.id}`)
                .then(response => {
                    commit('removeMark', payload.id);
                }).catch(error => {
                });
        },
    },
};

