import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
import shared from './shared';

export default new Vuex.Store({
    namespaced: false,
    modules: {
         shared,
        // trades
    }
})

