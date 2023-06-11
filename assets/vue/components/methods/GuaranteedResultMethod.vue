<template>
  <div>
    <h6>Ответ:</h6>
    Нормализованная таблица:
    <table class="table table-bordered">
      <thead>
      <tr>
        <th></th>
        <th v-for="(value, characteristicName) in result[0].normalizeData">{{ characteristicName }}</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="resultItem in result">
        <th>{{ resultItem.name }}</th>
        <td v-for="(value, characteristicName) in resultItem.normalizeData">{{ Math.trunc( value * 1000 ) / 1000  }}</td>
      </tr>
      </tbody>
    </table>
    Результат:
    <table class="table table-bordered">
      <tbody>
      <tr v-for="resultItem in result">
        <th>{{ resultItem.name }}</th>
        <td>{{ Math.trunc( resultItem.value * 1000 ) / 1000 }}</td>
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