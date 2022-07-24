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
import regions from './regions';
import marks from './marks';
// import files from './files';
import lots from "./lots";
import favourites from "./favourites";
import monitoring from "./monitoring";
import events from './events';


export default new Vuex.Store({
    namespaced: false,
    modules: {
        shared, auth, trades, filters, debtors, organizers, arbitrManagers,
        tradePlaces, categories, regions, marks, lots, favourites, monitoring, events
    }
})

