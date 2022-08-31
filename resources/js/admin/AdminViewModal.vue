<template>
    <div class="modal fade" id="modalView" tabindex="-1" role="dialog"
         aria-labelledby="modalViewTitle" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewTitle">Просмотр</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card" v-for="(value, name, index) in modalData" :key="index">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ mColumns[name] }}</h5>
                            <a v-if="Array.isArray(value)===true" class="page-link text-wrap"
                               :href="v" v-for="v in value" target="_blank">{{ v }}</a>
                            <a v-if="Array.isArray(value)===false
                                    &&/^((ftp|http|https)?:\/\/)?([\w-]{1,32}\.[\w-]{1,32})[^\s@]*$/.test(value)===true"
                               class="page-link text-wrap" :href="value" target="_blank"> {{ value }}</a>
                            <p v-if="Array.isArray(value)===false &&
                                        /^((ftp|http|https)?:\/\/)?([\w-]{1,32}\.[\w-]{1,32})[^\s@]*$/.test(value)===false && typeof value !== 'boolean'"
                               class="card-text text-wrap">{{ value }}</p>
                            <p v-if="typeof value === 'boolean'">{{ value ? 'Да' : 'Нет' }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdminViewModal",
    props: ['modalData', 'mColumns'],
}
</script>

<style scoped>

</style>
