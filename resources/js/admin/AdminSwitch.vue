<template>
    <div v-can="'content-rules-edit'" class="switchToggle">
        <input type="checkbox" :id="'contentRuleTitle'+index"
               v-model="param">
        <label :for="'contentRuleTitle'+index">Toggle</label>
    </div>
</template>

<script>
export default {
    name: "AdminSwitch",
    props: ['model','index'],
    computed: {
        param: {
            get() {
                return this.model;
            },
            set(val) {
                this.$emit('change', val);
            }
        }
    }
}
</script>

<style scoped>
.switchToggle input[type=checkbox] {
    height: 0;
    width: 0;
    visibility: hidden;
    position: absolute;
}

.switchToggle label {
    cursor: pointer;
    text-indent: -9999px;
    width: 70px;
    max-width: 70px;
    height: 30px;
    background: #dc3545;
    display: block;
    border-radius: 100px;
    position: relative;
}

.switchToggle label:after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 26px;
    height: 26px;
    background: #fff;
    border-radius: 90px;
    transition: 0.3s;
}

.switchToggle input:checked + label, .switchToggle input:checked + input + label {
    background: #28a745;
}

.switchToggle input + label:before, .switchToggle input + input + label:before {
    content: 'Нет';
    position: absolute;
    top: 3px;
    left: 32px;
    width: 32px;
    height: 22px;
    border-radius: 90px;
    transition: 0.3s;
    text-indent: 0;
    color: #fff;
}

.switchToggle input:checked + label:before, .switchToggle input:checked + input + label:before {
    content: 'Да';
    position: absolute;
    top: 3px;
    left: 13px;
    width: 26px;
    height: 26px;
    border-radius: 90px;
    transition: 0.3s;
    text-indent: 0;
    color: #fff;
}

.switchToggle input:checked + label:after, .switchToggle input:checked + input + label:after {
    left: calc(100% - 2px);
    transform: translateX(-100%);
}

.switchToggle label:active:after {
    width: 60px;
}

.toggle-switchArea {
    margin: 10px 0 10px 0;
}
</style>
