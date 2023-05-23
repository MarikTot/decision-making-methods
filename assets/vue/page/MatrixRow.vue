<template>
  <tr>
    <td class="text-center align-middle">
      <a @click="remove" class="btn btn-sm btn-danger"><i class="fa fa-xmark"></i> Удалить</a>
    </td>
    <td class="align-middle">
      {{ alternative.name }}
    </td>
    <td v-for="cell in cells">
      <matrix-cell :cell="cell" />
    </td>
    <td v-if="characteristics.length > 0"></td>
  </tr>
</template>

<script>
import MatrixCell from "./MatrixCell";

export default {
  name: 'matrix-row',
  components: {
    MatrixCell,
  },
  computed: {
    cells() {
      let cells = [];
      this.matrix.rows.forEach((row) => {
        if (row.alternative.id === this.alternative.id) {
          cells = row.cells;
        }
      });
      return cells;
    },
  },
  props: ['alternative', 'matrix', 'characteristics'],
  methods: {
    remove() {
      fetch('/api/matrix/remove-alternative', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          'id': this.matrix.id,
          'alternativeId': this.alternative.id,
        }),
      })
        .then((response) => response.json())
        .then((response) => {
          this.$emit('removeAlternative', this.alternative);
        })
      ;
    },
  },
};
</script>
