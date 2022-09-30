<template>
    <div class="bkt-form wide w-100 mx-auto align-items-start">
        <div class="col-12">
            <bkt-input v-model="model.includedWords"
                       type="text"
                       field_name="'Ключевые слова'"
                       label="ключевые слова"
                       label_class="bkt-form__label"
                       name="includedWords" icon_name="Check"
                       :group_item_class="model.includedWords ? 'bkt-bg-green': 'bkt-bg-white'"
                       :icon_color="model.includedWords ? 'white': 'main-lighter'"
                       @input="saveValue"
            >
            </bkt-input>
        </div>
        <div class="col-12">
            <bkt-input v-model="model.excludedWords"
                       type="text"
                       field_name="'Cлова-исключения'"
                       label="cлова-исключения"
                       label_class="bkt-form__label"
                       name="exception_words" icon_name="Check"
                       :group_item_class="model.excludedWords ? 'bkt-bg-green': 'bkt-bg-white'"
                       :icon_color="model.excludedWords ? 'white': 'main-lighter'"
                       @input="saveValue"
            >
            </bkt-input>
        </div>
<!--        <div class="col-12">-->
<!--            &lt;!&ndash;                    <div class="bkt-form m-0">&ndash;&gt;-->
<!--            &lt;!&ndash;                        <div class="col-lg-8 col-12 p-0">&ndash;&gt;-->
<!--            <bkt-select-->
<!--                v-model="model.tradePlaces"-->
<!--                multiple-->
<!--                name="tradePlaces"-->
<!--                label="торговые площадки"-->
<!--                label_class="bkt-form__label"-->
<!--                :option_label="'name'"-->
<!--                :options="trade_places"-->
<!--                :pagination="trade_places_pagination"-->
<!--                :reduce="item => item.id"-->
<!--                :method_name="'getTradePlaces'"-->
<!--                :searchable="true"-->
<!--                :loading="trade_places_loading"-->
<!--                @input="saveValue"-->
<!--            >-->
<!--            </bkt-select>-->
<!--            &lt;!&ndash;            <bkt-select name="tradePlaces"&ndash;&gt;-->
<!--            &lt;!&ndash;                        label="торговые площадки"&ndash;&gt;-->
<!--            &lt;!&ndash;                        label_class="bkt-form__label"&ndash;&gt;-->
<!--            &lt;!&ndash;                        v-model="current_platform"&ndash;&gt;-->
<!--            &lt;!&ndash;                        :options="trade_places"&ndash;&gt;-->
<!--            &lt;!&ndash;                        :option_label="'name'"&ndash;&gt;-->
<!--            &lt;!&ndash;                        :pagination="trade_places_pagination"&ndash;&gt;-->
<!--            &lt;!&ndash;                        :method_name="'getTradePlaces'"&ndash;&gt;-->
<!--            &lt;!&ndash;            >&ndash;&gt;-->
<!--            &lt;!&ndash;            </bkt-select>&ndash;&gt;-->

<!--            &lt;!&ndash;            <h5 class="bkt-form__label">выбранные площадки</h5>&ndash;&gt;-->
<!--            &lt;!&ndash;            <div class="bkt-tag__list">&ndash;&gt;-->
<!--            &lt;!&ndash;                <div class="bkt-tag justify-content-between flex-fill"&ndash;&gt;-->
<!--            &lt;!&ndash;                     v-for="(item, index) in selected_trade_places">&ndash;&gt;-->
<!--            &lt;!&ndash;                    <span class="bkt-item-rounded__text mr-2">{{ item.name }}</span>&ndash;&gt;-->
<!--            &lt;!&ndash;                    <span class="bkt-tag__icon bkt-cursor-pointer" @click="removeTradePlace(item.id)">&ndash;&gt;-->
<!--            &lt;!&ndash;                        <bkt-icon name="Cancel" color="red"></bkt-icon>&ndash;&gt;-->
<!--            &lt;!&ndash;                    </span>&ndash;&gt;-->
<!--            &lt;!&ndash;                </div>&ndash;&gt;-->
<!--            &lt;!&ndash;            </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                        </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                        <div class="col-12 col-lg-4 p-0">&ndash;&gt;-->
<!--            &lt;!&ndash;                            <div class="bkt-check__list">&ndash;&gt;-->
<!--            &lt;!&ndash;                                <div class="bkt-check__wrapper">&ndash;&gt;-->
<!--            &lt;!&ndash;                                    <div class="bkt-check">&ndash;&gt;-->
<!--            &lt;!&ndash;                                        <div class="bkt-check__input">&ndash;&gt;-->
<!--            &lt;!&ndash;                                            <input class="" type="checkbox">&ndash;&gt;-->
<!--            &lt;!&ndash;                                            <div class="bkt-check__input-check"></div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                        </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                        <label class="bkt-check__label">&ndash;&gt;-->
<!--            &lt;!&ndash;                                            Банкротство&ndash;&gt;-->
<!--            &lt;!&ndash;                                        </label>&ndash;&gt;-->
<!--            &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                <div class="bkt-check__wrapper">&ndash;&gt;-->
<!--            &lt;!&ndash;                                    <div class="bkt-check">&ndash;&gt;-->
<!--            &lt;!&ndash;                                        <div class="bkt-check__input">&ndash;&gt;-->
<!--            &lt;!&ndash;                                            <input class="" type="checkbox">&ndash;&gt;-->
<!--            &lt;!&ndash;                                            <div class="bkt-check__input-check"></div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                        </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                        <label class="bkt-check__label">&ndash;&gt;-->
<!--            &lt;!&ndash;                                            TorgiGov&ndash;&gt;-->
<!--            &lt;!&ndash;                                        </label>&ndash;&gt;-->
<!--            &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                <div class="bkt-check__wrapper">&ndash;&gt;-->
<!--            &lt;!&ndash;                                    <div class="bkt-check">&ndash;&gt;-->
<!--            &lt;!&ndash;                                        <div class="bkt-check__input">&ndash;&gt;-->
<!--            &lt;!&ndash;                                            <input class="" type="checkbox">&ndash;&gt;-->
<!--            &lt;!&ndash;                                            <div class="bkt-check__input-check"></div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                        </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                        <label class="bkt-check__label">&ndash;&gt;-->
<!--            &lt;!&ndash;                                            Залоговое&ndash;&gt;-->
<!--            &lt;!&ndash;                                        </label>&ndash;&gt;-->
<!--            &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                <div class="bkt-check__wrapper">&ndash;&gt;-->
<!--            &lt;!&ndash;                                    <div class="bkt-check">&ndash;&gt;-->
<!--            &lt;!&ndash;                                        <div class="bkt-check__input">&ndash;&gt;-->
<!--            &lt;!&ndash;                                            <input class="" type="checkbox">&ndash;&gt;-->
<!--            &lt;!&ndash;                                            <div class="bkt-check__input-check"></div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                        </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                        <label class="bkt-check__label">&ndash;&gt;-->
<!--            &lt;!&ndash;                                            Коммерческое&ndash;&gt;-->
<!--            &lt;!&ndash;                                        </label>&ndash;&gt;-->
<!--            &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                                </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                            </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                        </div>&ndash;&gt;-->
<!--            &lt;!&ndash;                    </div>&ndash;&gt;-->
<!--        </div>-->
<!--        <div class="col-12 p-0">-->
<!--            <div class="bkt-form m-0">-->
<!--                <div class="col-12">-->
<!--                    <h5 class="bkt-form__label">вид торгов</h5>-->
<!--                </div>-->
<!--                <div class="col-12">-->
<!--                    <div class="bkt-form bkt-wrapper bkt-auctions-types">-->
<!--                        <div class="bkt-auctions-type flex-fill" v-for="item in auctionTypes">-->
<!--                            <button class="bkt-auctions-type__card bkt-auctions-type__title bkt-bg-body"-->
<!--                                    @click="toggleAuctionType(item.title)"-->
<!--                                    :class="[model.tradeTypes.includes(item.title) ? 'bkt-border-primary': 'bkt-border-body']">-->
<!--                                {{item.description}}-->
<!--                            </button>-->
<!--                            &lt;!&ndash;                            <h6 class="bkt-auctions-type__subtitle">что это?</h6>&ndash;&gt;-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</template>

<script>
    export default {
        name: "ParamsControl",
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
                selected_trade_places: [],
                model: {
                    excludedWords: '',
                    includedWords: '',
                    tradePlaces: [],
                    tradeType: '',
                    tradeTypes: [],
                },
            };
        },
        mounted() {
            this.model = this.value;
        },
        computed: {
            current_platform: {
                get: function () {
                    return null;
                },
                set: function (newValue) {
                    // let removeIndex = this.trade_places
                    //     .map(item => item.code)
                    //     .indexOf(newValue.code);
                    // this.trade_places.splice(removeIndex, 1);
                    let index = this.selected_trade_places.map(item => item.id)
                        .indexOf(newValue.id);
                    if (index < 0) {
                        this.selected_trade_places.push(newValue);
                        this.model.tradePlaces.push(newValue.id);
                    }

                }
            },
            trade_places() {
                return this.$store.getters.trade_places
            },
            trade_places_pagination() {
                return this.$store.getters.trade_places_pagination
            },
            trade_places_loading() {
                return this.$store.getters.trade_places_loading
            },
        },
        watch: {
            value: function () {
                this.model = this.value;
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
                let item_index = this.model.tradeTypes.findIndex(el => el == title);
                if (item_index < 0) {
                    this.model.tradeTypes.push(title);
                } else {
                    this.model.tradeTypes.splice(item_index, 1);
                }
                // this.saveValue();
            },
            removeTradePlace(id) {
                let item_index = this.selected_trade_places.findIndex(el => el.id == id);
                if (item_index >= 0) {
                    this.selected_trade_places.splice(item_index, 1);
                }
                item_index = this.model.tradePlaces.findIndex(el => el == id);
                if (item_index >= 0) {
                    this.model.tradePlaces.splice(item_index, 1);
                }
            }
        }
    }
</script>

<style scoped>

</style>
