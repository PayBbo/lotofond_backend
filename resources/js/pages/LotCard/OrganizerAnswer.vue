<template>
    <div class="bkt-card bkt-card__body bkt-lot__card">
        <div class="bkt-card__header bkt-wrapper-between pb-0">
            <h3 class="bkt-card__title">Ответ организатора</h3>
            <h3 class="bkt-card__subtitle bkt-text-neutral">
                <span>
                    {{answer.publishDate | moment('DD.MM.YYYY')}}
                <star-rating :title="answer.rating" v-if="answer.rating>0"
                             :show-rating="false" :rating="answer.rating" :read-only="true" :star-size="16"
                             :increment="0.01"
                             :rounded-corners="false"
                />
                </span>
                <span v-if="isAdmin" :class="'bkt-text-'+( answer.isModerated ? 'green': 'red')" >
                    {{ answer.isModerated ? 'Проверен': 'Не проверен'}}
                </span>
            </h3>
        </div>
        <div class="bkt-form w-100">
            <template v-if="!edit_mode">
                <div class="col-5" v-if="answer.images.length>0 && ((rules && rules.showOrganizerAnswer) || !rules)">
                    <hooper :itemsToShow="1" :centerMode="true" class="bkt-card__image-slider">
                        <slide v-for="(img, index) in answer.images" :key="img.id">
                            <img v-lazy="img.preview" class="bkt-card__image" @click="$emit('changeImageIndex', index)"/>
                        </slide>
                        <hooper-navigation slot="hooper-addons"/>
                    </hooper>
                </div>
                <div :class="[answer.images.length>0 ? 'col': 'col-12']">
                    <skeleton type_name="spoiler" :loading="rules && !rules.showOrganizerAnswer">
                        {{answer.message}}
                    </skeleton>
                </div>
                <template v-if="answer.files.length>0 && ((rules && rules.showOrganizerAnswer) || !rules)">
                    <div class="col-12 col-md-6" v-for="file in organizer_answer_files">
                        <div class="row bkt-row outline align-items-start bkt-nowrap h-100">
                            <div class="col p-0" style="max-width: 28px;">
                                <bkt-icon name="Note" color="red" width="16px" height="16px" class="d-flex"/>
                            </div>
                            <div class="col">
                                <a :href="file.url" target="_blank" class="h-100">
                                    <h6>{{file.title}}</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </template>

            <div class="col-12" v-can="'additions-edit'">
                <button class="bkt-button primary" style="float: right;" @click="edit" v-if="!edit_mode">Редактировать</button>
<!--                <button class="bkt-button primary" data-bs-toggle="modal" data-bs-target="#ratingModal">-->
<!--                    Оценить-->
<!--                </button>-->
                <add-edit-additions v-if="edit_mode" :answer_id="answer.id" simple @cancel="edit_mode=false" @update="update"/>
            </div>
        </div>
        <rating-modal type="answer" :answer-id="answer.id" @estimated="estimated"/>
    </div>
</template>

<script>
    import {Hooper, Navigation as HooperNavigation, Slide} from "hooper";
    import axios from "axios";
    import AddEditAdditions from "../../admin/lots/additions/AddEditAdditions";
    import RatingModal from "./RatingModal";
    import StarRating from "vue-star-rating";

    export default {
        name: "OrganizerAnswer",
        props:['answer'],
        components: {
            Hooper,
            Slide,
            HooperNavigation,
            AddEditAdditions,
            RatingModal,
            StarRating
        },
        data() {
            return {
                loading: false,
                organizer_answer_files: [],
                edit_mode: false,
                edit_answer: null
            }
        },
        mounted() {
            this.answer.files.forEach(item => {
                let str = item;
                let n = item.lastIndexOf('/');
                let result = str.substring(n + 1);
                this.organizer_answer_files.push({title: result, url: item})
            })
        },
        computed: {
            rules() {
                return this.$store.getters.rules
            },
            auth_user() {
                return this.$store.getters.auth_user;
                // auth_user && auth_user.isAdmin
            },
            isAdmin() {
                return this.auth_user && this.auth_user.isAdmin;
            }
        },
        methods: {
            edit() {
                this.edit_mode = true;
            },
            async save() {
                this.loading=true;
                await axios({
                    method: 'put',
                    url: '/api/admin/additions/update',
                    data: this.edit_answer,
                })
                    .then((response) => {
                        if (response.status === 200) {
                            // dispatch('getData')
                            commit('setModal', {data: 'success', text: 'Операция прошла успешно'});
                            this.loading=false;
                        }
                    })
                    .catch((error) => {
                            commit('setModal', {data: 'error', text: 'Произошла ошибка'})
                        this.loading=false;
                    });
            },
            update() {
                this.edit_mode = false;
                this.$emit('update');
            },
            estimated() {

            }
        }
    }
</script>

<style scoped>

</style>
