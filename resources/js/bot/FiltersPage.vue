<template>
    <div class="bkt-page bkt-container">
        <h1 class="bkt-page__title">
            Задайте Фильтры
        </h1>
        <bkt-bot-filters class="bkt-card bkt-card__body bkt-auctions" :show_cancel="false" :filter_name="'bot_filters'"/>
    </div>
</template>

<script>
    import BktBotFilters from "./Filters";
    export default {
        name: "FiltersPage",
        components: {
            BktBotFilters
        }
    }
</script>

<style scoped>

</style>
