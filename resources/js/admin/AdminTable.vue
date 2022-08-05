<template>
    <fragment>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
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

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th v-for="column in columns">{{ column }}</th>
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

export default {
    name: "AdminTable",
    components: {AdminPagination},
    props: ['columns', 'header', 'pagination', 'getData'],
}
</script>

<style scoped>

</style>
