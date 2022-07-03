<template>
    <bkt-modal :id="'regionModal'" ref="regionModal" :modal_class="'bkt-region-modal bkt-filters-modal'"
               :title="'Выберите регион'" :loading="loading"  @left_action="clearFilters" @right_action="saveFilters"
    >
        <template #body="{ invalid }">
            <!--            <div class="bkt-search position-relative bg-white bkt-bg-item-neutral">-->
            <!--                <input class="w-100 bkt-search__input" type="text" :placeholder="'Введите нужное слово или фразу'">-->
            <!--                <button class="bkt-button green bkt-search__button">-->
            <!--                    <span class="d-none d-md-block">Найти</span>-->
            <!--                    <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>-->
            <!--                </button>-->
            <!--            </div>-->
            <div class="bkt-region-tabs d-lg-block d-none">
                <div class="bkt-form">
                    <div class="col-4 p-0">
                        <div class="bkt-tabs-nav">
                            <div class="nav flex-column text-center">
                                <div v-for="(region, index) in regions" @click="selectedRegion = region"
                                     :class="{'active bkt-bg-item-neutral': selectedRegion.id == region.id}"
                                     class="text-left bkt-button bkt-card__text bkt-button-federal-district"
                                >
                                    {{ region.label }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 p-0">
                        <div class="bkt-tabs-content h-100 bkt-bg-item-neutral p-5"
                             :class="{'bkt-rounded-left-top-none': regions[0].id == selectedRegion.id,
                             'bkt-rounded-left-bottom-none': regions[regions.length-1].id == selectedRegion.id}"
                        >
                            <div class="tab-content">
                                <div class="tab-pane fade show active" role="tabpanel"
                                     aria-labelledby="v-tabs-district-tab-1">
                                    <ul class="bkt-area-content list-group list-inline">
                                        <li class="bkt-area-content__item"
                                            v-for="(item, index) in selectedRegion.area"
                                            :key="index"
                                        >
                                            <div class="bkt-item text-left d-flex align-items-center"
                                                 style="gap:10px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                                <div class="bkt-bg-item-rounded bkt-item-rounded mb-1 p-2 w-100 pl-4 pr-4 mr-4"
                                                    :class="{'active': result.findIndex(el => el === item.key)>=0}"
                                                >
                                                    <span class="bkt-item-rounded__text">{{ item.label }}</span>
                                                </div>
                                                <div class="bkt-cursor-pointer"
                                                      v-if="result.findIndex(data => data === item.key)>=0"
                                                      @click="result.splice(index, 1)"
                                                >
                                                      <bkt-icon name="Cancel" width="20px" height="20px"></bkt-icon>
                                                </div>
                                                <div class="bkt-cursor-pointer" v-else @click="addArea(item.key)">
                                                      <bkt-icon name="Plus" color="green" width="20px" height="20px"></bkt-icon>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bkt-region-tabs d-lg-none bkt-regions-tabs__mobile">
                <div class="accordion" role="tablist">
                    <bkt-collapse :id="'region-collapse-'+index" v-for="(region, index) in regions" :key="index"
                                  main_class="mb-1 bkt-region-border-gray"
                                  collapse_button_class="bkt-bg-white"
                    >
                        <template #title>
                            <div class="text-left bkt-button d-flex justify-content-between p-2">
                                <bkt-checkbox class="bkt-regions-tabs__title" :label="region.label"
                                              :name="'bkt-region-checkbox-'+index"
                                              :id="'bkt-region-checkbox-'+index"
                                              v-model="region.status"
                                              @input="selectAllArea(index)"
                                ></bkt-checkbox>
                            </div>
                        </template>
                        <template #collapse>
                            <div class="bkt-area__item text-left px-2 mb-2" v-for="(area,index) in region.area">
<!--                                <bkt-checkbox :label="area.label" v-model="result"-->
<!--                                              :val="area.key"-->
<!--                                              :name="'bkt-area-checkbox-'+index"-->
<!--                                              :id="'bkt-area-checkbox-'+index"></bkt-checkbox>-->
                                <div class="bkt-check__wrapper">
                                    <div class="bkt-check">
                                        <div class="bkt-check__input">
                                            <input
                                                type="checkbox"
                                                v-model="result"
                                                :value="area.key"
                                            />
                                            <div class="bkt-check__input-check"></div>
                                        </div>
                                        <label class="bkt-check__label">
                                            <slot name="label">
                                                {{area.label}}
                                            </slot>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </bkt-collapse>
                </div>
            </div>

            <div class="bkt-region-selected" v-if="result.length>0">
                <div class="bkt-region-selected__title text-left mb-2">
                    <span class="text-muted">выбранные регионы</span>
                </div>
                <div class="bkt-selected-region-items float-left d-flex flex-wrap" style="gap: 10px;">
                    <div class="bkt-region__item bkt-bg-item-rounded bkt-item-rounded"
                         v-for="(item, index) in result">
                        <div class="mb-1 p-2 w-100 pl-4 pr-4 text-left">
                            <span class="bkt-item-rounded__text mr-2">{{ $t('regions.'+item)}}</span>
                            <span class="bkt-cursor-pointer" @click="result.splice(index, 1)">
                                <bkt-icon name="Cancel" color="red" alt="cancel" width="15px" height="15px"></bkt-icon>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    import BktCollapse from '../../components/Collapse.vue';

    export default {
        name: "RegionModal",
        components: {
            BktCollapse
        },
        data() {
            return {
                loading: false,
                regions: [
                    {
                        id: 1,
                        label: "Дальневосточный ФО",
                        key: 'Дальневосточный ФО', area: [
                            {id: 1, label: "Амурская область", key: 'AmurRegion'},
                            {id: 2, label: "Бурятия", key: 'TheRepublicOfBuryatia'},
                            {id: 3, label: "Еврейская АО", key: 'JewishAutonomousRegion'},
                            {id: 4, label: "Камчатский край", key: 'KamchatkaKrai'},
                            {id: 5, label: "Магаданская область", key: 'MagadanRegion'},
                            {id: 6, label: "Приморский край", key: 'PrimorskyKrai'},
                            {id: 7, label: "Сахалинская область", key: 'SakhalinRegion'}
                        ],
                        status: false,
                    },
                    {id: 2, label: "Приволжский ФО", key: '', area: []},
                    {id: 3, label: "Северо-Западный ФО", key: '', area: []},
                    {id: 4, label: "Северо-Кавказский ФО", key: '', area: []},
                    {id: 5, label: "Сибирский ФО", key: '', area: []},
                    {id: 6, label: "Уральский ФО", key: '', area: []},
                    {id: 7, label: "Центральный ФО", key: '', area: []},
                    {id: 8, label: "Южный ФО", key: '', area: []},
                ],
                selectedRegionId: 1,
                selectedRegion: null,
                selectedAreas: [],
                result: [],
            }
        },
        mounted() {
            this.selectedRegion = this.regions[0];
            this.result = JSON.parse(JSON.stringify(this.$store.getters.filters_regions));
        },
        computed: {
            filters_regions() {
                return this.$store.getters.filters_regions
            },
            filters() {
                return this.$store.getters.filters
            },
            filter: {
                get() {
                    return JSON.parse(JSON.stringify(this.$store.getters.filters_regions));
                },
                set(value) {
                    this.result = value;
                }
            },
        },
        methods: {
            addArea(area) {
                // if (!this.selectedAreas.some(data => data.id === area.id)) {
                let item_index = this.result.findIndex(el => el == area);
                if(item_index < 0){
                    this.result.push(area);
                }
            },
            selectAllArea(index) {
                let tmp = this.regions[index].area.map(item=>item.key);
                if (this.regions[index].status) {
                    tmp.forEach(item => {
                        let item_index = this.result.findIndex(el => el == item);
                        if(item_index < 0){
                            this.result.push(item)
                        }
                    })
                    // this.regions[index].status = true;
                }
                else {
                    tmp.forEach(it => {
                        let item_index = this.result.findIndex(el => el == it);
                        if(item_index>=0){
                            this.result.splice(item_index, 1)
                        }
                    });
                    // this.regions[index].status = false;
                }
            },
            saveFilters() {
                this.$store.commit('saveFiltersProperty', {key: 'regions', value: this.result});
                this.$store.commit('closeModal', '#regionModal');
                this.$store.dispatch('getFilteredTrades', {page: 1, filters: this.filters});
            },
            clearFilters() {
                this.$store.commit('saveFiltersProperty', {key: 'regions', value: []});
                this.$store.commit('closeModal', '#regionModal');
                this.$store.dispatch('getFilteredTrades', {page: 1, filters: this.filters});
            }
        },
    }

</script>

<style scoped>
    span {
        font-size: 14px;
        font-weight: 600;
    }

    * {
        font-size: 14px;
    }
</style>
