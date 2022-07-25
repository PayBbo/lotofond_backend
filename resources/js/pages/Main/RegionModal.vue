<template>
    <bkt-modal :id="'regionModal'" ref="regionModal" :modal_class="'bkt-region-modal bkt-filters-modal'"
               :title="'Выберите регион'" :loading="loading" @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body="{ invalid }">
            <div class="bkt-wrapper-column bkt-gap-large">
                <bkt-regions-control v-model="result"></bkt-regions-control>
                <div class="bkt-region-selected" v-if="result.length>0 && !loading">
                    <h5 class="bkt-region-selected__title text-left mb-2">
                        <span class="text-muted">выбранные регионы</span>
                    </h5>
                    <div class="bkt-tag__list">
                        <div class="bkt-region__item bkt-tag justify-content-between flex-fill"
                             v-for="(item, index) in result">
                            <span class="bkt-item-rounded__text mr-2">{{ $t('regions.'+item)}}</span>
                            <span class="bkt-tag__icon bkt-cursor-pointer" @click="toggleRegion(item)">
                                    <bkt-icon name="Cancel" color="red"></bkt-icon>
                                </span>
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
            </div>
        </template>
    </bkt-modal>
</template>

<script>
   import BktRegionsControl from "../../components/FiltersControls/RegionsControl";

    export default {
        name: "RegionModal",
        components: {
            BktRegionsControl,
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
                regionGroups: [],
                selectedRegion: null,
                result: [],
            }
        },
        created() {
            this.getRegions();
            this.result = JSON.parse(JSON.stringify(this.$store.getters.filters_regions))
        },
        computed: {
            filters_regions() {
                return this.$store.getters[this.filter_name].regions
            },
            filters() {
                return this.$store.getters[this.filter_name]
            },
            regions() {
                return this.$store.getters.regions
            },
            loading() {
                return this.$store.getters.regions_loading
            },
        },
        methods: {
            toggleRegion(region) {
                let item_index = this.result.findIndex(el => el == region);
                if (item_index < 0) {
                    this.result.push(region);
                } else {
                    this.result.splice(item_index, 1);
                }
            },
            selectAll(index) {
                if (this.regionGroups[index].status) {
                    this.regionGroups[index].regions.forEach(item => {
                        let item_index = this.result.findIndex(el => el == item);
                        if (item_index < 0) {
                            this.result.push(item)
                        }
                    })
                } else {
                    this.regionGroups[index].regions.forEach(item => {
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
                let all_checked = this.allChecked(this.result, this.regionGroups[index].regions);
                let some_checked = this.regionGroups[index].regions.some(v => this.result.includes(v));
                if (all_checked) {
                    this.regionGroups[index].status = true;
                } else {
                    this.regionGroups[index].status = false;
                }
                return !all_checked && some_checked;
            },
            saveFilters() {
                // this.$store.commit('saveFiltersProperty', {key: 'regions', value: this.result});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'regions',
                    value: this.result
                }, {root: true});
                this.$store.commit('closeModal', '#regionModal');
                this.$store.dispatch(this.method_name, {page: 1, filters: this.filters});
            },
            clearFilters() {
                this.result = [];
                // this.$store.commit('saveFiltersProperty', {key: 'regions', value: []});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'regions',
                    value: []
                }, {root: true});
                this.$store.commit('closeModal', '#regionModal');
                this.$store.dispatch(this.method_name, {page: 1, filters: this.filters});
            },
            async getRegions() {
                await this.$store.dispatch('getRegions').then(resp => {
                    this.regionGroups = JSON.parse(JSON.stringify(this.regions));
                    this.selectedRegion = this.regionGroups[0];
                });
            },
        },
    }

</script>

<style scoped>
</style>
