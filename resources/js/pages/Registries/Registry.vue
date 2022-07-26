<template>
    <div>
        <slot name="filters">
            <slot name="search">
                <div class="bkt-register__search-wrapper">
                    <bkt-search v-model="search" no_dropdown :method_name="method_name" :loading="loading" simple
                                @runSearch="runSearch" search_class="bkt-register-collapse__search"
                    >
                    </bkt-search>
                </div>
            </slot>
        </slot>
        <div class="bkt-register-collapse__body">
            <bkt-table :loading="loading" :items="items">
                <template #tr>
                    <slot name="tr">
                        <th>№</th>
                        <th>Должник</th>
                        <th>ИНН</th>
                        <th>Регион</th>
                        <th>Адрес</th>
                    </slot>
                </template>
                <template #tbody_tr="{item}">
                    <slot name="tbody_tr" v-bind:item="item">
                        <td>{{item.id}}</td>
                        <td>{{item.fullName}}</td>
                        <td>{{item.inn ? item.inn : ''}}</td>
                        <td>{{item.region ? item.region : ''}}</td>
                        <td>{{item.address ? item.address : ''}}</td>
                    </slot>
                </template>
            </bkt-table>
            <div class="bkt-register-filters bkt-wrapper bkt-gap-row">
                <div class="col-12 col-md-6 col-lg-4 order-1">
                    <div class="d-flex w-100 mx-auto bkt-nowrap">
                        <bkt-select v-model="current_params.sort.type" @input="callMethod(1)"
                                    name="sort"
                                    subtitle="сортировать по"
                                    :option_label="'title'"
                                    :options="sort"
                                    :reduce="item => item.value"
                                    :clearable="false"
                                    select_class="bkt-v-select_material w-100"
                                    class="w-100"
                        ></bkt-select>
                        <button class="bkt-button-ellipse"
                                :class="{'bkt-mirror-vertical' : current_params.sort.direction =='desc'}"
                                @click="toggleDirection"
                        >
                            <bkt-icon name="Bars"></bkt-icon>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-lg-6 order-last order-lg-2">
                    <bkt-pagination
                        v-if="pagination_data"
                        :limit="1"
                        :data="pagination_data"
                        @change-page="changePage"
                        :extraControls="false"
                        mainClass="bkt-pagination_body"
                    ></bkt-pagination>
                </div>
                <div class="col-12 col-md-6 col-lg-2 order-3">
                    <bkt-select v-model="current_params.perPage" @input="callMethod(1)"
                                name="perPage" :options="perPages" :clearable="false"
                                subtitle="выводить по" select_class="bkt-v-select_material w-100"
                                class="w-100"
                    ></bkt-select>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BktTable from "../../components/Table";

    export default {
        name: "Registry",
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
            no_pagination: {
                type: Boolean,
                default: false
            },
            pagination_data: {
                type: Object,
                required: true,
                default: function () {
                    return {};
                }
            },
            method_name: {
                type: String,
                default: ''
            },
            method_params: {},
            sort: {
                type: Array,
                required: false,
                default: function () {
                    return [{title: 'идентификатору', value: 'id'}];
                }
            },
        },
        components: {
            BktTable
        },
        data() {
            return {
                currentLoading: false,
                search: '',
                perPages: ['20', '30', '50', '100'],
                current_params: {
                    page: 1,
                    searchString: "",
                    sort: {
                        direction: "asc",
                        type: ""
                    },
                    perPage: '20',
                },
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
            if(this.sort.length > 0) {
                this.current_params.sort.type = this.sort[0].value;
            }

            if (this.method_name) {
                this.callMethod(1);
            }
        },
        computed: {
            // tableLoading: {
            //     get() {
            //         return this.loading;
            //     },
            //     set(value) {
            //         this.currentLoading = value;
            //     },
            // },
        },
        methods: {
            changePage(page) {
                this.$emit('change-page', page);
                if (this.method_name) {
                    this.callMethod(page);
                }
            },
            runSearch(search) {
                this.$emit('runSearch', search)
                if (this.method_name) {
                    this.callMethod(1);
                }
            },
            async callMethod(page = 1) {
                // this.tableLoading = true;
                this.current_params.searchString = this.search;
                let payload = this.current_params;
                if (this.method_params) {
                    payload = {
                        ...this.current_params,
                        ...this.method_params
                    };
                    //     payload = this.method_params;
                    //     payload.page = page;
                    //     payload.searchString = this.search;
                }
                payload.page = page;
                await this.$store.dispatch(this.method_name, payload)
                    .then(resp => {
                        // this.tableLoading = false;
                    }).catch(error => {
                        // this.tableLoading = false;
                    });
            },
            toggleDirection() {
                if (this.current_params.sort.direction == 'asc') {
                    this.current_params.sort.direction = 'desc';
                } else {
                    this.current_params.sort.direction = 'asc';
                }
                this.$emit('toggleDirection', this.current_params.sort.direction);
                if (this.method_name) {
                    this.callMethod(1);
                }
            }
        }

    }
</script>

<style scoped>

</style>
