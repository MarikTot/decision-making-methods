<template>
  <tr>
    <td>
      {{ row.alternative.name }}
    </td>
    <td v-for="cell in row.cells">
      <matrix-cell :cell="cell" />
    </td>
    <td></td>
  </tr>
</template>

<script>
import MatrixCell from "./MatrixCell";

export default {
  name: 'matrix-row',
  components: {
    MatrixCell,
  },
  props: ['row'],
  methods: {
  },
};
</script>
