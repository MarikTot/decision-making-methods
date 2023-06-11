<template>
    <div>
      <div>
        <h5>Решение #{{ result.id }}</h5>
      </div>

      <div class="row">
        <div class="col-lg-4">
          <table class="table table-bordered">
            <tbody>
            <tr>
              <th>Метод</th>
              <td>{{ result.method.label }}</td>
            </tr>
            <tr>
              <th>Дата создания</th>
              <td>{{ result.createdAt }}</td>
            </tr>
            <tr>
              <th>Создал пользователь</th>
              <td>{{ result.createdBy }}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4">
          <GuaranteedResultMethod v-if="result.method.value === 'guaranteed_result'" :result="result.result" />
        </div>
      </div>
    </div>
</template>

<script>

import GuaranteedResultMethod from "./methods/GuaranteedResultMethod";

export default {
  props: ['result'],
  name: 'result-item',
  components: {
    GuaranteedResultMethod,
  },
  data() {
    return {
    };
  },
  methods: {

  },
}

</script>