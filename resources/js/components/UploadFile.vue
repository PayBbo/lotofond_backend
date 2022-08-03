<template>
    <div class="position-relative">
        <input type="file" ref="upload" multiple v-on:change="handleFile()"/>
        <button class="bkt-button-link p-0" @click="startUpload">
            <bkt-icon name="Clip" color="primary" class="bkt-button__icon"></bkt-icon>
            прикрепить файл
        </button>
    </div>
</template>

<script>
    export default {
        name: "UploadFile",
        props: ['file'],
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
            handleFile() {
                let uploadedFiles = this.$refs['upload'].files;
                for (let i = 0; i < uploadedFiles.length; i++) {
                    if (/\.(jpe?g|png|gif|svg|pdf|doc|docx)$/i.test(uploadedFiles[i].name)) {
                        uploadedFiles[i].file_size = this.formatBytes(uploadedFiles[i].size);
                        this.upload_files.push(uploadedFiles[i]);
                        this.$emit('change', this.upload_files);
                    }
                }
            },
            startUpload() {
                this.$refs.upload.click();
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
