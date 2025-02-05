import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default {
    state: {
        usersCount: 0,
        newUsersCount: 0,
        lotsCount: 0,
        newLotsCount: 0,
        isAdmin: null,
        watermark: {text: '', image: ''},
        trialPeriod: 0,
        botTrialPeriod: 0,
        permissions: []
    },
    mutations: {
        setDashboardData(state, payload) {
            state.usersCount = payload.usersCount
            state.newUsersCount = payload.newUsersCount
            state.lotsCount = payload.lotsCount
            state.newLotsCount = payload.newLotsCount
            state.watermark = payload.watermark
            state.trialPeriod = payload.trialPeriod
            state.botTrialPeriod = payload.botTrialPeriod
        },
        setAdminData(state, data) {
            state.isAdmin = data.status
            state.permissions = data.permissions
        },
        setPermissions(state, data) {
            state.permissions = data
        },
        setTrialPeriod(state, value) {
            state.trialPeriod = value
        },
        setBotTrialPeriod(state, value) {
            state.botTrialPeriod = value
        }

    },
    actions: {
        async getDashboardData({commit}) {
            await axios({
                method: 'get',
                url: '/api/admin/dashboard',
                data: {},
            })
                .then((response) => {
                    commit('setDashboardData', response.data)
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async updateContacts({commit, state}, data) {
            await axios({
                method: 'put',
                url: '/api/admin/contacts/update',
                data: data,
            })
                .then((response) => {
                    if (response.status === 200) {
                        commit('setModal', {data: 'success', text: 'Операция прошла успешно'})
                    }
                })
                .catch((error) => {
                    commit('setModal', {data: 'error', text: 'Произошла ошибка'})
                });
        },
        async checkAdmin({commit}) {
            await axios.get('/api/admin/check').then(response => {
                commit('setAdminData', response.data)
            })
        }
    },
    getters: {
        usersCount(state) {
            return state.usersCount
        },
        newUsersCount(state) {
            return state.newUsersCount
        },
        lotsCount(state) {
            return state.lotsCount
        },
        newLotsCount(state) {
            return state.newLotsCount
        },
        contacts(state) {
            return state.contacts
        },
        isAdmin(state) {
            return state.isAdmin
        },
        permissions(state) {
            return state.permissions
        },
        watermark(state) {
            return state.watermark
        },
        trialPeriod(state) {
            return state.trialPeriod
        },
        botTrialPeriod(state) {
            return state.botTrialPeriod
        }
    }
}
