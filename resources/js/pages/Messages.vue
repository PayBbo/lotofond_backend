<template>
    <div class="bkt-messages bkt-page bkt-container">
        <h1 class="bkt-page__title">
            Сообщения
        </h1>
        <div class="bkt-content">
            <div class="row" ref="cardList">
                <div class="col-12 col-lg-3">
                    <div class="bkt-history__chats">
                        <ul class="list-unstyled text-left pt-4 pb-4">
                            <li class="bkt-chat" :class="{'bkt-bg-primary-lighter': selectedType=='all'}" id="chat-1"
                                @click="setType('all')"
                            >
                                Все
                                <div class="bkt-chat__num rounded-pill bkt-bg-primary bkt-text-neutral-light">
                                    <span v-if="notifications_count.all > 0" class="p-2">
                                        {{notifications_count.all}}
                                    </span>
                                </div>
                            </li>
                            <li class="bkt-chat" :class="{'bkt-bg-green-lighter': selectedType=='platform'}" id="chat-2"
                                @click="setType('platform')"
                            >
                                <div class="bkt-chat__text">
                                    <bkt-icon :name="'Bell'" :color="'green'" width="15px" height="15px"/>
                                    Сообщения платформы
                                </div>

                                <div class="bkt-chat__num rounded-pill bkt-bg-green bkt-text-neutral-light">
                                    <span v-if="notifications_count.platform > 0" class="p-2">
                                        {{notifications_count.platform}}
                                    </span>
                                </div>
                            </li>
                            <li class="bkt-chat" :class="{'bkt-bg-yellow-lighter': selectedType=='favourite'}"
                                id="chat-3"
                                @click="setType('favourite')"
                            >
                                <div class="bkt-chat__text">
                                    <bkt-icon :name="'Star'" :color="'yellow'" width="15px" height="15px"/>
                                    Избранное
                                </div>
                                <div class="bkt-chat__num rounded-pill bkt-bg-yellow bkt-text-neutral-light">
                                    <span v-if="notifications_count.favourite > 0" class="p-2">
                                        {{notifications_count.favourite}}
                                    </span>
                                </div>
                            </li>
                            <li class="bkt-chat" :class="{'bkt-bg-red-lighter': selectedType=='monitoring'}" id="chat-4"
                                @click="setType('monitoring')"
                            >
                                <div class="bkt-chat__text">
                                    <bkt-icon :name="'Target'" :color="'red'" width="15px" height="15px"/>
                                    Мониторинг
                                </div>

                                <div class="rounded-pill bkt-bg-red bkt-text-neutral-light">
                                    <span v-if="notifications_count.monitoring > 0" class="p-2">
                                        {{notifications_count.monitoring}}
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-9 bkt-gap-row-medium">
                    <div class="bkt-wrapper-column bkt-gap-row-medium">
                        <div v-show="!loading" class="bkt-wrapper-column bkt-gap-mini">
                            <div class="bkt-message"
                                 v-for="(message, index) in items" :key="index" v-if="message">
                                <bkt-icon :name="'Check'" :color="message.isSeen ? 'primary' : 'main-lighter'"
                                          width="15px" height="15px" class="bkt-message__check"/>

                                <div class="d-md-none bkt-wrapper-between w-100">
                                    <h6 class="bkt-message__date">
                                        {{ message.date | moment('D MMMM YYYY')}} в {{ message.date | moment('HH:mm')}}
                                    </h6>
                                    <div class="bkt-chat-content__info text-right">
                                        <div class="bkt-message__type" :class="{'bkt-bg-red-lighter bkt-text-red': message.type=='monitoring',
                                        'bkt-bg-yellow-lighter bkt-text-yellow': message.type=='favourite',
                                        'bkt-bg-green-lighter bkt-text-green': message.type=='platform',}"
                                        >
                                            {{ message.type=='monitoring' ? 'мониторинг' :''}}
                                            {{ message.type=='favourite' ? 'избранное' :''}}
                                            {{ message.type=='platform' ? 'сообщения платформы' :''}}
                                        </div>
                                    </div>
                                </div>

                                <div class="bkt-wrapper-column bkt-message__content">
                                    <div class="bkt-wrapper bkt-nowrap me-auto ms-0">
                                        <div class="bkt-message__image-wrapper" v-if="message.type=='favourite'">
                                            <!--                                            <img :src="message.dataFavourite" alt="" class="bkt-message__image">-->
                                            <bkt-card-image-category :no_multiple="true"
                                                :categories="message.dataFavourite.categories"
                                                v-if="(!message.dataFavourite.photos || message.dataFavourite.photos.length==0)
                                            && message.dataFavourite.categories && message.dataFavourite.categories.length>0"
                                            >
                                            </bkt-card-image-category>
                                            <img
                                                v-if="message.dataFavourite.photos && message.dataFavourite.photos.length>0"
                                                :src="message.dataFavourite.photos[0].preview" alt=""
                                                class="bkt-message__image"
                                            >
                                        </div>

                                        <div class="bkt-chat-content__text">
                                            <div v-if="message.type == 'monitoring'&& message.dataMonitoring"
                                                 class="bkt-badge mx-0 mb-2"
                                                 :class="message.dataMonitoring.folderInfo.color ?
                                                'bkt-bg-'+message.dataMonitoring.folderInfo.color :'bkt-bg-primary'"
                                            >
                                                {{message.dataMonitoring.folderInfo.name}}
                                            </div>
                                            <h5 v-if="message.type == 'monitoring'"
                                                class="bkt-message__text bkt-cursor-pointer"
                                                @click="navigate('/monitoring')"
                                            >
                                                Появились новые лоты в мониторинге:
                                                {{message.dataMonitoring ? message.dataMonitoring.newLotCount : '0'}}
                                            </h5>
                                            <h6 v-if="message.type == 'platform' && message.dataPlatform"
                                                class="bkt-message__title"
                                            >
                                                {{message.dataPlatform.label}}
                                            </h6>
                                            <h5 v-if="message.type == 'platform'" class="bkt-message__text">
                                                {{message.dataPlatform ? message.dataPlatform.value : ''}}
                                            </h5>
                                            <router-link v-if="message.type == 'favourite' && message.dataFavourite"
                                                         :to="'/lot/'+message.dataFavourite.id"
                                                         class="bkt-card__title bkt-text-truncate"
                                            >
                                                <h6 v-if="message.type == 'favourite' && message.dataFavourite"
                                                    class="bkt-message__title bkt-text-truncate bkt-arrow-after bkt-cursor-pointer"
                                                >
                                                    {{message.dataFavourite.description}}
                                                </h6>
                                            </router-link>
                                            <h5 v-if="message.type == 'favourite'" class="bkt-message__text">
                                                {{message.dataFavourite ? message.dataFavourite.detail : ''}}
                                            </h5>
                                        </div>
                                    </div>
                                    <!--                                    <button v-if="message.btnText" class="btn bkt-button p-4 primary mb-3">-->
                                    <!--                                        {{ message.btnText }}-->
                                    <!--                                    </button>-->
                                    <!--                                    <br class="d-none d-md-block">-->
                                    <h6 class="d-none d-md-block bkt-message__date">
                                        {{ message.date | moment('D MMMM YYYY')}} в {{ message.date | moment('HH:mm')}}
                                    </h6>
                                </div>

                                <div class="bkt-message__type d-none d-md-block "
                                     :class="{'bkt-bg-red-lighter bkt-text-red': message.type=='monitoring',
                                        'bkt-bg-yellow-lighter bkt-text-yellow': message.type=='favourite',
                                        'bkt-bg-green-lighter bkt-text-green': message.type=='platform'}"
                                >
                                    {{ message.type=='monitoring' ? 'мониторинг' :''}}
                                    {{ message.type=='favourite' ? 'избранное' :''}}
                                    {{ message.type=='platform' ? 'сообщения платформы' :''}}
                                </div>
                            </div>
                        </div>
                        <div v-show="loading||type_loading" class="bkt-wrapper-column bkt-gap-mini">
                            <div class="bkt-message" v-for="(message, index) in 20" :key="index">
                                <skeleton width="15px" height="15px" skeleton_class="bkt-message__check"></skeleton>
                                <div class="d-md-none bkt-wrapper-between w-100">
                                    <skeleton skeleton_class="bkt-message__date mb-1" height="12px"></skeleton>
                                    <div class="bkt-chat-content__info text-right">
                                        <skeleton skeleton_class="bkt-bkt-message__type" width="92px"></skeleton>
                                    </div>
                                </div>
                                <div class="bkt-wrapper-column bkt-message__content">
                                    <div class="bkt-wrapper bkt-nowrap me-auto ms-0">
                                        <div class="bkt-message__image-wrapper">
                                            <skeleton skeleton_class="bkt-message__image"></skeleton>
                                        </div>
                                        <div class="bkt-chat-content__text">
                                            <skeleton height="14px" width="150px" skeleton_class="mb-1"></skeleton>
                                            <skeleton height="12px" width="60%"></skeleton>
                                        </div>
                                    </div>
                                    <skeleton height="12px" skeleton_class="d-none d-md-block bkt-message__date"></skeleton>
                                </div>
                                <skeleton skeleton_class="bkt-message__type d-none d-md-block" width="92px"></skeleton>
                            </div>
                        </div>
                        <bkt-pagination
                            v-if="pagination_data && !type_loading"
                            :limit="1"
                            :data="pagination_data"
                            @change-page="changePage"
                            :extraControls="false"
                        ></bkt-pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BktCardImageCategory from "../components/CardImageCategory";

    export default {
        name: "Messages",
        components: {
            BktCardImageCategory
        },
        data() {
            return {
                info_categories: [
                    {id: 1, code: 'platform', title: 'сообщения платформы', color: 'green'},
                    {id: 2, code: 'favourite', title: 'избранное', color: 'yellow'},
                    {id: 3, code: 'monitoring', title: 'мониторинг', color: 'red'},
                ],
                selectedType: 'all',
                type_loading: false,
                signal: null,
                controller: null,
            }
        },
        created() {
            let page = 1;
            if (sessionStorage.getItem('messages_page')) {
                page = sessionStorage.getItem('messages_page')
            }
            this.getData(page);
        },
        computed: {
            items() {
                return this.$store.getters.notifications;
            },
            pagination_data() {
                return this.$store.getters.notifications_pagination;
            },
            loading() {
                return this.$store.getters.notifications_loading;
            },
            notifications_count() {
                return this.$store.getters.notifications_count;
            },
        },
        methods: {
            async getData(page = 1) {
                this.controller = new AbortController();
                this.signal = this.controller.signal;
                let type = this.selectedType;
                if (sessionStorage.getItem('messages_page_type')) {
                    type = sessionStorage.getItem('messages_page_type');
                    if(type != this.selectedType) {
                        this.selectedType = type;
                    }
                }
                sessionStorage.setItem('messages_page', page + '');
                await this.$store.dispatch('getNotifications', {
                    page: page,
                    type: type,
                    signal: this.signal
                });
            },
            setType(type) {
                // if (!this.loading) {
                if (this.signal) {
                    this.controller.abort();
                }
                this.type_loading = true;
                this.selectedType = type;
                sessionStorage.setItem('messages_page_type', type);
                setTimeout(() => {
                    this.getData(1).then(resp => {
                        this.type_loading = false;
                    }).catch(resp => {
                        this.type_loading = false;
                    });
                }, 50)
                // }
            },
            changePage(page) {
                if (this.signal) {
                    this.controller.abort();
                }
                setTimeout(() => {
                    this.getData(page).then(()=> {
                        const el = this.$refs.cardList;
                        if (el) {
                            requestAnimationFrame(() => {
                                el.scrollIntoView({block: 'start', scrollBehavior: 'smooth'});
                                requestAnimationFrame(() => {
                                    el.scrollIntoView();
                                })
                            })
                        }
                    })
                }, 50)
            },
            navigate(path) {
                this.$router.push(path);
            }
        }
    }
</script>

<style scoped>

</style>
