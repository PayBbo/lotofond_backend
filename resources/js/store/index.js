import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)
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
import events from './events';


export default new Vuex.Store({
    namespaced: false,
    modules: {
        shared, auth, trades, filters,
        marks, lots, favourites, monitoring,
        bidders, filtersData, events
    }
})

