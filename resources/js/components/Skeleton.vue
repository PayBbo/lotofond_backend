<template>
    <fragment>
        <template v-for="(n,index) in count" v-if="showSkeleton">
            <component :is="tag" :key="index" class="bkt-skeleton" :style="style"
                       :class="['bkt-skeleton__'+type_name, skeleton_class]"
            >
            </component>
        </template>
        <slot v-else>

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
            loading: {
                type: [Boolean, Object, Array],
                default: null
            }
        },
        data() {
            return {
                showSkeleton: true,
                hasSlotContent: false,
            }
        },
        computed: {
            style() {
                let style = {};
                if(this.width) {
                    style.width = this.width;
                }
                if(this.height) {
                    style.height = this.height;
                }
                if (this.circle) style.borderRadius = "50%";
                return style
            },
            // isEmptyVNode() {
            //     if(!this.$slots.default) return true;
            //     const [firstNode] = this.$slots.default;
            //     let str = firstNode.children;
            //     return !firstNode.elm && !str;
            // },
            // isLoading() {
            //     return this.loading !== null
            //         ? this.loading
            //         : this.isEmptyVNode;
            // }
        },
        methods: {
            // checkForSlotContent() {
            //     let checkForContent = (hasContent, node) => {
            //         if(hasContent || node.tag || (node.text && node.text.trim() !== '')) return true;
            //         return false;
            //     }
            //     return this.$slots.default && this.$slots.default.reduce(checkForContent, false);
            // },
            isEmpty() {
                if(!this.$slots.default) return true;
                const [firstNode] = this.$slots.default;
                let children = firstNode.children;
                let str = firstNode.text;
                return !firstNode.elm && !children && !str;
            },
        },
        beforeUpdate() {
            // this.hasSlotContent = this.checkForSlotContent();
            this.showSkeleton = this.loading !== null
                ? this.loading
                : this.isEmpty();
            if(!this.$slots.default || this.$slots.default[0].text=='' || this.$slots.default[0].text) {
                this.showSkeleton = this.loading !== null
                    ? this.loading
                    : false;
            }
        },
        created() {
            // this.hasSlotContent = this.checkForSlotContent();
            this.showSkeleton = this.loading !== null
                ? this.loading
                : this.isEmpty();
        },
        mounted() {
            this.showSkeleton = this.loading !== null
                ? this.loading
                : this.isEmpty();
        }
    }
</script>

<style scoped>

</style>
