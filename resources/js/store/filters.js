const initialState = {
    filters: {
        categories: [],
        regions: [],
        prices: {
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
        dates: {
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
        extraOptions: {
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
                isHidden: false
                // hasAnswer: false
            }
        },
        mainParams: {
            excludedWords: null,
            includedWords:'',
            tradePlaces: [],
            tradeTypes:[]
        },
        sort: {
            direction: "desc",
            type: "publishDate"
        },
        searchString: ''
    },
    nearest_filters: {
        categories: [],
        regions: [],
        prices: {
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
        dates: {
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
        extraOptions: {
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
                isHidden: false
                // hasAnswer: false
            }
        },
        mainParams: {
            excludedWords: '',
            includedWords:'',
            tradePlaces: [],
            tradeTypes:[]
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
            direction: "desc",
            type: ""
        },
        perPage: 20,
        page:1
    },
    bot_filters: {
        categories: [],
        regions: [],
        prices: {
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
        mainParams: {
            tradeTypes:[]
        },
    },
}
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
                    isHidden: false
                    // hasAnswer: false
                }
            },
            mainParams: JSON.parse(localStorage.getItem('filters_mainParams')) ||  {
                excludedWords: null,
                includedWords:'',
                tradePlaces: [],
                tradeTypes:[]
            },
            // other: {
            //     period: 'all',
            //     hasPhotos: false,
            //     isStopped: false,
            //     isCompleted: false,
            //     isHidden: false
            // },
            sort: {
                direction: "desc",
                type: "publishDate"
            },
            searchString: JSON.parse(localStorage.getItem('filters_searchString')) ||''
        },
        nearest_filters: {
            categories: JSON.parse(localStorage.getItem('nearest_filters_categories')) || [],
            regions: JSON.parse(localStorage.getItem('nearest_filters_regions')) || [],
            prices: JSON.parse(localStorage.getItem('nearest_filters_prices')) || {
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
            dates: JSON.parse(localStorage.getItem('nearest_filters_dates')) || {
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
            extraOptions: JSON.parse(localStorage.getItem('nearest_filters_extraOptions')) || {
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
                    isHidden: false
                    // hasAnswer: false
                }
            },
            mainParams: JSON.parse(localStorage.getItem('nearest_filters_mainParams')) || {
                excludedWords: '',
                includedWords:'',
                tradePlaces: [],
                tradeTypes:[]
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
                direction: "desc",
                type: ""
            },
            perPage: 20,
            page:1
        },
        bot_filters: {
            categories: JSON.parse(localStorage.getItem('bot_filters_categories')) || [],
            regions: JSON.parse(localStorage.getItem('bot_filters_regions')) || [],
            prices: JSON.parse(localStorage.getItem('bot_filters_prices')) || {
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
            mainParams: JSON.parse(localStorage.getItem('bot_filters_mainParams')) ||  {
                tradeTypes:[]
            },
            sort: {
                direction: "desc",
                type: "publishDate"
            },
        },
        user_filters_exist: false
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
        bot_filters(state) {
            return state.bot_filters;
        },
        user_filters_exist(state) {
            return state.user_filters_exist;
        },
    },

    actions: {
        async saveUserFilters({commit, state}, payload) {
            await axios.post('/api/bot/save-filters', {filters: state.bot_filters})
                .then(resp => {
                    commit('setUserFilters', true)
                }).catch(error => {
                });
        },
        async getUserFilters({commit, state}) {
            await axios.post('/api/bot/get-filters')
                .then(resp => {
                    if(resp.data.filter) {
                        commit('setUserFilters', true)
                    }
                }).catch(error => {
                    commit('setUserFilters', false)
                });
        }
    },

    mutations: {
        setFilters(state, payload) {
            return (state.filters = payload);
        },
        setUserFilters(state, payload) {
            return (state.user_filters_exist = payload);
        },
        saveFiltersProperty(state, payload) {
            // Vue.set(state.filters, payload.key, payload.value);
            // if (localStorage.getItem(payload.key)) {
                localStorage.setItem(payload.key, JSON.stringify(payload.value));
            // }
        },
        saveFilterProperty(state, payload) {
            Vue.set(state.filters[payload.filter], payload.key, payload.value);
            localStorage.setItem(payload.filter, JSON.stringify(state.filters[payload.filter]));
        },
        resetFilters(state, payload) {
            localStorage.removeItem(payload+'filters_categories');
            localStorage.removeItem(payload+'filters_regions');
            localStorage.removeItem(payload+'filters_prices');
            localStorage.removeItem(payload+'filters_dates');
            localStorage.removeItem(payload+'filters_extraOptions');
            localStorage.removeItem(payload+'filters_mainParams');
            localStorage.removeItem(payload+'filters_searchString');
            return (state[payload+'filters'] = initialState[payload+'filters'])

        }
    }
};
