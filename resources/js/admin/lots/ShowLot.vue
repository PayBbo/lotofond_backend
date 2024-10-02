<template>
    <fragment>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Просмотр лота</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/admin/lots"
                                             style="color: #007bff; text-decoration: none; background-color: transparent;">
                                    Лоты
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">Просмотр</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content" v-if="item">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-gradient-light">
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <label>ID</label>
                                        <p class="card-text text-wrap">{{ item.id }}</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <label>Номер торгов</label>
                                        <p class="card-text text-wrap">
                                            {{ item.tradeNumber + ', лот № ' + item.lotNumber }}</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <label>Тип торгов</label>
                                        <p class="card-text text-wrap">{{ $t('trades.type.' + item.tradeType) }}</p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <label>Статус торгов</label>
                                        <p class="card-text text-wrap">{{ item.status }}</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <label>Дата публикации</label>
                                        <p class="card-text text-wrap">{{ item.publishDate }}</p>
                                    </div>
                                </div>
                                <div class="card" v-if="item.eventTimeStart || item.eventTimeEnd">
                                    <div class="card-body d-flex flex-column">
                                        <label>Даты начала и окончания торгов</label>
                                        <p class="card-text text-wrap">{{
                                                item.eventTimeStart ? item.eventTimeStart : 'Не указано' +
                                                ' - ' + item.eventTimeEnd ? item.eventTimeEnd : 'Не указано'
                                            }}</p>
                                    </div>
                                </div>
                                <div class="card" v-if="item.eventTimeResult">
                                    <div class="card-body d-flex flex-column">
                                        <label>Дата окончания торгов</label>
                                        <p class="card-text text-wrap">{{ item.eventTimeResult }}</p>
                                    </div>
                                </div>
                                <div class="card" v-if="item.applicationTimeStart || item.applicationTimeEnd">
                                    <div class="card-body d-flex flex-column">
                                        <label>Даты начала и окончания приема заявок</label>
                                        <p class="card-text text-wrap">{{
                                                (item.applicationTimeStart ? item.applicationTimeStart : 'Не указано') +
                                                ' - ' + (item.applicationTimeEnd ? item.applicationTimeEnd : 'Не указано')
                                            }}</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <div class="bkt-wrapper-between">
                                            <label>Описание</label>
                                            <button  type="button"
                                                    class="btn btn-outline-primary bkt-button-icon primary-outline bkt-hover-primary"
                                                    @click="updateCadastralInfo"
                                                    title="Поиск кадастровых номеров"
                                                     :disabled="loading"
                                            >
                                                <bkt-icon name="Search" color="primary" :width="'16px'" :height="'16px'"/>
                                            </button>
                                        </div>
                                        <p class="card-text text-wrap">{{ item.description }}</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <files-table
                                            :files="item.files"
                                            :is-images="false"
                                            type="lot"
                                            :id="item.id"
                                            @change="changeItem">
                                        </files-table>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <files-table
                                            :files="item.images"
                                            :is-images="true"
                                            type="lot"
                                            :id="item.id"
                                            @change="changeItem">
                                        </files-table>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <label>Начальная цена</label>
                                        <p class="card-text text-wrap">{{ item.startPrice | priceFormat }} ₽</p>
                                    </div>
                                </div>

                                <div class="card" v-if="item.currentPrice">
                                    <div class="card-body d-flex flex-column">
                                        <label>Текущая цена</label>
                                        <p class="card-text text-wrap">{{ item.currentPrice | priceFormat }} ₽</p>
                                    </div>
                                </div>
                                <div class="card" v-if="item.minPrice">
                                    <div class="card-body d-flex flex-column">
                                        <label>Минимальная цена</label>
                                        <p class="card-text text-wrap">{{ item.minPrice | priceFormat }} ₽</p>
                                    </div>
                                </div>
                                <div class="card"
                                     v-if="item.stepPrice && auctions.includes(item.tradeType)">
                                    <div class="card-body d-flex flex-column">
                                        <label>Шаг аукциона</label>
                                        <p class="card-text text-wrap">
                                            {{item.stepPrice.value + (item.stepPrice.type == 'rubles' ? '₽' : '%') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="card"
                                     v-if="item.deposit && auctions.includes(item.tradeType)">
                                    <div class="card-body d-flex flex-column">
                                        <label>Задаток</label>
                                        <p class="card-text text-wrap">
                                            {{ item.deposit.value + (item.deposit.type == 'rubles' ? '₽' : '%') }}</p>
                                    </div>
                                </div>
                                <div class="card"
                                     v-if="item.priceReduction && offers.includes(item.tradeType)">
                                    <div class="card-body d-flex flex-column">
                                        <label>Информация о снижении цены</label>
                                        <p class="card-text text-wrap" v-html="item.priceReduction"></p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <label>Категории</label>
                                        <ul>
                                            <li v-for="category in item.categories">
                                                {{ category.label }}
                                                <ul v-if="category.subcategories.length > 0">
                                                    <li v-for="subcategory in category.subcategories">
                                                        {{ subcategory.label }}
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card" v-if="item.location.length >0">
                                    <div class="card-body d-flex flex-column">
                                        <label>Регионы</label>
                                        <ul>
                                            <li v-for="region in item.location">
                                                {{
                                                    $t('regions.' + region.code) + (region.isDebtorRegion ? '- регион должника' : '')
                                                }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <label>Ссылка на лот</label>
                                        <a :href="item.link" target="_blank">Перейти</a>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body d-flex flex-column">
                                        <label>Ссылка на лот в источнике</label>
                                        <a :href="item.efrsbLink" target="_blank">Перейти</a>
                                    </div>
                                </div>
                                <div class="card" v-if="item.descriptionExtracts.length>0">
                                    <div class="card-body d-flex flex-column">
                                        <div class="bkt-wrapper-between">
                                            <label>Данные из описания</label>
<!--                                            <button v-if="cadastralData" type="button"-->
<!--                                                    class="btn btn-outline-primary bkt-button-icon primary-outline bkt-hover-primary"-->
<!--                                                    @click="updateCadastralNumberInfo"-->
<!--                                                    title="Обновить данные кадастра"-->
<!--                                            >-->
<!--                                                <bkt-icon name="Refresh" color="primary" :width="'16px'" :height="'16px'"/>-->
<!--                                            </button>-->
                                        </div>

                                        <ul>
                                            <li v-for="extract in item.descriptionExtracts">
                                                {{
                                                    extract.tradeSubject == null ? 'Другое: ' : extract.tradeSubject + ':'
                                                }}
                                                <ul v-if="extract.extracts.length > 0">
                                                    <li v-for="property in extract.extracts" v-if="property.value">
                                                        <div :class="{'bkt-wrapper-between': property.type=='cadastralNumber'}">

                                                            <div class="flex align-items-center">
                                                                <span v-if="property.id" @click="deleteParam(property.id)"
                                                                     title="Удалить параметр"
                                                                     class="bkt-cursor-pointer me-1">
                                                                     <bkt-icon
                                                                         name="Trash" color="red"
                                                                         :width="'12px'" :height="'12px'"
                                                                     />
                                                                </span>
                                                                {{ property.title + ' - ' + property.value }}
                                                            </div>
                                                            <button v-if="property.type=='cadastralNumber'" type="button"
                                                                    class="btn btn-outline-primary bkt-button-icon primary-outline bkt-hover-primary"
                                                                    @click="updateCadastralNumberInfo(property.value)"
                                                                    title="Обновить данные кадастра"
                                                                    :disabled="loading"
                                                            >
                                                                <bkt-icon name="Refresh" color="primary" :width="'16px'" :height="'16px'"/>
                                                            </button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card" v-if="item.additionalLotInfoId">
                                    <div class="card-body d-flex flex-column">
                                        <label>Ответ организатора</label>
                                        <add-edit-additions simple :answer_id="item.additionalLotInfoId"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </fragment>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import FilesTable from "../FilesTable";
import AddEditAdditions from "./additions/AddEditAdditions";

export default {
    name: "ShowLot",
    components: {FilesTable, AddEditAdditions},
    data() {
        return {
            loading: false,
            offers: ['ClosePublicOffer', 'PublicOffer', "PPZ", "PPU"],
            auctions: ['CloseAuction', 'OpenAuction', 'EA', 'OpenConcours', 'CloseConcours', "EK", "SA", "PA", "BC", "PK"]
        }
    },
    computed: {
        ...mapGetters(['item']),
        cadastralData() {
            if (this.item.descriptionExtracts && this.item.descriptionExtracts.length == 1) {
                let tmp = this.item.descriptionExtracts[0];
                if (tmp.extracts.length > 0) {
                    let extracts = tmp.extracts;
                    // let cadastralData = {};
                    // let index = extracts.findIndex(item => item.type == 'cadastralDataPrice')
                    // if (index >= 0) {
                    //     if (extracts[index].value > 0) {
                    //         cadastralData.cadastralDataPrice = extracts[index].value;
                    //     }
                    // }
                    let index = extracts.findIndex(item => item.type == 'cadastralNumber');
                    if (index >= 0) {
                        // cadastralData.cadastralNumber = extracts[index].value;
                        return extracts[index].value
                    }
                    // return cadastralData == {} ? null : cadastralData
                }
            }
            return null;
        },
    },
    methods: {
        ...mapActions(['editItem']),
        async changeItem(){
            await this.editItem('show')
        },
        async updateCadastralNumberInfo(number) {
            // if(this.cadastralData) {
            this.loading = true;
                await axios.post('/api/admin/lots/update-cadastral-number-info', {id: this.item.id, cadastralNumber: number})
                    .then((response) => {
                        console.log('response', response.data.result);
                        if(response.data.result) {
                            this.$store.commit('setModal', {data: 'success', text: 'Данные успешно обновлены'});
                            this.changeItem()
                        }
                        else {
                            this.$store.commit('setModal', {data: 'error', text: 'Поиск ничего не нашел'});
                        }
                        this.loading = false;
                    }).catch(error => {
                        console.log(error);
                        this.loading = false;
                        this.$store.commit('setModal', {data: 'error', text: 'Произошла ошибка'});
                        throw error
                    });
            // }
        },
        async updateCadastralInfo() {
            this.loading = true;
            await axios.post('/api/admin/lots/update-cadastral-info', {
                id: this.item.id,
            })
                .then((response) => {
                    console.log('response', response.data.result);
                    if (response.data.result) {
                        this.$store.commit('setModal', {data: 'success', text: 'Данные успешно обновлены'});
                        this.changeItem()
                    }
                    this.loading = false;
                }).catch(error => {
                    console.log(error);
                    this.loading = false;
                    this.$store.commit('setModal', {data: 'error', text: 'Произошла ошибка'});
                    throw error
                });

        },
        async deleteParam(id) {
            this.loading = true;
            await axios.delete('/api/admin/lots/param/'+id)
                .then((response) => {
                    console.log('response', response.data);
                    if (response.data.result) {
                        this.$store.commit('setModal', {data: 'success', text: 'Данные успешно обновлены'});
                        this.changeItem()
                    }
                    this.loading = false;
                }).catch(error => {
                    console.log(error);
                    this.loading = false;
                    this.$store.commit('setModal', {data: 'error', text: 'Произошла ошибка'});
                    throw error
                });

        }
    },
    async created() {
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
        await this.editItem('show')
    },
}
</script>

<style scoped>
a {
    color: var(--bs-link-color);
    text-decoration: underline;
}

ul {
    margin-bottom: 0;
}
</style>
