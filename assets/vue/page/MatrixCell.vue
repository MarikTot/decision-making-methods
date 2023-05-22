<template>
<!--  {{ cell.characteristic.name }}-->
<!--  {{ cell.alternative.name }}-->
  <div v-if="haveEnums">
    <select v-model="selected" @change="saveValue" class="form-select" :multiple="this.cell.characteristic.multiple">
      <option v-for="en in this.cell.characteristic.type.enum" :value="en">{{ en }}</option>
    </select>
  </div>
  <div v-else-if="this.cell.characteristic.multiple">
    <input @change="saveValue" class="form-control" type="text" :value="formatValue">
    <small class="text-center text-muted">Укажите значения через запятую</small>
  </div>
  <div v-else-if="this.cell.characteristic.type.name === 'Число'">
    <input @change="saveValue" class="form-control" type="number" :value="formatValue">
  </div>
  <div v-else>
    <input @change="saveValue" class="form-control" type="text" :value="formatValue">
  </div>
</template>

<script>
export default {
  name: 'matrix-cell',
  props: ['cell'],
  data() {
    return {
      'selected': this.cell.value || this.cell.characteristic.type.enum[0] || null,
    };
  },
  methods: {
    saveValue(event) {
      let value = event.target.value;

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
          // успех не показывать, ошибку да
          console.log('zbs');
        })
      ;
    },
  },
  computed: {
    haveEnums() {
      return this.cell.characteristic.type.enum !== null;
    },
    formatValue() {
      if (Array.isArray(this.cell.value)) {
        return this.cell.value.join(', ');
      }

      if (null === this.cell.value || false === this.cell.value) {
        return '';
      }

      return this.cell.value;
    },
  },
  mounted() {
    console.log(this.cell);
  },
};
</script>
