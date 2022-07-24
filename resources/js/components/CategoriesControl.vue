<template>
    <div class="bkt-wrapper-column bkt-gap-large" v-if="!loading">
        <div class="bkt-wrapper-column bkt-gap-small">
            <bkt-collapse :id="'category-collapse-'+index" v-for="(category, index) in items" :key="index"
                          main_class="bkt-collapse_check"
                          :collapse_button_class="category.subcategories.length>0 ? 'bkt-bg-white': 'd-none'"
            >
                <template #title>
                    <div class="bkt-collapse__title-wrapper">
                        <bkt-checkbox v-if="category.subcategories.length==0"
                                      :name="'bkt-category-checkbox-'+index"
                                      :id="'bkt-category-checkbox-'+index"
                                      v-model="model"
                                      :val="category.key"
                        ></bkt-checkbox>
                        <bkt-checkbox v-else
                                      :name="'bkt-category-checkbox-'+index"
                                      :id="'bkt-category-checkbox-'+index"
                                      v-model="category.status"
                                      @input="selectAll(index)"
                                      :indeterminate="isIndeterminate(index)"
                        ></bkt-checkbox>
                        <h5 class="bkt-regions-tabs__title" data-bs-toggle="collapse"
                            :data-bs-target="'#category-collapse-'+index">
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
                            ></bkt-checkbox>
                            <h6 class="bkt-regions-tabs__subtitle">
                                {{subcategory.label}}
                            </h6>
                        </div>
                    </div>
                </template>
            </bkt-collapse>
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
        },
        data() {
            return {
                items:[]
            };
        },
        created() {
            this.getCategories();
        },
        computed: {
            model: {
                get() {
                    return this.value;
                },
                set(value) {
                    this.$emit("input", value);
                },
            },
            categories() {
                return this.$store.getters.categories
                    .sort(function (one, other) {
                        return  other.subcategories.length - one.subcategories.length;
                    });
            },
            loading() {
                return this.$store.getters.categories_loading
            },
        },
        methods: {
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
                } else {
                    tmp.forEach(it => {
                        let item_index = this.model.findIndex(el => el == it);
                        if (item_index >= 0) {
                            this.model.splice(item_index, 1)
                        }
                    });
                }
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
