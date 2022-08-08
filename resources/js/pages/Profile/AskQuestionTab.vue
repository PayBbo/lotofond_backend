<template>
    <div class="bkt-card bkt-card__body">
        <div class="bkt-form align-items-baseline bkt-gap-down-sm-large">
            <div class="col-4 ps-md-0 d-none d-md-block">
                <h5 class="bkt-form__label">ваш e-mail</h5>
            </div>
            <div class="col-12 col-md-8 p-md-0">
                <bkt-input
                    v-model="question.email"
                    name="email"
                    type="email"
                    label="ваш e-mail"
                    :rules="'required|email'"
                    placeholder="pochta@gmail.com"
                    :label_class="'d-md-none'"
                    no_group_item
                >
                </bkt-input>
            </div>
            <div class="col-4 ps-md-0 d-none d-md-block">
                <h5 class="bkt-form__label">тема вопроса</h5>
            </div>
            <div class="col-12 col-md-8 p-md-0">
                <bkt-input
                    v-model="question.topic"
                    name="topic"
                    type="text"
                    label="тема вопроса"
                    :rules="'required'"
                    placeholder=""
                    :label_class="'d-md-none'"
                    no_group_item
                >
                </bkt-input>
            </div>
            <div class="col-4 ps-md-0 d-none d-md-block">
                <h5 class="bkt-form__label">текст вопроса</h5>
            </div>
            <div class="col-12 col-md-8 p-md-0">
                <bkt-textarea
                    v-model="question.question"
                    name="question"
                    type="text"
                    label="текст вопроса"
                    :rules="'required'"
                    placeholder=""
                    :label_class="'d-md-none'"
                    no_group_item
                ></bkt-textarea>
            </div>
            <div class="col-4 ps-md-0 d-none d-md-block"></div>
            <div class="col-12 col-md-8 p-md-0">
                <div class="bkt-tag__list">
                    <div class="bkt-tag justify-content-between flex-fill" v-for="(item, index) in question.files">
                        <span class="bkt-text-truncate">{{ item.name }}</span>
                        <h6 class="bkt-text-neutral">{{ item.file_size }}</h6>

                        <span class="bkt-tag__icon bkt-cursor-pointer" @click="removeFile(index)">
                            <bkt-icon name="Cancel" color="red" width="12px" height="12px"></bkt-icon>
                        </span>
                    </div>
                </div>
                <div class="bkt-card__footer bkt-wrapper-between bkt-gap-large">
                    <!--                    <button class="bkt-button-link">-->
                    <!--                        <bkt-icon name="Clip" color="primary" class="bkt-button__icon"></bkt-icon>-->
                    <!--                        прикрепить файл-->
                    <!--                    </button>-->
                    <bkt-upload-file v-model="question.files" ref="upload_file"></bkt-upload-file>
                    <button class="bkt-button primary bkt-button_plump bkt-w-sm-100">
                        Отправить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BktUploadFile from "../../components/UploadFile";

    export default {
        name: "AskQuestion",
        components: {
            BktUploadFile
        },
        data() {
            return {
                question: {
                    email: "",
                    question: '',
                    topic: "",
                    files: []
                },
                loading: false,
            }
        },
        methods: {
            removeFile(index) {
                this.$refs.upload_file.removeFile(index);
            },
            sendApplication() {
                this.loading = true;
                let formData = new FormData();
                formData.append('email', this.question.email);
                formData.append('question', this.question.question);
                formData.append('topic', this.question.topic);
                for (var i = 0; i < this.question.files.length; i++) {
                    formData.append("file[]", this.question.files[i]);
                }
                axios.post('/api/send/question', this.question, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                    .then(resp => {
                        this.loading = false;
                        this.$store.dispatch('sendNotification',
                            {self: this, message: 'Вопрос успешно отправлен'});
                        this.question = {
                            email: "",
                            question: '',
                            topic: "",
                            files: []
                        };
                    })
                    .catch(error => {
                        this.loading = false;
                    })
            },
        }
    }
</script>

<style scoped>

</style>
