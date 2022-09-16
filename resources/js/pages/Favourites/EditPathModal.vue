<template>
    <bkt-modal :id="'editPathModal'" ref="addPathModal" :modal_class="'bkt-folder-modal'"
               :title="`Редактировать папку <span class='text-uppercase bkt-text-primary'>${edit_path.name}</span>`"
               :loading="loading"  @left_action="cancel" @right_action="save">
        <template #body="{ invalid }">
            <div class="bkt-wrapper-column bkt-gap-large">
                <bkt-input v-model="edit_path.name"
                           rules="required"
                           name="edit_name_folder"
                           placeholder="Введите название папки"
                           label="название папки"
                           no_group_item
                >
                </bkt-input>
                <div class="bkt-wrapper mx-0">
                    <bkt-checkbox v-model="edit_path.color" val="yellow" name="edit-yellow" type="radio"
                                  rules="required"
                                  class="bkt-check_color" check_color="yellow"
                                  :border_color="edit_path.color === 'yellow' ? 'yellow' : ''"
                    >
                    </bkt-checkbox>
                    <bkt-checkbox v-model="edit_path.color" val="blue" name="edit-blue" type="radio"
                                  class="bkt-check_color" check_color="blue"
                                  :border_color="edit_path.color === 'blue' ? 'blue' : ''"
                    >
                    </bkt-checkbox>
                    <bkt-checkbox v-model="edit_path.color" val="pink" name="edit-pink" type="radio"
                                  class="bkt-check_color" check_color="pink"
                                  :border_color="edit_path.color === 'pink' ? 'pink' : ''"
                    >
                    </bkt-checkbox>
                    <bkt-checkbox v-model="edit_path.color" val="green" name="edit-green" type="radio"
                                  class="bkt-check_color" check_color="green"
                                  :border_color="edit_path.color === 'green' ? 'green' : ''"
                    >
                    </bkt-checkbox>
                    <bkt-checkbox v-model="edit_path.color" val="red" name="edit-red" type="radio"
                                  class="bkt-check_color" check_color="red"
                                  :border_color="edit_path.color === 'red' ? 'red' : ''"
                    >
                    </bkt-checkbox>
                    <bkt-checkbox v-model="edit_path.color" val="main" name="edit-main" type="radio"
                                  class="bkt-check_color" check_color="main"
                                  :border_color="edit_path.color === 'main' ? 'main' : ''"
                    >
                    </bkt-checkbox>
                    <bkt-checkbox v-model="edit_path.color" val="primary" name="edit-primary" type="radio"
                                  class="bkt-check_color" check_color="primary"
                                  :border_color="edit_path.color === 'primary' ? 'primary' : ''"
                    >
                    </bkt-checkbox>
                </div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "EditPathModal",
        data() {
            return {
                loading: false,
                path: {
                    name: '',
                    pathId: 0,
                    color: '',
                },
                template: {
                    name: '',
                    pathId: 0,
                    color: 'yellow',
                },
            };
        },
        computed: {
            current_path() {
                return this.$store.getters.current_path;
            },
            paths() {
                return this.$store.getters.favourites_paths;
            },
            edit_path: {
                get() {
                    let index = this.paths.findIndex(item=> item.pathId === this.current_path);
                    if(index>=0)
                    {
                        return JSON.parse(JSON.stringify(this.paths[index]));
                    }
                    else {
                        return JSON.parse(JSON.stringify(this.template));
                    }

                },
                set(value) {
                    this.path = value;
                }
            },
        },
        methods: {
            cancel() {
                this.$store.commit('closeModal', '#editPathModal');
            },
            save() {
                this.loading = true;
                this.$store.dispatch('saveFavouritePath', this.edit_path)
                    .then(resp => {
                        this.$store.commit('closeModal', '#editPathModal');
                        this.loading = false;
                    })
                    .catch(err => {
                    this.loading = false;
                });

            }
        }
    }
</script>

<style scoped>

</style>
