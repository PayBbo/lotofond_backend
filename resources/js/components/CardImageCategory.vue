<template>
    <div class="bkt-card__image-category bkt-gap bkt-nowrap" v-if="icons.length>0"
         :class="[{'bkt-card__image-category_multiple':icons.length>1}, 'bkt-bg-'+categories_colors[icons[0].key]+'-lighter']"
    >
        <span v-for="category in icons">
            <bkt-icon :name="'categories/'+category.key" :color="categories_colors[icons[0].key]"></bkt-icon>
        </span>
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
                    "productionLines": "pink",
                    "obligations": "purple",
                    "accountsReceivable": "primary",
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
                        color: 'pink'
                    },
                    {
                        "label": "Ценные бумаги",
                        "key": "obligations",
                        icon: 'File',
                        color: 'purple'
                    },
                    {
                        "label": "Дебиторская задолженность",
                        "key": "accountsReceivable",
                        icon: 'Percentage',
                        color: 'primary'
                    }
                ],
            }
        },
        computed: {
            icons() {
                let tmp = [];
                tmp = this.categories;
                if (tmp.length == 0) {
                    tmp.push({key: 'other', color: 'primary'})
                }
                if(this.no_multiple && tmp.length>1) {
                    tmp = [this.categories[0]];
                }
                return tmp
            },
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
