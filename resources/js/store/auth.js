import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default {
    state: {
        token: localStorage.getItem('token') || '',
        refreshToken: localStorage.getItem('refreshToken') || '',
        // is_admin: localStorage.getItem('is_admin') || false,
        // is_client: localStorage.getItem('is_client') || false,
        auth_user: null,
        error: ''
    },
    mutations: {
        setAuthUser(state, payload) {
            state.auth_user = payload;
        },
        auth_success(state, payload) {
            if (payload.token) {
                state.token = payload.token;
                localStorage.setItem('token', payload.token);
                axios.defaults.headers.common['Authorization'] = "Bearer " + payload.token;
            }
            if (payload.refreshToken) {
                localStorage.setItem('refreshToken', payload.refreshToken);
                state.refreshToken = payload.refreshToken;
            }
        },
        logout(state) {
            state.token = '';
            // state.is_admin = false;
            // state.is_client = false;
            state.auth_user = null;
        },
        clearStorage() {
            localStorage.removeItem('token');
            localStorage.removeItem('refreshToken');
            // localStorage.removeItem('is_admin');
            // localStorage.removeItem('is_client');
            delete axios.defaults.headers.common['Authorization'];
        }
    },
    actions: {
        /*
            Auth

            POST http://localhost:8080/api/login
            POST http://localhost:8080/api/registration
            POST http://localhost:8080/api/registrationCode
            POST http://localhost:8080/api/registrationCodeVerify


            Account
            GET  /account/logout                Выход пользователя из аккаунта
            GET  /account/user                  Получение информации об аккаунте пользователя
            PUT  /account/user/update           Обновление информации об аккаунте
            POST /account/password/code         Запрос кода подтверждения для сброса пароля
            POST /account/password/code/verify  Отправка пользователем кода подтверждения для сброса пароля
            POST /account/password/reset        Сброс пароля пользователя
        */

        async login({dispatch, commit}, payload) {
            await axios.post('/api/login', payload)
                .then(resp => {
                    commit('auth_success', {token: resp.data.accessToken, refreshToken: resp.data.refreshToken});
                    commit('closeModal', '#authModal');
                    dispatch('getAuthUser');
                })
                .catch(error => {
                    commit('clearStorage');
                });
        },
        async registration({dispatch, commit}, payload) {
            await axios.post('/api/registration', payload)
                .then(resp => {
                   commit('setUser', payload);
                    commit('closeModal', '#authModal');
                    commit('openModal', '#codeModal');
                })
                .catch(error => {
                    commit('clearStorage');
                })
        },
        async registrationCode({dispatch, commit}, payload) {
            await axios.post('/auth/registration/code', payload)
                .then(resp => {

                })
                .catch(error => {
                })
        },
        async registrationCodeVerify({dispatch, commit}, payload) {
            await axios.post('/auth/registration/code/verify', payload)
                .then(resp => {
                })
                .catch(error => {
                })
        },
        async logout({commit}) {
            await axios.get('/api/account/logout').then(resp => {
                console.log(resp);
                commit('clearStorage');
                commit('logout');
            }).catch(error => {
                console.log(error);
                commit('clearStorage');
                commit('logout');
            });
        },
        async getAuthUser({commit}) {
            await axios.get('/api/account/user').then(resp => {
                console.log(resp);
                commit('setAuthUser', resp.data)
            }).catch(error => {
                console.log(error);
            });
        },
        async updateAuthUser({commit}, payload) {
            await axios.put('/api/account/user/update', payload).then(resp => {
                console.log(resp);
                commit('setAuthUser', payload)
            }).catch(error => {
                console.log(error);
            });
        },
        async getPasswordCode({commit}, payload) {
            await axios.post('/api/account/password/code', payload)
                .then(resp => {
                    console.log(resp);
                }).catch(error => {
                    console.log(error);
                });
        },
        async verifyPasswordCode({commit}, payload) {
            await axios.post('/api/account/password/code/verify', payload)
                .then(resp => {
                    console.log(resp);
                }).catch(error => {
                    console.log(error);
                });
        },
        async resetPassword({commit}, payload) {
            await axios.post('/api/account/password/reset', payload)
                .then(resp => {
                    console.log(resp);
                }).catch(error => {
                    console.log(error);
                });
        },
    },
    getters: {
        isLoggedIn: state => !!state.token,
        auth_user: state => state.auth_user,
    }
};
