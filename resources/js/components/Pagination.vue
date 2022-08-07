<template>
    <nav
        v-if="lastPage != 1"
        class="bkt-pagination"
        :class="mainClass"
        aria-label="Page navigation"
    >
        <ul class="pagination"
            :class="{
                'pagination-sm': size == 'small',
                'pagination-lg': size == 'large',
                'justify-content-center': align == 'center',
                'justify-content-end': align == 'right'
            }"
            v-if="total > perPage"
        >
            <li class="page-item page-item-control d-none d-sm-block" :class="{'disabled': !prevPageUrl}"
                v-if="(prevPageUrl || showDisabled) && extraControls">
                <div class="page-link" aria-label="Previous" :tabindex="!prevPageUrl && -1"
                   @click.prevent=changePage(1)>
                    <svg fill="#ffc515" width="14" height="12" viewBox="0 0 14 12">
                        <path
                            d="M14 10.59L12.59 12L6.59 6L12.59 1.23266e-07L14 1.41L9.42 6L14 10.59ZM8 10.59L6.59 12L0.59 6L6.59 6.47803e-07L8 1.41L3.42 6L8 10.59Z"
                        ></path>
                    </svg>
                </div>
            </li>
            <li class="page-item page-item-control" :class="{'disabled': !prevPageUrl}"
            >
                <div
                    class="page-link"
                    @click.prevent="previousPage"
                >
                    <svg
                        width="8"
                        height="12"
                        viewBox="0 0 8 12"
                        fill="#ffc515"
                    >
                        <path
                            d="M8 1.42L3.42 6L8 10.59L6.59 12L0.59 6L6.59 1.23266e-07L8 1.42Z"
                        ></path>
                    </svg>
                </div>
            </li>
            <li class="page-item" v-for="(page, index) in pageRange" :key="index"
                :class="{ 'active': page == currentPage, 'dots': page == '...' }">
                <div class="page-link" @click.prevent="changePage(page)">
                    {{ page }}
                </div>
            </li>

            <li
                class="page-item page-item-control"
                :class="{'disabled': !nextPageUrl}"
            >
                <div
                    class="page-link"
                    @click.prevent="nextPage"
                >
                    <svg
                        fill="#ffc515"
                        width="8"
                        height="12"
                        viewBox="0 0 8 12"
                    >
                        <path
                            d="M0 10.5801L4.58 6.00012L0 1.41012L1.41 0.00012207L7.41 6.00012L1.41 12.0001L0 10.5801Z"
                        ></path>
                    </svg>
                </div>
            </li>
            <li class="page-item page-item-control d-none d-sm-block" :class="{'disabled': !nextPageUrl}"
                v-if="(nextPageUrl || showDisabled) && extraControls">
                <div class="page-link" aria-label="Next" :tabindex="!nextPageUrl && -1"
                   @click.prevent=changePage(lastPage)>
                    <svg
                        fill="#ffc515"
                        width="14"
                        height="12"
                        viewBox="0 0 14 12"
                    >
                        <path
                            d="M0 1.41012L1.41 0.00012207L7.41 6.00012L1.41 12.0001L0 10.5901L4.58 6.00012L0 1.41012ZM6 1.41012L7.41 0.00012207L13.41 6.00012L7.41 12.0001L6 10.5901L10.58 6.00012L6 1.41012Z"
                        ></path>
                    </svg>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "Pagination",
        props: {
            data: {
                type: Object,
                default: () => {
                }
            },
            limit: {
                type: Number,
                default: 0
            },
            showDisabled: {
                type: Boolean,
                default: true
            },
            size: {
                type: String,
                default: 'default',
                validator: value => {
                    return ['small', 'default', 'large'].indexOf(value) !== -1;
                }
            },
            align: {
                type: String,
                default: 'left',
                validator: value => {
                    return ['left', 'center', 'right'].indexOf(value) !== -1;
                }
            },
            mainClass: {
                type: String,
                default: '',
            },
            extraControls: {
                type: Boolean,
                default: true
            }
        },
        data() {
            return {
                // page: 1,
                // pages:[]
            }
        },
        computed: {
            isApiResource() {
                return !!this.data.meta;
            },
            currentPage() {
                return this.isApiResource ? this.data.meta.currentPage : this.data.currentPage;
            },
            firstPageUrl() {
                return this.isApiResource ? this.data.links.first : this.data.firstPageUrl;
            },
            from() {
                return this.isApiResource ? this.data.meta.from : this.data.from;
            },
            lastPage() {
                return this.isApiResource ? this.data.meta.lastPage : this.data.lastPage;
            },
            lastPageUrl() {
                return this.isApiResource ? this.data.links.last : this.data.lastPageUrl;
            },
            nextPageUrl() {
                return this.isApiResource ? this.data.links.next : this.data.nextPageUrl;
            },
            perPage() {
                return this.isApiResource ? this.data.meta.perPage : this.data.perPage;
            },
            prevPageUrl() {
                return this.isApiResource ? this.data.links.prev : this.data.prevPageUrl;
            },
            to() {
                return this.isApiResource ? this.data.meta.to : this.data.to;
            },
            total() {
                return this.isApiResource ? this.data.meta.total : this.data.total;
            },
            pageRange() {
                if (this.limit === -1) {
                    return 0;
                }

                if (this.limit === 0) {
                    return this.lastPage;
                }

                var current = this.currentPage;
                var last = this.lastPage;
                var delta = this.limit;
                var left = current - delta;
                var right = current + delta + 1;
                var range = [];
                var pages = [];
                var l;

                for (var i = 1; i <= last; i++) {
                    if (i === 1 || i === last || (i >= left && i < right)) {
                        range.push(i);
                    }
                }

                range.forEach(function (i) {
                    if (l) {
                        if (i - l === 2) {
                            // pages.push(l + 1);
                            pages.push('...');
                        } else if (i - l !== 1) {
                            pages.push('...');
                        }
                    }
                    pages.push(i);
                    l = i;
                });

                return pages;
            }
        },
        methods: {
            changePage(page) {
                if (page === '...') {
                    return;
                }
                this.$emit("change-page", page);
            },
            previousPage() {
                this.changePage((this.currentPage - 1));
            },
            nextPage() {
                this.changePage((this.currentPage + 1));
            },
        }
    }
</script>

<style scoped>

</style>
