<template>
    <div class="bkt-orders bkt-wrapper-column bkt-gap-row-medium" ref="cardList">
        <div v-show="!loading" class="bkt-wrapper-column bkt-gap">
            <div class="bkt-order" v-for="(item, index) in items" :key="index" v-if="item">
                <div class="d-md-none bkt-wrapper-between w-100">
                    <h6 class="bkt-order__date">
                        {{ item.publishDate }}
                    </h6>
                    <div class="bkt-chat-content__info text-right">
                        <div class="bkt-order__type"
                             :class="'bkt-bg-'+statuses_colors[item.status]+'-lighter bkt-text-'+statuses_colors[item.status]"
                        >
                            {{item.status ? $t('trades.statuses.'+item.status) : ''}}
                        </div>
                    </div>
                </div>

                <div class="bkt-wrapper-column bkt-order__content">
                    <h5 class="bkt-order__title">
                        {{item.type}}
                    </h5>
                    <div class="bkt-wrapper-column bkt-gap">

                            <div class="bkt-wrapper bkt-nowrap bkt-gap align-items-center me-auto ms-0" v-if="item.cadastralNumber">
                                <div class="bkt-icon-frame bkt-bg-cornflower-blue-lighter">
                                    <bkt-icon :name="'categories/realEstate'" :color="'cornflower-blue'" width="25px" height="25px"/>
                                </div>
                                <div>
                                    <h6 class="bkt-order__subtitle">Кадастровый номер</h6>
                                    <h6 class="bkt-order__subtitle">{{item.cadastralNumber}}</h6>
                                </div>
                            </div>

                            <div class="bkt-wrapper bkt-nowrap align-items-center bkt-cursor-pointer mx-0"
                                 v-if="item.lot" @click="toLot(item.lot.id)"
                            >
                                <div class="bkt-order__image-wrapper">
                                    <bkt-card-image-category
                                        :no_multiple="true"
                                        :categories="item.lot.categories"
                                        v-if="(!item.lot.photos || item.lot.photos.length==0)
                                        && item.lot.categories && item.lot.categories.length>0"
                                    />
                                    <img
                                        v-if="item.lot.photos && item.lot.photos.length>0"
                                        :src="item.lot.photos[0].preview" alt=""
                                        class="bkt-order__image"
                                    >
                                </div>
                                <h6 class="bkt-order__lot-title bkt-text-truncate">{{item.lot.description}}</h6>
                            </div>

<!--                            <h5 class="bkt-order__text">-->
<!--                                <a :href="item.lotUrl" class="bkt-button-link">Перейти к лоту</a>-->
<!--                            </h5>-->
                    </div>
                    <h6 class="d-none d-md-block bkt-order__date">
                        {{ item.publishDate }}
                    </h6>
                </div>

                <div class="bkt-order__type d-none d-md-block "
                     :class="'bkt-bg-'+statuses_colors[item.status]+'-lighter bkt-text-'+statuses_colors[item.status]"
                >
                    {{item.status ? $t('trades.statuses.'+item.status) : ''}}
                </div>
            </div>
        </div>
        <div v-show="loading||type_loading" class="bkt-wrapper-column bkt-gap">
            <div class="bkt-order" v-for="(item, index) in 20" :key="index">
                <div class="d-md-none bkt-wrapper-between w-100">
                    <skeleton skeleton_class="bkt-order__date mb-1" height="12px"/>
                    <div class="bkt-chat-content__info text-right">
                        <skeleton skeleton_class="bkt-order__type" width="92px"/>
                    </div>
                </div>
                <div class="bkt-wrapper-column bkt-order__content">
                    <div class="bkt-wrapper bkt-nowrap me-auto ms-0">
                        <div class="bkt-chat-content__text">
                            <skeleton height="14px" width="150px" skeleton_class="mb-1"/>
                            <skeleton height="12px" width="60%"/>
                        </div>
                    </div>
                    <skeleton height="12px" skeleton_class="d-none d-md-block bkt-order__date"/>
                </div>
                <skeleton skeleton_class="bkt-order__type d-none d-md-block" width="92px"/>
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
    import BktCardImageCategory from "../../components/CardImageCategory";

    export default {
        name: "OrdersTab",
        components: {
            BktCardImageCategory
        },
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
            },
            toLot(id) {
                this.$router.push('/lot/'+id);
            }
        }
    }
</script>

<style scoped>

</style>
