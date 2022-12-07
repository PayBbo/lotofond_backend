<template>
    <div class="bkt-form wide w-100 mx-auto align-items-start">
        <div class="col-12">
            <!--                    <div class="bkt-form m-0">-->
            <!--                        <div class="col-lg-8 col-12 p-0">-->
            <bkt-select
                v-model="model"
                multiple
                name="tradePlaces"
                label="торговые площадки"
                label_class="bkt-form__label"
                :option_label="'name'"
                :options="trade_places"
                :reduce="item => item.id"
                :method_name="'getFiltersTradePlaces'"
                :searchable="true"
                @input="saveValue"
            >
            </bkt-select>
            <!--            <bkt-select name="tradePlaces"-->
            <!--                        label="торговые площадки"-->
            <!--                        label_class="bkt-form__label"-->
            <!--                        v-model="current_platform"-->
            <!--                        :options="trade_places"-->
            <!--                        :option_label="'name'"-->
            <!--                        :pagination="trade_places_pagination"-->
            <!--                        :method_name="'getTradePlaces'"-->
            <!--            >-->
            <!--            </bkt-select>-->

            <!--            <h5 class="bkt-form__label">выбранные площадки</h5>-->
            <!--            <div class="bkt-tag__list">-->
            <!--                <div class="bkt-tag justify-content-between flex-fill"-->
            <!--                     v-for="(item, index) in selected_trade_places">-->
            <!--                    <span class="bkt-item-rounded__text mr-2">{{ item.name }}</span>-->
            <!--                    <span class="bkt-tag__icon bkt-cursor-pointer" @click="removeTradePlace(item.id)">-->
            <!--                        <bkt-icon name="Cancel" color="red"></bkt-icon>-->
            <!--                    </span>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--                        </div>-->
            <!--                        <div class="col-12 col-lg-4 p-0">-->
            <!--                            <div class="bkt-check__list">-->
            <!--                                <div class="bkt-check__wrapper">-->
            <!--                                    <div class="bkt-check">-->
            <!--                                        <div class="bkt-check__input">-->
            <!--                                            <input class="" type="checkbox">-->
            <!--                                            <div class="bkt-check__input-check"></div>-->
            <!--                                        </div>-->
            <!--                                        <label class="bkt-check__label">-->
            <!--                                            Банкротство-->
            <!--                                        </label>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                                <div class="bkt-check__wrapper">-->
            <!--                                    <div class="bkt-check">-->
            <!--                                        <div class="bkt-check__input">-->
            <!--                                            <input class="" type="checkbox">-->
            <!--                                            <div class="bkt-check__input-check"></div>-->
            <!--                                        </div>-->
            <!--                                        <label class="bkt-check__label">-->
            <!--                                            TorgiGov-->
            <!--                                        </label>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                                <div class="bkt-check__wrapper">-->
            <!--                                    <div class="bkt-check">-->
            <!--                                        <div class="bkt-check__input">-->
            <!--                                            <input class="" type="checkbox">-->
            <!--                                            <div class="bkt-check__input-check"></div>-->
            <!--                                        </div>-->
            <!--                                        <label class="bkt-check__label">-->
            <!--                                            Залоговое-->
            <!--                                        </label>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                                <div class="bkt-check__wrapper">-->
            <!--                                    <div class="bkt-check">-->
            <!--                                        <div class="bkt-check__input">-->
            <!--                                            <input class="" type="checkbox">-->
            <!--                                            <div class="bkt-check__input-check"></div>-->
            <!--                                        </div>-->
            <!--                                        <label class="bkt-check__label">-->
            <!--                                            Коммерческое-->
            <!--                                        </label>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
        </div>
    </div>
</template>

<script>
    export default {
        name: "TradePlacesControl",
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
                selected_trade_places: [],
                model: [],
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
                        this.model.push(newValue.id);
                    }

                }
            },
            trade_places() {
                return this.$store.getters.filters_data.tradePlaces.data
            },
            trade_places_pagination() {
                return this.$store.getters.trade_places_pagination
            },
            trade_places_loading() {
                return this.$store.getters.filters_data.tradePlaces.loading
            },
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
            removeTradePlace(id) {
                let item_index = this.selected_trade_places.findIndex(el => el.id == id);
                if (item_index >= 0) {
                    this.selected_trade_places.splice(item_index, 1);
                }
                item_index = this.model.findIndex(el => el == id);
                if (item_index >= 0) {
                    this.model.splice(item_index, 1);
                }
            }
        }
    }
</script>

<style scoped>

</style>
