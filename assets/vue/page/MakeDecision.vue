<template>
  <div>
    <filter-matrix @filterMatrix="filterMatrix" :matrix="matrix"></filter-matrix>
    <br>
    <displaying-matrix :matrix="rmatrix"></displaying-matrix>
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
      "rmatrix": this.matrix,
    };
  },
  methods: {
    filterMatrix(table) {
      this.rmatrix.table = table;
    },
  },
}

</script>