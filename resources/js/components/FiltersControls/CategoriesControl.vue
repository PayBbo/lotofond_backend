<template>
    <div class="bkt-wrapper-column bkt-gap-large">
        <div class="bkt-wrapper-column bkt-gap-small" v-if="!loading">
            <bkt-collapse :id="'category-collapse-'+index" v-for="(category, index) in items" :key="index"
                          main_class="bkt-collapse_check" :collapse_header="false"
                          :collapse_button_class="category.subcategories.length>0 ? 'bkt-bg-white': 'd-none'"
            >
                <template #title>
                    <div class="bkt-collapse__title-wrapper">
                        <bkt-checkbox v-if="category.subcategories.length==0"
                                      :name="'bkt-category-checkbox-'+index"
                                      :id="'bkt-category-checkbox-'+index"
                                      v-model="model"
                                      :val="category.key"
                                      @input="saveValue"
                        ></bkt-checkbox>
                        <bkt-checkbox v-else
                                      :name="'bkt-category-checkbox-'+index"
                                      :id="'bkt-category-checkbox-'+index"
                                      v-model="category.status"
                                      @input="selectAll(index)"
                                      :indeterminate="isIndeterminate(index)"
                        ></bkt-checkbox>
                        <bkt-icon :name="'categories/'+category.key" :color="categories_colors[category.key]"
                                  :width="'20px'" :height="'20px'"></bkt-icon>
                        <h5 class="bkt-regions-tabs__title" data-bs-toggle="collapse"
                            :data-bs-target="'#category-collapse-'+index"
                        >
                            {{category.label}}
                        </h5>
                    </div>
                </template>
                <template #collapse>
                    <div class="bkt-gap-mini" v-for="(subcategory,index) in category.subcategories">
                        <div class="bkt-collapse__title-wrapper">
                            <bkt-checkbox
                                :name="'bkt-subcategory-checkbox-'+index"
                                :id="'bkt-subcategory-checkbox-'+index"
                                v-model="model"
                                :val="subcategory.key"
                                @input="saveValue"
                            ></bkt-checkbox>
                            <h6 class="bkt-regions-tabs__subtitle">
                                {{subcategory.label}}
                            </h6>
                        </div>
                    </div>
                </template>
            </bkt-collapse>
        </div>
        <div class="bkt-region-selected" v-if="model.length>0 && !loading && show_selected">
            <h5 class="bkt-region-selected__title text-left mb-2">
                <span class="text-muted">выбранные категории</span>
            </h5>
            <div class="bkt-tag__list">
                <div class="bkt-region__item bkt-tag justify-content-between flex-fill"
                     v-for="(item, index) in model"
                >
                    <span class="bkt-item-rounded__text mr-2">{{ $t('categories.' + item) }}</span>
                    <span class="bkt-tag__icon bkt-cursor-pointer" @click="toggleCategory(item)">
                        <bkt-icon name="Cancel" color="red"></bkt-icon>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CategoriesControl",
        props: {
            value: {
                type: null,
                default: false,
            },
            show_selected: {
                type: Boolean,
                default: true,
            },
        },
        model: {
            prop: 'value',
            event: 'input'
        },
        data() {
            return {
                items:[],
                model:[],
                categories_colors: {
                    "realEstate": "green",
                    "other": "main",
                    "equipment": "red",
                    "transportAndEquipment": "orange",
                    "agriculturaProperty": "blue",
                    "tangibles": "yellow",
                    "productionLines": "purple",
                    "obligations": "teal",
                    "accountsReceivable": "primary",
                    "torgi": "indigo",
                },
            };
        },
        created() {
            this.getCategories();
        },
        mounted() {
            this.model = this.value;
        },
        computed: {
            categories() {
                return this.$store.getters.categories;
            },
            loading() {
                return this.$store.getters.categories_loading
            },
        },
        watch:{
            value: function(newValue, oldValue){
                this.model = newValue;
                // this.saveValue()
            },
        },
        methods: {
            saveValue() {
                this.$emit('input', this.model);
            },
            include(category) {
                return this.model.indexOf(category) >= 0
            },
            toggleCategory(subcategory) {
                let item_index = this.model.findIndex(el => el == subcategory);
                if (item_index < 0) {
                    this.model.push(subcategory);
                } else {
                    this.model.splice(item_index, 1);
                }
                this.saveValue()
            },
            selectAll(index) {
                let tmp = this.items[index].subcategories.map(item => item.key);
                if (this.items[index].status) {
                    tmp.forEach(item => {
                        let item_index = this.model.findIndex(el => el == item);
                        if (item_index < 0) {
                            this.model.push(item)
                        }
                    })
                }
                else {
                    tmp.forEach(it => {
                        let item_index = this.model.findIndex(el => el == it);
                        if (item_index >= 0) {
                            this.model.splice(item_index, 1)
                        }
                    });
                }
                this.saveValue()
            },
            allChecked(arr, target) {
                return target.every(v => arr.includes(v))
            },
            isIndeterminate(index) {
                let all_checked = this.allChecked(this.model, this.items[index].subcategories.map(item=>item.key));
                let some_checked = this.items[index].subcategories.some(v => this.model.includes(v.key));
                this.items[index].status = !!all_checked;
                return !all_checked && some_checked;
            },
            async getCategories() {
                if (this.categories.length === 0) {
                    await this.$store.dispatch('getCategories').then(resp => {
                        this.items = JSON.parse(JSON.stringify(this.categories));
                    });
                }
                else {
                    this.items = JSON.parse(JSON.stringify(this.categories));
                }
            },
        }
    }
</script>

<style scoped>

</style>
