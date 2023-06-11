<template>
  <div>
    <h6>Ответ:</h6>
    <table class="table table-bordered">
      <tbody>
      <tr v-for="resultItem in result">
        <th>{{ resultItem.name }}</th>
        <td>{{ resultItem.value.toFixed(4) }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>

export default {
  props: ['result'],
  name: 'guaranteed-result',
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