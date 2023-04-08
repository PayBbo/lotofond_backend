<template>
    <fragment>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h1 class="m-0">{{ header }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <slot name="inline-block"></slot>
                            </div>

                            <div class="card-body table-responsive p-0" style="max-height: 600px">
                                <table class="table table-bordered table-hover table-head-fixed">
                                    <thead>
                                    <tr>
                                        <th v-for="(column, index) in columns.columns_title"
                                            v-bind:class="[
                                                columns.columns_sort[index] !== null ? 'sort' : '',
                                                columns.columns_sort[index] !== null && getSortProperty === columns.columns_sort[index] ? 'sorted' : ''
                                            ]"
                                            v-bind:data-sorting-direction="columns.columns_sort[index] !== null && getSortDirection === 'desc' && getSortProperty === columns.columns_sort[index] ? 'desc' : 'asc'"
                                            @click="columns.columns_sort[index] !== null ? getSortedData(columns.columns_sort[index], $event.target.dataset.sortingDirection) : null">{{ column }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <slot name="raws-block"></slot>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer clearfix" v-if="pagination.total > pagination.perPage">
                                <AdminPagination :pagination="pagination" @paginate="getData"></AdminPagination>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </section>
    </fragment>
</template>

<script>

import AdminPagination from "./AdminPagination";
import {mapGetters, mapMutations} from "vuex";

export default {
    name: "AdminTable",
    components: {AdminPagination},
    props: ['columns', 'header', 'pagination', 'getData'],
    computed: {
        ...mapGetters(['getSortProperty', 'getSortDirection'])
    },
    methods: {
        ...mapMutations(['updateSortProperty', 'updateSortDirection']),
        getSortedData(param, direction) {
            this.$store.commit('updateSortProperty', param);
            if (direction === 'desc')
                this.$store.commit('updateSortDirection', 'asc');
            else
                this.$store.commit('updateSortDirection', 'desc');
            this.$store.dispatch('getData')
        }
    }
}
</script>

<style scoped>
th.sort, th.sort {
    padding-right: 40px;
}
th.sort::before {
    content: "↓";
    right: 0;
}
th.sort::after {
    content: "↑";
    right: 15px;
}
th.sort::after, th.sort::before {
    position: absolute;
    display: inline-block;
    float: right;
    opacity: 0.5;
    bottom: 0.5rem;
}

th.sorted[data-sorting-direction="desc"]::after, th.sorted[data-sorting-direction="asc"]::before {
    opacity: 1;
}
.table-responsive>.table-bordered {
    border: 1px solid var(--bs-table-border-color);
}
.table-bordered > :not(caption) > * > * {
    border-width: 0 2px;
}
.table-bordered > :not(caption) > * {
    border-width: 2px 0;
}
</style>
