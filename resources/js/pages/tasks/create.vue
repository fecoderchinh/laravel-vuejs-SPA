<template>
  <div class="row">
    <form @submit.prevent="createTask()">
      <div class="col-9">
        <input id="content" v-model="task.content" name="content" type="text" class="form-control" placeholder="Enter task...">
      </div>
      <div class="col-3">
        <button :disabled="!isValid" type="submit" class="btn btn-primary">
          Save
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  middleware: 'auth',

  data () {
    return {
      task: {
        content: ''
      },
      endpoint: '/api/tasks'
    }
  },

  computed: {
    isValid () {
      return this.task.content !== ''
    }
  },

  methods: {
    createTask () {
      axios.post(this.endpoint, { content: this.task.content })
        .then((res) => {
          return this.$store.dispatch('task/createTask', res.data)
        })
        .then(() => {
          this.$store.dispatch('alert/alert', { message: 'Task stored successfully!' })
          this.$router.push({ name: 'tasks.index' })
        })
        .catch(error => {
          this.errors.record(error.response.data.errors)
        })
    }
  }
}
</script>

<style scoped>

</style>
