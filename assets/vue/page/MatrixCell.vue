<template>
<!--  {{ cell.characteristic.name }}-->
<!--  {{ cell.alternative.name }}-->
  <div v-if="isEdit">
    <div v-if="haveEnums">
      <select v-model="selected" @change="saveValue" class="form-select" :multiple="this.cell.characteristic.multiple">
        <option v-for="en in this.rcell.characteristic.type.enum" :value="en">{{ en }}</option>
      </select>
    </div>
    <div v-else-if="this.rcell.characteristic.multiple">
      <input @change="saveValue" class="form-control" type="text" :value="formatValue">
      <small class="text-center text-muted">Укажите значения через запятую</small>
    </div>
    <div v-else-if="this.rcell.characteristic.type.name === 'Число'">
      <input @change="saveValue" min="0" step="1" class="form-control" type="number" :value="formatValue">
    </div>
    <div v-else>
      <input @change="saveValue" class="form-control" type="text" :value="formatValue">
    </div>
  </div>
  <div v-if="isView">
    <span v-if="formatValue">{{ formatValue }}</span>
    <span v-else class="text-danger">-</span>
  </div>
</template>

<script>
export default {
  name: 'matrix-cell',
  props: ['cell', 'mode'],
  data() {
    return {
      'rcell': this.cell,
      'selected': this.cell.value || (this.cell.characteristic.type.enum ? this.cell.characteristic.type.enum[0] : null) || null,
    };
  },
  methods: {
    saveValue(event) {
      let value = event.target.value;
      if (this.rcell.characteristic.type.name === 'Число') {
        value = parseInt(value);
      }

      this.rcell.value = value;

      this.$emit('changeCell', value);

      fetch('/api/matrix/save-value', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          'cellId': this.cell.id,
          'value': value,
        }),
      })
        .then((response) => response.json())
        .then((response) => {
          // успех не показывать, ошибку - да
          console.log('zbs');
        })
      ;
    },
  },
  computed: {
    isView() {
      return this.mode === 'view';
    },
    isEdit() {
      return this.mode === 'edit';
    },
    haveEnums() {
      return this.rcell.characteristic.type.enum !== null;
    },
    formatValue() {
      if (Array.isArray(this.rcell.value)) {
        return this.rcell.value.join(', ');
      }

      if (null === this.rcell.value || false === this.rcell.value) {
        return '';
      }

      return this.rcell.value;
    },
  },
  mounted() {
    // console.log(this.cell);
  },
};
</script>
