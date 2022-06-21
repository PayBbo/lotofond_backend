import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
import shared from './shared';
import trades from './trades';
import auth from './auth';

export default new Vuex.Store({
    namespaced: false,
    modules: {
         shared, auth, trades
    }
})

