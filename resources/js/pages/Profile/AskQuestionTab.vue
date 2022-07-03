<template>
    <div class="bkt-card bkt-card__body">
        <div class="bkt-form" style="gap: 10px 0;">
            <div class="col-4 ps-md-0 d-none d-md-block">
                <h5 class="bkt-form__label">ваш e-mail</h5>
            </div>
            <div class="col-12 col-md-8 p-md-0">
                <bkt-input
                    name="from_email"
                    type="email"
                    label="ваш e-mail"
                    :rules="'required|email'"
                    placeholder="pochta@gmail.com"
                    :label_class="'d-md-none'"
                >
                </bkt-input>
            </div>
            <div class="col-4 ps-md-0 d-none d-md-block">
                <h5 class="bkt-form__label">тема вопроса</h5>
            </div>
            <div class="col-12 col-md-8 p-md-0">
                <bkt-input
                    name="subject"
                    type="text"
                    label="тема вопроса"
                    :rules="'required'"
                    placeholder=""
                    :label_class="'d-md-none'"
                >
                </bkt-input>
            </div>
            <div class="col-4 ps-md-0 d-none d-md-block">
                <h5 class="bkt-form__label">текст вопроса</h5>
            </div>
            <div class="col-12 col-md-8 p-md-0">
                <bkt-textarea
                    name="description"
                    type="text"
                    label="текст вопроса"
                    :rules="'required'"
                    placeholder=""
                    :label_class="'d-md-none'"
                ></bkt-textarea>
            </div>

            <div class="col-4 ps-md-0 d-none d-md-block"></div>
            <div class="col-12 col-md-8 p-md-0">
                <div class="bkt-wrapper-between">
                    <button class="bkt-button-link">
                        <bkt-icon name="Clip" color="primary" class="bkt-button__icon"></bkt-icon>
                        прикрепить файл
                    </button>
                    <button class="bkt-button primary">
                        Отправить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AskQuestion"
    }
</script>

<style scoped>

</style>
