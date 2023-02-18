<template>
    <v-select :options="options.data" :filterable="false" @search="onSearch" v-model="param">
        <li slot="list-footer" class="pagination">
            <button :disabled="!hasPrevPage" @click="changePage(false)"> << </button>
            <button :disabled="!hasNextPage" @click="changePage(true)"> >> </button>
        </li>
    </v-select>
</template>

<script>
export default {
    name: "AdminSelect",
    props: ['options', 'model'],
    data() {
        return {
            page: 1,
            search: ''
        }
    },
    computed: {
        param: {
            get() {
                return this.model;
            },
            set(val) {
                this.$emit('selected', val);
            }
        },
        hasPrevPage() {
            return this.options === undefined ? false : this.options.pagination.prevPageUrl !== null
        },
        hasNextPage() {
            return this.options === undefined ? false : this.options.pagination.nextPageUrl !== null
        }
    },
    methods: {
        changePage(isNext) {
            if (isNext) {
                this.page += 1;
            } else {
                this.page -= 1;
            }
            this.$emit('search', this.page, this.search)
        },
        onSearch(query) {
            this.search = query
            this.$emit('search', 1, this.search)
        },
    }

}
</script>

<style scoped>

</style>
