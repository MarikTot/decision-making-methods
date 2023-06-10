<template>
  <div>
    <div class="container">
      <div class="row">
        <div class="form-widget form-group col-md-6 col-xxl-5">
          <label class="form-control-label required" for="name">Название задачи</label>
          <input v-model="name" class="form-control" type="text" id="name">
        </div>
      </div>
      <div class="row">
        <div class="form-widget form-group col-md-6 col-xxl-5">
          <label class="form-control-label required" for="description">Описание задачи</label>
          <textarea v-model="description" class="form-control" type="text" id="description"></textarea>
        </div>
      </div>
    </div>

    <br>

    <h2>Матрица</h2>

    <filter-matrix @filterMatrix="filterMatrix" :matrix="matrix"></filter-matrix>
    <br>

    <displaying-matrix @selectCharacteristics="selectCharacteristics" :matrix="rmatrix" :showCheckboxes="true"></displaying-matrix>
    <br>
    <div class="d-flex justify-content-end">
      <button :disabled="buttonIsDisabled" @click="createTask" class="btn btn-success">Создать</button>
    </div>
  </div>
</template>

<script>

import DisplayingMatrix from "./DisplayingMatrix";
import FilterMatrix from "./FilterMatrix";

export default {
  props: ['matrix', 'allowEdit'],
  components: {
    DisplayingMatrix,
    FilterMatrix,
  },
  name: 'make-decision',
  data() {
    return {
      'name': '',
      'description': '',
      'rmatrix': this.matrix,
      'characteristicIds': [],
      'isProcessed': false,
    };
  },
  computed: {
    buttonIsDisabled() {
      return !this.name || !this.description || this.characteristicIds.length === 0 || Object.keys(this.rmatrix.table).length === 0 || this.isProcessed;
    },
  },
  methods: {
    filterMatrix(table) {
      this.rmatrix.table = table;
    },
    selectCharacteristics(ids)
    {
      this.characteristicIds = ids;
    },
    createTask() {
      this.isProcessed = true;
      let alternativeIds = Object.keys(this.rmatrix.table).map(key => this.rmatrix.table[key][Object.keys(this.rmatrix.table[key])[0]].alternative.id);
      fetch('/api/task/create', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          'name': this.name,
          'matrixId': this.rmatrix.id,
          'description': this.description,
          'alternativeIds': alternativeIds,
          'characteristicIds': this.characteristicIds,
        }),
      })
        .then((response) => response.json())
        .then((response) => {
          alert('Таска создана епт');
        })
        .catch(() => {
          alert('Произошла ошибка');
        })
        .finally(() => {
          this.isProcessed = false;
        })
      ;
    }
  },
}

</script>