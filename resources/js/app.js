require('./bootstrap');

window.Vue = require("vue").default;
const token = localStorage.getItem('token');
if (token) {
    axios.defaults.headers.common['Authorization'] = "Bearer " + token;
}
axios.interceptors.response.use((response) => {
        return response
    },
    async function (error) {
        const originalRequest = error.config;
        if (error.response && error.config && error.config.url !== '/api/refreshtoken') {
            console.log('interceptors have error.response')
            if (error.response.status === 401 && !originalRequest._retry && !error.response.config.__isRetryRequest) {
                console.log('interceptors have error.response.status === 401');
                store.commit('clearStorage');
                // if (localStorage.getItem('token')) {
                //     console.log('interceptors have token in localStorage');
                //     originalRequest._retry = true;
                //     await store.dispatch('refresh')
                //         .then(() => {
                //             const access_token = localStorage.getItem('token');
                //             if (access_token) {
                //                 axios.defaults.headers.common['Authorization'] = 'Bearer ' + access_token;
                //                 // originalRequest.headers['Authorization'] = 'Bearer ' + access_token;
                //                 console.log('access_token', access_token);
                //                 console.log('interceptors refresh token is successful');
                //                 console.log('originalRequest', originalRequest);
                //                 return axios(originalRequest);
                //             } else {
                //                 console.log('interceptors refresh token catch error');
                //                 store.commit('clearStorage');
                //                 location.reload();
                //                 return Promise.reject(error);
                //             }
                //         })
                // }
            }
        }
        console.log('interceptors end without return by token case');
        return Promise.reject(error);
    });

import {ValidationProvider, extend, ValidationObserver, localize, localeChanged} from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';

Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);
extend('required_boolean', {
    message: field => 'Поле ' + field + '  обязательно для заполнения',
    validate(value) {
        return value == true;
    },
});
extend('phone', {
    message: field => 'Поле ' + field + ' должно быть верным номером телефона',
    validate(value) {
        if (value) {
            return /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/.test(value) && value.length >= 10 && value.length <= 19;
        }
        return false;
    },
});
import Notifications from 'vue-notification';

Vue.use(Notifications);
import VueTheMask from 'vue-the-mask'

Vue.use(VueTheMask);
import VueLazyload from 'vue-lazyload'

Vue.use(VueLazyload, {
    preLoad: 1.3,
    error: "/images/card-image.jpg",
    loading: "/images/card-image.jpg",
    attempt: 1
});
const moment = require('moment');
require('moment/locale/ru');
moment.locale('ru');
Vue.use(require('vue-moment'), {
    moment
});

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/locale/ru';
import 'vue2-datepicker/locale/en';
import 'vue2-datepicker/locale/zh-cn';
Vue.component("date-picker", DatePicker);
import vSelect from "vue-select";
Vue.component("v-select", vSelect);
import VueRouter from 'vue-router';
import routes from './routes';
Vue.use(VueRouter);
import store from './store/index.js';

Vue.component("App", require("./App.vue").default);
import Card from "./components/Card.vue";
import Icon from "./components/Icon.vue";
import Modal from "./components/Modal.vue";
import Pagination from "./components/Pagination.vue";
import Input from "./components/Input.vue";
import Textarea from "./components/Textarea.vue";
import Checkbox from "./components/Checkbox.vue";
import CardList from "./components/CardList.vue";
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
import Datepicker from "./components/Datepicker.vue";

import BktAuthModal from "./auth/AuthModal.vue";
import BktCodeModal from "./auth/CodeModal.vue";
import Main from "./pages/Main/Main.vue";
import LotCard from "./pages/LotCard.vue";

Vue.component('BktIcon', Icon);
Vue.component('BktModal', Modal);
Vue.component('BktInput', Input);
Vue.component('BktTextarea', Textarea);
Vue.component('BktCheckbox', Checkbox);
Vue.component('BktCard', Card);
Vue.component('BktAuthModal', BktAuthModal);
Vue.component('BktCodeModal', BktCodeModal);
Vue.component('BktPagination', Pagination);
Vue.component('BktCardList', CardList);
Vue.component('BktHeader', Header);
Vue.component('BktFooter', Footer);
Vue.component('BktDatepicker', Datepicker);

//pages
Vue.component('MainPage', Main);
Vue.component('LotCardPage', LotCard);

Vue.filter('priceFormat', value => {
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
});
Vue.filter('daysToDate', value => {
    const start = moment(value, "DD.MM.YYYY HH:mm");
    const end = moment();
    return start.diff(end, "days");
});

const app = new Vue({
    el: "#app",
    router: new VueRouter(routes),
    store
});

if (!localStorage.getItem('locale')) {
    localStorage.setItem('locale', 'ru');
}
axios.defaults.headers.common['Content-Language'] = localStorage.getItem('locale');
app.$moment.locale(localStorage.getItem('locale'));
import('vee-validate/dist/locale/' + localStorage.getItem('locale') + '.json')
    .then(locale => {
        localize(localStorage.getItem('locale'), locale);
    });
DatePicker.locale(localStorage.getItem('locale'));
localeChanged();
