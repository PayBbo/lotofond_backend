<template>
    <bkt-modal :id="'regionModal'" ref="regionModal" :modal_class="'bkt-region-modal bkt-filters-modal'" @close-modal="closeModal"
               :title="'Выберите регион'" :loading="loading" @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body="{ invalid }">
            <div class="bkt-wrapper-column bkt-gap-large" v-if="!loading">
                <bkt-regions-control v-model="model"></bkt-regions-control>
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
                    return JSON.parse(JSON.stringify(this.filters_regions));
                },
                set(value) {
                    this.result = value
                }
            }
        },
        methods: {
            saveFilters() {
                this.$store.commit('saveFiltersProperty', {key: this.filter_name+'_regions', value: this.result});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'regions',
                    value: this.result
                }, {root: true});
                this.$store.commit('closeModal', '#regionModal');
                this.callMethod();
            },
            clearFilters() {
                this.model = [];
                this.$store.commit('saveFiltersProperty', {key: this.filter_name+'_regions', value: []});
                this.$store.dispatch('saveDataProperty', {
                    module_key: 'filters', state_key: this.filter_name,
                    key: 'regions',
                    value: []
                }, {root: true});
                this.$store.commit('closeModal', '#regionModal');
                this.callMethod();
            },
            async getRegions() {
                await this.$store.dispatch('getRegions').then(resp => {
                    this.regionGroups = JSON.parse(JSON.stringify(this.regions));
                    this.selectedRegion = this.regionGroups[0];
                });
            },
            closeModal() {
                let tmp_regions = JSON.parse(JSON.stringify(this.filters.regions));
                this.model.splice(0);
                tmp_regions.forEach( item => {
                    this.model.push(item)
                })
            },
            callMethod() {
                let tmp_filters = JSON.parse(JSON.stringify(this.filters));
                this.$store.dispatch(this.method_name, {page: 1, filters: tmp_filters});
            }
        },
    }

</script>

<style scoped>
</style>
