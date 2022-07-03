<template>
    <bkt-modal :id="'paramsModal'" title="Выберите основные параметры" modal_class="bkt-filters-modal"
               @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body>
            <div class="bkt-form wide w-100 mx-auto align-items-start">
                <div class="col-12">
                    <bkt-input v-model="filter.excludedWords"
                               type="text"
                               field_name="'Cлова-исключения'"
                               label="cлова-исключения"
                               label_class="bkt-form__label"
                               name="exception_words" icon_name="Check"
                               :group_item_class="filter.excludedWords ? 'bkt-bg-green': 'bkt-bg-white'"
                               :icon_color="filter.excludedWords ? 'white': 'main-lighter'"
                    >
                    </bkt-input>
                </div>
                <div class="col-12">
                    <!--                    <div class="bkt-form m-0">-->
                    <!--                        <div class="col-lg-8 col-12 p-0">-->
                    <bkt-select
                        v-model="filter.tradePlaces"
                        multiple
                        name="tradePlaces"
                        label="выбранные площадки"
                        label_class="bkt-form__label"
                        :option_label="'name'"
                        :options="trade_places"
                        :pagination="trade_places_pagination"
                        :reduce="item => item.id"
                        :method_name="'getTradePlaces'"
                    ></bkt-select>
                    <!--                    <h5 class="bkt-form__label bkt-text-neutral-dark">выбранные площадки</h5>-->

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
                <div class="col-12 p-0">
                    <div class="bkt-form m-0">
                        <div class="col-12 col-lg-2">
                            <h5 class="bkt-form__label">вид торгов</h5>
                        </div>
                        <div class="col-12 col-lg-10">
                            <div class="bkt-form bkt-wrapper bkt-auctions-types">
                                <div class="bkt-auctions-type" v-for="item in auctionTypes">
                                    <button class="bkt-auctions-type__card bkt-auctions-type__title bkt-bg-body"
                                            @click="filter.tradeType=item.title"
                                            :class="[filter.tradeType===item.title ? 'bkt-border-primary': 'bkt-border-body']">
                                        {{item.description}}
                                    </button>
                                    <h6 class="bkt-auctions-type__subtitle">что это?</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "RatingModal"
    }
</script>

<style scoped>

</style>
