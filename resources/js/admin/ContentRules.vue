<template>
    <AdminTable header="Ограничения доступа к контенту на бесплатном тарифе"
                :columns="columns" :pagination="pagination" :getData="getData">
        <template v-slot:inline-block>
            <div class="row justify-content-end">
                <div class="col-4">
                    <div class="input-group input-group-sm w-100">
                        <input type="text" v-model="param" name="table_search" class="form-control float-right"
                               placeholder="Поиск">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default" @click="searchParam(param)">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:raws-block>
            <tr v-for="(item, index) in dataItems">
                <td>{{ item.title }}</td>
                <td>
                    <div v-can="'content-rules-edit'" class="switchToggle">
                        <input type="checkbox" :id="'contentRuleTitle'+index"
                               v-model="item.isAvailable" @change="updateData(item)">
                        <label :for="'contentRuleTitle'+index">Toggle</label>
                    </div>
                    <p v-cannot="'content-rules-edit'">{{ item.isAvailable ? 'Да' : 'Нет' }}</p>
                </td>
            </tr>
        </template>
    </AdminTable>

</template>

<script>
import {mapActions, mapGetters} from "vuex";
import main from "./mixins/main";
import AdminTable from "./AdminTable";

export default {
    name: "ContentRules",
    components: {AdminTable},
    methods: {
        ...mapActions(['updateData']),
    },
    mixins: [main],
    data() {
        return {
            columns: ['Контент', 'Доступно ли на бесплатном тарифе?'],
            param: ''
        }
    },
    async created() {
        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\/*$)/, ""))
    }
}
</script>

<style scoped>
.switchToggle input[type=checkbox] {
    height: 0;
    width: 0;
    visibility: hidden;
    position: absolute;
}

.switchToggle label {
    cursor: pointer;
    text-indent: -9999px;
    width: 70px;
    max-width: 70px;
    height: 30px;
    background: #dc3545;
    display: block;
    border-radius: 100px;
    position: relative;
}

.switchToggle label:after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 26px;
    height: 26px;
    background: #fff;
    border-radius: 90px;
    transition: 0.3s;
}

.switchToggle input:checked + label, .switchToggle input:checked + input + label {
    background: #28a745;
}

.switchToggle input + label:before, .switchToggle input + input + label:before {
    content: 'Нет';
    position: absolute;
    top: 3px;
    left: 32px;
    width: 26px;
    height: 26px;
    border-radius: 90px;
    transition: 0.3s;
    text-indent: 0;
    color: #fff;
}

.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {
    content: 'Да';
    position: absolute;
    top: 3px;
    left: 13px;
    width: 26px;
    height: 26px;
    border-radius: 90px;
    transition: 0.3s;
    text-indent: 0;
    color: #fff;
}

.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {
    left: calc(100% - 2px);
    transform: translateX(-100%);
}

.switchToggle label:active:after {
    width: 60px;
}

.toggle-switchArea {
    margin: 10px 0 10px 0;
}
</style>
