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

        <section class="content">
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
                                        <label>Описание</label>
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
                                     v-if="item.stepPrice && (item.tradeType === 'CloseAuction' || item.tradeType === 'OpenAuction')">
                                    <div class="card-body d-flex flex-column">
                                        <label>Шаг аукциона</label>
                                        <p class="card-text text-wrap">
                                            {{
                                                item.stepPrice.value + (item.stepPrice.type == 'rubles' ? '₽' : '%')
                                            }}</p>
                                    </div>
                                </div>
                                <div class="card"
                                     v-if="item.deposit && (item.tradeType === 'CloseAuction' || item.tradeType === 'OpenAuction')">
                                    <div class="card-body d-flex flex-column">
                                        <label>Задаток</label>
                                        <p class="card-text text-wrap">
                                            {{ item.deposit.value + (item.deposit.type == 'rubles' ? '₽' : '%') }}</p>
                                    </div>
                                </div>
                                <div class="card"
                                     v-if="item.priceReduction && (item.tradeType === 'PublicOffer' || item.tradeType === 'ClosePublicOffer')">
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
                                        <label>Ссылка на лот на федресурсе</label>
                                        <a :href="item.efrsbLink" target="_blank">Перейти</a>
                                    </div>
                                </div>
                                <div class="card" v-if="item.descriptionExtracts.length>0">
                                    <div class="card-body d-flex flex-column">
                                        <label>Данные из описания</label>
                                        <ul>
                                            <li v-for="extract in item.descriptionExtracts">
                                                {{
                                                    extract.tradeSubject == null ? 'Другое: ' : extract.tradeSubject + ':'
                                                }}
                                                <ul v-if="extract.extracts.length > 0">
                                                    <li v-for="property in extract.extracts" v-if="property.value">
                                                        {{ property.title + ' - ' + property.value }}
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
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

export default {
    name: "ShowLot",
    components: {FilesTable},
    computed: {
        ...mapGetters(['item']),
    },
    methods: {
        ...mapActions(['editItem']),
        async changeItem(){
            await this.editItem('show')
        }
    },
    async created() {
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
        await this.editItem('show')
    }
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
