<template>
  <div class="accordion" id="accordionFilter">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <i style="margin-right: 5px" class="fa fa-filter"></i>
          Фильтры
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFilter">
        <div class="accordion-body">
          <div class="row">
            <div class="col-md-6 col-lg-4" v-for="characteristic in matrix.characteristics">
              <div class="form-group">
                <label class="form-control-label" :for="'characteristic-' + characteristic.id">
                  {{ characteristic.name }}
                </label>
                <filter-condition @changeCondition="changeCondition" :characteristic="characteristic"></filter-condition>
                <filter-input @changeValue="changeValue" :characteristic="characteristic"></filter-input>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 justify-content-end d-flex">
              <button @click="filter" class="btn btn-success">Применить</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import FilterInput from "./FilterInput";
import FilterCondition from "./FilterCondition";

export default {
  props: ['matrix'],
  data() {
    return {
      'filters': [],
      'rmatrix': this.matrix,
      'omatrix': JSON.parse(JSON.stringify(this.matrix)),
    };
  },
  name: 'filter-matrix',
  mounted() {
    // this.rmatrix.table = [];
    // this.$emit('filterMatrix', this.rmatrix);
  },
  components: {
    FilterInput,
    FilterCondition,
  },
  methods: {
    filter() {
      let table = Object.fromEntries(Object.entries(this.omatrix.table).filter(([alternativeName, data]) => {
        let show = true;
        for (const [cId, filter] of Object.entries(this.filters)) {
          if (filter.value && filter.condition) {
            if (filter.condition === 'eq') {
              show = show && data[cId].value == filter.value;
            }
            if (filter.condition === 'neq') {
              show = show && data[cId].value != filter.value;
            }
            if (filter.condition === 'less') {
              show = show && data[cId].value < filter.value;
            }
            if (filter.condition === 'greater') {
              show = show && data[cId].value > filter.value;
            }
            if (filter.condition === 'contain') {
              show = show && data[cId].value.includes(filter.value);
            }
          }
        }
        return show;
      }));

      this.$emit('filterMatrix', table);
    },
    changeCondition(characteristic, condition) {
      if (this.filters[characteristic.name]) {
        this.filters[characteristic.name].condition = condition;
      } else {
        this.filters[characteristic.name] = {
          'condition': condition,
          'value': null,
        };
      }
    },
    changeValue(characteristic, value) {
      if (this.filters[characteristic.name]) {
        this.filters[characteristic.name].value = value;
      } else {
        this.filters[characteristic.name] = {
          'condition': 'eq',
          'value': value,
        };
      }
    },
  },
}

</script>