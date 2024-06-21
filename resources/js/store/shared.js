import { localize, localeChanged } from "vee-validate";
import DatePicker from "vue2-datepicker";
export default {
    state: {
        user: {
            name:'',
            surname:'',
            // email:'',
            // phone:'',
            code:'',
            password:'',
            confirm_password:'',
            grantType:'email',
            region:''
        },
        locale: localStorage.getItem('locale') || 'ru',
        selected_item: null,
        main_contacts: {
            phone:'',
            email:'',
            loading:false
        },
        help:[],
        about: [],
        info: [],
        informationMessage: null,
        informationMessageMode: localStorage.getItem('shortNewsItemMode') || 'show',
        buyBlock: [],
        buyLotBlock: [],
        controllers: [],
        signals: [],
        tariffs:[],
        isMobile: /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(navigator.userAgent || navigator.vendor || window.opera)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test((navigator.userAgent || navigator.vendor || window.opera).substr(0, 4))
        || false,
        services: [],
    },

    getters: {
        user(state) {
            return state.user;
        },
        locale(state) {
            return state.locale;
        },
        main_contacts(state) {
            return state.main_contacts;
        },
        help(state) {
            return state.help;
        },
        about(state) {
            return state.about;
        },
        info(state) {
            return state.info;
        },
        informationMessage(state) {
            return state.informationMessage;
        },
        informationMessageMode(state) {
            return state.informationMessageMode;
        },
        buyBlock(state) {
            return state.buyBlock;
        },
        buyLotBlock(state) {
            return state.buyLotBlock;
        },
        controllers(state) {
            return state.controllers;
        },
        signals(state) {
            return state.signals;
        },
        tariffs(state) {
            return state.tariffs;
        },
        services(state) {
            return state.services;
        },
        isMobile(state) {
            return state.isMobile;
        },
    },

    actions: {
        sendNotification({commit}, payload) {
            if (!payload.type){ payload.type='success';}
            if (!payload.message){ payload.message='Ошибка';}
            if (!payload.title){ payload.title='LotoFond';}
           this._vm.$notify({
                // group: 'message',
                type: payload.type,
                title: payload.title,
                text: payload.message,
                duration: payload.duration|5000
            });
        },
        sendAuthNotification({commit}, payload) {
            this._vm.$notify({
                type: 'error',
                title: 'LotoFond',
                text: 'Необходима авторизация',
                duration: 5000
            });
        },
        saveDataProperty({commit, rootState}, payload) {
            let schema = rootState[payload.module_key];
            if(payload.state_key) {
                schema = rootState[payload.module_key][payload.state_key]
            }
            if(schema) {
                let pList = payload.key.split('.');
                let len = pList.length;
                for (let i = 0; i < len - 1; i++) {
                    let elem = pList[i];
                    if (!schema[elem]) schema[elem] = {};
                    schema = schema[elem];
                }
                // schema[pList[len-1]] = payload.value;
                // if (pList[len - 1]) {
                    Vue.set(schema, pList[len - 1], payload.value);
                // }
            }
        },
        checkDataProperty({commit, rootState}, payload) {
            let schema = rootState[payload.module_key];
            if(payload.state_key) {
                schema = rootState[payload.module_key][payload.state_key]
            }
            if(schema) {
                let pList = payload.key.split('.');
                let len = pList.length;
                for (let i = 0; i < len - 1; i++) {
                    let elem = pList[i];
                    if (!schema[elem]) schema[elem] = {};
                    schema = schema[elem];
                }
                // schema[pList[len-1]] = payload.value;
                // if (pList[len - 1]) {
                // }
                return !!schema[pList[len - 1]]
            }
            return false;
        },
        getDataProperty({commit, rootState}, payload) {
            let schema = rootState[payload.module_key];
            if(payload.state_key) {
                schema = rootState[payload.module_key][payload.state_key]
            }
            if(schema) {
                let pList = payload.key.split('.');
                let len = pList.length;
                for (let i = 0; i < len - 1; i++) {
                    let elem = pList[i];
                    if (!schema[elem]) schema[elem] = {};
                    schema = schema[elem];
                }
                // schema[pList[len-1]] = payload.value;
                // if (pList[len - 1]) {
                // }
                return schema[pList[len - 1]]
            }
            return null;
        },
        getContacts({commit}, payload) {
            let contacts = {
                phone:'',
                email:'',
                loading: true
            }
            commit('setContacts', contacts);
            axios.get('/api/text-data/contacts')
                .then( resp => {
                    let index = resp.data.findIndex( item => item.header=='Почта')
                    if ( index >= 0) {
                        contacts.email = resp.data[index].value;
                    }
                    index = resp.data.findIndex( item => item.header=='Телефон')
                    if ( index >= 0) {
                        contacts.phone = resp.data[index].value;
                    }
                    contacts.loading = false;
                    commit('setContacts', contacts)
            }).catch(error => {
                contacts.loading = false;
                commit('setContacts', contacts)
            });
        },
        getInfo({commit}, payload) {
            axios.get('/api/text-data/info')
                .then( resp => {
                    commit('setInfo', resp.data)
            });
        },
        getHelp({commit}, payload) {
            axios.get('/api/text-data/help')
                .then( resp => {
                    commit('setHelp', resp.data)
            });
        },
        getAbout({commit}, payload) {
            axios.get('/api/text-data/about')
                .then( resp => {
                    commit('setAbout', resp.data)
            });
        },
        getRules({commit}) {
            axios.get('/api/text-data/content-rules')
                .then( resp => {
                    commit('setRules', resp.data)
            });
        },
        getBuyBlock({commit}) {
            axios.get('/api/text-data/buyBlock')
                .then(resp => {
                    commit('setBuyBlock', resp.data)
            });
        },
        getBuyLotBlock({commit}) {
            axios.get('/api/text-data/buyLotBlock')
                .then(resp => {
                    commit('setBuyLotBlock', resp.data)
            });
        },
        async getInformationMessage({commit}) {
            await axios.get('/api/information-message')
                .then( resp => {
                    if (!localStorage.getItem('shortNewsItemMode'))
                    {
                        localStorage.setItem('shortNewsItemMode', 'show')
                    }
                    if(resp.data.shortNewsItem)
                    {
                        const old_id = localStorage.getItem('shortNewsItemId');
                        if(old_id && old_id != resp.data.shortNewsItem.id)
                        {
                            localStorage.setItem('shortNewsItemMode', 'show')
                        }
                        localStorage.setItem('shortNewsItemId', resp.data.shortNewsItem.id)
                    }

                    commit('setInformationMessage', resp.data.shortNewsItem)
                });
        },
        setAborts({commit, state}, payload) {
            state.controllers[payload.method] = payload.controller;
            state.signals[payload.method] = payload.signal;
        },
        checkAbort({commit, state}, payload) {
            if (state.signals[payload]) {
                state.controllers[payload].abort();
            }
        },
        getTariffs({commit}) {
            axios.get('/api/tariffs')
                .then( resp => {
                    commit('setTariffs', resp.data)
                });
        },
        getServices({commit}) {
            axios.post('/api/services', null)
                .then( resp => {
                    if(resp.data && Array.isArray(resp.data))
                    {
                        commit('setServices', resp.data)
                    }
                    else {
                        commit('setServices', [
                            {
                                id: 5,
                                header: "Покупка без ЭЦП - инструкция",
                                description: "Инструкция для проведения торгов",
                                detailedDescription: [],
                                price: 3000,
                                type: "purchaseInstructions"
                            },
                            {
                                id: 6,
                                header: "Покупка без ЭЦП – проведение торгов",
                                description: "Проведение торгов нашими специалистами вместо вас",
                                detailedDescription: [],
                                price: 10000,
                                type: "purchaseBidByAgent"
                            },
                            {
                                id: 7,
                                header: "Отчет ЕГРН",
                                description: "Отчет ЕГРН",
                                detailedDescription: [],
                                price: 70,
                                type: "receiptEGRN"
                            },
                            {
                                id: 8,
                                header: "Сбор информации по лоту",
                                description: "Оценка ликвидности выбранного лота нашими сотрудниками",
                                detailedDescription: [],
                                price: 3000,
                                type: "infoAboutLot"
                            },
                            {
                                id: 9,
                                header: "Консультация по лоту",
                                description: "Юридическая консультация по выбранному лоту",
                                detailedDescription: [],
                                price: 5000,
                                type: "consultation"
                            },
                            {
                                id: 10,
                                header: "Сопровождение в ФАС",
                                description: "Сопровождение в Федеральной Антимонопольной службе",
                                detailedDescription: [],
                                price: 9000,
                                type: "accompanimentFAS"
                            }
                        ])
                    }
                });
        },
        getCache({dispatch, commit, state}, payload) {
            // const check = dispatch('checkDataProperty', {
            //     module_key: 'shared',
            //     key: 'cached_data.'+ payload.key,
            // });
            let return_value = null;
            if(payload.return_value != null) {
                return_value = payload.return_value;
            }
            const itemStr = localStorage.getItem('lotofond_cached_'+payload.key);
            // if the item doesn't exist, return null
            if (!itemStr) {
                return return_value;
            }

            const item = JSON.parse(itemStr);
            // const item = dispatch('getDataProperty', {
            //     module_key: 'shared',
            //     key: 'cached_data.'+ payload.key,
            // });

            const now = new Date();

            // compare the expiry time of the item with the current time
            if (now.getTime() > item.expiry) {
                // If the item is expired, delete the item from storage
                // and return null
                localStorage.removeItem('lotofond_cached_'+payload.key);
                return return_value;
            }
            return item.value;
        },
        // setCache({dispatch, commit, state}, payload) {
        //     const now = new Date();
        //     const item = {
        //         value: payload.value,
        //         expiry: now.getTime() + 5000,
        //     }
        //     dispatch('saveDataProperty', {
        //         module_key: 'shared',
        //         key: 'cached_data.'+ payload.key,
        //         value: item
        //     }, {root: true});
        //     localStorage.setItem('cached_data', JSON.stringify(state.cached_data))
        // },
    },

    mutations: {
        openModal(state, payload) {
            let modal = bootstrap.Modal.getOrCreateInstance(document.querySelector(''+payload));
            modal.show();
        },
        closeModal(state, payload) {
            let modal = bootstrap.Modal.getOrCreateInstance(document.querySelector(''+payload));
            modal.hide();
            let backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove()
            }
        },
        setUser(state, payload) {
            return (state.user = payload);
        },
        saveUserProperty(state, payload) {
            Vue.set(state.user, payload.key, payload.value)
        },
        changeLocale(state, payload) {
            state.locale = payload;
            localStorage.setItem('locale', payload);
            axios.defaults.headers.common['Content-Language'] = payload;
            // $moment.locale(payload);
            import('vee-validate/dist/locale/' + payload + '.json')
                .then(locale => {
                    localize(payload, locale);
                });
            DatePicker.locale(payload);
            localize(payload);
            localeChanged();
        },
        setContacts(state, payload) {
            return (state.main_contacts = payload);
        },
        setHelp(state, payload) {
            return (state.help = payload);
        },
        setAbout(state, payload) {
            return (state.about = payload);
        },
        setInfo(state, payload) {
            return (state.info = payload);
        },
        setInformationMessage(state, payload) {
            state.informationMessageMode = localStorage.getItem('shortNewsItemMode')
            return (state.informationMessage = payload);
        },
        setInformationMessageMode(state, payload) {
            localStorage.setItem('shortNewsItemMode', payload)
            return (state.informationMessageMode = payload);
        },
        setBuyBlock(state, payload) {
            return (state.buyBlock = payload);
        },
        setBuyLotBlock(state, payload) {
            return (state.buyLotBlock = payload);
        },
        setTariffs(state, payload) {
            return (state.tariffs = payload);
        },
        setServices(state, payload) {
            return (state.services = payload);
        },
        setCache(state, payload) {
            const now = new Date();
            const item = {
                value: payload.value,
                expiry: now.getTime() + 2629800000,
            }
            localStorage.setItem('lotofond_cached_'+payload.key, JSON.stringify(item))
        },
    }
};
