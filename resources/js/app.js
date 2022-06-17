require('./bootstrap');

window.Vue = require("vue").default;

import {ValidationProvider, extend, ValidationObserver, localize} from 'vee-validate';
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
import Notifications from 'vue-notification';
Vue.use(Notifications);
import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask);
const moment = require('moment');
require('moment/locale/ru');
moment.locale('ru');
Vue.use(require('vue-moment'), {
    moment
});

import store from './store/index.js';


import Card from "./components/Card.vue";
import Icon from "./components/Icon.vue";
import Modal from "./components/Modal.vue";
import Pagination from "./components/Pagination.vue";
import Input from "./components/Input.vue";
import Textarea from "./components/Textarea.vue";
import Checkbox from "./components/Checkbox.vue";
import CardList from "./components/CardList.vue";

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

//pages
Vue.component('MainPage', Main);
Vue.component('LotCardPage', LotCard);
const app = new Vue({
    el: "#app",
    store
});
