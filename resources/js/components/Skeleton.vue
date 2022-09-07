<template>
    <fragment>
        <slot>
            <template v-for="(n,index) in count">
                <component :is="tag" :key="index" class="bkt-skeleton" :style="style"
                     :class="['bkt-skeleton__'+type_name, skeleton_class]"
                >
                </component>
            </template>
        </slot>
    </fragment>
</template>

<script>
    export default {
        name: "Skeleton",
        props: {
            tag: {
                type: String,
                default:'div'
            },
            type_name: {
                type: String,
                default:'item'
            },
            skeleton_class: {
                type: String,
                default:''
            },
            count: {
                type: Number,
                default:1
            },
            width: {
                type: [String, Number],
                default: 0
            },
            height: {
                type: [String, Number],
                default: 0
            },
            circle: Boolean,
        },
        computed: {
            style() {
                let style = {}
                if(this.width) {
                    style.width = this.width;
                }
                if(this.height) {
                    style.height = this.height;
                }
                if (this.circle) style.borderRadius = "50%";
                return style
            }
        }
    }
</script>

<style scoped>

</style>
