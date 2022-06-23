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
