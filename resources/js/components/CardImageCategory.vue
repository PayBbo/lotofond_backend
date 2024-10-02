<template>
    <div class="bkt-card__image-category bkt-gap bkt-nowrap"
         :class="[{'bkt-card__image-category_multiple':(!rules || (rules && rules.categories)) && icons.length>1 },
         (!rules || (rules && (rules.categories || rules.photos))) ? 'bkt-bg-'+categories_colors[icons[0].key]+'-lighter' : 'bkt-bg-neutral-light'
        ]"
    >
        <skeleton type_name="spoiler_mini" tag="h1" skeleton_class="bkt-text-neutral-dark"
                  v-if="rules && (!rules.categories||!rules.photos)"
                  :loading="rules && (!rules.categories||!rules.photos)"
        >
        </skeleton>
        <template v-if="icons.length>0 && ((rules&&rules.categories) || !rules)">
            <span v-for="(category, index) in icons" :key="category.key+'-'+index">
                <bkt-icon :name="'categories/'+category.key" :color="categories_colors[icons[0].key]" :key="category.key+'-'+index"></bkt-icon>
            </span>
        </template>
    </div>
</template>

<script>
    export default {
        name: "CardImageCategory",
        props:{
            no_multiple: {
                default: false
            },
            categories: {
                default: function () {
                    return [];
                }
            }
        },
        data() {
            return {
                color: 'primary',
                // icons: [],
                categories_colors: {
                    "realEstate": "green",
                    "other": "main",
                    "equipment": "red",
                    "transportAndEquipment": "orange",
                    "agriculturaProperty": "blue",
                    "tangibles": "yellow",
                    "productionLines": "purple",
                    "obligations": "teal",
                    "accountsReceivable": "primary",
                    "torgi": "indigo",
                },
                categories_icons: [
                    {
                        "label": "Недвижимость",
                        "key": "realEstate",
                        icon: 'Home',
                        color: 'green'
                    },
                    {
                        "label": "Прочее",
                        "key": "other",
                        icon: 'More',
                        color: 'main'
                    },
                    {
                        "label": "Оборудование",
                        "key": "equipment",
                        icon: 'Gear',
                        color: 'red'
                    },
                    {
                        "label": "Транспорт и техника",
                        "key": "transportAndEquipment",
                        icon: 'Car',
                        color: 'orange'
                    },
                    {
                        "label": "Сельскохозяйственное имущество",
                        "key": "agriculturaProperty",
                        icon: 'Cow',
                        color: 'blue'
                    },
                    {
                        "label": "Товарно-материальные ценности",
                        "key": "tangibles",
                        icon: 'Wrench',
                        color: 'yellow'
                    },
                    {
                        "label": "Производственные линии",
                        "key": "productionLines",
                        icon: 'MechanicalArm',
                        color: 'purple'
                    },
                    {
                        "label": "Ценные бумаги",
                        "key": "obligations",
                        icon: 'File',
                        color: 'teal'
                    },
                    {
                        "label": "Дебиторская задолженность",
                        "key": "accountsReceivable",
                        icon: 'Percentage',
                        color: 'primary'
                    },
                    {
                        "label": "ГИС Торги",
                        "key": "torgi",
                        icon: 'torgi',
                        color: 'indigo'
                    }
                ],
            }
        },
        computed: {
            icons() {
                let tmp = [];
                if (this.categories != null) {
                    tmp = this.categories;
                }
                if (tmp.length == 0) {
                    tmp.push({key: 'other', color: 'primary'})
                }
                if(this.no_multiple && tmp.length>1) {
                    tmp = [this.categories[0]];
                }
                return tmp
            },
            rules() {
                return this.$store.getters.rules
            }
        },
        mounted() {
            // this.icons = this.categories_icons.filter(value => this.categories.map(item => item.key).includes(value.key));
            // if (this.icons.length > 0) {
            //     this.color = this.icons[0].color;
            // } else {
            //     this.icons.push({key: 'other', color: 'primary'})
            // }
            // this.icons = this.categories;
            // if (this.icons.length == 0) {
            //     this.icons.push({key: 'other', color: 'primary'})
            // }
        }
    }
</script>

<style scoped>

</style>
