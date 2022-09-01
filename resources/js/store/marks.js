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
            let mark = state.marks.findIndex(item => item.id === payload.id);
            if (mark < 0) {
                state.marks.push(payload)
            }
        },
        saveMark(state, payload) {
            let mark = state.marks.findIndex(item => item.id === payload.id);
            if (mark >= 0) {
                Vue.set(state.marks, mark, payload)
            }
        },
        removeMark(state, payload) {
            let mark = state.marks.findIndex(item => item.id === payload);
            if (mark >= 0) {
                state.marks.splice(mark, 1);
            }
        },
        setMarksLoading(state, payload) {
            return (state.marks_loading = payload);
        },
        saveMarkProperty(state, payload) {
            let mark = state.marks.findIndex(item => item.id === payload.id);
            if (mark >= 0 && state.marks[mark].hasOwnProperty(payload.key)) {
                Vue.set(state.marks[mark], payload.key, payload.value)
            }
        },
    },
    actions: {
        /*
            GET
            /marks
            Получение всех меток пользователя

            POST
            /mark
            Добавление метки к лоту

            DELETE
            /mark/{markId}/lot/{lotId}
            Удаление метки

            GET
            /mark/lot/{lotId}
            Получение меток для лота
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
        async addMark({dispatch, commit}, payload) {
            await axios.post('/api/mark', payload)
                .then((response) => {
                    commit('addMark', response.data)
                    dispatch('sendNotification', {message: 'Метка успешно добавлена'});
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
        async removeMark({dispatch, commit}, payload) {
            await axios.delete(`/api/marks/${payload.id}`)
                .then(response => {
                    commit('removeMark', payload.id);
                    dispatch('sendNotification', {message: 'Метка успешно удалена'});
                }).catch(error => {
                    throw error;
                });
        },
        async getLotMarks({commit, state}, payload) {
            return await axios({
                method: 'get',
                url: `/api/mark/lot/${payload}`,
                data: {},
            })

        },
        async addLotMark({dispatch, commit}, payload) {
            await axios.post('/api/mark', payload)
                .then((response) => {
                    commit('addMark', response.data);
                    commit('addSelectedLotMark', response.data);
                    dispatch('sendNotification', {message: 'Метка успешно добавлена'});
                }).catch(error => {
                    console.log(error);
                    throw error
                });
        },
        async removeLotMark({dispatch, commit}, payload) {
            await axios.delete(`/api/mark/${payload.markId}/lot/${payload.lotId}`)
                .then(response => {
                    commit('removeMark', payload.id);
                    dispatch('sendNotification', {message: 'Метка успешно удалена'});
                }).catch(error => {
                    throw error
                });
        },
    },
};

