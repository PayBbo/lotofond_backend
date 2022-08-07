require('./bootstrap');

window.Vue = require("vue").default;
const token = localStorage.getItem('token');
if (token) {
    axios.defaults.headers.common['Authorization'] = "Bearer " + token;
}
axios.interceptors.response.use(
    (response) => {
        return response
    },
    async function (error) {
        const originalRequest = error.config;
        if (error.response && error.config && error.config.url !== '/api/account/refresh/token') {
            console.log('interceptors have error.response');
            if(error.response.data)
            {
                // if(error.response.data.code == 401)
                // {
                //     app.$notify({
                //         type: 'error',
                //         title:'LotoFond',
                //         text: 'Необходима авторизация',
                //         duration: 5000
                //     });
                // }
                // else {
                    if(error.response.data.code != 401 && error.response.data.detail)
                    {
                        app.$notify({
                            type: 'error',
                            title:'LotoFond',
                            text: error.response.data.detail,
                            duration: 5000
                        });
                    }
                // }

            }

            if (error.response.status === 401 && !originalRequest._retry && !error.response.config.__isRetryRequest) {
                console.log('interceptors have error.response.status === 403');
                store.commit('clearStorage');
                if (localStorage.getItem('token')) {
                    console.log('interceptors have token in localStorage');
                    originalRequest._retry = true;
                    await store.dispatch('refresh')
                        .then(() => {
                            const access_token = localStorage.getItem('token');
                            if (access_token) {
                                axios.defaults.headers.common['Authorization'] = 'Bearer ' + access_token;
                                // originalRequest.headers['Authorization'] = 'Bearer ' + access_token;
                                console.log('access_token', access_token);
                                console.log('interceptors refresh token is successful');
                                console.log('originalRequest', originalRequest);
                                return axios(originalRequest);
                            } else {
                                console.log('interceptors refresh token catch error');
                                store.commit('clearStorage');
                                store.commit('logout');
                                return Promise.reject(error);
                            }
                        })
                }
            }
        }
        console.log('interceptors end without return by token case');
        return Promise.reject(error);
    }
);

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
    error: "/images/card-image1.png",
    loading: "/images/card-image1.png",
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

require('lang.js');
import VueLang from '@eli5/vue-lang-js'
// get the data source
import translations from './vue-translations.json';

Vue.use(VueLang, {
    messages: translations, // Provide locale file
    locale: 'ru', // Set locale
    fallback: 'ru' // Set fallback locale
});
import {
    Hooper,
    Slide,
    Navigation as HooperNavigation
} from 'hooper';
import 'hooper/dist/hooper.css';


import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
Vue.component('slick',  VueSlickCarousel);

import Fuse from 'fuse.js'
Vue.prototype.$search = function (term, list, options) {
    return new Promise(function (resolve, reject) {
        var run = new Fuse(list, options);
        var results = run.search(term);
        let arr = [];
        results.forEach(item => {
            arr.push(item.item)
        });
        resolve(arr)
    })
};

import InfiniteLoading from 'vue-infinite-loading';
Vue.component('infinite-loading', InfiniteLoading);

import router from './routes';
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
import Dropdown from "./components/Dropdown.vue";
import WinCard from "./components/WinCard";
import Search from "./components/Search";
import Select from "./components/Select";
import Collapse from "./components/Collapse";

import BktAuthModal from "./auth/AuthModal.vue";
import BktCodeModal from "./auth/CodeModal.vue";

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
Vue.component('BktDropdown', Dropdown);
Vue.component('BktWinCard', WinCard);
Vue.component('BktSearch', Search);
Vue.component('BktSelect', Select);
Vue.component('BktCollapse', Collapse);


Vue.filter('priceFormat', value => {
    if(value) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }
    return '0';
});
Vue.filter('daysToDate', value => {
    const start = moment(value);
    const end = moment();
    return start.diff(end, "days");
});

const app = new Vue({
    el: "#app",
    router,
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
