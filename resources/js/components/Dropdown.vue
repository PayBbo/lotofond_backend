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
                            {{item}}
                        </slot>
                    </div>
                    <div class="bkt-dropdown__item-icon">
                        <bkt-icon :name="icon" color="primary"></bkt-icon>
                    </div>
                </slot>
            </div>
        </slot>

        <div class="bkt-dropdown__menu dropdown-menu" :class="dropdown_menu_class"
             :aria-labelledby="id">
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
            }
        }
    }
</script>

<style scoped>

</style>
