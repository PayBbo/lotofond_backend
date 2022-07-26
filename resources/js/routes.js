import store from './store/index'

export default {
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
            component: () => import(/* webpackChunkName: "profile" */ "./pages/Profile/Profile.vue"),
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
            component: () => import(/* webpackChunkName: "monitoring" */ "./pages/Messages.vue"),
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
            component: () => import(/* webpackChunkName: "auctions" */ "./pages/Calendar.vue"),
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
        // { path: '/:pathMatch(.*)*', component: EmptyView }
    ],
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return {x: 0, y: 0}
        }
    }
};

function guardMyRoute(to, from, next) {
    if (to.matched.some(record => record.meta.auth)) {
        if (store.getters.isLoggedIn === false) {
            next('/');
            return;
        }
    }
    next()
}
