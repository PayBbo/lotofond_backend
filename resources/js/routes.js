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
			path: '/lot/:id',
            name:'LotCard',
            component: () =>
                import(
                    /* webpackChunkName: "lot-card" */ "./pages/LotCard.vue"
                    ),
		},
		// { path: '/:pathMatch(.*)*', component: EmptyView }
	]
};
