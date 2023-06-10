<template>
  <div>
    <div class="d-flex justify-content-end mb-2">
      <button @click="setMode('edit')" v-if="allowEdit && mode === 'view'" class="btn btn-primary">Редактирование</button>
      <button @click="setMode('view')" v-if="allowEdit && mode === 'edit'" class="btn btn-default">Просмотр</button>
    </div>
    <table v-if="Object.values(matrix.table).length > 0" class="table table-bordered">
      <thead>
      <tr>
        <th></th>
        <th v-for="characteristic in matrix.characteristics">{{ characteristic.name }}</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="row in matrix.table">
        <th class="align-middle">{{ Object.values(row)[0].alternative.name }}</th>
        <td v-for="cell in row">
          <matrix-cell :cell="cell" :mode="mode"/>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>

import MatrixCell from "./MatrixCell";

export default {
  props: ['matrix', 'allowEdit'],
  data() {
    return {
      'rmatrix': this.matrix,
      'mode': 'view',
    };
  },
  name: 'fill-matrix',
  components: {
    MatrixCell,
  },
  mounted() {
    console.log(this.matrix);
  },
  methods: {
    setMode(mode) {
      this.mode = mode;
    }
  },
}

</script>
