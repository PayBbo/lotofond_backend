<template>
    <div class="position-relative">
        <input type="file" :ref="'upload'+id" :multiple="multiple" v-on:change="handleFile()"/>
        <slot name="upload_button">
            <button :class="upload_button_class" @click="startUpload" :disabled="disabled">
                <slot name="upload_button_inner">
                    <bkt-icon name="Clip" color="primary" class="bkt-button__icon"></bkt-icon>
                    прикрепить файл
                </slot>
            </button>
        </slot>
    </div>
</template>

<script>
    export default {
        name: "UploadFile",
        props: {
            file: {},
            id: {
                type: String,
                default: ''
            },
            upload_button_class: {
                type: String,
                default: 'bkt-button-link p-0'
            },
            multiple: {
                type: Boolean,
                default: true
            },
            disabled: {
                type: Boolean,
                default: false
            }
        },
        model: {
            prop: 'file',
            event: 'change'
        },
        data() {
            return {
                upload_files: []
            }
        },
        methods: {
            removeFile(key) {
                this.$emit('removeFile', this.upload_files[key]);
                this.upload_files.splice(key, 1);
                this.$emit('change', this.upload_files);
            },
            clear() {
                this.$refs['upload'+this.id].value = '';
            },
            handleFile() {
                let uploadedFiles = this.$refs['upload'+this.id].files;
                for (let i = 0; i < uploadedFiles.length; i++) {
                    if (/\.(jpe?g|png|bmp|pdf|doc|docx|mp4|webm|ogg)$/i.test(uploadedFiles[i].name)) {
                        uploadedFiles[i].fileType = 'file';
                        if(/\.(jpe?g|png|bmp)$/i.test(uploadedFiles[i].name))
                        {
                            uploadedFiles[i].fileType = 'image';
                        }
                        uploadedFiles[i].file_size = this.formatBytes(uploadedFiles[i].size);
                        if(this.multiple) {
                            this.upload_files.push(uploadedFiles[i]);
                            this.$emit('change', this.upload_files);
                        }
                        else {
                            this.$emit('change', uploadedFiles[0]);
                        }
                    }
                }
            },
            startUpload() {
                // this.$emit('start-upload')
                this.$refs['upload'+this.id].click();
            },
            formatBytes(bytes, decimals = 2) {
                if (bytes === 0) return '0 Bytes';

                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

                const i = Math.floor(Math.log(bytes) / Math.log(k));

                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            }
        }
    }
</script>

<style scoped>
    input[type="file"] {
        opacity: 0;
        width: 100%;
        height: 0;
        position: absolute;
        cursor: pointer;
    }
</style>
