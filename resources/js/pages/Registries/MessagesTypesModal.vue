<template>
    <bkt-modal :id="'messagesTypesModal'" :title="'Выберите основные параметры'" modal_class="bkt-filters-modal"
               @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #title>
            <div class="bkt-wrapper-between w-100">
                <h3 class="bkt-modal__title">Выберите основные параметры</h3>
                <div class="bkt-wrapper-between">
                    <button class="bkt-button next bkt-text-red me-2" @click="removeAllTypes">Выключить все</button>
                    <button class="bkt-button next bkt-text-green"
                          @click="selectAllTypes">Включить все</button>
                </div>
            </div>
        </template>
        <template #body>
            <div class="bkt-wrapper-column bkt-gap">
                <bkt-collapse :id="'messages-types-collapse-'+index" v-for="(item, index) in items" :key="index"
                              main_class="bkt-collapse_check" collapse_button_class="bkt-bg-white"
                >
                    <template #title>
                        <div class="bkt-collapse__title-wrapper">
                            <bkt-checkbox
                                :name="'bkt-messages-type-checkbox-'+index"
                                :id="'bkt-messages-type-checkbox-'+index"
                                v-model="item.status"
                                @input="selectAll(index)"
                                :indeterminate="isIndeterminate(index)"
                            ></bkt-checkbox>
                            <h5 class="bkt-collapse__title" data-bs-toggle="collapse"
                                :data-bs-target="'#messages-types-collapse-'+index">
                                {{item.messagesGroup}}
                            </h5>
                        </div>
                    </template>
                    <template #collapse>
                        <div class="bkt-gap-mini bkt-wrapper-column">
                            <div class="bkt-collapse__title-wrapper align-items-start" v-for="(type,index) in item.types">
                                <bkt-checkbox
                                    :name="'bkt-type-checkbox-'+index"
                                    :id="'bkt-type-checkbox-'+index"
                                    v-model="result"
                                    :val="type.code"
                                ></bkt-checkbox>
                                <h6 class="bkt-collapse__subtitle my-auto">
                                    {{type.title}}
                                </h6>
                            </div>
                        </div>
                    </template>
                </bkt-collapse>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "MessagesTypesModal",
        data() {
            return {
                loading: false,
                items:[],
                result: []
            }
        },
        computed: {
            messages_types() {
                return this.$store.getters.messages_types;
            },
            filters() {
                return this.$store.getters.messages_filters;
            },
        },
        mounted() {
            this.getMessagesTypes()
        },
        methods: {
            async getMessagesTypes() {
                this.loading = true;
                if (this.messages_types.length === 0) {
                    await this.$store.dispatch('getFiltersMessagesTypes').then(resp => {
                        this.items = JSON.parse(JSON.stringify(this.messages_types));
                        this.loading = false;
                    }).catch(err => {
                        this.loading = false;
                    });
                }
                else {
                    this.items = JSON.parse(JSON.stringify(this.messages_types));
                    this.loading = false;
                }
            },
            toggleItem(type) {
                let item_index = this.result.findIndex(el => el == type);
                if (item_index < 0) {
                    this.result.push(type);
                } else {
                    this.result.splice(item_index, 1);
                }
            },
            selectAll(index) {
                let tmp = this.items[index].types.map(item => item.code);
                if (this.items[index].status) {
                    tmp.forEach(item => {
                        let item_index = this.result.findIndex(el => el == item);
                        if (item_index < 0) {
                            this.result.push(item)
                        }
                    })
                } else {
                    tmp.forEach(item => {
                        let item_index = this.result.findIndex(el => el == item);
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
                let all_checked = this.allChecked(this.result, this.items[index].types.map(item=>item.code));
                let some_checked = this.items[index].types.some(v => this.result.includes(v.code));
                this.items[index].status = !!all_checked;
                return !all_checked && some_checked;
            },
            selectAllTypes() {
                let tmp = [].concat.apply([], this.items.map(item => item.types));
                tmp.forEach(item => {
                    let item_index = this.result.findIndex(el => el == item.code);
                    if (item_index < 0) {
                        this.result.push(item.code)
                    }
                })
            },
            removeAllTypes() {
                this.result = [];
            },
            saveFilters() {
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters',
                    key: 'messages_filters.types',
                    value: this.result
                }, {root: true});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters',
                    key: 'messages_filters.page',
                    value: 1
                }, {root: true});
                this.$store.commit('closeModal', '#messagesTypesModal');
                this.$store.dispatch('getDebtorMessages',  this.filters);
            },
            clearFilters() {
                this.result = [];
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters',
                    key: 'messages_filters.page',
                    value: 1
                }, {root: true});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters',
                    key: 'messages_filters.types',
                    value: []
                }, {root: true});
                this.$store.commit('closeModal', '#messagesTypesModal');
                this.$store.dispatch('getDebtorMessages', this.filters);
            },
        }
    }
</script>

<style scoped>

</style>
