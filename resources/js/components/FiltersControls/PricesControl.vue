<template>
    <div class="bkt-form mx-auto align-items-center">
        <div class="col-12 col-lg-3 p-0">
            <h5 class="bkt-form__label">начальная цена, ₽</h5>
        </div>
        <div class="col-12 col-lg-9 m-0">
            <div class="bkt-form">
                <div class="col-12 col-lg-6">
                    <bkt-input v-model="model.startPrice.min"
                               type="number"
                               field_name="'Начальная цена от'"
                               name="startPriceMin" icon_name="Check"
                               :group_item_class="model.startPrice.min ? 'bkt-bg-green': 'bkt-bg-white'"
                               :icon_color="model.startPrice.min ? 'white': 'main-lighter'"
                    >
                        <template #group-text>
                            от
                        </template>
                    </bkt-input>
                </div>
                <div class="col-12 col-lg-6">
                    <bkt-input v-model="model.startPrice.max"
                               type="number"
                               field_name="'Начальная цена до'"
                               name="startPriceMax" icon_name="Check"
                               :group_item_class="model.startPrice.max ? 'bkt-bg-green': 'bkt-bg-white'"
                               :icon_color="model.startPrice.max ? 'white': 'main-lighter'"
                    >
                        <template #group-text>
                            до
                        </template>
                    </bkt-input>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-3 p-0">
            <h5 class="bkt-form__label">текущая цена, ₽</h5>
        </div>
        <div class="col-12 col-lg-9 m-0">
            <div class="bkt-form">
                <div class="col-12 col-lg-6">
                    <bkt-input v-model="model.currentPrice.min"
                               type="number"
                               field_name="'Текущая цена от'"
                               name="currentPriceMin" icon_name="Check"
                               :group_item_class="model.currentPrice.min ? 'bkt-bg-green': 'bkt-bg-white'"
                               :icon_color="model.currentPrice.min ? 'white': 'main-lighter'"
                    >
                        <template #group-text>
                            от
                        </template>
                    </bkt-input>
                </div>
                <div class="col-12 col-lg-6">
                    <bkt-input v-model="model.currentPrice.max"
                               type="number"
                               field_name="'Текущая цена до'"
                               name="currentPriceMax" icon_name="Check"
                               :group_item_class="model.currentPrice.max ? 'bkt-bg-green': 'bkt-bg-white'"
                               :icon_color="model.currentPrice.max ? 'white': 'main-lighter'"
                    >
                        <template #group-text>
                            до
                        </template>
                    </bkt-input>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-3 p-0">
            <h5 class="bkt-form__label">минимальная цена, ₽</h5>
        </div>
        <div class="col-12 col-lg-9 m-0">
            <div class="bkt-form">
                <div class="col-12 col-lg-6">
                    <bkt-input v-model="model.minPrice.min"
                               type="number"
                               field_name="'Минимальная цена от'"
                               name="minPriceMin" icon_name="Check"
                               :group_item_class="model.minPrice.min ? 'bkt-bg-green': 'bkt-bg-white'"
                               :icon_color="model.minPrice.min ? 'white': 'main-lighter'"
                    >
                        <template #group-text>
                            от
                        </template>
                    </bkt-input>
                </div>
                <div class="col-12 col-lg-6">
                    <bkt-input v-model="model.minPrice.max"
                               field_name="'Минимальная цена до'"
                               name="minPriceMax" icon_name="Check"
                               :group_item_class="model.minPrice.max ? 'bkt-bg-green': 'bkt-bg-white'"
                               :icon_color="model.minPrice.max ? 'white': 'main-lighter'"
                    >
                        <template #group-text>
                            до
                        </template>
                    </bkt-input>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-3 p-0">
            <h5 class="bkt-form__label">процент снижения, %</h5>
        </div>
        <div class="col-12 col-lg-9 m-0">
            <div class="bkt-form">
                <div class="col-12 col-lg-6">
                    <bkt-input v-model="model.percentageReduction.min"
                               field_name="'Процент снижения от'"
                               name="percentageReductionMin" icon_name="Check"
                               :group_item_class="model.percentageReduction.min ? 'bkt-bg-green': 'bkt-bg-white'"
                               :icon_color="model.percentageReduction.min ? 'white': 'main-lighter'"
                    >
                        <template #group-text>
                            от
                        </template>
                    </bkt-input>
                </div>
                <div class="col-12 col-lg-6">
                    <bkt-input v-model="model.percentageReduction.max"
                               field_name="'Процент снижения до'"
                               name="percentageReductionMax" icon_name="Check"
                               :group_item_class="model.percentageReduction.max ? 'bkt-bg-green': 'bkt-bg-white'"
                               :icon_color="model.percentageReduction.max ? 'white': 'main-lighter'"
                    >
                        <template #group-text>
                            до
                        </template>
                    </bkt-input>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PricesControl",
        props: {
            value: {
                type: null,
                default: false,
            },
        },
        model: {
            prop: 'value',
            event: 'input'
        },
        data() {
            return {
                loading: false,
                model: {
                    currentPrice: {
                        min: '',
                        max: ''
                    },
                    startPrice: {
                        min: '',
                        max: ''
                    },
                    minPrice: {
                        min: '',
                        max: ''
                    },
                    percentageReduction: {
                        min: '',
                        max: ''
                    }
                },
            }
        },
        created() {
            this.getData();
        },
        mounted() {
            this.model = this.value;
        },
        computed: {
            filters_prices() {
                return this.$store.getters.filters_data.prices;
            },
        },
        methods: {
            saveValue() {
                this.$emit('input', this.model);
            },
            async getData() {
                this.loading = true;
                await this.$store.dispatch('getFiltersPrices')
                    .then(resp => {
                        this.loading = false;
                    }).catch(error => {
                        this.loading = false;
                    });
            },
        },
    }
</script>

<style scoped>

</style>
