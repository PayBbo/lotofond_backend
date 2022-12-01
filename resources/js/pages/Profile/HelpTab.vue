<template>
    <div class="bkt-wrapper-column">
        <bkt-collapse main_class="bkt-card bkt-notifications-card" collapse_button_class="bkt-bg-white"
                      v-for="(item, index) in help" :id="'question'+index" :key="index" :loading="loading"
        >
            <template #title>
                <h4 class="bkt-card__title" data-bs-toggle="collapse" :data-bs-target="'#question'+index">
                   {{item.header}}
                </h4>
            </template>
            <template #collapse>
                <p class="bkt-card__text">
                   {{item.value}}
                </p>
            </template>
        </bkt-collapse>
    </div>
</template>

<script>
    import BktCollapse from '../../components/Collapse.vue';

    export default {
        name: "HelpTab",
        components: {
            BktCollapse
        },
        data() {
            return {
                loading: false,
            }
        },
        computed: {
            help() {
                return this.$store.getters.help;
            },
        },
        mounted() {
            if(this.help.length===0 || !this.help) {
                this.getHelp();
            }
        },
        methods: {
            getHelp() {
                this.loading = true;
                this.$store.dispatch('getHelp').then(resp => {
                    this.loading=false;
                }).catch(error => {
                    this.loading=false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
