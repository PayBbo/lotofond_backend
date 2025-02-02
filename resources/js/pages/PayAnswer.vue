<template>
    <div class="bkt-page bkt-container">
        <div class="bkt-card">
            <div class="bkt-card__body align-items-center text-center bkt-gap-medium" v-if="!loading">
                <bkt-icon name="Check" height="100px" width="100px" color="green"
                          v-if="status==='Authorized' || status==='Settled'"/>
                <bkt-icon name="Cancel" height="100px" width="100px" color="red"
                          v-if="status==='Cancelled' || status==='Rejected'"/>
                <bkt-icon name="Clock" height="100px" width="100px" color="yellow"
                          v-if="status==='Confirmation' || status==='Pending'"/>
                <h2 class="bkt-card__title"
                    :class="{ 'bkt-text-green' : status==='Authorized' || status==='Settled',
                    'bkt-text-red': status==='Cancelled' || status==='Rejected',
                    'bkt-text-yellow' : status==='Confirmation' || status==='Pending'}"
                >
                    {{ $t('payments.' + status)}}
                </h2>
                <a class="bkt-button green" :href="'/'+type">На главную</a>
            </div>
            <div class="bkt-card__body align-items-center text-center bkt-gap-medium" v-if="loading">
                <skeleton type_name="item" height="100px" width="100px"></skeleton>
                <skeleton type_name="text" height="30px" width="260px"></skeleton>
                <skeleton type_name="button" skeleton_class="bkt-button" width="140px"></skeleton>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PayAnswer",
        props: {
          type: {
              type:String,
              default:''
          }
        },
        data() {
            return {
                loading: false,
                status: '',
            }
        },
        mounted() {
            this.checkStatus();
        },
        methods: {
            checkStatus() {
                this.loading = true;
                axios.post('/api/payment/check/status', {paymentId: this.$route.params.id})
                    .then( resp => {
                        this.status = resp.data.status;
                        this.loading = false;
                }).catch(error => {
                    this.status = 'error';
                    this.loading = false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
