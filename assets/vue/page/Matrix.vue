<template>
  <table class="table table-bordered table-dark">
    <thead>
      <tr>
        <th scope="col">Альтернатива</th>
        <th scope="col" v-for="column in matrix[0].columns">{{ column.name }}</th>
        <th scope="col" class="p-2 d-flex justify-content-end">
          <a v-on:click="addColumn" class="btn btn-success" href="#"><i class="fa fa-plus"></i> Добавить колонку</a>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="row in matrix">
        <th scope="row">{{ row.name }}</th>
        <matrix-row :row="row" />
        <td></td>
      </tr>
      <tr>
        <td class="p-2" :colspan="matrix.length + 2">
          <a v-on:click="addRow" class="btn btn-success" href="#"><i class="fa fa-plus"></i> Добавить строку</a>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
  import MatrixRow from "./MatrixRow";

  export default {
    name: 'matrix',
    components: {
      MatrixRow,
    },
    data() {
      return {
        matrix: [
          {
            name: 'Альтернатива 1',
            columns: [
              {
                name: 'Показатель 1',
                value: 1,
              },
              {
                name: 'Показатель 2',
                value: '10',
              },
            ],
          },
          {
            name: 'Альтернатива 2',
            columns: [
              {
                name: 'Показатель 1',
                value: 10,
              },
              {
                name: 'Показатель 2',
                value: '20',
              },
            ],
          },
        ],
      }
    },
    methods: {
      addColumn(event) {
        this.matrix.map((row) => {
          row.columns.push({
            name: 'Новый показатель',
            value: '0',
          },);
        })
      },
      addRow(event) {
        let columns = this.matrix[0].columns.map((column) => {
          return {
            name: column.name,
            value: 0,
          };
        });
        this.matrix.push({
          name: 'Новая альтернатива',
          columns: columns,
        },);
      },
    },
  };
</script>
