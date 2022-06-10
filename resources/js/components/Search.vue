<template>
    <div class="bkt-search bkt-card position-relative">
        <input class="w-100 bkt-search__input" type="text" placeholder="Введите нужное слово или фразу">
        <button class="bkt-button green bkt-search__button">
            <span class="d-none d-md-block">Найти</span>
            <bkt-icon class="d-block d-md-none" :name="'Search'"></bkt-icon>
        </button>
    </div>
</template>

<script>
    export default {
        name: "Search",
         props:{}
    }
</script>

<style scoped>

</style>
