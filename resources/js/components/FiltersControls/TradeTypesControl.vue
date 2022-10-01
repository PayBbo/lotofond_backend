<template>
    <div class="bkt-form wide w-100 mx-auto align-items-start">
        <div class="col-12 p-0">
            <div class="bkt-form m-0">
                <div class="col-12">
                    <h5 class="bkt-form__label">вид торгов</h5>
                </div>
                <div class="col-12">
                    <div class="bkt-form bkt-wrapper bkt-auctions-types">
                        <div class="bkt-auctions-type flex-fill" v-for="item in auctionTypes">
                            <button class="bkt-auctions-type__card bkt-auctions-type__title bkt-bg-body"
                                    @click="toggleAuctionType(item.title)"
                                    :class="[model.includes(item.title) ? 'bkt-border-primary': 'bkt-border-body']">
                                {{item.description}}
                            </button>
                            <!--                            <h6 class="bkt-auctions-type__subtitle">что это?</h6>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TradeTypesControl",
        props: {
            value: {
                type: null,
            },
        },
        model: {
            prop: 'value',
            event: 'input'
        },
        data() {
            return {
                loading: false,
                auctionTypes: [
                    {description: 'Открытый аукцион', title: 'OpenAuction'},
                    {description: 'Открытый конкурс', title: 'OpenConcours'},
                    {description: 'Публичное предложение', title: 'PublicOffer'},
                    {description: 'Закрытый аукцион', title: 'CloseAuction'},
                    {description: 'Закрытый конкурс', title: 'CloseConcours'},
                    {description: 'Закрытое публичное предложение', title: 'ClosePublicOffer'},
                ],
                model: [],
            };
        },
        mounted() {
            this.model = this.value;
        },
        watch: {
            value: function (newValue, oldValue) {
                this.model = newValue;
                this.saveValue()
            },
        },
        methods: {
            saveValue() {
                this.$emit('input', this.model);
            },
            chooseAuctionType(title) {
                this.model.tradeType = title
            },
            toggleAuctionType(title) {
                let item_index = this.model.findIndex(el => el == title);
                if (item_index < 0) {
                    this.model.push(title);
                } else {
                    this.model.splice(item_index, 1);
                }
                this.saveValue();
            },
        }
    }
</script>

<style scoped>

</style>
