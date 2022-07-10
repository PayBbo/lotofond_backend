<template>
    <bkt-modal :id="'categoryModal'" ref="categoryModal" :title="'Выберите нужные категории'"
               modal_class="bkt-category-modal bkt-region-modal" @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body>
            <div class="bkt-wrapper-column" v-if="!loading">
                <div class="bkt-wrapper-column">
                    <bkt-collapse :id="'category-collapse-'+index" v-for="(category, index) in categories" :key="index"
                                  main_class="bkt-regions-tabs__mobile-item"
                                  :collapse_button_class="category.subcategories.length>0 ? 'bkt-bg-white': 'd-none'"
                    >
                        <template #title>
                            <div class="text-left bkt-button d-flex justify-content-between p-2">
                                <div class="bkt-check__wrapper" v-if="category.subcategories.length==0">
                                    <div class="bkt-check">
                                        <div class="bkt-check__input">
                                            <input

                                                type="checkbox"
                                                v-model="result"
                                                :value="category.key"
                                                :name="'bkt-category-checkbox-'+index"
                                                :id="'bkt-category-checkbox-'+index"
                                            />
                                            <div class="bkt-check__input-check"></div>
                                        </div>
                                        <label class="bkt-check__label">
                                                {{category.label}}
                                        </label>
                                    </div>
                                </div>
                                <bkt-checkbox v-else :label="category.label"
                                              :name="'bkt-category-checkbox-'+index"
                                              :id="'bkt-category-checkbox-'+index"
                                              v-model="category.status"
                                              @input="selectAll(index)"
                                ></bkt-checkbox>
                            </div>
                        </template>
                        <template #collapse>
                            <div class="bkt-area__item text-left px-2 mb-2" v-for="(subcategory,index) in category.subcategories">
                                <div class="bkt-check__wrapper">
                                    <div class="bkt-check">
                                        <div class="bkt-check__input">
                                            <input
                                                type="checkbox"
                                                v-model="result"
                                                :value="subcategory.key"
                                            />
                                            <div class="bkt-check__input-check"></div>
                                        </div>
                                        <label class="bkt-check__label">
                                                {{subcategory.label}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </bkt-collapse>
                </div>
                <div class="bkt-region-selected" v-if="result.length>0">
                    <div class="bkt-region-selected__title text-left mb-2">
                        <span class="text-muted">выбранные категории</span>
                    </div>
                    <div class="bkt-tag__list">
                        <div class="bkt-region__item bkt-tag justify-content-between flex-fill"
                             v-for="(item, index) in result">
                            <span class="bkt-item-rounded__text mr-2">{{ $t('categories.'+item)}}</span>
                            <span class="bkt-tag__icon bkt-cursor-pointer" @click="toggleCategory(item)">
                            <bkt-icon name="Cancel" color="red"></bkt-icon>
                        </span>
                        </div>
                    </div>
                </div>
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
<!--                <template v-for="category in categories">-->
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
<!--&lt;!&ndash;                <div class="bkt-categories__grid-item bkt-categories__item-1">&ndash;&gt;-->
<!--&lt;!&ndash;                    <div class="bkt-category__card">&ndash;&gt;-->
<!--&lt;!&ndash;                        <div class="bkt-category__card-header">&ndash;&gt;-->
<!--&lt;!&ndash;                            <div class="bkt-card__category bkt-bg-orange-lighter">&ndash;&gt;-->
<!--&lt;!&ndash;                                <div class="bkt-card__category-icon">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <bkt-icon name="Car" color="orange"></bkt-icon>&ndash;&gt;-->
<!--&lt;!&ndash;                                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            <h5 class="bkt-card__title">Транспорт и техника</h5>&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                        <div class="bkt-category__card-body">&ndash;&gt;-->
<!--&lt;!&ndash;                            <button class="bkt-category__card-item bkt-bg-body"&ndash;&gt;-->
<!--&lt;!&ndash;                                    @click="toggleCategory('specialEquipment')"&ndash;&gt;-->
<!--&lt;!&ndash;                                    :class="[include('specialEquipment') ? 'bkt-border-primary': 'bkt-border-body']">&ndash;&gt;-->
<!--&lt;!&ndash;                                {{$t('categories.specialEquipment')}}&ndash;&gt;-->
<!--&lt;!&ndash;                            </button>&ndash;&gt;-->
<!--&lt;!&ndash;                            <button class="bkt-category__card-item bkt-bg-body"&ndash;&gt;-->
<!--&lt;!&ndash;                                    @click="toggleCategory('passengerTransport')"&ndash;&gt;-->
<!--&lt;!&ndash;                                    :class="[include('passengerTransport') ? 'bkt-border-primary': 'bkt-border-body']">&ndash;&gt;-->
<!--&lt;!&ndash;                                {{$t('categories.passengerTransport')}}&ndash;&gt;-->
<!--&lt;!&ndash;                            </button>&ndash;&gt;-->
<!--&lt;!&ndash;                            <button class="bkt-category__card-item bkt-bg-body"&ndash;&gt;-->
<!--&lt;!&ndash;                                    @click="toggleCategory('freightTransport')"&ndash;&gt;-->
<!--&lt;!&ndash;                                    :class="[include('freightTransport') ? 'bkt-border-primary': 'bkt-border-body']">&ndash;&gt;-->
<!--&lt;!&ndash;                                {{$t('categories.freightTransport')}}&ndash;&gt;-->
<!--&lt;!&ndash;                            </button>&ndash;&gt;-->
<!--&lt;!&ndash;                            <button class="bkt-category__card-item bkt-bg-body"&ndash;&gt;-->
<!--&lt;!&ndash;                                    @click="toggleCategory('mototechnics')"&ndash;&gt;-->
<!--&lt;!&ndash;                                    :class="[include('mototechnics') ? 'bkt-border-primary': 'bkt-border-body']">&ndash;&gt;-->
<!--&lt;!&ndash;                                {{$t('categories.mototechnics')}}&ndash;&gt;-->
<!--&lt;!&ndash;                            </button>&ndash;&gt;-->
<!--&lt;!&ndash;                            <button class="bkt-category__card-item bkt-bg-body"&ndash;&gt;-->
<!--&lt;!&ndash;                                    @click="toggleCategory('airTransport')"&ndash;&gt;-->
<!--&lt;!&ndash;                                    :class="[include('airTransport') ? 'bkt-border-primary': 'bkt-border-body']">&ndash;&gt;-->
<!--&lt;!&ndash;                                {{$t('categories.airTransport')}}&ndash;&gt;-->
<!--&lt;!&ndash;                            </button>&ndash;&gt;-->
<!--&lt;!&ndash;                            <button class="bkt-category__card-item bkt-bg-body"&ndash;&gt;-->
<!--&lt;!&ndash;                                    @click="toggleCategory('waterTransport')"&ndash;&gt;-->
<!--&lt;!&ndash;                                    :class="[include('waterTransport') ? 'bkt-border-primary': 'bkt-border-body']">&ndash;&gt;-->
<!--&lt;!&ndash;                                {{$t('categories.waterTransport')}}&ndash;&gt;-->
<!--&lt;!&ndash;                            </button>&ndash;&gt;-->
<!--&lt;!&ndash;                            <button class="bkt-category__card-item bkt-bg-body"&ndash;&gt;-->
<!--&lt;!&ndash;                                    @click="toggleCategory('commercialTransport')"&ndash;&gt;-->
<!--&lt;!&ndash;                                    :class="[include('commercialTransport') ? 'bkt-border-primary': 'bkt-border-body']">&ndash;&gt;-->
<!--&lt;!&ndash;                                {{$t('categories.commercialTransport')}}&ndash;&gt;-->
<!--&lt;!&ndash;                            </button>&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--&lt;!&ndash;                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                <div class="bkt-categories__grid-item bkt-categories__item-2">&ndash;&gt;-->
<!--&lt;!&ndash;                    <div class="bkt-category__card">&ndash;&gt;-->
<!--&lt;!&ndash;                        <div class="bkt-category__card-header">&ndash;&gt;-->
<!--&lt;!&ndash;                            <div class="bkt-card__category bkt-bg-yellow-lighter">&ndash;&gt;-->
<!--&lt;!&ndash;                                <div class="bkt-card__category-icon">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <bkt-icon name="Wrench" color="yellow"></bkt-icon>&ndash;&gt;-->
<!--&lt;!&ndash;                                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            <h5 class="bkt-card__title">Товарно-материаль- ные ценности</h5>&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--&lt;!&ndash;                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                <div class="bkt-categories__grid-item bkt-categories__item-3">&ndash;&gt;-->
<!--&lt;!&ndash;                    <div class="bkt-category__card">&ndash;&gt;-->
<!--&lt;!&ndash;&lt;!&ndash;                        :class="{ allChecked()}"&ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;                        <div class="bkt-category__card-header">&ndash;&gt;-->
<!--&lt;!&ndash;                            <div class="bkt-card__category bkt-bg-green-lighter">&ndash;&gt;-->
<!--&lt;!&ndash;                                <div class="bkt-card__category-icon">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <bkt-icon name="Home" color="green"></bkt-icon>&ndash;&gt;-->
<!--&lt;!&ndash;                                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            <h5 class="bkt-card__title">Недвижимость</h5>&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                        <div class="bkt-category__card-body">&ndash;&gt;-->
<!--&lt;!&ndash;                           &ndash;&gt;-->
<!--&lt;!&ndash;                            <button class="bkt-category__card-item bkt-bg-body"&ndash;&gt;-->
<!--&lt;!&ndash;                                    @click="toggleCategory('residentialProperty')"&ndash;&gt;-->
<!--&lt;!&ndash;                                    :class="[include('residentialProperty') ? 'bkt-border-primary': 'bkt-border-body']">&ndash;&gt;-->
<!--&lt;!&ndash;                                {{$t('categories.residentialProperty')}}&ndash;&gt;-->
<!--&lt;!&ndash;                            </button>&ndash;&gt;-->
<!--&lt;!&ndash;                            <button class="bkt-category__card-item bkt-bg-body"&ndash;&gt;-->
<!--&lt;!&ndash;                                    @click="toggleCategory('commercialRealEstate')"&ndash;&gt;-->
<!--&lt;!&ndash;                                    :class="[include('commercialRealEstate') ? 'bkt-border-primary': 'bkt-border-body']">&ndash;&gt;-->
<!--&lt;!&ndash;                                {{$t('categories.commercialRealEstate')}}&ndash;&gt;-->
<!--&lt;!&ndash;                            </button>&ndash;&gt;-->
<!--&lt;!&ndash;                            <button class="bkt-category__card-item bkt-bg-body"&ndash;&gt;-->
<!--&lt;!&ndash;                                    @click="toggleCategory('land')"&ndash;&gt;-->
<!--&lt;!&ndash;                                    :class="[include('land') ? 'bkt-border-primary': 'bkt-border-body']">&ndash;&gt;-->
<!--&lt;!&ndash;                                {{$t('categories.land')}}&ndash;&gt;-->
<!--&lt;!&ndash;                            </button>&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--&lt;!&ndash;                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                <div class="bkt-categories__grid-item bkt-categories__item-4">&ndash;&gt;-->
<!--&lt;!&ndash;                    <div class="bkt-category__card">&ndash;&gt;-->
<!--&lt;!&ndash;                        <div class="bkt-category__card-header">&ndash;&gt;-->
<!--&lt;!&ndash;                            <div class="bkt-card__category bkt-bg-primary-lighter">&ndash;&gt;-->
<!--&lt;!&ndash;                                <div class="bkt-card__category-icon">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <bkt-icon name="Percentage" color="primary"></bkt-icon>&ndash;&gt;-->
<!--&lt;!&ndash;                                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            <h5 class="bkt-card__title">Дебиторская задолженность</h5>&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--&lt;!&ndash;                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                <div class="bkt-categories__grid-item bkt-categories__item-5">&ndash;&gt;-->
<!--&lt;!&ndash;                    <div class="bkt-category__card">&ndash;&gt;-->
<!--&lt;!&ndash;                        <div class="bkt-category__card-header">&ndash;&gt;-->
<!--&lt;!&ndash;                            <div class="bkt-card__category bkt-bg-blue-lighter">&ndash;&gt;-->
<!--&lt;!&ndash;                                <div class="bkt-card__category-icon">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <bkt-icon name="Cow" color="blue"></bkt-icon>&ndash;&gt;-->
<!--&lt;!&ndash;                                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            <h5 class="bkt-card__title">Сельскохозяйствен-ное имущество</h5>&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--&lt;!&ndash;                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                <div class="bkt-categories__grid-item bkt-categories__item-6">&ndash;&gt;-->
<!--&lt;!&ndash;                    <div class="bkt-category__card">&ndash;&gt;-->
<!--&lt;!&ndash;                        <div class="bkt-category__card-header">&ndash;&gt;-->
<!--&lt;!&ndash;                            <div class="bkt-card__category bkt-bg-pink-lighter">&ndash;&gt;-->
<!--&lt;!&ndash;                                <div class="bkt-card__category-icon">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <bkt-icon name="MechanicalArm" color="pink"></bkt-icon>&ndash;&gt;-->
<!--&lt;!&ndash;                                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            <h5 class="bkt-card__title">Производственные линии</h5>&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--&lt;!&ndash;                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                <div class="bkt-categories__grid-item bkt-categories__item-7">&ndash;&gt;-->
<!--&lt;!&ndash;                    <div class="bkt-category__card">&ndash;&gt;-->
<!--&lt;!&ndash;                        <div class="bkt-category__card-header">&ndash;&gt;-->
<!--&lt;!&ndash;                            <div class="bkt-card__category bkt-bg-teal-lighter">&ndash;&gt;-->
<!--&lt;!&ndash;                                <div class="bkt-card__category-icon">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <bkt-icon name="File" color="teal"></bkt-icon>&ndash;&gt;-->
<!--&lt;!&ndash;                                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            <h5 class="bkt-card__title">Ценные бумаги</h5>&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--&lt;!&ndash;                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                <div class="bkt-categories__grid-item bkt-categories__item-8">&ndash;&gt;-->
<!--&lt;!&ndash;                    <div class="bkt-category__card">&ndash;&gt;-->
<!--&lt;!&ndash;                        <div class="bkt-category__card-header">&ndash;&gt;-->
<!--&lt;!&ndash;                            <div class="bkt-card__category bkt-bg-red-lighter">&ndash;&gt;-->
<!--&lt;!&ndash;                                <div class="bkt-card__category-icon">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <bkt-icon name="Gear" color="red"></bkt-icon>&ndash;&gt;-->
<!--&lt;!&ndash;                                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            <h5 class="bkt-card__title">Оборудование</h5>&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--&lt;!&ndash;                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                <div class="bkt-categories__grid-item bkt-categories__item-9">&ndash;&gt;-->
<!--&lt;!&ndash;                    <div class="bkt-category__card">&ndash;&gt;-->
<!--&lt;!&ndash;                        <div class="bkt-category__card-header">&ndash;&gt;-->
<!--&lt;!&ndash;                            <div class="bkt-card__category bkt-bg-purple-lighter">&ndash;&gt;-->
<!--&lt;!&ndash;                                <div class="bkt-card__category-icon">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <bkt-icon name="Building" color="purple"></bkt-icon>&ndash;&gt;-->
<!--&lt;!&ndash;                                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            <h5 class="bkt-card__title">Имущественный комплекс</h5>&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--&lt;!&ndash;                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                <div class="bkt-categories__grid-item bkt-categories__item-10">&ndash;&gt;-->
<!--&lt;!&ndash;                    <div class="bkt-category__card">&ndash;&gt;-->
<!--&lt;!&ndash;                        <div class="bkt-category__card-header">&ndash;&gt;-->
<!--&lt;!&ndash;                            <div class="bkt-card__category bkt-bg-neutral-light">&ndash;&gt;-->
<!--&lt;!&ndash;                                <div class="bkt-card__category-icon">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <bkt-icon name="More" color="main" class="bkt-fill-neutral-light"></bkt-icon>&ndash;&gt;-->
<!--&lt;!&ndash;                                </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            </div>&ndash;&gt;-->
<!--&lt;!&ndash;                            <h5 class="bkt-card__title">Прочее</h5>&ndash;&gt;-->
<!--&lt;!&ndash;                        </div>&ndash;&gt;-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--&lt;!&ndash;                </div>&ndash;&gt;-->
<!--            </div>-->
        </template>
    </bkt-modal>
</template>

<script>
    import BktCollapse from '../../components/Collapse.vue';
    export default {
        name: "Category",
        components: {
            BktCollapse
        },
        data() {
            return {
                result: [],
                selectedCategory:{ key:'realEstate', subcategories: []},
            };
        },
        mounted() {
            if(this.categories.length > 0)
            {
                this.selectedCategory = this.categories[0];
            }

        },
        computed: {
            filters_categories() {
                return this.$store.getters.filters_categories
            },
            filters() {
                return this.$store.getters.filters
            },
            categories() {
                return this.$store.getters.categories
                //     .sort(function (one, other) {
                //     //a - b is
                //     //   0 when elements are the same
                //     //  >0 when a > b
                //     //  <0 when a < b
                //     return one.subcategories.length - other.subcategories.length;
                // });
            },
            loading() {
                return this.$store.getters.categories_loading
            },
        },
        methods: {
            include(category) {
                return this.filter.indexOf(category) >= 0
            },
            allChecked(arr, target) {
                return target.every(v => arr.includes(v))
            },
            toggleCategory(subcategory) {
                let item_index = this.result.findIndex(el => el == subcategory);
                if (item_index < 0) {
                    this.result.push(subcategory);
                } else {
                    this.result.splice(item_index, 1);
                }
                console.log('filter', this.filter, this.result)
            },
            selectAll(index) {
                let tmp = this.categories[index].subcategories.map(item => item.key);
                if (this.categories[index].status) {
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
            saveFilters() {
                this.$store.commit('saveFiltersProperty', {key: 'categories', value: this.result});
                this.$store.commit('closeModal', '#categoryModal');
                this.$store.dispatch('getFilteredTrades', {page: 1, filters: this.filters});
            },
            clearFilters() {
                this.result = [];
                this.$store.commit('saveFiltersProperty', {key: 'categories', value: []});
                this.$store.commit('closeModal', '#categoryModal');
                this.$store.dispatch('getFilteredTrades', {page: 1, filters: this.filters});
            }
        }
    }
</script>

<style scoped>
</style>
