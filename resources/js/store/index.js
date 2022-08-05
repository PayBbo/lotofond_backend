import Vue from 'vue'
import Vuex from 'vuex'
import shared from './shared';
import trades from './trades';
import auth from './auth';
import filters from './filters';
import marks from './marks';
// import files from './files';
import lots from "./lots";
import favourites from "./favourites";
import monitoring from "./monitoring";
import bidders from "./bidders";
import filtersData from "./filtersData";

import admin from './admin/dashboard';
import adminData from './admin/adminData';

import events from './events';

Vue.use(Vuex)

export default new Vuex.Store({
    namespaced: false,
    modules: {
        shared, auth, trades, filters,
        marks, lots, favourites, monitoring,
        bidders, filtersData,
        events, admin, adminData
    }
})

