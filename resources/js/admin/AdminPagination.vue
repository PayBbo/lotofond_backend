<template>
    <ul class="pagination pagination-sm m-0 float-right">
        <li class="page-item" v-if="pagination.currentPage > 1">
            <a href="javascript:void(0)" class="page-link" aria-label="Previous" v-on:click.prevent="changePage(pagination.currentPage - 1)">
                «
            </a>
        </li>
        <li class="page-item" v-for="page in pagesNumber" :class="{'active': page == pagination.currentPage}">
            <a href="javascript:void(0)" class="page-link"  v-on:click.prevent="changePage(page)">{{ page }}</a>
        </li>
        <li  class="page-item"v-if="pagination.currentPage < pagination.lastPage">
            <a href="javascript:void(0)" class="page-link"  aria-label="Next" v-on:click.prevent="changePage(pagination.currentPage + 1)">
               »
            </a>
        </li>
    </ul>
</template>

<script>
export default {
    name: "AdminPagination",
    props: {
        pagination: {
            type: Object,
            required: true
        }
    },
    data(){
        return{
            offset: 4
        }
    },
    computed: {
        pagesNumber() {
            if (!this.pagination.to) {
                return [];
            }
            let from = this.pagination.currentPage - this.offset;
            if (from < 1) {
                from = 1;
            }
            let to = from + (this.offset * 2);
            if (to >= this.pagination.lastPage) {
                to = this.pagination.lastPage;
            }
            let pagesArray = [];
            for (let page = from; page <= to; page++) {
                pagesArray.push(page);
            }
            return pagesArray;
        }
    },
    methods : {
        changePage(page) {
            this.$store.commit('setCurrentPage', page)
            this.$emit('paginate');
        }
    }
}
</script>

<style scoped>

</style>
