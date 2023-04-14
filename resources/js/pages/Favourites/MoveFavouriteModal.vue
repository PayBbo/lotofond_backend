<template>
    <bkt-modal :id="'moveFavouriteModal'" :modal_class="'bkt-folder-modal'"
               title="Переместить в:" :loading="loading">
        <template #body="{ invalid }">
            <div class="bkt-wrapper-column bkt-gap">
                <div v-for="(path, index) in items_paths" :key="index">
                    <button @click="setNewPath(path.pathId)"
                            class="bkt-button w-100 bkt-button_plump text-uppercase text-break"
                            :class="[newPathId === path.pathId && path.color ? 'bkt-bg-'+path.color : '',
                                {'bkt-bg-primary': newPathId === path.pathId && !path.color,
                                'bkt-bg-body bkt-text-main': newPathId !== path.pathId}]"
                    >
                        {{path.name}}
                        <span class="bkt-badge"
                              :class="[
                                  path.color ? 'bkt-text-'+path.color : 'bkt-text-primary',
                                  newPathId !== path.pathId && path.color ? 'bkt-bg-'+path.color+'-lighter' : '',
                                  {
                                      'bkt-bg-white': newPathId === path.pathId,
                                      'bkt-bg-primary-lighter': newPathId !== path.pathId && !path.color
                                  }
                              ]"
                        >
                            {{path.lotCount ? path.lotCount : '0'}}
                        </span>
                    </button>
                </div>
            </div>
        </template>
        <template #footer="{ invalid }">
            <button class="w-100 bkt-button primary bkt-button_plump text-break" @click="move" :disabled="loading || !newPathId">
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status"></span>
                Переместить {{newPath && newPath.name ? 'в папку "'+newPath.name+'"' : ''}}
            </button>
        </template>
    </bkt-modal>
</template>

<script>
    export default {
        name: "MoveFavouriteModal",
        data() {
            return {
                loading: false,
                newPathId: '',
                newPath: null
            };
        },
        mounted() {
            if (this.items_paths.length == 0) {
                this.getFavouritePaths();
            }
        },
        computed: {
            item() {
                return this.$store.getters.selected_lot
            },
            items_paths() {
                let paths = this.$store.getters.favourites_paths;
                if (this.item && this.item.favouritePaths) {
                    paths = paths.filter(item => item.pathId != this.item.favouritePaths[0].pathId)
                    if (paths.length > 0) {
                        this.newPathId = paths[0].pathId;
                        this.newPath = paths[0];
                    }
                    return paths;
                }
                return paths;
            },
        },
        methods: {
            async getFavouritePaths() {
                this.loading = true;
                await this.$store.dispatch('getFavouritePaths')
                    .finally(() => {
                        this.loading = false;
                    });
            },
            async move() {
                this.loading = true;
                let currentPathId = 0;
                if (this.item && this.item.favouritePaths && this.item.favouritePaths.length > 0) {
                    currentPathId = this.item.favouritePaths[0].pathId
                }
                let payload = {
                    currentPathId: currentPathId,
                    newPathId: this.newPathId,
                    newPath: this.newPath,
                    lotId: this.item.id
                };
                await this.$store.dispatch('moveFavourite', payload)
                    .then(resp => {
                        this.$emit('moveFavourite', payload);
                        this.$store.dispatch('saveDataProperty', {
                            module_key: 'lots', state_key: 'selected_lot',
                            key: 'favouritePaths',
                            value: [this.newPath]
                        }, {root: true});
                        this.$store.commit('closeModal', '#moveFavouriteModal');
                        this.loading = false;
                    })
                    .catch(err => {
                        this.loading = false;
                    });
            },
            setNewPath(id) {
                let index = this.items_paths.findIndex(item => item.pathId == id);
                // if(index>=0) {
                this.newPath = this.items_paths[index];
                this.newPathId = id;
                // }
            }
        }
    }
</script>

<style scoped>

</style>
