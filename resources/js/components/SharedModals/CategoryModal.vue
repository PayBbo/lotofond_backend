<template>
    <bkt-modal :id="'categoryModal'" ref="categoryModal" :title="'Выберите нужные категории'"
               modal_class="bkt-category-modal bkt-region-modal" @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body>
            <div class="bkt-wrapper-column bkt-gap-large" v-if="!loading">
                <bkt-categories-control v-model="result"></bkt-categories-control>
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

<!--            <div class="bkt-categories__grid">-->
<!--                <template v-for="category in items">-->
<!--                    <div class="bkt-categories__grid-item">-->
<!--                        <div class="bkt-category__card">-->
<!--                            <div class="bkt-category__card-header">-->
<!--                                <div class="bkt-card__category bkt-bg-yellow-lighter">-->
<!--                                    <div class="bkt-card__category-icon">-->
<!--                                        <bkt-icon name="Wrench" color="yellow"></bkt-icon>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <h5 class="bkt-card__title">{{category.label}}</h5>-->
<!--                            </div>-->
<!--                            <div class="bkt-category__card-body" v-if="category.subcategories.length>0">-->
<!--                                <template v-for="subcategory in category.subcategories">-->
<!--                                    <button class="bkt-category__card-item bkt-bg-body"-->
<!--                                            @click="toggleCategory(subcategory.key)"-->
<!--                                            :class="[include(subcategory.key) ? 'bkt-border-primary': 'bkt-border-body']">-->
<!--                                        {{subcategory.label}}-->
<!--                                    </button>-->
<!--                                </template>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </template>-->
                <!--                <div class="bkt-categories__grid-item bkt-categories__item-1">-->
                <!--                    <div class="bkt-category__card">-->
                <!--                        <div class="bkt-category__card-header">-->
                <!--                            <div class="bkt-card__category bkt-bg-orange-lighter">-->
                <!--                                <div class="bkt-card__category-icon">-->
                <!--                                    <bkt-icon name="Car" color="orange"></bkt-icon>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <h5 class="bkt-card__title">Транспорт и техника</h5>-->
                <!--                        </div>-->
                <!--                        <div class="bkt-category__card-body">-->
                <!--                            <button class="bkt-category__card-item bkt-bg-body"-->
                <!--                                    @click="toggleCategory('specialEquipment')"-->
                <!--                                    :class="[include('specialEquipment') ? 'bkt-border-primary': 'bkt-border-body']">-->
                <!--                                {{$t('categories.specialEquipment')}}-->
                <!--                            </button>-->
                <!--                            <button class="bkt-category__card-item bkt-bg-body"-->
                <!--                                    @click="toggleCategory('passengerTransport')"-->
                <!--                                    :class="[include('passengerTransport') ? 'bkt-border-primary': 'bkt-border-body']">-->
                <!--                                {{$t('categories.passengerTransport')}}-->
                <!--                            </button>-->
                <!--                            <button class="bkt-category__card-item bkt-bg-body"-->
                <!--                                    @click="toggleCategory('freightTransport')"-->
                <!--                                    :class="[include('freightTransport') ? 'bkt-border-primary': 'bkt-border-body']">-->
                <!--                                {{$t('categories.freightTransport')}}-->
                <!--                            </button>-->
                <!--                            <button class="bkt-category__card-item bkt-bg-body"-->
                <!--                                    @click="toggleCategory('mototechnics')"-->
                <!--                                    :class="[include('mototechnics') ? 'bkt-border-primary': 'bkt-border-body']">-->
                <!--                                {{$t('categories.mototechnics')}}-->
                <!--                            </button>-->
                <!--                            <button class="bkt-category__card-item bkt-bg-body"-->
                <!--                                    @click="toggleCategory('airTransport')"-->
                <!--                                    :class="[include('airTransport') ? 'bkt-border-primary': 'bkt-border-body']">-->
                <!--                                {{$t('categories.airTransport')}}-->
                <!--                            </button>-->
                <!--                            <button class="bkt-category__card-item bkt-bg-body"-->
                <!--                                    @click="toggleCategory('waterTransport')"-->
                <!--                                    :class="[include('waterTransport') ? 'bkt-border-primary': 'bkt-border-body']">-->
                <!--                                {{$t('categories.waterTransport')}}-->
                <!--                            </button>-->
                <!--                            <button class="bkt-category__card-item bkt-bg-body"-->
                <!--                                    @click="toggleCategory('commercialTransport')"-->
                <!--                                    :class="[include('commercialTransport') ? 'bkt-border-primary': 'bkt-border-body']">-->
                <!--                                {{$t('categories.commercialTransport')}}-->
                <!--                            </button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="bkt-categories__grid-item bkt-categories__item-2">-->
                <!--                    <div class="bkt-category__card">-->
                <!--                        <div class="bkt-category__card-header">-->
                <!--                            <div class="bkt-card__category bkt-bg-yellow-lighter">-->
                <!--                                <div class="bkt-card__category-icon">-->
                <!--                                    <bkt-icon name="Wrench" color="yellow"></bkt-icon>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <h5 class="bkt-card__title">Товарно-материаль- ные ценности</h5>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="bkt-categories__grid-item bkt-categories__item-3">-->
                <!--                    <div class="bkt-category__card">-->
                <!--&lt;!&ndash;                        :class="{ allChecked()}"&ndash;&gt;-->
                <!--                        <div class="bkt-category__card-header">-->
                <!--                            <div class="bkt-card__category bkt-bg-green-lighter">-->
                <!--                                <div class="bkt-card__category-icon">-->
                <!--                                    <bkt-icon name="Home" color="green"></bkt-icon>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <h5 class="bkt-card__title">Недвижимость</h5>-->
                <!--                        </div>-->
                <!--                        <div class="bkt-category__card-body">-->

                <!--                            <button class="bkt-category__card-item bkt-bg-body"-->
                <!--                                    @click="toggleCategory('residentialProperty')"-->
                <!--                                    :class="[include('residentialProperty') ? 'bkt-border-primary': 'bkt-border-body']">-->
                <!--                                {{$t('categories.residentialProperty')}}-->
                <!--                            </button>-->
                <!--                            <button class="bkt-category__card-item bkt-bg-body"-->
                <!--                                    @click="toggleCategory('commercialRealEstate')"-->
                <!--                                    :class="[include('commercialRealEstate') ? 'bkt-border-primary': 'bkt-border-body']">-->
                <!--                                {{$t('categories.commercialRealEstate')}}-->
                <!--                            </button>-->
                <!--                            <button class="bkt-category__card-item bkt-bg-body"-->
                <!--                                    @click="toggleCategory('land')"-->
                <!--                                    :class="[include('land') ? 'bkt-border-primary': 'bkt-border-body']">-->
                <!--                                {{$t('categories.land')}}-->
                <!--                            </button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="bkt-categories__grid-item bkt-categories__item-4">-->
                <!--                    <div class="bkt-category__card">-->
                <!--                        <div class="bkt-category__card-header">-->
                <!--                            <div class="bkt-card__category bkt-bg-primary-lighter">-->
                <!--                                <div class="bkt-card__category-icon">-->
                <!--                                    <bkt-icon name="Percentage" color="primary"></bkt-icon>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <h5 class="bkt-card__title">Дебиторская задолженность</h5>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="bkt-categories__grid-item bkt-categories__item-5">-->
                <!--                    <div class="bkt-category__card">-->
                <!--                        <div class="bkt-category__card-header">-->
                <!--                            <div class="bkt-card__category bkt-bg-blue-lighter">-->
                <!--                                <div class="bkt-card__category-icon">-->
                <!--                                    <bkt-icon name="Cow" color="blue"></bkt-icon>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <h5 class="bkt-card__title">Сельскохозяйствен-ное имущество</h5>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="bkt-categories__grid-item bkt-categories__item-6">-->
                <!--                    <div class="bkt-category__card">-->
                <!--                        <div class="bkt-category__card-header">-->
                <!--                            <div class="bkt-card__category bkt-bg-pink-lighter">-->
                <!--                                <div class="bkt-card__category-icon">-->
                <!--                                    <bkt-icon name="MechanicalArm" color="pink"></bkt-icon>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <h5 class="bkt-card__title">Производственные линии</h5>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="bkt-categories__grid-item bkt-categories__item-7">-->
                <!--                    <div class="bkt-category__card">-->
                <!--                        <div class="bkt-category__card-header">-->
                <!--                            <div class="bkt-card__category bkt-bg-teal-lighter">-->
                <!--                                <div class="bkt-card__category-icon">-->
                <!--                                    <bkt-icon name="File" color="teal"></bkt-icon>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <h5 class="bkt-card__title">Ценные бумаги</h5>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="bkt-categories__grid-item bkt-categories__item-8">-->
                <!--                    <div class="bkt-category__card">-->
                <!--                        <div class="bkt-category__card-header">-->
                <!--                            <div class="bkt-card__category bkt-bg-red-lighter">-->
                <!--                                <div class="bkt-card__category-icon">-->
                <!--                                    <bkt-icon name="Gear" color="red"></bkt-icon>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <h5 class="bkt-card__title">Оборудование</h5>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="bkt-categories__grid-item bkt-categories__item-9">-->
                <!--                    <div class="bkt-category__card">-->
                <!--                        <div class="bkt-category__card-header">-->
                <!--                            <div class="bkt-card__category bkt-bg-purple-lighter">-->
                <!--                                <div class="bkt-card__category-icon">-->
                <!--                                    <bkt-icon name="Building" color="purple"></bkt-icon>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <h5 class="bkt-card__title">Имущественный комплекс</h5>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="bkt-categories__grid-item bkt-categories__item-10">-->
                <!--                    <div class="bkt-category__card">-->
                <!--                        <div class="bkt-category__card-header">-->
                <!--                            <div class="bkt-card__category bkt-bg-neutral-light">-->
                <!--                                <div class="bkt-card__category-icon">-->
                <!--                                    <bkt-icon name="More" color="main" class="bkt-fill-neutral-light"></bkt-icon>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <h5 class="bkt-card__title">Прочее</h5>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
<!--            </div>-->
        </template>
    </bkt-modal>
</template>

<script>
    import BktCollapse from '../Collapse.vue';
    import BktCategoriesControl from "../FiltersControls/CategoriesControl";
    export default {
        name: "Category",
        components: {
            BktCollapse,
            BktCategoriesControl
        },
        props: {
            filter_name: {
                type: String,
                default: 'filters'
            },
            method_name: {
                type: String,
                default: 'getFilteredTrades'
            }
        },
        data() {
            return {
                result: [],
                items:[]
            };
        },
        created() {
            this.getCategories();
            this.result = JSON.parse(JSON.stringify(this.filters_categories))
        },
        computed: {
            filters_categories() {
                return this.$store.getters[this.filter_name].categories
            },
            filters() {
                return this.$store.getters[this.filter_name]
            },
            categories() {
                return this.$store.getters.categories
                    .sort(function (one, other) {
                    //a - b is
                    //   0 when elements are the same
                    //  >0 when a > b
                    //  <0 when a < b
                    return  other.subcategories.length - one.subcategories.length;
                });
            },
            loading() {
                return this.$store.getters.categories_loading
            },
        },
        methods: {
            include(category) {
                return this.result.indexOf(category) >= 0
            },
            toggleCategory(subcategory) {
                let item_index = this.result.findIndex(el => el == subcategory);
                if (item_index < 0) {
                    this.result.push(subcategory);
                } else {
                    this.result.splice(item_index, 1);
                }
            },
            selectAll(index) {
                let tmp = this.items[index].subcategories.map(item => item.key);
                if (this.items[index].status) {
                    tmp.forEach(item => {
                        let item_index = this.result.findIndex(el => el == item);
                        if (item_index < 0) {
                            this.result.push(item)
                        }
                    })
                } else {
                    tmp.forEach(it => {
                        let item_index = this.result.findIndex(el => el == it);
                        if (item_index >= 0) {
                            this.result.splice(item_index, 1)
                        }
                    });
                }
            },
            allChecked(arr, target) {
                return target.every(v => arr.includes(v))
            },
            isIndeterminate(index) {
                let all_checked = this.allChecked(this.result, this.items[index].subcategories.map(item=>item.key));
                let some_checked = this.items[index].subcategories.some(v => this.result.includes(v.key));
                if (all_checked) {
                    this.items[index].status = true;
                } else {
                    this.items[index].status = false;
                }
                return !all_checked && some_checked;
            },
            saveFilters() {
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'categories',
                    value: this.result
                }, {root: true});
                // this.$store.commit('saveFiltersProperty', {key: 'categories', value: this.result});
                this.$store.commit('closeModal', '#categoryModal');
                this.$store.dispatch(this.method_name, {page: 1, filters: this.filters});
            },
            clearFilters() {
                this.result = [];
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'categories',
                    value: []
                }, {root: true});
                // this.$store.commit('saveFiltersProperty', {key: 'categories', value: []});
                this.$store.commit('closeModal', '#categoryModal');
                this.$store.dispatch(this.method_name, {page: 1, filters: this.filters});
            },
            async getCategories() {
                await this.$store.dispatch('getCategories').then(resp => {
                    this.items = JSON.parse(JSON.stringify(this.categories));
                });
            },
        }
    }
</script>

<style scoped>
</style>
