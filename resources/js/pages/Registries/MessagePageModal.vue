<template>
    <bkt-modal :id="'messagePageModal'" :title="''" modal_class="bkt-filters-modal" no_footer
    >
        <template #body>
            <div class="bkt-message-page">
                <div v-if="!loading" v-html="page"></div>
                <div v-if="loading" class="d-flex w-100 justify-content-center">
                    <div
                        style="color: #2953ff;border-width: 2px;"
                        class="spinner-border"
                        role="status"
                    ></div>
                </div>
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
                        this.page = resp.data;
                        this.loading = false;
                        console.log('here')
                        this.$nextTick(() => {
                            console.log('here next')
                            const boxes = document.querySelector('.lotInfoTable');
                            console.log(boxes, boxes.childNodes[0], boxes.childNodes[0].childNodes[0])
                            const ths = boxes.childNodes[0].childNodes[0].childNodes
                            console.log(ths)
                            let ths_labels = Array.prototype.map.call(ths,
                                element => element.innerText
                                // ({
                                //     height: element.offsetTop,
                                //     bgsrc: element.dataset.bgsrc,
                                //     bgcolor: element.dataset.bgcolor,
                                //     size: element.dataset.size,
                                //     name: element.id,
                                //     image: parseInt(element.dataset.image)
                                // })
                            );
                            boxes.childNodes[0].childNodes.forEach(tr => {
                                tr.childNodes.forEach((td, index) => {
                                    td.setAttribute('data-label', ths_labels[index]);
                                });
                            });
                        })

                    }).catch(error => {
                    this.loading = false;
                })
            }
        }
    }
</script>

<style scoped lang="scss">
</style>
