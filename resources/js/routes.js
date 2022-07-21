export default {
	mode: 'history',
	linkActiveClass: 'active',
	routes: [
		{
			path: '/',
            name:'Main',
            component: () =>
                import(
                    /* webpackChunkName: "main" */ "./pages/Main/Main.vue"
                    ),
		},
		{
			path: '/registries',
            name:'Registries',
            component: () =>
                import(
                    /* webpackChunkName: "registries" */ "./pages/Registries.vue"
                    ),
		},
        {
            path: '/registries/:type/:id',
            name:'Registry',
            component: () =>
                import(
                    /* webpackChunkName: "registry" */ "./pages/Registry.vue"
                    ),
        },
		{
			path: '/profile',
            name:'Profile',
            component: () =>
                import(
                    /* webpackChunkName: "profile" */ "./pages/Profile/Profile.vue"
                    ),
		},
        {
			path: '/agent',
            name:'Agent',
            component: () =>
                import(
                    /* webpackChunkName: "agent" */ "./pages/Agent.vue"
                    ),
		},
        {
			path: '/contacts',
            name:'Contacts',
            component: () =>
                import(
                    /* webpackChunkName: "contacts" */ "./pages/Contacts.vue"
                    ),
		},
        {
			path: '/without-ecp',
            name:'WithoutEcp',
            component: () =>
                import(
                    /* webpackChunkName: "without-ecp" */ "./pages/WithoutEcp.vue"
                    ),
		},
        {
			path: '/favourites',
            name:'Favourites',
            component: () =>
                import(
                    /* webpackChunkName: "favourites" */ "./pages/Favourites.vue"
                    ),
		},
        {
			path: '/monitoring',
            name:'Monitoring',
            component: () =>
                import(
                    /* webpackChunkName: "monitoring" */ "./pages/Monitoring.vue"
                    ),
		},
        {
			path: '/messages',
            name:'Messages',
            component: () =>
                import(
                    /* webpackChunkName: "monitoring" */ "./pages/Messages.vue"
                    ),
		},
        {
			path: '/tariffs',
            name:'Tariffs',
            component: () =>
                import(
                    /* webpackChunkName: "tariffs" */ "./pages/Tariffs.vue"
                    ),
		},
        {
			path: '/auctions',
            name:'Auctions',
            component: () =>
                import(
                    /* webpackChunkName: "auctions" */ "./pages/UpcomingAuctions.vue"
                    ),
		},
        {
			path: '/calendar',
            name:'Calendar',
            component: () =>
                import(
                    /* webpackChunkName: "auctions" */ "./pages/Calendar.vue"
                    ),
		},
        {
			path: '/lot/:id',
            name:'LotCard',
            component: () =>
                import(
                    /* webpackChunkName: "lot-card" */ "./pages/LotCard.vue"
                    ),
		},
        {
			path: '/week-winners',
            name:'WeekWinners',
            component: () =>
                import(
                    /* webpackChunkName: "week-winners" */ "./pages/WeekWinners.vue"
                    ),
		},
		// { path: '/:pathMatch(.*)*', component: EmptyView }
	],
    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    }
};
