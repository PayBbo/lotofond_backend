import Vue from 'vue'
import store from './store/index'
import VueRouter from 'vue-router'
import NProgress from 'nprogress';
NProgress.configure({showSpinner: false, speed: 1000});
Vue.use(VueRouter);
const progressShowDelay = 100;
let routeResolved = false;
let router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'Main',
            component: () => import(/* webpackChunkName: "main" */ "./pages/Main.vue"),
        },
        {
            path: '/registries',
            name: 'Registries',
            component: () => import(/* webpackChunkName: "registries" */ "./pages/Registries.vue"),
        },
        {
            path: '/registries/:type/:id',
            name: 'RegistryCard',
            component: () => import(/* webpackChunkName: "registry" */ "./pages/RegistryCard.vue"),
        },
        {
            path: '/profile',
            beforeEnter: guardMyRoute,
            name: 'Profile',
            component: () => import(/* webpackChunkName: "profile" */ "./pages/Profile.vue"),
            meta: {
                auth: true
            },
        },
        {
            path: '/agent',
            name: 'Agent',
            component: () => import(/* webpackChunkName: "agent" */ "./pages/Agent.vue"),
        },
        {
            path: '/contacts',
            name: 'Contacts',
            component: () => import(/* webpackChunkName: "contacts" */ "./pages/Contacts.vue"),
        },
        {
            path: '/without-ecp',
            name: 'WithoutEcp',
            component: () => import(/* webpackChunkName: "without-ecp" */ "./pages/WithoutEcp.vue"),
        },
        {
            path: '/favourites',
            beforeEnter: guardMyRoute,
            name: 'Favourites',
            component: () => import(/* webpackChunkName: "favourites" */ "./pages/Favourites.vue"),
            meta: {
                auth: true
            },
        },
        {
            path: '/monitoring',
            beforeEnter: guardMyRoute,
            name: 'Monitoring',
            component: () => import(/* webpackChunkName: "monitoring" */ "./pages/Monitoring.vue"),
            meta: {
                auth: true
            },
        },
        {
            path: '/messages',
            beforeEnter: guardMyRoute,
            name: 'Messages',
            component: () => import(/* webpackChunkName: "messages" */ "./pages/Messages.vue"),
            meta: {
                auth: true
            },
        },
        {
            path: '/tariffs',
            name: 'Tariffs',
            component: () => import(/* webpackChunkName: "tariffs" */ "./pages/Tariffs.vue"),
        },
        {
            path: '/auctions',
            name: 'Auctions',
            component: () => import(/* webpackChunkName: "auctions" */ "./pages/UpcomingAuctions.vue"),
        },
        {
            path: '/calendar',
            beforeEnter: guardMyRoute,
            name: 'Calendar',
            component: () => import(/* webpackChunkName: "calendar" */ "./pages/Calendar.vue"),
            meta: {
                auth: true
            },
        },
        {
            path: '/lot/:id',
            name: 'LotCard',
            component: () => import(/* webpackChunkName: "lot-card" */ "./pages/LotCard.vue"),
        },
        {
            path: '/week-winners',
            name: 'WeekWinners',
            component: () => import(/* webpackChunkName: "week-winners" */ "./pages/WeekWinners.vue"),
        },
        {
            path: '/admin/dashboard',
            name: 'Dashboard',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "dashboard" */ "./admin/Dashboard.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin'
            }
        },
        {
            path: '/admin/users',
            name: 'Users',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "users" */ "./admin/users/Users.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin'
            }
        },
        {
            path: '/admin/text-data',
            name: 'TextData',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "text-data" */ "./admin/textData/TextData.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin'
            }
        },
        {
            path: '/admin/text-data/:id',
            name: 'TextDataEdit',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "text-data-edit" */ "./admin/textData/TextDataEdit.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin'
            }
        },
        {
            path: '/admin/text-data/add',
            name: 'TextDataAdd',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "text-data-edit" */ "./admin/textData/TextDataEdit.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin'
            }
        },
        {
            path: '/admin/contacts',
            name: 'Contacts',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "text-data-edit" */ "./admin/Contacts.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin'
            }
        },
        {
            path: '/admin/applications',
            name: 'Applications',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "text-data-edit" */ "./admin/Applications.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin'
            }
        },
        // { path: '/:pathMatch(.*)*', component: EmptyView }
    ],
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return {x: 0, y: 0}
        }
    }
});

function guardMyRoute(to, from, next) {
    if (to.matched.some(record => record.meta.auth)) {
        if (store.getters.isLoggedIn === false) {
            next('/');
            return;
        }
    }
    next()
}

function guardAdminRoute(to, from, next) {
    if (store.getters.isLoggedIn === false) {
        next('/');
        return;
    }
    axios.get('/api/admin/check').then(response => {
        if (response.data.status !== true) {
            next('/');

        }
    })
    next();
}

router.beforeEach((to, from, next) => {
    routeResolved = false;
    setTimeout(() => {
        if (!routeResolved) {
            NProgress.start();
        }
    }, progressShowDelay);
    next();
});
router.afterEach(() => {
    routeResolved = true;
    NProgress.done();
});
export default router

