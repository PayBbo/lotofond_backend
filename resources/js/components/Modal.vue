<template>
    <div class="modal fade bkt-modal" tabindex="-1"
         :id="id" :class="modal_class"
         data-bs-backdrop="static" data-bs-keyboard="false"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="bkt-modal-wrapper">
                <slot name="aside">
                </slot>
                <div class="modal-content bkt-modal-content">
                    <div class="bkt-modal-header" v-if="!no_header">
                        <slot name="header">
                            <h3 class="bkt-modal__title" v-if="!no_title">{{title}}</h3>
                            <button type="button" :class="close_button_class" data-bs-dismiss="modal" aria-label="Close">
                                <bkt-icon :name="'Cancel'" :width="'13px'" :height="'13px'"></bkt-icon>
                            </button>
                        </slot>
                    </div>
                    <div class="bkt-modal-body">
                        <slot name="body">
                        </slot>
                    </div>
                    <div class="bkt-modal-footer" v-if="!no_footer">
                        <slot name="footer">
                            <slot name="left_button">
                                <button type="button" :class="left_button_class" @click="left_method">
                                    <slot name="left_button_inner">
                                    <bkt-icon :name="'Trash'" :width="'22px'" :height="'22px'"></bkt-icon>
                                    {{left_button}}
                                    </slot>
                                </button>
                            </slot>
                            <button type="button" :class="right_button_class" @click="right_method">{{right_button}}</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            // description: {
            //     type: String,
            //     default: 'Вы уверены, что хотите совершить данное действие?'
            // },
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
                default: 'bkt-button bg-primary bkt-modal-save'
            },
            left_button_class: {
                type: String,
                default: 'bkt-button bg-red-lighter bkt-modal-delete'
            },
            modal_class: {
                type: String,
                default: ''
            },
            close_button_class:{
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
            return {

            }
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
                this.$emit('right-action');
                if (this.right_action) {
                    this.right_action();
                    return;
                }
            }
        }
    }
</script>

<style scoped>

</style>
