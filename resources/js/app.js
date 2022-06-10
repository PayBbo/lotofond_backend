require('./bootstrap');

import { createApp } from "vue";
import { defineRule, configure } from "vee-validate";
import {  localize, setLocale } from '@vee-validate/i18n';
import ru from '@vee-validate/i18n/dist/locale/ru.json';
import AllRules from '@vee-validate/rules';
Object.keys(AllRules).forEach(rule => {
    defineRule(rule, AllRules[rule]);
});
configure({
    validateOnInput: true,
    generateMessage: localize({
        ru,
    }),
});
setLocale("ru");
import * as yup from "yup";

import Card from "./components/Card.vue";
import Icon from "./components/Icon.vue";
import Modal from "./components/Modal.vue";
import BktAuthModal from "./auth/AuthModal.vue";
import Input from "./components/Input.vue";
import Checkbox from "./components/Checkbox.vue";
import Main from "./pages/Main/Main.vue";

const app = createApp({
    components: {
        BktAuthModal
    }
});
app.component('BktIcon', Icon);
app.component('BktModal', Modal);
app.component('BktInput', Input);
app.component('BktCheckbox', Checkbox);
app.component('BktCard', Card);
app.component('MainPage', Main);
app.mount("#app");
