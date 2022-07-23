<template>
<!--    <div>-->
<!--        <bkt-card-list :loading="tableLoading" :items="items" :pagination_data="pagination_data">-->
<!--            <template #filters>-->
<!--                <slot name="search">-->
<!--                    <hr>-->
<!--                    <bkt-search v-model="search" no_dropdown :method_name="method_name">-->
<!--&lt;!&ndash;                        <template #dropdown_item="item">&ndash;&gt;-->
<!--&lt;!&ndash;                            <slot name="search_dropdown_item">&ndash;&gt;-->
<!--&lt;!&ndash;                                {{item.fullName}}&ndash;&gt;-->
<!--&lt;!&ndash;                            </slot>&ndash;&gt;-->
<!--&lt;!&ndash;                        </template>&ndash;&gt;-->
<!--                    </bkt-search>-->
<!--                    <hr>-->
<!--                </slot>-->
<!--            </template>-->
<!--            <template #card_list>-->
                <div class="overflow-auto">
                    <table class="table table-borderless bkt-simple-table" :class="main_class">
                        <thead>
                            <slot name="thead">
                                <tr>
                                    <slot name="tr">

                                    </slot>
                                </tr>
                            </slot>
                        </thead>

                        <tbody>
                        <slot name="tbody">
                            <tr v-for="item in items">
                                <slot name="tbody_tr" v-bind:item="item">

                                </slot>
                            </tr>
                        </slot>
                        </tbody>
                    </table>
                </div>
<!--            </template>-->
<!--            <template #footer>-->
<!--                <div class="bkt-register-filters bkt-row">-->
<!--                    <div class="col-12 col-md-6 col-lg-4">-->
<!--                        <slot name="sort">-->
<!--                            <div class="d-flex w-100 mx-auto justify-content-around">-->
<!--                                <div class="form-floating bkt-select__wrapper bkt-item-rounded">-->
<!--                                    <select class="form-select bkt-select bkt-item-rounded" id="sortSelect1"-->
<!--                                            aria-label="">-->
<!--                                        <option selected>алфавиту</option>-->
<!--                                        <option value="1">One</option>-->
<!--                                        <option value="2">Two</option>-->
<!--                                        <option value="3">Three</option>-->
<!--                                    </select>-->
<!--                                    <label class="bkt-select__subtitle" for="sortSelect1">сортировать по</label>-->
<!--                                </div>-->
<!--                                <button class="bkt-button-ellipse">-->
<!--                                    <bkt-icon name="Bars"></bkt-icon>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </slot>-->
<!--                    </div>-->
<!--                    <div class="col-12 col-md-6 col-lg-5 d-flex justify-content-center bkt-pagination-items">-->
<!--                        <slot name="pagination" v-if="!no_pagination && items.length>0 && !tableLoading">-->
<!--                            <bkt-pagination-->
<!--                                :limit="1"-->
<!--                                :data="pagination_data"-->
<!--                                @change-page="changePage"-->
<!--                            ></bkt-pagination>-->
<!--                        </slot>-->
<!--                    </div>-->
<!--                    <div class="col-12 col-md-6 col-lg-3">-->
<!--                        <slot name="page_count">-->
<!--                            <div class="form-floating bkt-select__wrapper bkt-item-rounded">-->
<!--                                <select class="form-select bkt-select bkt-item-rounded" id="sortSelect9" aria-label="">-->
<!--                                    <option selected>20</option>-->
<!--                                    <option value="1">30</option>-->
<!--                                    <option value="2">50</option>-->
<!--                                    <option value="3">100</option>-->
<!--                                </select>-->
<!--                                <label class="bkt-select__subtitle" for="sortSelect9">выводить по</label>-->
<!--                            </div>-->
<!--                        </slot>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </template>-->
<!--        </bkt-card-list>-->
<!--    </div>-->
</template>

<script>
    export default {
        name: "Table",
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
                default: false
            },
            main_class: {
                type: String,
                default: ''
            },
        },
        data() {
            return {
                currentLoading: false,
                search: '',
            }
        },
        created() {
            // if(this.type) {
            //     this.method_name += this.type.charAt(0).toUpperCase() + this.type.slice(1);
            //     this.method_params = {
            //         page:1,
            //         type:'table'
            //     }
            // }
            if(this.method_name) {
                this.callMethod(1);
            }
        },
        computed: {
            tableLoading: {
                get() {
                    return this.loading;
                },
                set(value) {
                    this.currentLoading = value;
                },
            },
        },
        methods: {
            changePage(page) {
                this.$emit('change-page', page);
                if(this.method_name) {
                    this.callMethod(page);
                }
            },
            runSearch() {
                this.$emit('runSearch')
            },
            async callMethod(page=1) {
                this.tableLoading = true;
                let payload = page;
                if (this.method_params) {
                    payload = this.method_params;
                    payload.page = page;
                }
                await this.$store.dispatch(this.method_name, payload)
                    .then(resp => {
                        this.tableLoading = false;
                    }).catch(error => {
                        this.tableLoading = false;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
