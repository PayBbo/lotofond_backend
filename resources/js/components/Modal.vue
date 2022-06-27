<template>
    <transition name="modal-animation">
        <div class="modal bkt-modal" tabindex="-1"
             :id="id" aria-hidden="true"
             data-bs-backdrop="static" data-bs-keyboard="false"
        >
            <div :class="modal_class">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="bkt-modal-wrapper">
                        <slot name="aside">
                        </slot>
                        <ValidationObserver v-slot="{ invalid }" tag="div" class="modal-content bkt-modal-content">
                            <div class="bkt-modal-header" :invalid="invalid" v-if="!no_header">
                                <slot name="header">
                                    <h3 class="bkt-modal__title" v-if="!no_title">{{title}}</h3>
                                    <button type="button" :class="close_button_class" data-bs-dismiss="modal"
                                            aria-label="Close">
                                        <bkt-icon :name="'Cancel'" :width="'13px'" :height="'13px'"></bkt-icon>
                                    </button>
                                </slot>
                            </div>
                            <div class="bkt-modal-body">
                                <slot name="body" :invalid="invalid">
                                </slot>
                            </div>
                            <div class="bkt-modal-footer" v-if="!no_footer">
                                <slot name="footer" :invalid="invalid">
                                    <slot name="left_button">
                                        <button type="button" :class="left_button_class" @click="left_method" :disabled="loading">
                                            <slot name="left_button_inner">
                                                <bkt-icon :name="'Trash'" :width="'22px'" :height="'22px'"></bkt-icon>
                                                {{left_button}}
                                            </slot>
                                        </button>
                                    </slot>
                                    <button type="button" :class="right_button_class" :disabled="invalid||loading"
                                            @click="right_method">
                                        <span v-show="loading" class="spinner-border spinner-border-sm"
                                              role="status"></span>
                                        {{right_button}}
                                    </button>
                                </slot>
                            </div>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "BktModal",
        props: {
            id: {
                type: String,
                default: 'bkt-modal'
            },
            title: {
                type: String,
                default: 'Модальное окно'
            },
            loading: {
                type: Boolean,
                default: false
            },
            right_action: {
                type: Function,
                default: null
            },
            left_action: {
                type: Function,
                default: null
            },
            right_button: {
                type: String,
                default: 'Сохранить'
            },
            left_button: {
                type: String,
                default: ''
            },
            right_button_class: {
                type: String,
                default: 'bkt-button bkt-bg-primary bkt-modal-save'
            },
            left_button_class: {
                type: String,
                default: 'bkt-button bkt-bg-red-lighter bkt-modal-delete'
            },
            modal_class: {
                type: String,
                default: ''
            },
            close_button_class: {
                type: String,
                default: 'bkt-close-button bkt-button'
            },
            no_header: {
                type: Boolean,
                default: false
            },
            no_footer: {
                type: Boolean,
                default: false
            },
            no_title: {
                type: Boolean,
                default: false
            },
        },
        data() {
            return {}
        },
        methods: {
            left_method() {
                this.$emit('left_action');
                if (this.left_action) {
                    this.left_action();
                    return;
                }
            },
            right_method() {
                this.$emit('right_action');
                if (this.right_action) {
                    this.right_action();
                    return;
                }
            }
        }
    }
</script>

<style scoped>
    .modal-animation-enter-active,
    .modal-animation-leave-active {
        transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .modal-animation-enter-from,
    .modal-animation-leave-to {
        opacity: 0;
    }

    .modal-animation-inner-enter-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02) 0.15s;
    }

    .modal-animation-inner-leave-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .modal-animation-inner-enter-from {
        opacity: 0;
        transform: scale(0.8);
    }

    .modal-animation-inner-leave-to {
        transform: scale(0.8);
    }
</style>
