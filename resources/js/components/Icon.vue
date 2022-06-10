<script setup>
    import { defineAsyncComponent} from 'vue'

    const props = defineProps({
        name: String,
        fill: String,
        stroke: String,
        width: String,
        height: String,
    });
    const AsyncComp = defineAsyncComponent(() =>
        import('../icons/'+props.name+'.vue')
    )
    // const name = ref('Home')
</script>

<template>
    <AsyncComp v-if="name" v-bind="props"></AsyncComp>
</template>
