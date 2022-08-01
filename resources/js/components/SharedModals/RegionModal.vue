<template>
    <bkt-modal :id="'regionModal'" ref="regionModal" :modal_class="'bkt-region-modal bkt-filters-modal'"
               :title="'Выберите регион'" :loading="loading" @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body="{ invalid }">
            <div class="bkt-wrapper-column bkt-gap-large">
                <bkt-regions-control v-model="model"></bkt-regions-control>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
   import BktRegionsControl from "../FiltersControls/RegionsControl";

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
            // this.result = JSON.parse(JSON.stringify(this.$store.getters.filters_regions))
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
            model:{
                get() {
                    return JSON.parse(JSON.stringify(this.$store.getters[this.filter_name].regions));
                },
                set(value) {
                    this.result = value
                }
            }
        },
        methods: {
            toggleRegion(region) {
                let item_index = this.model.findIndex(el => el == region);
                if (item_index < 0) {
                    this.model.push(region);
                } else {
                    this.model.splice(item_index, 1);
                }
            },
            selectAll(index) {
                if (this.regionGroups[index].status) {
                    this.regionGroups[index].regions.forEach(item => {
                        let item_index = this.model.findIndex(el => el == item);
                        if (item_index < 0) {
                            this.model.push(item)
                        }
                    })
                } else {
                    this.regionGroups[index].regions.forEach(item => {
                        let item_index = this.model.findIndex(el => el == item);
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
                let all_checked = this.allChecked(this.model, this.regionGroups[index].regions);
                let some_checked = this.regionGroups[index].regions.some(v => this.model.includes(v));
                if (all_checked) {
                    this.regionGroups[index].status = true;
                } else {
                    this.regionGroups[index].status = false;
                }
                return !all_checked && some_checked;
            },
            saveFilters() {
                // this.$store.commit('saveFiltersProperty', {key: 'regions', value: this.model});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'regions',
                    value: this.model
                }, {root: true});
                this.$store.commit('closeModal', '#regionModal');
                this.$store.dispatch(this.method_name, {page: 1, filters: this.filters});
            },
            clearFilters() {
                this.model = [];
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
