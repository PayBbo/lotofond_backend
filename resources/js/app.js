require('./bootstrap');

import { createApp } from "vue";
// import Bell from "./icons/Bell.vue";
// import Target from "./icons/Target.vue";
// import Star from "./icons/Star.vue";
// import Law from "./icons/Law.vue";
// import Tree from "./icons/Tree.vue";
// import Trash from "./icons/Trash.vue";
// import Clone from "./icons/Clone.vue";
// import Date from "./icons/Date.vue";
// import Location from "./icons/Location.vue";
// import Fire from "./icons/Fire.vue";
// import Category from "./icons/Category.vue";
// import More from "./icons/More.vue";
import Card from "./components/Card.vue";
import Icon from "./Icon.vue";

const app = createApp({
    components: {
        // Bell, Target, Star, Law, Tree, Trash, Clone, Date, Location, Fire, Category, More
        Card
    }
});
app.component('BktIcon', Icon);
app.mount("#app");
