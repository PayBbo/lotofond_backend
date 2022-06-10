<template>
    <bkt-modal :id="'codeModal'" :title="'Добро пожаловать'" :left_button_class="'bkt-modal-next'">
        <template #body>
            <h4>Чтобы начать работу, пройдите несколько шагов:</h4>
            <bkt-input
                name="email"
                type="email"
                label="e-mail"
                :rules="'required|email'"
                placeholder="pochta@gmail.com"
            />
            <bkt-input
                name="code"
                type="number"
                label="код"
                :rules="'required|digits:6'"
            ></bkt-input>

        </template>
        <template #left_button_inner>
          Пропустить<bkt-icon name="ArrowDown"></bkt-icon>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "CodeModal"
    }
</script>

<style scoped>

</style>
