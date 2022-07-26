import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default {
    state: {
        usersCount: 0
    },
    mutations: {
        setDashboardData(state, payload){
            state.usersCount = payload.usersCount
        }

    },
    actions:{
        async getDashboardData({commit}) {
            try {
                await axios({
                    method: 'get',
                    url: '/api/admin/dashboard',
                    data: {},
                })
                    .then((response) => {
                        commit('setDashboardData', response.data)
                    });
            } catch (error) {
                console.log(error);
            }
        },
    },
    getters:{
        usersCount(state){
            return state.usersCount
        }
    }
}
