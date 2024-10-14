<template>
    <bkt-modal :id="id" :title="'Оцените '+(type === 'answer' ? '' : 'работу ')+types[type]"
               modal_class="bkt-filters-modal text-center" :loading="loading"
               @left_action="cancel" @right_action="chooseSave"
    >
        <template #title>
            <h3 class="bkt-modal__title mx-auto">
                Оцените {{type === 'answer' ?'' : 'работу '}}{{ types[type]}}
            </h3>
        </template>
        <template #body>
            <div class="bkt-wrapper-column bkt-gap-row-large">
                <ValidationProvider :name="'Оценка'" :rules="'required|min_value:1|max_value:5'" v-slot="{ errors }"
                                    tag="div" class="bkt-rating bkt-wrapper-column" style="gap: 0;">
                    <label class="bkt-input__label text-center mb-0">выберите оценку от 1 до 5</label>
                    <star-rating :show-rating="false" v-model="rating.estimate" class="mx-auto"
                                 :star-size="16" :increment="1" :rounded-corners="false"
                    >
                    </star-rating>
                    <p class="bkt-input-error" v-if="errors.length>0">{{errors[0]}}</p>
                </ValidationProvider>
                <bkt-textarea v-model="rating.comment"
                              label="мой комментарий (вижу только я)"
                              name="comment"
                              class="w-100"
                              rows="4"
                              no_group_item
                >
                </bkt-textarea>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    import StarRating from "vue-star-rating";

    export default {
        name: "RatingModal",
        props: {
            id: {
                type: String,
                default: 'ratingModal'
            },
            type: {
                type: String,
                default: 'organizer'
            },
            bidderId: {
                type: [String, Number],
                default: '0'
            },
            answerId: {
                type: [String, Number],
                default: null
            },
            admin: {
                type: Boolean,
                default: false
            }
        },
        components: {
            StarRating
        },
        data() {
            return {
                loading: false,
                rating: {
                    estimate: 0,
                    comment: "",
                    bidderId: 0,
                    type: "organizer",
                    answerId: null
                },
                types: {
                    organizer: 'организатора торгов',
                    arbitrationManager: 'арбитражного управляющего',
                    answer: 'ответ организатора'
                }
            };
        },
        methods: {
            cancel() {
                this.$store.commit('closeModal', '#'+this.id);
                this.rating = {
                    estimate: 0,
                    comment: "",
                    bidderId: this.bidderId,
                    type: this.type,
                    answerId: this.answerId
                }
                this.$emit('cancel');
            },
            chooseSave() {
                if(this.admin) {
                    this.rating.answerId = this.answerId;
                    this.$emit('save', this.rating);
                }
                else {
                    this.save()
                }
            },
            save() {
                this.loading = true;
                this.rating.bidderId = this.bidderId;
                this.rating.type = this.type;
                this.rating.answerId = this.answerId;
                this.method='Bidder';
                if(this.type === 'answer') {
                    this.method='Answer';
                }
                this.$store.dispatch('estimate'+this.method, this.rating)
                    .then(resp => {
                        this.loading = false;
                        this.$emit('estimated', resp.data);
                        this.$store.dispatch('sendNotification',
                            {self: this, message: 'Оценка успешно сохранена'});
                        this.cancel();
                    }).catch(error => {
                    this.loading = false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
