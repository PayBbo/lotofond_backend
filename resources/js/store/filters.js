export default {
    state: {
        filters: {
            categories: JSON.parse(localStorage.getItem('categories')) || [],
            regions: JSON.parse(localStorage.getItem('regions')) || [],
            prices: JSON.parse(localStorage.getItem('prices')) || {
                currentPrice: {
                    min: '',
                    max: ''
                },
                startPrice: {
                    min: '',
                    max: ''
                },
                minPrice: {
                    min: '',
                    max: ''
                },
                percentageReduction: {
                    min: '',
                    max: ''
                }
            },
            dates: JSON.parse(localStorage.getItem('dates')) || {
                eventTimeStart: {
                    start: "",
                    end: ""
                },
                eventTimeEnd: {
                    start: "",
                    end: ""
                },
                applicationTimeStart: {
                    start: "",
                    end: ""
                },
                applicationTimeEnd: {
                    start: "",
                    end: ""
                }
            },
            extraOptions: JSON.parse(localStorage.getItem('extraOptions')) || {
                debtorCategories: [
                ],
                debtors: [
                ],
                organizers: [
                ],
                arbitrManagers: [
                ]
            },
            mainParams: {
                exceptionWords: '',
                tradePlaces: [],
                tradeNumber:'',
                tradeType:'',
                period:'all',
                isWithPhotos: false,
                isStopped: false,
                isCompleted: false,
                isDeleted: false,
            }
        },
    },

    getters: {
        filters(state) {
            return state.filters;
        },
        filters_categories(state) {
            return state.filters.categories;
        },
        filters_regions(state) {
            return state.filters.regions;
        },
        filters_prices(state) {
            return state.filters.prices;
        },
        filters_dates(state) {
            return state.filters.dates;
        },
        filters_extra_options(state) {
            return state.filters.extraOptions;
        },
        filters_params(state) {
            return state.filters.mainParams;
        },
    },

    actions: {
    },

    mutations: {
        setFilters(state, payload) {
            return (state.filters = payload);
        },
        saveFiltersProperty(state, payload) {
            Vue.set(state.filters, payload.key, payload.value);
            localStorage.setItem(payload.key, JSON.stringify(payload.value));
        },
        saveFilterProperty(state, payload) {
            Vue.set(state[payload.filter], payload.key, payload.value);
            localStorage.setItem(payload.filter, state[payload.filter]);
        }
    }
};
