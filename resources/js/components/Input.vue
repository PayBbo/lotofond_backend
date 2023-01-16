<template>
    <ValidationProvider :name="field_name" :rules="rules" v-slot="{ errors }" tag="div" class="bkt-input__wrapper" :vid="name">
        <div class="d-flex align-items-center justify-content-between" v-if="label||status">
            <label :for="name" class="bkt-input__label" v-if="label" :class="label_class" v-html="label"></label>
            <slot name="status" v-if="status">
                <label :for="name" class="bkt-input__label" :class="status_class">{{ status }}</label>
            </slot>
        </div>
        <div class="bkt-input__group">
            <slot name="group-text">
            </slot>
            <input
                :type="type"
                class="bkt-input"
                :name="name"
                :key="name"
                :id="name"
                :value="display"
                :placeholder="placeholder"
                :disabled="disabled"
                @input="saveValue"
                v-mask="config"
            />
            <slot name="group-item"  v-if="!no_group_item">
                <div class="bkt-input__group-item"
                     :class="[{'active': group_item_action&&!disabled}, group_item_class]"
                     @click="clickGroupItem"
                >
                    <slot name="group-item-inner">
                        <div :class="group_item_inner_class">
                            <slot name="icon">
                                <bkt-icon :name="icon_name" :color="icon_color" :class="icon_class"></bkt-icon>
                            </slot>
                        </div>
                    </slot>
                </div>
            </slot>
        </div>
        <slot name="subtitle">
            <p class="bkt-input__label bkt-text-neutral" v-if="subtitle">{{subtitle}}</p>
        </slot>
        <slot name="errors" :errors="errors">
            <p class="bkt-input-error" :class="errors_class" v-if="errors.length>0 && !no_errors">{{errors[0]}}</p>
        </slot>
    </ValidationProvider>
</template>

<script>
    import mask from "../mask";
    export default {
        props: {
            type: {
                type: String,
                default: "text",
            },
            value: {
                type: [String, Number],
                default: "",
            },
            name: {
                type: String,
                required: true,
            },
            label: {
                type: String,
            },
            subtitle: {
                type: String,
            },
            label_class: {
                type: String,
            },
            field_name: {
                type: String,
                default: function () {
                    let field_label = this.label;
                    if (!this.label) {
                        field_label = this.name;
                    }
                    return field_label;
                }
            },
            status: {
                type: String,
            },
            status_class: {
                type: String,
            },
            placeholder: {
                type: String,
                default: "",
            },
            rules: {
                type: String,
                default: "",
            },
            icon_name: {
                type: String,
                default: "",
            },
            icon_color: {
                type: String,
            },
            icon_class: {
                type: String,
                default: "",
            },
            no_errors: {
                type: Boolean,
                default: false,
            },
            errors_class: {
                type: String,
                default: '',
            },
            no_group_item: {
                type: Boolean,
                default: false,
            },
            group_item_action: {
                type: Boolean,
                default: false,
            },
            group_item_class: {
                type: String,
                default: '',
            },
            group_item_inner_class: {
                type: String,
                default: 'bkt-input__icon',
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            loading: {
                type: Boolean,
                default: false,
            },
            mask: {
                type: [String, Array],
                default: "",
            },
            masked: {
                type: Boolean,
                default: false,
            },
        },
        data: function() {
            return {
                lastValue: null,
                tokens: {
                    '#': { pattern: /\d/ },
                    X: { pattern: /[0-9a-zA-Z]/ },
                    S: { pattern: /[a-zA-Z]/ },
                    A: { pattern: /[a-zA-Z]/, transform: v => v.toLocaleUpperCase() },
                    a: { pattern: /[a-zA-Z]/, transform: v => v.toLocaleLowerCase() },
                    '!': { escape: true }
                },
                display: this.value
            };
        },
        computed: {
            config () {
                return {
                    mask: this.mask,
                    tokens: this.tokens,
                    masked: this.masked
                }
            }
        },
        watch : {
            value (newValue) {
                if (newValue !== this.lastValue) {
                    this.display = newValue
                }
            },
            masked () {
                this.refresh(this.display)
            }
        },
        methods: {
            saveValue(e) {
                if(this.mask) {
                    // if (e.isTrusted) return // ignore native event
                    this.refresh(e.target.value)
                }
                else {
                    this.display = e.target.value;
                    this.$emit('input', e.target.value);
                }
                // this.$emit('input', event.target.value);
            },
            clickGroupItem() {
                if(this.group_item_action)
                {
                    this.$emit('click-group-item');
                }
            },
            refresh (value) {
                this.display = value
                var value = this.masker(value, this.mask, this.masked, this.tokens)
                if (value !== this.lastValue) {
                    this.lastValue = value;
                    this.$emit('input', value)
                }
            },
            masker(value, mask, masked = true) {
                return Array.isArray(mask)
                    ? this.dynamicMask( mask, value, masked)
                    : this.maskit(value, mask, masked)
            },
            dynamicMask (masks, value, masked) {
                masks = masks.sort((a, b) => a.length - b.length);
                let i = 0;
                while (i < masks.length) {
                    let currentMask = masks[i];
                    i++;
                    let nextMask = masks[i];
                    if (! (nextMask && this.maskit(value, nextMask, true).length > currentMask.length) ) {
                        return this.maskit(value, currentMask, masked)
                    }
                }
                return '' // empty masks

            },
            maskit (value, mask, masked = true) {
                value = value || '';
                mask = mask || '';
                let iMask = 0;
                let iValue = 0;
                let output = '';
                let cMask = '';
                let masker = '';
                let cValue = '';
                while (iMask < mask.length && iValue < value.length) {
                    cMask = mask[iMask];
                    masker = this.tokens[cMask];
                    cValue = value[iValue];
                    if (masker && !masker.escape) {
                        if (masker.pattern.test(cValue)) {
                            output += masker.transform ? masker.transform(cValue) : cValue;
                            iMask++
                        }
                        iValue++
                    } else {
                        if (masker && masker.escape) {
                            iMask++;// take the next mask char and treat it as char
                            cMask = mask[iMask]
                        }
                        if (masked) output += cMask;
                        if (cValue === cMask) iValue++; // user typed the same char
                        iMask++
                    }
                }

                // fix mask that ends with a char: (#)
                let restOutput = '';
                while (iMask < mask.length && masked) {
                    cMask = mask[iMask];
                    if (this.tokens[cMask]) {
                        restOutput = '';
                        break
                    }
                    restOutput += cMask;
                    iMask++
                }

                return output + restOutput
            },
        },
        directives: {
            mask
        }
    };
</script>

<style scoped>

</style>
