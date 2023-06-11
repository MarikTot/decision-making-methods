<template>
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <make-decision-select @createResult="onCreateResult" :taskId="rtask.id" :methods="methods" />
      </div>
    </div>
    <br>
    <div v-for="result in rtask.results" class="row">
      <div class="col-12">
        <result-item :result="result" />
      </div>
    </div>
  </div>

</template>

<script>

import MakeDecisionSelect from "./MakeDecisionSelect";
import ResultItem from "../components/ResultItem";

export default {
  props: ['task', 'methods'],
  name: 'result',
  components: {
    MakeDecisionSelect,
    ResultItem,
  },
  data() {
    return {
      'rtask': this.task,
    };
  },
  methods: {
    onCreateResult(result) {
      this.rtask.results.push(result);
    },
  },
}

</script>