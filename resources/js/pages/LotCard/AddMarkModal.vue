<template>
    <bkt-modal :id="'addMarkModal'" ref="addMarkModal" :modal_class="'bkt-folder-modal'"
               :title="'Создать метку для лота'" :loading="loading || !item" @left_action="cancel" @right_action="save">
        <template #body="{ invalid }">
            <bkt-input v-model="mark.mark"
                       rules="required"
                       name="mark_title"
                       placeholder="Введите название метки"
                       label="название метки"
                       no_group_item
            >
            </bkt-input>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "AddMarkModal",
        data() {
            return {
                loading: false,
                mark: {
                    mark: '',
                    lotId: '',
                },
            };
        },
        computed: {
            item() {
                return this.$store.getters.selected_lot
            }
        },
        methods: {
            cancel() {
                this.$store.commit('closeModal', '#addMarkModal');
                this.mark = {
                    mark: '',
                    lotId: '',
                };
            },
            save() {
                this.loading = true;
                this.mark.lotId = this.item.id;
                this.$store.dispatch('addLotMark', this.mark)
                    .then(resp => {
                        this.$store.commit('closeModal', '#addMarkModal');
                        this.$store.commit('saveTradeProperty', {
                            id: this.item.id,
                            key: 'marks',
                            value: this.item.marks
                        });
                        this.mark = {
                            mark: '',
                            lotId: '',
                        };
                        this.loading = false;
                    }).catch(error => {
                    this.loading = false;
                });

            }
        }
    }
</script>

<style scoped>

</style>
