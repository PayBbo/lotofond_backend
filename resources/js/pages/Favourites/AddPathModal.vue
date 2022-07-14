<template>
    <bkt-modal :id="'addPathModal'" ref="addPathModal" :modal_class="'bkt-folder-modal'"
               :title="'Создать папку'" :loading="loading"  @left_action="cancel" @right_action="save">
        <template #body="{ invalid }">
            <div>
                <bkt-input v-model="path.name"
                           rules="required"
                           name="name_folder"
                           placeholder="Введите название папки"
                           label="название папки"
                           no_group_item
                >
                </bkt-input>
<!--                <div class="bkt-user-checkboxes mt-4" v-if="selBtn == 2">-->
<!--                    <div class="bkt bkt-user" v-for="(user, index) in users">-->
<!--                        <bkt-checkbox :label="user.name"/>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="bkt-wrapper">
                    <bkt-checkbox v-model="path.color" val="yellow" name="yellow" type="radio"
                                  class="bkt-check_color" check_color="yellow"
                                  :border_color="path.color === 'yellow' ? 'yellow' : ''"
                    >
                    </bkt-checkbox>
                    <bkt-checkbox v-model="path.color" val="blue" name="blue" type="radio"
                                  class="bkt-check_color" check_color="blue"
                                  :border_color="path.color === 'blue' ? 'blue' : ''"
                    >
                    </bkt-checkbox>
                    <bkt-checkbox v-model="path.color" val="pink" name="pink" type="radio"
                                  class="bkt-check_color" check_color="pink"
                                  :border_color="path.color === 'pink' ? 'pink' : ''"
                    >
                    </bkt-checkbox>
                    <bkt-checkbox v-model="path.color" val="green" name="green" type="radio"
                                  class="bkt-check_color" check_color="green"
                                  :border_color="path.color === 'green' ? 'green' : ''"
                    >
                    </bkt-checkbox>
                    <bkt-checkbox v-model="path.color" val="red" name="red" type="radio"
                                  class="bkt-check_color" check_color="red"
                                  :border_color="path.color === 'red' ? 'red' : ''"
                    >
                    </bkt-checkbox>
                    <bkt-checkbox v-model="path.color" val="main" name="main" type="radio"
                                  class="bkt-check_color" check_color="main"
                                  :border_color="path.color === 'main' ? 'main' : ''"
                    >
                    </bkt-checkbox>
                    <bkt-checkbox v-model="path.color" val="primary" name="primary" type="radio"
                                  class="bkt-check_color" check_color="primary"
                                  :border_color="path.color === 'primary' ? 'primary' : ''"
                    >
                    </bkt-checkbox>
                </div>
            </div>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "CreatePathModal",
        data() {
            return {
                loading: false,
                path: {
                    name: '',
                    pathId: 0,
                    color: 'yellow'
                },
            };
        },
        methods: {
            cancel() {
                this.$store.commit('closeModal', '#addPathModal');
                this.path = {
                    name: '',
                    pathId: 0,
                    color: 'yellow'
                };
            },
            save() {
                this.$store.commit('closeModal', '#addPathModal');
            }
        }
    }
</script>

<style scoped>

</style>
