<template>
    <ValidationProvider :name="field_label" :rules="rules" v-slot="{ errors }" tag="div" :vid="name">
        <label class="bkt-select__label" v-if="label" :class="label_class">{{label}}</label>
        <div class="bkt-select__wrapper" :class="select_class">
            <v-select
                :multiple="multiple"
                class="bkt-v-select order-2"
                :class="[model ?'vs--selected' : '', errors && errors.length>0 ? 'error':'', additional_class]"
                :placeholder="placeholder"
                v-model="model"
                :label="option_label"
                :reduce="reduce"
                :options="options"
                :clearable="clearable"
                :searchable="searchable"
                :disabled="disabled"
                :loading="loading"
                @input="saveValue"
                :filter="fuseSearch"
                @open="open"
            >
                <template v-slot:option="option" v-if="with_option">
                    <slot name="option" v-bind:option="option">
                    </slot>
                </template>
                <template #selected-option="option" v-if="with_selected_option">
                    <slot name="selected-option" v-bind:option="option">
                    </slot>
                </template>
<!--                <template #selected-option-container="{ option, deselect, multiple, disabled }">-->
<!--                    <slot name="selected-option-container" v-bind="{ option, deselect, multiple, disabled }">-->
<!--                    </slot>-->
<!--                </template>-->
                <template #no-options="{ search, searching, loading }">
                    <div v-if="method_name">
                        <infinite-loading
                            @infinite="infiniteHandler"
                            :ref="method_name"
                            :distance="15"
                            spinner="waveDots"
                            force-use-infinite-wrapper=".vs__dropdown-menu"
                        >
                            <span slot="no-results"></span>
                            <span slot="no-more"></span>
                        </infinite-loading>
                    </div>
                    <div v-if="!method_name || $refs[method_name] && $refs[method_name].status!==1">Элементы не найдены</div>
                </template>

                <template #list-footer="{ filteredOptions }" v-if="method_name && pagination">
                    <li v-if="pagination && pagination.nextPageUrl !==null && filteredOptions.length>0">
                        <infinite-loading
                            @infinite="infiniteHandler"
                            :ref="method_name"
                            :distance="15"
                            spinner="waveDots"
                            force-use-infinite-wrapper=".vs__dropdown-menu"
                        >
                            <span slot="no-results"></span>
                            <span slot="no-more"></span>
                        </infinite-loading>
                    </li>
                </template>
            </v-select>
            <slot name="subtitle" v-if="subtitle">
                <label class="bkt-select__subtitle">{{subtitle}}</label>
            </slot>
        </div>
    </ValidationProvider>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';
    import Fuse from 'fuse.js';
    export default {
        name: "Select",
        components: {
            InfiniteLoading,
        },
        props: {
            value: {

            },
            name: {
                type: String,
                required: true,
            },
            field_name: {
                type: String,
            },
            label: {
                type: String,
            },
            label_class: {
                type: String,
            },
            select_class: {
                type: String,
                default: ''
            },
            placeholder: {
                type: String,
            },
            pagination:{
                required: false,
            },
            option_label: {
                type: String,
            },
            options:{
                type: Array,
                required: true,
                default: function(){
                    return [];
                }
            },
            method_name: {
                type: String,
                default: ''
            },
            method_params: {
            },
            selected_class: {
                type: Boolean,
                default: false
            },
            reduce: {
                type: Function,
                // default: function(){
                //
                // }
            },
            additional_class: {
                type: String
            },
            with_option: {
                type: Boolean,
                default: false
            },
            with_selected_option: {
                type: Boolean,
                default: false
            },
            multiple: {
                type: Boolean,
                default: false
            },
            disabled: {
                type: Boolean,
                default: false
            },
            loading: {
                type: Boolean,
                default: false
            },
            clearable: {
                type: Boolean,
                default: true
            },
            searchable: {
                type: Boolean,
                default: false
            },
            rules: {
                type: String,
                default: "",
            },
            subtitle: {
                type: String,
                default: "",
            },
        },
        model: {
            prop: 'value',
            event: 'input'
        },
        data: function() {
            return {
                searchOptions: {
                    shouldSort: false,
                    threshold: 0.2,
                    keys: []
                },
                results: [],
                infinite_loading: false,
                field_label:''
            };
        },
        mounted() {
            if(!this.field_name) {
                this.field_label = this.label;
                if (!this.label) {
                    this.field_label = this.name;
                }
            }
            this.makeSearchOptions();
            if(this.options.length ==0 && this.value) {
                this.infiniteHandler();
            }
            // this.select_value = this.value;
        },
        computed: {
            model: {
                get() {
                    return this.value;
                },
                set(value) {
                    this.$emit("input", value);
                },
            },
        },
        watch:{
            options: function(){
                this.makeSearchOptions();
            },
            // value: function(){
            //     this.select_value = this.value;
            // },
        },
        methods: {
            saveValue(value) {
                this.$emit('input', value);
            },
            makeSearchOptions() {
                if( this.searchOptions.keys.length === 0)
                {
                    this.searchOptions.keys=[];
                    if (this.options.length > 0){
                        // this.$set(this.searchOptions, 'keys',  Object.keys(this.options[0]))
                        Object.entries(this.options[0]).forEach(([key, value]) => {
                            if(typeof value !== 'object' && value !== null && !Array.isArray(value)) {
                                this.searchOptions.keys.push(key);
                            }
                        });
                        // this.searchOptions.keys = Object.keys(this.options[0])
                    }
                }

            },
            async infiniteHandler($state) {
                let page = 0;

                if(this.pagination){
                    page = this.pagination.currentPage;
                    if (this.pagination.nextPageUrl !== null) {
                        this.infinite_loading = true;
                        let payload = page+1;
                        if(this.method_params)
                        {
                            payload = this.method_params;
                            payload.page = page+1;
                        }
                        await this.$store.dispatch(this.method_name, payload).then(resp => {
                            if($state) {
                                if (this.pagination.nextPageUrl !== null) {
                                    $state.loaded();
                                } else {
                                    $state.complete();
                                }
                            }

                        }).finally(() => {
                            this.infinite_loading = false;
                        });
                    }
                    else {
                        $state.complete();
                    }
                }
                else {
                    if(this.method_name)
                    {
                        let payload = page+1;
                        if(this.method_params)
                        {
                            payload = this.method_params;
                            payload.page = page+1;
                        }
                        await this.$store.dispatch(this.method_name, payload).then(resp => {
                            if($state) {
                                if (this.pagination.nextPageUrl !== null) {
                                    $state.loaded();
                                } else {
                                    $state.complete();
                                }
                            }
                        });
                    }
                }

            },
            fuseSearch(options, search) {
                const fuse = new Fuse(options, this.searchOptions);
                if(this.$refs[this.method_name] && this.$refs[this.method_name].status!==1) {
                    this.$refs[this.method_name].status = 1;
                    this.$refs[this.method_name].$emit('infinite', this.$refs[this.method_name].stateChanger);
                }
                return search.length
                    ? fuse.search(search).map(({ item }) => item)
                    : fuse.list
            },
            open() {
                this.$emit('open');
                if(this.options.length===0) {
                    if(this.$refs[this.method_name] && this.$refs[this.method_name].status!==1) {
                        this.$refs[this.method_name].status = 1;
                        this.$refs[this.method_name].$emit('infinite', this.$refs[this.method_name].stateChanger);
                    }
                }
            },
        }
    }
</script>

<style scoped>

</style>
