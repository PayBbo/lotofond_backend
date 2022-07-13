<template>
    <div class="bkt-wrapper-column">
        <bkt-collapse main_class="bkt-card bkt-notifications-card" id="question1" collapse_button_class="bkt-bg-white">
            <template #title>
                <h4 class="bkt-card__title" data-bs-toggle="collapse" data-bs-target="#question1">
                    Безопасно ли это?
                </h4>
            </template>
            <template #collapse>
                <p class="bkt-card__text">
                    После завершения сделки можно будет оценить и покупателя, и продавца. Запрос на оценку придет
                    специальным сообщением в переписку о товаре между продавцом и покупателем. Оценку можно оставить, если
                    товар будет доставлен в населённый пункт покупателя и будет получен покупателем либо по товару будет
                    оформлен возврат.
                </p>
            </template>
        </bkt-collapse>
        <bkt-collapse title="Почему к объявдению не подключена доставка?" main_class="bkt-notifications-card"
                      id="question2" collapse_button_class="bkt-bg-white">
            <template #title>
                <h4 class="bkt-card__title" data-bs-toggle="collapse" data-bs-target="#question2">
                    Почему к объявдению не подключена доставка?
                </h4>
            </template>
            <template #collapse>
                <p class="bkt-card__text">
                    Text
                </p>
            </template>
        </bkt-collapse>
        <bkt-collapse title="Как отменить заказ?" main_class="bkt-notifications-card" id="question3"
                      collapse_button_class="bkt-bg-white">
            <template #title>
                <h4 class="bkt-card__title" data-bs-toggle="collapse" data-bs-target="#question3">
                    Как отменить заказ?
                </h4>
            </template>
            <template #collapse>
                <p class="bkt-card__text">
                    Text
                </p>
            </template>
        </bkt-collapse>
        <bkt-collapse title="Возврат товара?" main_class="bkt-notifications-card" id="question4"
                      collapse_button_class="bkt-bg-white">
            <template #title>
                <h4 class="bkt-card__title" data-bs-toggle="collapse" data-bs-target="#question4">
                    Возврат товара?
                </h4>
            </template>
            <template #collapse>
                <p class="bkt-card__text">
                    Text
                </p>
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
