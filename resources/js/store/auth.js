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
        error: '',
        auth_user_loading: false
    },
    mutations: {
        setAuthUser(state, payload) {
            state.auth_user = payload;
        },
        updateAuthUser(state, payload) {
            state.auth_user.lastName = payload.lastName;
            state.auth_user.middleName = payload.middleName;
            state.auth_user.name = payload.name;
        },
        setAuthUserLoading(state, payload) {
            state.auth_user_loading = payload;
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
            GET  /account/logout                  Выход пользователя из аккаунта
            POST /account/refresh/token           Обновление токена
            GET  /account/user                    Получение информации об аккаунте пользователя
            PUT  /account/user/update             Обновление информации об аккаунте
            POST /account/password/code           Запрос кода подтверждения для сброса пароля
            POST /account/password/code/verify    Отправка пользователем кода подтверждения для сброса пароля
            POST /account/password/reset          Сброс пароля пользователя
            POST /account/password/change         Смена пароля пользователя
            POST /account/credentials/code        Запрос кода подтверждения для смены почты/телефона
            POST /account/credentials/code/verify Отправка пользователем кода подтверждения для подтвержденыя изменения почты/телефона
            POST /account/notifications/settings  изменение настроек уведомлений в профиле пользователя
            DELETE /account/change/credentials/delete/{changeCredentialsProcessId} Отмена изменения почты/телефона аккаунта
            POST /account/apple/callback          Получение данных после авторизации через соц.сеть
            POST /account/socials/link            Привязка социальной сети к аккаунту

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
                    throw error
                    // dispatch('sendNotification',
                    //     {self: payload.self, message: error.response.data.detail, type: 'error'})
                });
        },
        async registration({dispatch, commit}, payload) {
            await axios.post('/api/registration', payload)
                .then(resp => {
                    commit('setUser', payload);
                    commit('closeModal', '#authModal');
                    commit('openModal', '#codeModal');
                    // dispatch('registrationCode', payload);
                })
                .catch(error => {
                    commit('clearStorage');
                    throw error
                    // dispatch('sendNotification',
                    //     {self: payload.self, message: error.response.data.detail, type: 'error'})
                })
        },
        async registrationCode({dispatch, commit}, payload) {
            await axios.post('/api/registration/code', payload);
        },
        async registrationCodeVerify({dispatch, commit}, payload) {
            await axios.post('/api/registration/code/verify', payload)
                .then(resp => {
                    commit('auth_success', {token: resp.data.accessToken, refreshToken: resp.data.refreshToken});
                    if(payload.region) {
                        commit('saveFiltersProperty', {key: 'filters_regions', value: [payload.region]});
                        dispatch('saveDataProperty', {
                            module_key: 'filters', state_key: 'filters',
                            key: 'regions',
                            value: [payload.region]
                        }, {root: true});
                    }
                    dispatch('getAuthUser');
                    commit('closeModal', '#codeModal');
                })
                .catch(error => {
                    // dispatch('sendNotification',
                    //     {self: payload.self, message: error.response.data.detail, type: 'error'})
                    throw error
                })
        },

        async logout({commit}) {
            commit('setAuthUserLoading', true);
            await axios.post('/api/account/logout').then(resp => {
                // sessionStorage.clear();
                // commit('clearStorage');
                // commit('logout');
                // commit('setHasNotSeenNotifications', false);
                commit('setAuthUserLoading', false);
                // commit('setFilteredTrades', {data: [], pagination: {}});
                // commit('setNearestTrades', {data: [], pagination: {}});

            }).catch(error => {
                console.log(error);
                // commit('clearStorage');
                // commit('logout');
                commit('setAuthUserLoading', false);
            }).finally(() => {
                sessionStorage.clear();
                commit('clearStorage');
                commit('logout');
                commit('setHasNotSeenNotifications', false);
                commit('setAuthUserLoading', false);
                commit('setTrades', {data: [], pagination: {}});
                commit('setNearestTrades', {data: [], pagination: {}});
            });
        },
        async refresh({commit, state}) {
            await axios.post('/api/account/refresh/token', {refreshToken: state.refreshToken}).then(resp => {
                commit('auth_success', {token: resp.data.accessToken, refreshToken: resp.data.refreshToken});
            }).catch(error => {
                commit('clearStorage');
                commit('logout');
            });
        },
        async getAuthUser({commit}) {
            commit('setAuthUserLoading', true);
            await axios.get('/api/account/user').then(resp => {
                commit('setAuthUser', resp.data);
                commit('setAuthUserLoading', false);
            }).catch(error => {
                console.log(error);
                commit('clearStorage');
                commit('logout');
                commit('setAuthUserLoading', false);
            });
        },
        async updateAuthUser({commit}, payload) {
            commit('setAuthUserLoading', true);
            await axios.put('/api/account/user/update', payload).then(resp => {
                console.log(resp);
                commit('updateAuthUser', payload)
                commit('setAuthUserLoading', false);
            }).catch(error => {
                console.log(error);
                commit('setAuthUserLoading', false);
            });
        },
        async getPasswordCode({commit}, payload) {
            return await axios.post('/api/account/password/code', payload)
                // .then(resp => {
                //     console.log(resp);
                // }).catch(error => {
                //     console.log(error);
                // });
        },
        async verifyPasswordCode({commit}, payload) {
            return await axios.post('/api/account/password/code/verify', payload)
                // .then(resp => {
                //     console.log(resp);
                // }).catch(error => {
                //     console.log(error);
                // });
        },
        async resetPassword({commit}, payload) {
            return await axios.post('/api/account/password/reset', payload)
                // .then(resp => {
                //     console.log(resp);
                // }).catch(error => {
                //     console.log(error);
                // });
        },
        async changePassword({commit}, payload) {
            return await axios.post('/api/account/password/change', payload)
            // .then(resp => {
            //     // commit('auth_success', {token: resp.data.accessToken, refreshToken: resp.data.refreshToken});
            //     console.log(resp);
            // }).catch(error => {
            //     console.log(error);
            // });
        },
        async getCredentialsCode({commit}, payload) {
            return await axios.post('/api/account/credentials/code', payload)
        },
        async verifyCredentialsCode({commit}, payload) {
            return await axios.post('/api/account/credentials/code/verify', payload)
        },
        async saveNotificationsSettings({commit}, payload) {
            return await axios.post('/api/account/notifications/settings', payload)
        },
        async deleteCredentialsProcess({commit}, payload) {
            return await axios.delete('/api/account/change/credentials/delete/'+payload)
        },
    },
    getters: {
        isLoggedIn: state => !!state.token,
        auth_user: state => state.auth_user,
        auth_user_loading: state => state.auth_user_loading,
    }
};
