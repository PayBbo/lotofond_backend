<template>
  <div class="bkt-color-folder text-left mb-5 ">
    <label class="bkt-color-folder__title">выберите цвет папки</label>

    <div class="d-flex bkt-folder-color__block">
      <div class="bkt bkt-color__block bkt-border-main-lighter bkt-border-rounded p-2 mr-2"
           v-for="(color, index) in colors" :class="getBorderColor(color.title)">
        <label :for="'color-'+index" :class="'bkt-color__bg bkt-bg-'+color.title" @click="selColor = color.title"
               class="bkt-cursor-pointer">
          <input :value="color.title" type="checkbox" name="color"
                 :id="'color-'+index" hidden>
        </label>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ColorFolder",
  props: {
    selectedColor: {
      type: String,
      default: 'yellow',
    },
  },
  data() {
    return {
      model: 'default',
      colors: [{title: 'blue'}, {title: 'yellow'}, {title: 'purple'}, {title: 'green'}, {title: 'red'},
        {title: 'neutral-lighter'}, {title: 'primary'}],
      selColor: '',
    }
  },
  methods: {
    getBorderColor(color) {
      if (color == this.selColor) return `bkt-border-${color}`;
    },
  },
  mounted() {
    this.selColor = this.$props.selectedColor;
  }
}
</script>

<style scoped>

</style>
