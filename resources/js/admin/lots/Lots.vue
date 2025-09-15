<template>
    <AdminTable header="Лоты" :columns="columns" :pagination="pagination" :getData="getData">
        <template v-slot:inline-block>
            <div class="row justify-content-end">
                <div class="col-2 text-left">
                    <p class="mb-0">С даты</p>
                    <admin-datepicker :model="param.dateFrom" @input="startFilter('start_date')" ref="start_date" refName="start_date"/>
                </div>
                <div class="col-2 text-left">
                    <p class="mb-0">По дату</p>
                    <admin-datepicker :model="param.dateTo" @input="startFilter('end_date')" ref="end_date" refName="end_date"/>
                </div>
                <div class="col-4">
                    <p class="mb-0">Регион</p>
                    <div class="input-group input-group-sm w-100">
                        <select class="form-control" v-model="param.region" @input="chooseRegion">
                            <option v-for="region in region_options" :value="region.value">{{ region.label }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <p class="mb-0">Поиск</p>
                    <div class="input-group input-group-sm w-100">
                        <input type="text" v-model="param.search" name="table_search" class="form-control float-right"
                               placeholder="Поиск">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default" @click="startFilter">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:raws-block>
            <tr v-for="(lot, index) in dataItems">
                <td>{{ lot.id }}</td>
                <td style=" max-width: 500px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ lot.description }}
                </td>
                <td>{{ lot.startPrice | priceFormat }} ₽</td>
                <td>{{ lot.status }}</td>
                <td>{{ lot.tradeNumber }}</td>
                <td>{{ $t('trades.type.' + lot.tradeType) }}</td>
                <td>
                    <a v-if="lot.additionalLotInfoId" :href="'/admin/additions/'+ lot.additionalLotInfoId" target="_blank"
                       class="d-flex justify-content-center"
                    >
                        <span
                            :title="lot.additionalLotInfoIsModerated==true ? 'Проверен' : 'Непроверен'"
                            class="bkt-cursor-pointer"
                            :class="{'bkt-bg-green': lot.additionalLotInfoIsModerated == true,
                            'bkt-bg-red': lot.additionalLotInfoIsModerated == false}"
                            style="width: 20px; height: 20px; border-radius: 50%"
                        />
                    </a>
                    {{lot.additionalLotInfoIsModerated === null ? 'Нет' : ''}}
                </td>
                <td>{{ lot.publishDate }}</td>
                <td>
                    <router-link v-can="'lot-edit'" :to="'/admin/lots/'+lot.id" class="btn btn-primary btn-sm">
                        <i class="fas fa-pencil-alt"> </i>
                    </router-link>
                    <button v-can="'lot-delete'" class="btn btn-danger  btn-sm" @click="deleteItem(lot.id)">
                        <i class="fas fa-trash-alt"> </i>
                    </button>
                </td>
            </tr>
        </template>
    </AdminTable>
</template>

<script>
import AdminTable from "../AdminTable";
import main from "../mixins/main";
import AdminDatepicker from "../AdminDatepicker";

export default {
    name: "Lots",
    components: {AdminTable, AdminDatepicker},
    mixins: [main],
    data() {
        return {
            columns: {
                columns_title: ['ID', 'Описание', 'Начальная цена', 'Статус', 'Номер торгов', 'Тип торгов', 'Ответ', 'Дата публикации', 'Действия'],
                columns_sort: ['id', 'description', 'startPrice', 'status', 'tradeNumber', 'tradeType', 'additionalLotInfoIsModerated', 'publishDate',   null]
            },
            param: {'dateFrom': this.$moment().subtract(1, 'months').format('YYYY-MM-DD'),
                'dateTo':this.$moment().format('YYYY-MM-DD'), 'search': null, region: null},
        }
    },
    created() {
        this.getRegions();
        this.param.dateTo = this.$moment().format('YYYY-MM-DD');
        this.param.dateFrom = this.$moment().subtract(1, 'months').format('YYYY-MM-DD');
        if (this.$refs.end_date) {
            this.$refs.end_date.setDate(this.param.dateTo)
        }
        if (this.$refs.start_date) {
            this.$refs.start_date.setDate(this.param.dateFrom)
        }
    },
    computed: {
        region_options() {
            let tmp = [].concat.apply([], this.$store.getters.regions.map(item => item.regions));
            let result =[];
            tmp.forEach(item => {
                result.push({label: this.$t('regions.'+item), value: item});
            });
            return result.sort((a, b) => a.label.localeCompare(b.label))
        },
    },
    methods: {
        startFilter(date=null) {
            if(date) {
                this.checkDates(date);
            }
            let result = this.serializeParams(this.param);
            this.searchParam(result)
        },
        serializeParams(obj) {
            let str = [];
            for (let p in obj)
                if (obj.hasOwnProperty(p) && obj[p] != null) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
            return 'null&'+str.join("&");
        },
        // Если конечная дата меньше начальной, выставлем начальную такую же как конечную
// Если начальная дата больше конечной, выставлем конечную такую же как начальную
        checkDates(date) {
            if(this.param.dateFrom && this.param.dateTo) {
                let start = this.param.dateFrom.split('.');
                let end = this.param.dateTo.split('.');
                let startNum = start[2] + start[1] + start[0];
                let endNum = end[2] + end[1] + end[0];
                if (startNum > endNum) {
                    if (date == 'start_date') {
                        this.param.dateTo = this.param.dateFrom;
                        if(this.$refs.end_date) {
                            this.$refs.end_date.setDate(start[2]+'-'+start[1]+'-'+ start[0])
                        }
                    } else {
                        this.param.dateFrom = this.param.dateTo;
                        if(this.$refs.start_date) {
                            this.$refs.start_date.setDate(end[2]+'-'+end[1]+'-'+ end[0])
                        }
                    }
                }
            }
        },
        async getRegions() {
            await this.$store.dispatch('getRegions')
        },
        chooseRegion(event) {
            this.param.region = event.target.value;
            this.startFilter()
        }
    }
}
</script>

<style scoped>

</style>
