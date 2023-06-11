<template>
  <div>
    <div v-if="showCheckboxes" class="alert alert-info" role="alert">
        Выберите показатели для сравнения
    </div>

    <table class="table table-bordered">
      <thead>
      <tr>
        <th></th>
        <th class="text-nowrap" v-for="characteristic in rmatrix.characteristics">
          {{ characteristic.name }}
          <input
              @change="changeSelectedOptions"
              v-model="selectedOptions"
              v-if="showCheckbox(characteristic)"
              style="margin-left: 5px;"
              type="checkbox"
              :value="characteristic.id"
          >
        </th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="row in rmatrix.table">
        <th class="align-middle">{{ Object.values(row)[0].alternative.name }}</th>
        <td v-for="cell in row">
          {{ cell.value }}
        </td>
      </tr>
      <tr v-if="this.showCheckboxes">
        <th></th>
        <th class="text-nowrap" v-for="characteristic in rmatrix.characteristics">
          <select
              @change="conditionChange($event, characteristic)"
              v-if="showCheckbox(characteristic)"
              class="form-select form-select-sm"
          >
            <option value="min">min</option>
            <option value="max">max</option>
          </select>
        </th>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>

export default {
  props: ['matrix', 'showCheckboxes'],
  data() {
    return {
      'conditions': this.matrix.characteristics.filter((characteristic) => this.showCheckbox(characteristic)).map((characteristic) => {
        return {
          'id': characteristic.id,
          'condition': 'min',
        };
      }),
      'selectedOptions': this.matrix.characteristics.filter((characteristic) => this.showCheckbox(characteristic)).map((characteristic) => characteristic.id),
      'rmatrix': this.matrix,
    };
  },
  name: 'displaying-matrix',
  mounted() {
    this.changeSelectedOptions();
    this.$emit('changeConditions', this.conditions);
  },
  methods: {
    changeSelectedOptions() {
      this.$emit('selectCharacteristics', this.selectedOptions);
    },
    showCheckbox(characteristic) {
      return this.showCheckboxes && characteristic.multiple === false && characteristic.type.isNumber === true;
    },
    conditionChange(event, characteristic) {
      this.conditions = this.conditions.map((condition) => {
        if (condition.id === characteristic.id) {
          condition.condition = event.target.value;
        }
        return condition;
      });

      this.$emit('changeConditions', this.conditions);
    },
  },
}

</script>
