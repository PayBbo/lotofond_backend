export default {
    state: {
        files: [],
        files_pagination: {},
        files_loading: false,
    },

    getters: {
        files(state) {
            return state.files;
        },
        files_pagination(state) {
            return state.files_pagination;
        },
        files_loading(state) {
            return state.files_loading;
        },

    },
    mutations: {
        setFiles(state, payload) {
            state.files = payload.data;
            state.files_pagination = payload.pagination;
        },
        addFile(state, payload) {
            state.files.push(payload)
        },
        saveFile(state, payload) {
            let file = state.files.findIndex(item => item.id === payload.id);
            if (file >= 0) {
                Vue.set(state.files, file, payload)
            }
        },
        removeFile(state, payload) {
            let file = state.files.findIndex(item => item.id === payload);
            if (file >= 0) {
                state.files.splice(file, 1);
            }
        },
        setFilesLoading(state, payload) {
            return (state.files_loading = payload);
        },
        saveFileProperty(state, payload) {
            let file = state.files.findIndex(item => item.id === payload.id);
            if (file >= 0 && state.files[file].hasOwnProperty(payload.key)) {
                Vue.set(state.files[file], payload.key, payload.value)
            }
        },
    },
    actions: {
        /*
            GET
            /files/{lotId}
            Получение списка файлов для лота


            POST
            /files/store
            Загрузка файлов на сервер


            DELETE
            /files/{id}
            Удаление пользовательского файла/картинки
        */
        // async getFiles({commit, state}, payload) {
        //     try {
        //         await axios({
        //             method: 'get',
        //             url: '/api/files' + payload,
        //             data: {},
        //         })
        //             .then((response) => {
        //                 commit('setFiles', response.data)
        //             });
        //     } catch (error) {
        //         console.log(error);
        //         // commit('setFiles', []);
        //         throw error
        //     }
        // },
        // async addFile({commit}, payload) {
        //     await axios.post('/api/files', payload, {
        //         headers: {
        //             'Content-Type': 'multipart/form-data',
        //         }
        //     }).then((response) => {
        //         commit('addFile', response.data)
        //     }).catch(error => {
        //         console.log(error);
        //         throw error
        //     });
        // },
        // async removeFile({dispatch, commit}, payload) {
        //     await axios.delete(`/api/files/${payload.id}`)
        //         .then(response => {
        //             commit('removeFile', payload.id);
        //             dispatch('sendNotification',
        //                 {
        //                     self: payload.self,
        //                     title: 'Должники',
        //                     message: 'Должник успешно удален'
        //                 });
        //         }).catch(error => {
        //             dispatch('sendNotification',
        //                 {
        //                     self: payload.self,
        //                     title: 'Должники',
        //                     type: 'error',
        //                     message: 'Произошла ошибка'
        //                 });
        //         });
        // },
        async getLotFiles({commit, state}, payload) {

                await axios({
                    method: 'get',
                    url: `/api/files/${payload}`,
                    data: {},
                })
                // .then((response) => {
                //     commit('setFiles', response.data)
                // });
        },
        async addLotFile({commit}, payload) {
            await axios.post('/api/files/store', payload, {
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
            await axios.delete(`/api/files/${payload.id}`)
                // .then(response => {
                //     commit('removeFile', payload.id);
                // }).catch(error => {
                // });
        },
    },
};

