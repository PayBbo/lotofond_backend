export default {
    state: {
        filters: {
            categories: JSON.parse(localStorage.getItem('filters_categories')) || [],
            regions: JSON.parse(localStorage.getItem('filters_regions')) || [],
            prices: JSON.parse(localStorage.getItem('filters_prices')) || {
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
            dates: JSON.parse(localStorage.getItem('filters_dates')) || {
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
            extraOptions: JSON.parse(localStorage.getItem('filters_extraOptions')) || {
                debtorCategories: [
                ],
                debtors: [
                ],
                organizers: [
                ],
                arbitrationManagers: [
                ],
                other: {
                    period: 'periodAll',
                    hasPhotos: false,
                    isStopped: false,
                    isCompleted: false,
                    isHidden: false,
                    organizer: false
                },
            },
            mainParams: JSON.parse(localStorage.getItem('filters_mainParams')) ||  {
                excludedWords: null,
                includedWords:'',
                tradePlaces: [],
                tradeType:'',
            },
            // other: {
            //     period: 'all',
            //     hasPhotos: false,
            //     isStopped: false,
            //     isCompleted: false,
            //     isHidden: false
            // },
            sort: {
                direction: "asc",
                type: "publishDate"
            }
        },
        nearest_filters: {
            categories: JSON.parse(localStorage.getItem('nearest_categories')) || [],
            regions: JSON.parse(localStorage.getItem('nearest_regions')) || [],
            prices: JSON.parse(localStorage.getItem('nearest_prices')) || {
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
            dates: JSON.parse(localStorage.getItem('nearest_dates')) || {
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
            extraOptions: JSON.parse(localStorage.getItem('nearest_extraOptions')) || {
                debtorCategories: [
                ],
                debtors: [
                ],
                organizers: [
                ],
                arbitrManagers: [
                ],
                other: {
                    period: 'periodAll',
                    hasPhotos: false,
                    isStopped: false,
                    isCompleted: false,
                    isHidden: false,
                    organizer: false
                },
            },
            mainParams: {
                excludedWords: '',
                includedWords:'',
                tradePlaces: [],
                tradeType:'',
            },
            sort: {
                direction: "desc",
                type: "applicationEnd"
            }
        },
        messages_filters: {
            searchString:'',
            debtor: '',
            types: [],
            regions: [],
            publishDate: {
                start: '',
                end: ''
            },
            messageHasFiles: false,
            sort: {
                direction: "asc",
                type: ""
            },
            perPage: 20,
            page:1
        }
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
        filters_other(state) {
            return state.filters.extraOptions.other;
        },
        filters_sort(state) {
            return state.filters.sort;
        },
        nearest_filters(state) {
            return state.nearest_filters;
        },
        messages_filters(state) {
            return state.messages_filters;
        },
    },

    actions: {
    },

    mutations: {
        setFilters(state, payload) {
            return (state.filters = payload);
        },
        saveFiltersProperty(state, payload) {
            // Vue.set(state.filters, payload.key, payload.value);
            localStorage.setItem(payload.key, JSON.stringify(payload.value));
        },
        saveFilterProperty(state, payload) {
            Vue.set(state.filters[payload.filter], payload.key, payload.value);
            localStorage.setItem(payload.filter, JSON.stringify(state.filters[payload.filter]));
        }
    }
};
