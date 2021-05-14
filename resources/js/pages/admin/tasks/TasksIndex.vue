<template>
  <div>
    <div class="w-full">
      <router-link :to="{name: 'admin.tasks.create'}"
                   class="inline-block tc-button tc-button__primary tc-button__fill"
      >
        {{ $t('add_task') }}
      </router-link>
    </div>
    <box v-if="tasks.length > 0" class="mt-5">
      <tasks :data="tasks" />
    </box>
    <box v-else>
      {{ $t('no_task') }}
    </box>
    <pagination v-if="tasks.length > 0" :meta="pagination" @changed="paginate" />
  </div>
</template>

<script>
import Tasks from '~/components/admin/Tasks'
import Pagination from '~/components/Pagination'
import tasks from '~/utils/requests'
import { TASKS_ALL } from '~/utils/endpoints'
import { mapGetters } from 'vuex'

export default {
  name: 'TasksIndex',
  middleware: ['auth'],
  layout: 'admin',
  components: {
    Tasks,
    Pagination
  },
  data () {
    return {
      pagination: {}
    }
  },
  computed: {
    ...mapGetters({
      tasks: 'task/tasks'
    })
  },
  watch: {
    '$route.query' (newQuery, oldQuery) {
      let endpoint = this.getEndpoint(newQuery.popular)
      this.fetchTasks(endpoint)
    }
  },
  created () {
    this.fetchTasks(this.getEndpoint(this.$route.query.popular))
  },
  methods: {
    fetchTasks (endpoint) {
      tasks.all(endpoint)
        .then(({ data: tasks }) => {
          this.pagination = tasks.meta
          // this.tasks = tasks.data
          console.log(tasks)
          this.$store.dispatch('task/fetchAllTasks', tasks.data)
        })
        .catch(error => {
          this.$notify({
            title: `Error loading tasks`,
            text: error.response.data.message,
            type: 'error'
          })
        })
    },
    getEndpoint (popular = null) {
      return popular !== null ? `${TASKS_ALL}?popular=1` : TASKS_ALL
    },
    paginate (page) {
      let endpoint = `${TASKS_ALL}?page=${page}`
      this.fetchTasks(endpoint)
    }
  }
}
</script>

<style scoped>

</style>
