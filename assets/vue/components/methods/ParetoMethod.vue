<template>
  <div>
    <h6>Ответ:</h6>
    <table class="table table-bordered">
      <tbody>
      <tr v-for="resultItem in result">
        <th>{{ resultItem.name }}</th>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>

export default {
  props: ['result'],
  name: 'pareto',
  components: {
  },
  data() {
    return {
    };
  },
  methods: {

  },
}

</script>