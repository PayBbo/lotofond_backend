<template>
    <div class="bkt-collapse" :class="main_class">
        <div class="collapse bkt-collapse__body" :class="collapse_class" :id="id" v-if="!disabled">
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
        <div class="bkt-collapse__header" :class="header_class">
            <slot name="title">
                <h3 class="bkt-card__title" :class="title_class" v-if="title" data-bs-toggle="collapse" :data-bs-target="'#'+id">
                    <slot name="title-inner">
                         <span v-if="count>=0" :class="[count>0 ? 'bkt-text-green' : 'bkt-text-neutral-dark']">
                            ({{count}})
                        </span>
                        {{title}}
                    </slot>
                </h3>
            </slot>
            <button class="bkt-collapse__button bkt-button-icon"
                    :class="[collapse_button_class, disabled ? 'bkt-button_disabled' :'']" data-bs-toggle="collapse"
                    :data-bs-target="'#'+id" aria-expanded="false" :disabled="loading||count==0||disabled"
            >
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status"></span>
                <bkt-icon v-else :name="'ArrowDown'" class="bkt-button__icon"
                          :color="disabled ? 'neutral-dark' :'primary'"></bkt-icon>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Collapse",
        props: {
            id: {
                type: String,
                default: 'bkt-collapse',
                required: true
            },
            title: {
                type: String
            },
            title_class: {
                type: String,
                default: 'bkt-collapse__title'
            },
            main_class: {
                type: String,
                default: 'bkt-card bkt-card__body'
            },
            header_class: {
                type: String
            },
            collapse_class: {
                type: String
            },
            collapse_button_class: {
                type: String,
                default: 'bkt-bg-body'
            },
            count: {
                type: [String, Number]
            },
            loading: {
                type: Boolean,
                default: false
            },
            disabled: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style scoped>

</style>
