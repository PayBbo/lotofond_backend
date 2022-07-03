import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
import shared from './shared';
import trades from './trades';
import auth from './auth';
import filters from './filters';
import debtors from './debtors';
import organizers from './organizers';
import arbitrManagers from './arbitrManagers';
import tradePlaces from './tradePlaces';
import categories from './categories';
import marks from './marks';
import files from './files';

export default new Vuex.Store({
    namespaced: false,
    modules: {
         shared, auth, trades, filters, debtors, organizers, arbitrManagers, tradePlaces, categories, marks, files
    }
})

