<template>
    <div :class="main_class">
        <slot name="list">
            <div v-if="loading" class="d-flex w-100 justify-content-center mb-5">
                <slot name="loading">
                    <div
                        style="color: #2953ff;border-width: 2px;"
                        class="spinner-border"
                        role="status"
                    ></div>
                </slot>
            </div>
            <slot name="card_list" v-if="!loading">
                <template v-for="(item, index) in items">
                    <component
                        :is="current_component"
                        :item="item"
                        :index="index"
                        :key="index"
                        :in_process="in_process"
                    />
                </template>
            </slot>
            <slot name="pagination" v-if="!no_pagination && items.length>0">
                <bkt-pagination
                    :limit="1"
                    :data="pagination_data"
                    @change-page="changePage"
                ></bkt-pagination>
            </slot>
        </slot>
    </div>
</template>

<script>
    export default {
        name: "CardList",
        props: {
            items: {
                type: Array,
                required: true,
                default: function () {
                    return [];
                }
            },
            loading: {
                type: Boolean,
                default: true
            },
            // params: {
            //     type: Object,
            //     required: true,
            // },
            // fields: {
            //     type: Array,
            //     required: true,
            //     default: function(){
            //         return [];
            //     }
            // },
            in_process: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            loading_class: {
                type: String,
                default: 'd-flex justify-content-center mt-5'
            },
            main_class: {
                type: String,
                default: 'bkt-main-cards bkt-card__list'
            },
            current_component: {
                // type:String
            },
            no_pagination: {
                type: Boolean,
                default: false
            },
            pagination_data: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
            }
        },
        methods: {
            changePage(page) {
                this.$emit('change-page', page)
            }
        }
    }
</script>

<style scoped>

</style>

