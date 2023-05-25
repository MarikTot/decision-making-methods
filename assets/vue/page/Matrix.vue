<template>
  <table class="table table-bordered">
    <thead>
    <tr v-if="reactiveMatrix.characteristics.length > 0">
      <td :colspan="reactiveMatrix.alternatives.length > 0 ? 2 : 1"></td>
      <td class="text-center align-middle" v-for="characteristic in reactiveMatrix.characteristics">
        <a @click="removeCharacteristic(characteristic)" class="btn btn-sm btn-danger"><i class="fa fa-xmark"></i> Удалить</a>
      </td>
      <td v-if="reactiveCharacteristics.length > 0"></td>
    </tr>
    <tr>
      <th v-if="reactiveMatrix.alternatives.length > 0"></th>
      <th scope="col">Альтернативы</th>
      <th scope="col" v-for="characteristic in reactiveMatrix.characteristics">{{ characteristic.name }}</th>
      <th scope="col" v-if="reactiveCharacteristics.length > 0">
        <div class="p-2 d-flex justify-content-end">
          <select class="form-select-sm form-select d-inline w-auto" style="margin-right: 10px" name="characteristic" id="characteristic" v-model="newCharacteristic">
            <option v-for="characteristic in reactiveCharacteristics" :value="characteristic.id">{{ characteristic.name }}</option>
          </select>
          <a v-on:click="addCharacteristic" class="btn btn-success" href="#"><i class="fa fa-plus"></i> Добавить</a>
        </div>
      </th>
    </tr>
    </thead>
    <tbody>
    <matrix-row @remove-alternative="removeAlternativeHandler" v-for="alternative in reactiveMatrix.alternatives" :alternative="alternative" :matrix="reactiveMatrix" :characteristics="reactiveCharacteristics" />
    <tr>
      <td :colspan="1"></td>
      <th class="align-middle">Условие</th>
      <td class="p-2" v-for="characteristic in reactiveMatrix.characteristics">
        <select v-if="characteristic.type.isNumber === true" @change="saveCondition($event.target.value, characteristic)" class="form-select-sm form-select">
          <option :selected="selected(condition, characteristic)" v-for="condition in conditions" :value="condition">{{ condition }}</option>
        </select>
      </td>
      <td v-if="reactiveCharacteristics.length > 0">
      </td>
    </tr>
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
  <div class="d-flex justify-content-end">
    <select class="form-select-sm form-select d-inline w-auto" style="margin-right: 10px" v-model="method">
      <option value="guaranteed_result">Метод гарантированного результата</option>
    </select>
    <a v-on:click="solve" class="btn btn-success" href="#"><i class="fa fa-hand-fist"></i> Решить</a>
  </div>

  <div style="width: 200px" v-for="decision in reactiveMatrix.decisions">
    Метод: {{ decision.method }} <br>
    Создал: {{ decision.createdBy }} <br>
    Дата: {{ decision.createdAt }} <br><br>
    Результат: <br>
    <table class="table table-sm table-bordered">
      <tbody>
        <tr v-for="row in decision.result">
          <th>{{ row.name }}</th>
          <td>{{ row.value }}</td>
        </tr>
      </tbody>
    </table>

  </div>

</template>

<script>
  import MatrixRow from "./MatrixRow";

  export default {
    props: ['matrix', 'alternatives', 'characteristics', 'characteristicTypes', 'conditions'],
    name: 'matrix',
    components: {
      MatrixRow,
    },
    data() {
      let newAlternative;
      let newCharacteristic;
      let method = 'guaranteed_result';

      return {
        newAlternative,
        newCharacteristic,
        method,

        'reactiveMatrix': this.matrix,

        'reactiveAlternatives': this.alternatives,
        'reactiveCharacteristics': this.characteristics,
      };
    },
    computed: {
      cellsCount() {
        let emptyCell = this.reactiveCharacteristics.length > 0 ? 1 : 0;
        let count = this.reactiveMatrix.characteristics.length || 0;
        return count + 2 + emptyCell;
      },
    },
    mounted() {
      this.filterAlternatives();
      this.filterCharacteristics();
    },
    methods: {
      solve() {
        fetch('/api/matrix/solve', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            'id': this.reactiveMatrix.id,
            'method': this.method,
          }),
        })
          .then((response) => response.json())
          .then((response) => {
            this.reactiveMatrix.decisions.push(response['data']);
          })
        ;
      },
      saveCondition(condition, characteristic) {
        fetch('/api/matrix/save-condition', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            'id': this.reactiveMatrix.id,
            'characteristicId': characteristic.id,
            'condition': condition,
          }),
        })
          .then((response) => response.json())
          .then((response) => {

          })
        ;
      },
      selected(condition, characteristic) {
        return condition === (this.reactiveMatrix.conditions[characteristic.id]?.type || null);
      },
      removeAlternativeHandler(removeAlt) {
        this.reactiveMatrix.alternatives = this.reactiveMatrix
          .alternatives
          .filter((alternative) => alternative.id !== removeAlt.id)
        ;
        this.reactiveMatrix.rows = this.reactiveMatrix
          .rows
          .filter((row) => row.alternative.id !== removeAlt.id)
        ;
        this.reactiveAlternatives.push(removeAlt);
        this.newAlternative = this.reactiveAlternatives[0]?.id;
      },
      removeCharacteristic(removeChar) {
        fetch('/api/matrix/remove-characteristic', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            'id': this.reactiveMatrix.id,
            'characteristicId': removeChar.id,
          }),
        })
          .then((response) => response.json())
          .then((response) => {
            this.reactiveMatrix
                .rows
                .map((row) => {
                  row.cells = row.cells.filter((cell) => cell.characteristic.id !== removeChar.id)
                  return row;
                })
            ;
            this.reactiveMatrix.characteristics = this.reactiveMatrix
                .characteristics
                .filter((characteristic) => characteristic.id !== removeChar.id)
            ;
            this.reactiveCharacteristics.push(removeChar);
            this.newCharacteristic = this.reactiveCharacteristics[0]?.id;
          })
        ;
      },
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
