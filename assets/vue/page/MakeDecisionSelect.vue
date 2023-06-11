<template>
    <div class="d-flex">
      <select v-model="method" class="form-select form-select-sm">
        <option v-for="(value, key) in methods" :value="key">{{ value }}</option>
      </select>
      <button :disabled="isProcessed" @click="makeDecision" class="ms-2 btn btn-primary">Создать решение методом</button>
    </div>
</template>

<script>

export default {
  props: ['methods', 'taskId'],
  name: 'make-decision-select',
  data() {
    return {
      'isProcessed': false,
      'method': Object.keys(this.methods)[0],
    };
  },
  methods: {
    makeDecision() {
      this.isProcessed = true;

      fetch('/api/task/make-decision', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          'id': this.taskId,
          'method': this.method,
        }),
      })
        .then((response) => response.json())
        .then((response) => {
          if (response.isError) {
            alert(response.errors[0]);
          } else {
            this.$emit('createResult', response.data.result);
            alert('Решение создано');
          }
        })
        .catch(() => {
          alert('Произошла ошибка');
        })
        .finally(() => {
          this.isProcessed = false;
        })
      ;
    },
  },
}

</script>