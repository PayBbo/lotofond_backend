<template>
    <div class="bkt-information-message mb-5" v-if="informationMessage && informationMessageMode ==='show'">
        <div class="bkt-card bkt-bg-primary-lighter text-white overflow-hidden"
             v-if="!informationMessage.description && informationMessage.image"
        >
            <button type="button" class="btn-close" aria-label="Close" style="position: absolute; top: 10px; right:10px;" @click="close"></button>
            <img v-lazy="informationMessage.image"
                 class="card-img" style="max-height: 350px;object-fit: fill;" alt="...">
        </div>
        <div class="bkt-card overflow-hidden"  v-if="informationMessage.description">
            <button type="button" class="btn-close" aria-label="Close" style="position: absolute; top: 10px; right:10px;" @click="close"></button>
            <div class="row g-0">
                <div class="col-md-4">
                    <img v-if="informationMessage.image" v-lazy="informationMessage.image"
                         class="img-fluid rounded-start bkt-w-100 bkt-bg-primary-lighter" style="max-height: 300px; object-fit: fill" alt="...">
                    <img v-else :src="'/images/favicon/android-chrome-256x256.png'" class="img-fluid rounded-start bkt-w-down-md-100 bkt-bg-primary-lighter"
                         style="max-height: 300px; object-fit: fill" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="bkt-card__body">
                        <h3 class="bkt-card__title">{{informationMessage.description}}</h3>
                        <p class="card-text"><small class="text-muted">{{informationMessage.publishDate | moment('DD.MM.YYYY')}}</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "InformationMessage",
        computed: {
            informationMessage() {
                return this.$store.getters.informationMessage
            },
            informationMessageMode() {
                return this.$store.getters.informationMessageMode
            }
        },
        methods: {
            close() {
                this.$store.commit('setInformationMessageMode', 'close')
            }
        }
    }
</script>

<style scoped>

</style>
