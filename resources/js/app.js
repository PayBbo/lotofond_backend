require('./bootstrap');
import 'bootstrap'
// import '@popperjs/core'
// import 'bootstrap/dist/css/bootstrap.min.css'
window.Vue = require("vue").default;
const token = localStorage.getItem('token');
if (token) {
    axios.defaults.headers.common['Authorization'] = "Bearer "+token;
}
import {ValidationProvider, extend, ValidationObserver, localize, localeChanged} from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import ru from 'vee-validate/dist/locale/ru.json';
Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});
localize('ru', ru);
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);
extend('required_boolean', {
    message: field => 'Поле '+field+'  обязательно для заполнения',
    validate(value) {
        return value==true;
    },
});
extend('phone', {
    message: field => 'Поле '+field+' должно быть верным номером телефона',
    validate(value) {
        if (value) {
            return  /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/.test(value) && value.length>=10 && value.length<= 19;
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

// function loadLocale(code) {
//     return import(`vee-validate/dist/locale/${code}.json`).then(locale => {
//         localize(code, locale);
//     });
// }
if (localStorage.getItem('locale')) {
    axios.defaults.headers.common['Content-Language'] = localStorage.getItem('locale');
    // app.$lang.setLocale(localStorage.getItem('locale'));
    app.$moment.locale(localStorage.getItem('locale'));
    // loadLocale(localStorage.getItem('locale'));
    localize(localStorage.getItem('locale'));
    localeChanged();
} else {
    axios.defaults.headers.common['Content-Language'] = 'ru';
    localStorage.setItem('locale', 'ru');
    // app.$lang.setLocale('fr');
    app.$moment.locale('ru');
    localize('ru');
    // loadLocale('ru');
    localeChanged();
}

