<template>
    <div class="bkt-wrapper-column bkt-gap-large">
        <!--            <div class="bkt-search position-relative bg-white bkt-bg-item-neutral">-->
        <!--                <input class="w-100 bkt-search__input" type="text" :placeholder="'Введите нужное слово или фразу'">-->
        <!--                <button class="bkt-button green bkt-search__button">-->
        <!--                    <span class="d-none d-md-block">Найти</span>-->
        <!--                    <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>-->
        <!--                </button>-->
        <!--            </div>-->

        <div class="bkt-regions-tabs d-lg-block d-none" v-if="!loading && selectedRegion">
            <div class="bkt-form">
                <div class="col-5 p-0">
                    <div class="bkt-regions-tabs__nav text-center">
                        <div v-for="(group, index) in regionGroups" @click="selectedRegion = group"
                             :class="{'active bkt-bg-item-neutral': selectedRegion.regionGroup == group.regionGroup}"
                             class="bkt-regions-tabs__nav-item"
                        >
                            {{ $t('region_groups.'+group.regionGroup) }}
                        </div>
                    </div>
                </div>
                <div class="col-7 p-0">
                    <div class="bkt-regions-tabs__content bkt-bg-body"
                         :class="{
                            'bkt-rounded-left-top-none': regionGroups[0].regionGroup == selectedRegion.regionGroup,
                            'bkt-rounded-left-bottom-none': regionGroups[regionGroups.length-1].regionGroup == selectedRegion.regionGroup
                         }"
                    >
                        <div class="bkt-tag__wrapper" v-for="(item, index) in selectedRegion.regions"
                             :key="index">
                            <div class="bkt-tag w-100 text-left bkt-bg-item-rounded"
                                 :class="{'bkt-bg-green bkt-text-white': model.findIndex(el => el === item)>=0}"
                            >
                                {{ $t('regions.'+item) }}
                            </div>
                            <div class="bkt-tag__icon" @click="toggleRegion(item)">
                                <bkt-icon name="Cancel" color="red"
                                          v-show="model.findIndex(data => data === item)>=0"
                                ></bkt-icon>
                                <bkt-icon name="Plus" color="green"
                                          v-show="model.findIndex(data => data === item)<0"
                                ></bkt-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-lg-none bkt-wrapper-column bkt-gap-small" v-if="!loading  && selectedRegion">
            <bkt-collapse :id="'region-collapse-'+index" v-for="(group, index) in regionGroups" :key="index"
                          main_class="bkt-collapse_check"
                          collapse_button_class="bkt-bg-white"
            >
                <template #title>
                    <div class="bkt-collapse__title-wrapper">
                        <bkt-checkbox
                            :label="''"
                            :name="'bkt-region-group-checkbox-'+index"
                            :id="'bkt-region-group-checkbox-'+index"
                            v-model="group.status"
                            @input="selectAll(index)"
                            :indeterminate="isIndeterminate(index)"
                        ></bkt-checkbox>
                        <h5 class="bkt-regions-tabs__title" data-bs-toggle="collapse"
                            :data-bs-target="'#region-collapse-'+index">
                            {{$t('region_groups.'+group.regionGroup)}}
                        </h5>
                    </div>
                </template>
                <template #collapse>
                    <div class="bkt-gap-mini" v-for="(region,index) in group.regions">
                        <div class="bkt-collapse__title-wrapper">
                            <bkt-checkbox :label="''"
                                          :name="'bkt-region-checkbox-'+index"
                                          :id="'bkt-region-checkbox-'+index"
                                          v-model="model"
                                          :val="region"
                            ></bkt-checkbox>
                            <h6 class="bkt-regions-tabs__subtitle">
                                {{$t('regions.'+region)}}
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
        name: "RegionsControl",
        props: {
            value: {
                type: null,
                default: false,
            },
        },
        data() {
            return {
                regionGroups: [],
                selectedRegion: null,
            }
        },
        created() {
            this.getRegions();
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
            regions() {
                return this.$store.getters.regions
            },
            loading() {
                return this.$store.getters.regions_loading
            },
        },
        methods: {
            toggleRegion(region) {
                let item_index = this.model.findIndex(el => el === region);
                if (item_index < 0) {
                    this.model.push(region);
                } else {
                    this.model.splice(item_index, 1);
                }
            },
            selectAll(index) {
                if (this.regionGroups[index].status) {
                    this.regionGroups[index].regions.forEach(item => {
                        let item_index = this.model.findIndex(el => el === item);
                        if (item_index < 0) {
                            this.model.push(item)
                        }
                    })
                } else {
                    this.regionGroups[index].regions.forEach(item => {
                        let item_index = this.model.findIndex(el => el === item);
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
                this.regionGroups[index].status = !!all_checked;
                return !all_checked && some_checked;
            },
            async getRegions() {
                if (this.regions.length === 0) {
                    await this.$store.dispatch('getRegions').then(resp => {
                        this.regionGroups = JSON.parse(JSON.stringify(this.regions));
                        this.selectedRegion = this.regionGroups[0];
                    });
                } else {
                    this.regionGroups = JSON.parse(JSON.stringify(this.regions));
                    this.selectedRegion = this.regionGroups[0];
                }
            },
        },
    }
</script>

<style scoped>

</style>
