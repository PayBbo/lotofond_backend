<template>
    <div class="bkt-wrapper-column bkt-lot__cards w-100" v-if="!loading">
        <bkt-collapse v-for="(item, index) in list" :key="index"
            :title="item.tradeSubject ? item.tradeSubject : 'Объект № '+(index+1)" :id="'object'+index" :loading="loading"
            :disabled="loading" collapse_button_class="bkt-bg-body flex-shrink-0"
            title_class="bkt-collapse__title bkt-text-truncate" class="bkt-lot__collapse"
            :collapse_class="list.length===1 ? 'show bkt-gap bkt-wrapper-column' : 'bkt-gap bkt-wrapper-column'"
        >
            <template #collapse>
                <ul class="bkt-contents">
<!--                    <li v-if="item.tradeSubject">-->
<!--                        <div class="bkt-contents__heading">-->
<!--                            <span class="bkt-contents__heading text-lowercase">-->
<!--                                объект-->
<!--                            </span>-->
<!--                        </div>-->
<!--                        <div class="bkt-contents__answer">-->
<!--                            <span>{{item.tradeSubject}}</span>-->
<!--                        </div>-->
<!--                    </li>-->
                    <li v-if="item.type">
                        <div class="bkt-contents__heading">
                        <span class="bkt-contents__heading text-lowercase">
                           тип объекта
                        </span>
                        </div>
                        <div class="bkt-contents__answer">
                            <span>{{$t('trades.tradeSubjectType.'+item.type)}}</span>
                        </div>
                    </li>
                    <template v-if="item.extracts.length>0" v-for="extract in item.extracts">
                        <li v-if="extract.value && extract.value != 0">
                            <div class="bkt-contents__heading">
                                <span class="bkt-contents__heading text-lowercase">{{extract.title}}</span>
                            </div>
                            <div class="bkt-contents__answer"><span>{{extract.value}}</span>
                            </div>
                        </li>
                    </template>
                </ul>
                <div class="bkt-row outline bkt-wrapper-between align-items-center"
                     v-if="item.cadastralData && item.cadastralData.cadastralDataArea">
                    <div class="bkt-row__feature">
                        <h4 class="bkt-row__feature-title">{{item.cadastralData.cadastralDataArea | priceFormat}}
                            {{item.cadastralData.cadastralDataAreaMeasure}}
                        </h4>
                        <h6 class="bkt-row__feature-subtitle text-lowercase">
                            {{$t('trades.tradeSubjectType.'+item.cadastralData.cadastralDataAreaType)}}
                        </h6>
                    </div>
                    <span class="bkt-row__icon"><bkt-icon :name="'Tree'"></bkt-icon></span>
                </div>
                <div class="bkt-row outline bkt-wrapper-between align-items-center"
                     v-if="item.cadastralData && item.cadastralData.cadastralDataPrice">
                    <div class="bkt-row__feature">
                        <h4 class="bkt-row__feature-title">
                            {{item.cadastralData.cadastralDataPrice | priceFormat}} ₽
                        </h4>
                        <h6 class="bkt-row__feature-subtitle">кадастровая стоимость</h6>
                    </div>
                    <span class="bkt-row__icon"><bkt-icon :name="'File'"></bkt-icon></span>
                </div>
                <div class="bkt-row outline bkt-wrapper-between align-items-center"
                     v-if="item.cadastralData && item.cadastralData.cadastralDataFractionalOwnership">
                    <div class="bkt-row__feature">
                        <h4 class="bkt-row__feature-title">
                            {{item.cadastralData.cadastralDataFractionalOwnership}}%</h4>
                        <h6 class="bkt-row__feature-subtitle">доля в собственности</h6>
                    </div>
                    <span class="bkt-row__icon"><bkt-icon :name="'Pie'"></bkt-icon></span>
                </div>
            </template>
        </bkt-collapse>
    </div>
</template>

<script>
    export default {
        name: "ObjectsList",
        props:{
            loading: {
                default: false
            },
            items: {
                default: function () {
                    return [];
                }
            }
        },
        computed: {
            list() {
                let list = JSON.parse(JSON.stringify(this.items));
                if (list && list.length > 0) {
                    list.forEach( item => {
                        let extracts = item.extracts;
                        let cadastralData = {};
                        let index = extracts.findIndex(el => el.type == 'cadastralDataPrice');
                        if (index >= 0) {
                            cadastralData.cadastralDataPrice = extracts[index].value;
                            extracts.splice(index, 1);
                        }
                        index = extracts.findIndex(el => el.type == 'cadastralDataArea');
                        if (index >= 0) {
                            cadastralData.cadastralDataAreaType = item.type;
                            cadastralData.cadastralDataArea = extracts[index].value;
                            if (extracts[index].value <= 100) {
                                cadastralData.cadastralDataAreaMeasure = 'кв. м.';
                            } else if (extracts[index].value > 100 && extracts[index].value <= 10000) {
                                cadastralData.cadastralDataArea = extracts[index].value / 100;
                                // cadastralData.cadastralDataAreaMeasure = 'сотки';
                                cadastralData.cadastralDataAreaMeasure = this.$tc('trades.ar', this.pluralization(cadastralData.cadastralDataArea));

                            } else {
                                cadastralData.cadastralDataArea = extracts[index].value / 10000;
                                cadastralData.cadastralDataAreaMeasure = 'га';
                            }
                            extracts.splice(index, 1);
                        }
                        index = extracts.findIndex(el => el.type == 'cadastralDataFractionalOwnership');
                        if (index >= 0) {
                            cadastralData.cadastralDataFractionalOwnership = extracts[index].value;
                            extracts.splice(index, 1);
                        }
                        item.cadastralData = cadastralData;
                    })
                }
                return list;
            },
        },
        methods: {
            pluralization(choice, choicesLength=4) {
                if (choice === 0) {
                    return 0
                }

                const teen = choice > 10 && choice < 20
                const endsWithOne = choice % 10 === 1
                if (!teen && endsWithOne) {
                    return 1
                }
                if (!teen && choice % 10 >= 2 && choice % 10 <= 4) {
                    return 2
                }
                //0 соток | {n} сотка | {n} сотки | {n} соток
                return choicesLength < 4 ? 2 : 3
            },
        }
    }
</script>

<style scoped>

</style>
