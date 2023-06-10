<template>
  <div>
    <div class="d-flex justify-content-end mb-2">
      <a v-if="createTaskIsAvailable" class="btn btn-success me-1" :href="next.url">{{ next.label }}</a>

      <button @click="setMode('edit')" v-if="allowEdit && mode === 'view'" class="btn btn-primary me-1">Редактирование</button>
      <button @click="setMode('view')" v-if="allowEdit && mode === 'edit'" class="btn btn-default me-1">Просмотр</button>
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
          <matrix-cell @changeCell="changeCell" :cell="cell" :mode="mode"/>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>

import MatrixCell from "./MatrixCell";

export default {
  props: ['matrix', 'allowEdit', 'next'],
  data() {
    return {
      'rmatrix': this.matrix,
      'mode': 'view',
      'createTaskIsAvailable': true,
    };
  },
  name: 'fill-matrix',
  components: {
    MatrixCell,
  },
  mounted() {
    this.checkCreateTaskIsAvailable();
  },
  methods: {
    setMode(mode) {
      this.mode = mode;
    },
    checkCreateTaskIsAvailable() {
      let isAvailable = true;
      for (const rowI in this.rmatrix.table) {
        if (false === this.rmatrix.table.hasOwnProperty(rowI)) {
          continue;
        }
        for (const cellI in this.rmatrix.table[rowI]) {
          if (false === this.rmatrix.table[rowI].hasOwnProperty(cellI)) {
            continue;
          }
          isAvailable = isAvailable && this.rmatrix.table[rowI][cellI].value !== null && this.rmatrix.table[rowI][cellI].value !== '';
        }
      }

      this.createTaskIsAvailable = isAvailable;
    },
    changeCell() {
      this.checkCreateTaskIsAvailable();
    },
  },
}

</script>
