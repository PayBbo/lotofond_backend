<template>
    <bkt-modal :id="'messagePageModal'" :title="''" modal_class="bkt-filters-modal" no_footer
    >
        <template #body>
            <div v-if="!loading" class="bkt-page mx-0">
                <div v-html="page"></div>
            </div>
            <div v-if="loading" class="d-flex w-100 justify-content-center my-5">
                <slot name="loading">
                    <div
                        style="color: #2953ff;border-width: 2px;"
                        class="spinner-border"
                        role="status"
                    ></div>
                </slot>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "MessagePageModal",
        // props:['url'],
        data() {
            return {
                guid: '',
                page: '',
                loading: false,
            }
        },
        mounted() {

        },
        methods: {
            setGuid(value) {
                this.guid = value;
                this.getPage();
            },
            getPage() {
                this.loading = true;
                this.$store.dispatch('getDebtorMessagePage', this.guid)
                    .then(resp => {
                        this.page = resp.data.html;
                        this.loading = false;
                    }).catch(error => {
                    this.loading = false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
