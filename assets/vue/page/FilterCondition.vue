<template>
  <select @change="changeCondition" class="form-select" data-ea-widget="ea-autocomplete">
    <option v-for="condition in conditions" :value="condition?.id">{{ condition?.label }}</option>
  </select>
</template>

<script>

export default {
  props: ['characteristic'],
  name: 'filter-condition',
  mounted() {
    this.setConditions();
  },
  data() {
    return {
      'conditions': [],
    };
  },
  computed: {
  },
  methods: {
    changeCondition(event) {
      this.$emit('changeCondition', this.characteristic, event.target.value);
    },
    setConditions() {
      this.conditions = [
        {
          'id': 'eq',
          'label': 'Равно',
        },
        {
          'id': 'neq',
          'label': 'Не равно',
        },
      ];

      if (this.characteristic.type.isNumber) {
        this.conditions.push(
            {
              'id': 'less',
              'label': 'Меньше',
            },
            {
              'id': 'greater',
              'label': 'Больше',
            },
        );
      } else if (this.characteristic.type.enum === null) {
        this.conditions.push(
            {
              'id': 'contain',
              'label': 'Содержит',
            },
        );
      }
    },
  },
}

</script>