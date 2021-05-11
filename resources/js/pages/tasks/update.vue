<template>
  <div class="row">
    <form @submit.prevent="updateTask()">
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
import Errors from '~/utils/Errors'

export default {
  middleware: 'auth',

  data () {
    return {
      task: {
        content: ''
      },
      endpoint: '/api/tasks',
      errors: new Errors()
    }
  },

  computed: {
    isValid () {
      return this.task.content !== ''
    }
  },

  mounted () {
    this.endpoint = this.endpoint + `/${this.$route.params.id}`
    this.loadTask(this.endpoint)
  },

  methods: {
    loadTask (url) {
      axios.get(url)
        .then((res) => this.task = res.data)
    },
    updateTask () {
      axios.put(this.endpoint, this.task)
        .then((res) => {
          return this.$store.dispatch('task/updateTask', res)
        })
        .then(() => {
          this.$store.dispatch('alert/alert', { message: 'Task updated successfully!' })
          this.$router.push({ name: 'tasks.index' })
        })
        .catch((error) => {
          if (error.response.data.errors) {
            this.errors.record(error.response.data.errors)
          } else {
            this.$store.dispatch('alert/alert', {
              message: 'There is an error with the request',
              type: 'danger'
            })
          }
        })
    }
  }
}
</script>

<style scoped>

</style>
