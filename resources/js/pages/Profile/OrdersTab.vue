<template>
    <div class="bkt-messages bkt-wrapper-column bkt-gap-row-medium" ref="cardList">
        <div v-show="!loading" class="bkt-wrapper-column bkt-gap-mini">
            <div class="bkt-message" v-for="(item, index) in items" :key="index" v-if="item">
                <div class="d-md-none bkt-wrapper-between w-100">
                    <h6 class="bkt-message__date">
                        {{ item.publishDate }}
                    </h6>
                    <div class="bkt-chat-content__info text-right">
                        <div class="bkt-message__type"
                             :class="'bkt-bg-'+statuses_colors[item.status]+'-lighter bkt-text-'+statuses_colors[item.status]"
                        >
                            {{item.status ? $t('trades.statuses.'+item.status) : ''}}
                        </div>
                    </div>
                </div>

                <div class="bkt-wrapper-column bkt-message__content">
                    <div class="bkt-wrapper bkt-nowrap me-auto ms-0">
                        <div class="bkt-chat-content__text">
                            <h6 class="bkt-message__title">
                                {{item.type}}
                            </h6>
                            <h5 class="bkt-message__text">
                                <a :href="item.lotUrl" class="bkt-button-link">Перейти к лоту</a>
                            </h5>
                        </div>
                    </div>
                    <h6 class="d-none d-md-block bkt-message__date">
                        {{ item.publishDate }}
                    </h6>
                </div>

                <div class="bkt-message__type d-none d-md-block "
                     :class="'bkt-bg-'+statuses_colors[item.status]+'-lighter bkt-text-'+statuses_colors[item.status]"
                >
                    {{item.status ? $t('trades.statuses.'+item.status) : ''}}
                </div>
            </div>
        </div>
        <div v-show="loading||type_loading" class="bkt-wrapper-column bkt-gap-mini">
            <div class="bkt-message" v-for="(item, index) in 20" :key="index">
                <div class="d-md-none bkt-wrapper-between w-100">
                    <skeleton skeleton_class="bkt-message__date mb-1" height="12px"></skeleton>
                    <div class="bkt-chat-content__info text-right">
                        <skeleton skeleton_class="bkt-bkt-message__type" width="92px"></skeleton>
                    </div>
                </div>
                <div class="bkt-wrapper-column bkt-message__content">
                    <div class="bkt-wrapper bkt-nowrap me-auto ms-0">
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
        />
    </div>
</template>

<script>
    export default {
        name: "OrdersTab",
        data() {
            return {
                statuses: [
                    {'title': 'Не обработана', 'code': 'notProcessed', color: 'primary'},
                    {'title': 'В процессе', 'code': 'inProgress', color: 'yellow'},
                    {'title': 'Отклонена системой', 'code': 'rejectedBySystem', color: 'red'},
                    {'title': 'Отклонена пользователем', 'code': 'rejectedByUser', color: 'red'},
                    {'title': 'Завершена', 'code': 'completed', color: 'green'}
                ],
                statuses_colors: {
                    'notProcessed': 'primary',
                    'inProgress': 'yellow',
                    'rejectedBySystem': 'red',
                    'rejectedByUser': 'red',
                    'completed': 'green',
                },
                type_loading: false,
                signal: null,
                controller: null,
            }
        },
        created() {
            let page = 1;
            if (sessionStorage.getItem('orders_page')) {
                page = sessionStorage.getItem('orders_page')
            }
            this.getData(page);
        },
        computed: {
            items() {
                return this.$store.getters.orders;
            },
            pagination_data() {
                return this.$store.getters.orders_pagination;
            },
            loading() {
                return this.$store.getters.orders_loading;
            },
        },
        methods: {
            async getData(page = 1) {
                sessionStorage.setItem('orders_page', page + '');
                await this.$store.dispatch('getOrders', {
                    page: page,
                });
            },
            changePage(page) {
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
            navigate(item) {
                this.$router.push('/order/'+item.id);
            }
        }
    }
</script>

<style scoped>

</style>
