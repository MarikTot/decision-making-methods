<template>
  <select @change="changeValue" v-if="characteristic.type.enum" class="form-select" :multiple="this.characteristic.multiple">
    <option value="">Не задано</option>
    <option v-for="en in characteristic.type.enum" :value="en">{{ en }}</option>
  </select>
  <input @change="changeValue" v-else class="form-control" type="text" :id="'characteristic-' + characteristic.id">
</template>

<script>

export default {
  props: ['characteristic'],
  name: 'filter-input',
  data() {

  },
  methods: {
    changeValue(event) {
      this.$emit('changeValue', this.characteristic, event.target.value);
    },
  },
}

</script>