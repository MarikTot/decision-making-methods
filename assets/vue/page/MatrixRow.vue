<template>
      <td v-for="column in row.columns">
        <input type="number" :value="column.value">
      </td>
</template>

<script>
export default {
  name: 'matrix-row',
  props: ['row'],
  methods: {
  },
};
</script>
