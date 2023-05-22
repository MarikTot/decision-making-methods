<template>
  <table class="table table-bordered">
    <thead>
    <tr>
      <th scope="col">Альтернативы</th>
      <th scope="col" v-for="characteristic in reactiveMatrix.characteristics">{{ characteristic.name }}</th>
      <th scope="col">
        <div v-if="reactiveCharacteristics.length > 0" class="p-2 d-flex justify-content-end">
          <select class="form-select-sm form-select d-inline w-auto" style="margin-right: 10px" name="characteristic" id="characteristic" v-model="newCharacteristic">
            <option v-for="characteristic in reactiveCharacteristics" :value="characteristic.id">{{ characteristic.name }}</option>
          </select>
          <a v-on:click="addCharacteristic" class="btn btn-success" href="#"><i class="fa fa-plus"></i> Добавить</a>
        </div>
      </th>
    </tr>
    </thead>
    <tbody>
    <matrix-row v-if="reactiveMatrix.rows.length" v-for="row in reactiveMatrix.rows" :row="row" />
    <tr v-if="reactiveAlternatives.length > 0">
      <td class="p-2" :colspan="cellsCount">
        <select class="form-select-sm form-select d-inline w-auto" style="margin-right: 10px" name="alternative" id="alternative" v-model="newAlternative">
          <option v-for="alternative in this.reactiveAlternatives" :value="alternative.id">{{ alternative.name }}</option>
        </select>
        <a v-on:click="addAlternative" class="btn btn-success" href="#"><i class="fa fa-plus"></i> Добавить</a>
      </td>
    </tr>
    </tbody>
  </table>
</template>

<script>
  import MatrixRow from "./MatrixRow";

  export default {
    props: ['matrix', 'alternatives', 'characteristics', 'characteristicTypes'],
    name: 'matrix',
    components: {
      MatrixRow,
    },
    data() {
      let newAlternative;
      let newCharacteristic;

      return {
        newAlternative,
        newCharacteristic,

        'reactiveMatrix': this.matrix,

        'reactiveAlternatives': this.alternatives,
        'reactiveCharacteristics': this.characteristics,
      };
    },
    computed: {
      cellsCount() {
        let count = this.reactiveMatrix.characteristics.length || 0;
        return count + 2;
      },
    },
    mounted() {
      console.log(this.matrix);

      this.filterAlternatives();
      this.filterCharacteristics();
    },
    methods: {
      filterAlternatives() {
        let usedAlternatives = this.matrix.alternatives.map((alternative) => alternative.id);
        this.reactiveAlternatives = this.reactiveAlternatives.filter((alternative) => false === usedAlternatives.includes(alternative.id));
        this.newAlternative = this.reactiveAlternatives[0]?.id;
      },
      filterCharacteristics() {
        let usedCharacteristics = this.matrix.characteristics.map((characteristic) => characteristic.id) || [];
        this.reactiveCharacteristics = this.reactiveCharacteristics.filter((characteristic) => false === usedCharacteristics.includes(characteristic.id));
        this.newCharacteristic = this.reactiveCharacteristics[0]?.id;
      },
      addCharacteristic(event) {
        fetch('/api/matrix/add-characteristic', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            'id': this.reactiveMatrix.id,
            'characteristicId': this.newCharacteristic,
          }),
        })
          .then((response) => response.json())
          .then((response) => {
            this.reactiveMatrix.rows.map((row) => row.cells.push(response.data.cells.shift()));
            this.reactiveMatrix.characteristics.push(response.data.characteristic);

            this.filterCharacteristics();
          })
        ;
      },
      addAlternative(event) {
        fetch('/api/matrix/add-alternative', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            'id': this.reactiveMatrix.id,
            'alternativeId': this.newAlternative,
          }),
        })
          .then((response) => response.json())
          .then((response) => {
            this.reactiveMatrix.rows.push(response.data);
            this.reactiveMatrix.alternatives.push(response.data.alternative);

            this.filterAlternatives();
          })
        ;
      },
    },
  };
</script>
