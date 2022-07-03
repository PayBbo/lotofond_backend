<template>
<div class="bkt-wrapper-column">
    <bkt-collapse title="Безопасно ли это?" id="collapseDocuments" collapse_button_class="bkt-bg-white">
        <template #collapse>
            Text
        </template>
    </bkt-collapse>
    <bkt-collapse title="Почему к объявдению не подключена доставка?" id="order" collapse_button_class="bkt-bg-white">
        <template #collapse>
            Text
        </template>
    </bkt-collapse>
    <bkt-collapse title="Как отменить заказ?" id="order" collapse_button_class="bkt-bg-white">
        <template #collapse>
            Text
        </template>
    </bkt-collapse>
    <bkt-collapse title="Возврат товара?" id="order" collapse_button_class="bkt-bg-white">
        <template #collapse>
            Text
        </template>
    </bkt-collapse>
</div>
</template>

<script>
    import BktCollapse from '../../components/Collapse.vue';
    export default {
        name: "HelpTab",
        components: {
            BktCollapse
        }
    }
</script>

<style scoped>

</style>
