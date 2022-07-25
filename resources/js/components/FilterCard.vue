<template>
    <div class="bkt-card__row">
        <div class="col-10">
            <div class="bkt-card__row-column">
                <h4 class="bkt-card__title" v-html="title"></h4>
                <h5 class="bkt-card__subtitle" :class="{'bkt-text-green': total>0}">
                    {{total>0 ?'' : 'ничего не'}} выбрано {{total>0 ? total : ''}}
                </h5>
                <button class="bkt-button" :class="[total>0 ? 'primary-lighter': 'primary']" @click="openModal">
                    {{total>0 ? 'Изменить' : 'Выбрать'}}
                </button>
            </div>
        </div>
        <div class="col-2">
            <div class="bkt-card__category ms-auto" :class="category_class">
                <span class="bkt-card__category-icon">
                    <bkt-icon v-bind="icon"></bkt-icon>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FilterCard",
        props:['title', 'count', 'modal_name', 'icon', 'category_class'],
        computed: {
            total() {
                let total = JSON.parse(JSON.stringify(this.count));
                if(total.other)
                {
                    total.other = null
                }
                return Object.values(total)
                    .reduce((r, o) => {
                        // if(r && o) {
                        if (typeof o === 'object') {
                            if (o != null) {
                                Object.values(o).forEach(item => {
                                    if (item) {
                                        r++;
                                    }
                                });
                            }
                        }
                        if (typeof o === 'string') {
                            if (o !== '') {
                                r++;
                            }
                        }
                        // if (Array.isArray(o)) {
                        //     o.forEach(item => {
                        //         if (item) {
                        //             r++;
                        //         }
                        //         console.log('item', r, item)
                        //     });
                        // }
                        return r;
                        // }
                        // return 0;
                    }, 0);
            }
        },
        methods: {
            openModal() {
                this.$store.commit('openModal', this.modal_name);
            },
        }
    }
</script>

<style scoped>

</style>
