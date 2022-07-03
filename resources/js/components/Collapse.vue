<template>
    <div :class="main_class">
        <div class="bkt-wrapper-between bkt-nowrap">
            <slot name="title">
                <h3 class="bkt-card__title" v-if="title">
                    <slot name="title-inner">
                        {{title}}
                        <span v-if="count>=0" :class="[count>0 ? 'bkt-text-green' : 'bkt-text-neutral-dark']">
                            ({{count}})
                        </span>
                    </slot>
                </h3>
            </slot>
            <button class="bkt-button-icon" :class="collapse_button_class" data-bs-toggle="collapse"
                    :data-bs-target="'#'+id" aria-expanded="false" :disabled="loading||count==0"
            >
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status"></span>
                <bkt-icon v-else :name="'ArrowDown'" class="bkt-button__icon"></bkt-icon>
            </button>
        </div>
        <div class="collapse" :class="collapse_class" :id="id">
            <slot name="collapse" v-if="!loading">
            </slot>
            <div v-if="loading" class="d-flex w-100 justify-content-center mb-5">
                <slot name="loading">
                    <div
                        style="color: #2953ff;border-width: 2px;"
                        class="spinner-border"
                        role="status"
                    ></div>
                </slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Collapse",
        props: {
            id: {
                type: String,
                required: true
            },
            title: {
                type: String
            },
            main_class: {
                type: String,
                default:'bkt-card bkt-card__body'
            },
            collapse_class: {
                type: String
            },
            collapse_button_class: {
                type: String,
                default:'bkt-bg-body'
            },
            count: {
                type: [String, Number]
            },
            loading: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style scoped>

</style>
