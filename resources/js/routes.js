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
            beforeEnter: guardMyRoute,
            component: () => import(/* webpackChunkName: "registries" */ "./pages/Registries.vue"),
            meta: {
                auth: true,
                permission:'hasAccessToReestr'
            },
        },
        {
            path: '/registries/:type/:id',
            name: 'RegistryCard',
            beforeEnter: guardMyRoute,
            component: () => import(/* webpackChunkName: "registry" */ "./pages/RegistryCard.vue"),
            meta: {
                auth: true,
                permission:'hasAccessToReestr'
            },
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
                auth: true,
                permission:'hasAccessToFavourite'
            },
        },
        {
            path: '/monitoring',
            beforeEnter: guardMyRoute,
            name: 'Monitoring',
            component: () => import(/* webpackChunkName: "monitoring" */ "./pages/Monitoring.vue"),
            meta: {
                auth: true,
                permission:'hasAccessToMonitoring'
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
            path: '/privacy-policy',
            name: 'PrivacyPolicy',
            component: () => import(/* webpackChunkName: "privacy-policy" */ "./pages/PrivacyPolicy.vue"),
        },
        {
            path: '/terms',
            name: 'Terms',
            component: () => import(/* webpackChunkName: "terms" */ "./pages/Terms.vue"),
        },
        {
            path: '/pay-answer/:id?',
            name: 'PayAnswer',
            component: () => import(/* webpackChunkName: "pay-answer" */ "./pages/PayAnswer.vue"),
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
                layout: 'Admin',
                permission: 'user-list'
            }
        },
        {
            path: '/admin/users/add',
            name: 'Users',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "users-add" */ "./admin/users/AddUser.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
                permission: 'user-add'
            }
        },
        {
            path: '/admin/users/:id',
            name: 'Users',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "users-edit" */ "./admin/users/AddUser.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
                permission: 'user-edit'
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
                layout: 'Admin',
                permission: 'text-data-list'
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
                layout: 'Admin',
                permission: 'text-data-edit'
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
                layout: 'Admin',
                permission: 'text-data-add'
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
                layout: 'Admin',
                permission: 'emails-list'
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
                layout: 'Admin',
                permission: 'application-list'
            }
        },
        {
            path: '/admin/lots',
            name: 'Lots',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "lots" */ "./admin/lots/Lots.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
                permission: 'lot-list'
            }
        },
        {
            path: '/admin/lots/:id',
            name: 'ShowLot',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "text-data-edit" */ "./admin/lots/ShowLot.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
                permission: 'lot-list'
            }
        },
        {
            path: '/admin/roles',
            name: 'Roles',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "roles" */ "./admin/roles/Roles.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
                permission: 'role-list'
            }
        },
        {
            path: '/admin/roles/:id',
            name: 'Permissions',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "permissions" */ "./admin/roles/Permissions.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
                permission: 'role-edit'
            }
        },
        {
            path: '/admin/content-rules',
            name: 'ContentRules',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "roles" */ "./admin/ContentRules.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
                permission: 'content-rules-list'
            }
        },
        {
            path: '/admin/egrn-statements',
            name: 'EgrnStatements',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "roles" */ "./admin/Statements.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
                permission: 'egrn-statements-list'
            }
        },
        {
            path: '/admin/holiday-days',
            name: 'HolidaysDates',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "roles" */ "./admin/HolidaysDates.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
                permission: 'holidays-list'
            }
        },
        {
            path: '/admin/tariffs',
            name: 'Tariffs',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "tariffs" */ "./admin/tariffs/Tariffs.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
                permission: 'tariff-list'
            }
        },
        {
            path: '/admin/tariffs/add',
            name: 'AddTariff',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "tariffs-add" */ "./admin/tariffs/AddEditTariff.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
                permission: 'tariff-add'
            }
        },
        {
            path: '/admin/tariffs/:id',
            name: 'EditTariff',
            beforeEnter: guardAdminRoute,
            component: () =>
                import(
                    /* webpackChunkName: "tariffs-edit" */ "./admin/tariffs/AddEditTariff.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
                permission: 'tariff-edit'
            }
        },
        {
            path: "/admin/404",

            component: () =>
                import(
                    /* webpackChunkName: "error-404" */ "./admin/Error404.vue"
                    ),
            meta: {
                auth: true,
                layout: 'Admin',
            }
        },
        { path: '/admin/*', beforeEnter: (to, from, next) => { next('/admin/404') } },
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
    if (to.matched.some(record => record.meta.auth) && store.getters.isLoggedIn === false) {
        next({ name: 'Main' });
        if(from.name !== 'Main') {
            next({ name: 'Main' });
        }
    }
    else if (store.getters.isLoggedIn===true && to.matched.some(record => record.meta.permission)
        && store.getters.system_rules[to.meta.permission] === false)
    {
        if(from.name !== 'Main') {
            next({ name: 'Main' });
        }
        store.dispatch('sendNotification', {message: 'У Вас не активирован тариф', type: 'error'})
        setTimeout(() => {
            NProgress.done();
        }, progressShowDelay);
        return false;
    }
    else {
        next()
    }
}

function guardAdminRoute(to, from, next) {
    if (store.getters.isLoggedIn === false) {
        next('/');
        return;
    }
    if(store.getters.isAdmin === null){
        axios.get('/api/admin/check').then(response => {
              if (response.data.status !== true) {
                  next('/');
              }
              if(to.meta.permission !== undefined){
                  if( response.data.permissions.indexOf(to.meta.permission) === -1){
                      next('/admin/dashboard');
                  }
              }
            store.commit('setAdminData', response.data)
        })
    }else{
        if(!store.getters.isAdmin){
            next('/');
        }
        if(to.meta.permission !== undefined){
            if( store.getters.permissions.indexOf(to.meta.permission) === -1){
                next('/admin/dashboard');
            }
        }
    }

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
    return false;
});
router.afterEach((to, from) => {
    routeResolved = true;
    NProgress.done();
});
export default router

