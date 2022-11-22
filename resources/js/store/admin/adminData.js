import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

const getDefaultState = () => {
    return {
        dataItems: null,
        pagination: {
            total: 0,
            perPage: 0
        },
        currentPage: 1,
        currentRoute: null,
        param: '',
        item: null,
        types: []
    }
}


export default {
    state: getDefaultState(),
    mutations: {
        setData(state, payload) {
            state.dataItems = payload.data
            state.pagination = payload.pagination
            if (payload.hasOwnProperty('types')) {
                state.types = payload.types
            }
        },
        setCurrentPage(state, page) {
            state.currentPage = page
        },
        setCurrentRoute(state, route) {
            state.currentRoute = route
        },
        setParam(state, param) {
            state.param = param
        },
        setModal(state, data) {
            const Toast = Vue.swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Vue.swal.stopTimer)
                    toast.addEventListener('mouseleave', Vue.swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: data.data,
                title: data.text
            })
        },
        setItem(state, item) {
            state.item = item
        },
        resetState(state) {
            Object.assign(state, getDefaultState())
        }
    },
    actions: {
        async getData({commit, state}) {
            await axios({
                method: 'get',
                url: '/api' + state.currentRoute + '?page=' + state.currentPage + '&param=' + state.param,
                data: {},
            })
                .then((response) => {
                    commit('setData', response.data)
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async updateData({commit, dispatch, state}, item) {
            await axios({
                method: 'put',
                url: '/api' + state.currentRoute + '/update',
                data: item,
            })
                .then((response) => {
                    if (response.status === 200) {
                        dispatch('getData')
                        commit('setModal', {data: 'success', text: 'Операция прошла успешно'})
                    }
                })
                .catch((error) => {
                    if (error.response.data.code === 422) {
                        commit('setModal', {data: 'error', text: error.response.data.detail})
                    }else {
                        commit('setModal', {data: 'error', text: 'Произошла ошибка'})
                    }
                });
        },
        async editItem({commit, state}, method='edit') {
            await axios({
                method: 'get',
                url: '/api' + state.currentRoute + '/' + method,
                data: {},
            })
                .then((response) => {
                    commit('setItem', response.data)
                })
                .catch((error) => {
                    console.log(error);
                    commit('setModal', {data: 'error', text: 'Произошла ошибка'})
                });
        },
        async addData({commit, state}, item) {
            await axios({
                method: 'post',
                url: '/api' + state.currentRoute,
                data: item,
            })
                .then((response) => {
                    if (response.status === 200) {
                        commit('setModal', {data: 'success', text: 'Операция прошла успешно'})
                    }
                })
                .catch((error) => {
                    if (error.response.data.code === 422) {
                        commit('setModal', {data: 'error', text: error.response.data.detail})
                    }else {
                        commit('setModal', {data: 'error', text: 'Произошла ошибка'})
                    }

                });
        },
        async deleteItem({commit, dispatch, state}, id) {
            Vue.swal.fire({
                title: 'Вы уверены, что хотите удалить выбранную запись?',
                text: 'Отменить действие будет невозможно',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085D6',
                cancelButtonColor: '#D33',
                confirmButtonText: 'Да',
                cancelButtonText: 'Отменить',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await axios({
                        method: 'delete',
                        url: '/api' + state.currentRoute + '/' + id,
                        data: {},
                    })
                        .then((response) => {
                            if (response.status === 200) {
                                dispatch('getData')
                                commit('setModal', {data: 'success', text: 'Операция прошла успешно'})
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                            commit('setModal', {data: 'error', text: 'Произошла ошибка'})
                        });
                }
            })
        },

    },
    getters: {
        dataItems(state) {
            return state.dataItems
        },
        pagination(state) {
            return state.pagination
        },
        currentPage(state) {
            return state.currentPage
        },
        param(state) {
            return state.param
        },
        item(state) {
            return state.item
        },
        types(state) {
            return state.types
        }
    }
}
