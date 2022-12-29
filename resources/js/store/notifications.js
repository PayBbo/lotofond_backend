export default {
    state: {
        notifications: [],
        notifications_pagination: {},
        notifications_loading: false,
        notifications_count: {
            platform: 0,
            favourite: 0,
            monitoring: 0
        },
        hasNotSeenNotifications: false
    },

    getters: {
        notifications(state) {
            return state.notifications;
        },
        notifications_pagination(state) {
            return state.notifications_pagination;
        },
        notifications_loading(state) {
            return state.notifications_loading;
        },
        notifications_count(state) {
            return state.notifications_count;
        },
        hasNotSeenNotifications(state) {
            return state.hasNotSeenNotifications;
        },
    },
    mutations: {
        setNotifications(state, payload) {
            state.notifications = [];
            payload.data.forEach(item => {
                state.notifications.push(item)
            })
            // state.notifications = payload.data;
            state.notifications_pagination = payload.pagination;
            state.notifications_count = {
                all: payload.platformNotificationsCount + payload.favouriteNotificationsCount + payload.monitoringNotificationsCount,
                platform: payload.platformNotificationsCount,
                favourite: payload.favouriteNotificationsCount,
                monitoring: payload.monitoringNotificationsCount,
            }

        },
        setNotificationsLoading(state, payload) {
            return (state.notifications_loading = payload);
        },
        setHasNotSeenNotifications(state, payload) {
            return (state.hasNotSeenNotifications = payload);
        },
        seeNotifications(state, payload) {
            payload.forEach(item => {
                let index = state.notifications.findIndex(el => el.id == item);
                if (index >= 0) {
                    if (state.notifications[index].type === 'favourite') {
                        state.notifications_count.favourite -= 1;
                    }
                    if (state.notifications[index].type === 'platform') {
                        state.notifications_count.platform -= 1;
                    }
                    if (state.notifications[index].type === 'monitoring') {
                        state.notifications_count.monitoring -= 1;
                    }
                    state.notifications_count.all -= 1;
                    Vue.set(state.notifications[index], 'isSeen', true)
                }
            })
        },
    },

    actions: {
        /*
        GET
        /notifications/{type}
        Получение данных об уведомлениях пользователя


        POST
        /notifications/seen
        отметка уведомлений прочитанными
        */
        checkNotifications({dispatch, commit}, payload) {
            return axios.get('/api/account/notifications')
                .then(resp => {
                    commit('setHasNotSeenNotifications', resp.data.hasNotSeenNotifications);
                }).catch(error => {
                    commit('setHasNotSeenNotifications', false);
                });
        },
        getNotifications({dispatch, commit}, payload) {
            commit('setNotificationsLoading', true);
            return axios.get('/api/notifications/' + payload.type, {params: payload, signal: payload.signal})
                .then(resp => {
                    commit('setNotifications', resp.data);
                    let notificationIds = resp.data.data.filter(item => item.isSeen == false).map(item => item.id);
                    if (notificationIds.length > 0) {
                        dispatch('seeNotifications', {notificationIds: notificationIds})
                        dispatch('checkNotifications')
                    }
                    commit('setNotificationsLoading', false);
                }).catch(error => {
                    commit('setNotificationsLoading', false);
                });
        },
        seeNotifications({commit}, payload) {
            return axios.post('/api/notifications/seen', payload)
                .then(resp => {
                    // commit('seeNotifications', payload.notificationIds);
                });
        },
    },

};
