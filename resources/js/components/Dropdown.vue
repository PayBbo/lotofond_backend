<template>
    <div class="bkt-dropdown">
        <slot name="item">
            <div class="bkt-dropdown__item"
                 :id="id" :class="dropdown_item_class"
                 data-bs-toggle="dropdown"
                 aria-expanded="false"
            >
                <slot name="item_wrapper">
                    <div class="bkt-dropdown__item-inner text-truncate">
                        <slot name="item_inner">
                            <h5 class="text-truncate bkt-dropdown__title" v-if="title">
                                {{title}}
                            </h5>
                            <h6 class="bkt-dropdown__subtitle" v-if="subtitle">
                                {{subtitle}}
                            </h6>
                        </slot>
                    </div>
                    <slot name="icon_wrapper">
                        <div class="bkt-dropdown__item-icon" :class="dropdown_icon_class">
                            <bkt-icon :name="icon" color="primary" width="22px" height="22px"></bkt-icon>
                        </div>
                    </slot>
                </slot>
            </div>
        </slot>

        <div class="bkt-dropdown__menu dropdown-menu" :class="dropdown_menu_class" :aria-labelledby="id">
            <slot name="menu">

            </slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Dropdown",
        props: {
            id: {
                default:'bkt-dropdown'
            },
            item: {
            },
            title: {
               default:'',
            },
            subtitle: {
               default:'',
            },
            icon: {
               default:'ArrowDown',
            },
            type: {
                default:'list'
            },
            dropdown_item_class: {
                default:''
            },
            dropdown_menu_class: {
                default:''
            },
            dropdown_icon_class: {
                default:''
            }
        }
    }
</script>

<style scoped>

</style>
