<template>
  <box>
    <div class="list-group list-group-flush shadow-sm post-search--results">
      <a v-for="result in results" :key="result.id" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center result"
         href="#" :data-result="result.slug" @click.prevent="goTo(result)"
      >
        {{ result.title }}
      </a>
    </div>
  </box>
</template>

<script>
import tasks from '~/utils/requests'
import { TASKS } from '~/utils/endpoints'

export default {
  name: 'TasksSearch',

  middleware: ['auth'],

  data () {
    return {
      results: {},
      endpoint: `${TASKS}?search=`
    }
  },
  watch: {
    '$route': function () {
      this.loadResults(this.endpoint, this.$route.params.tasks)
    }
  },
  created () {
    this.loadResults(this.endpoint, this.$route.params.tasks)
  },
  methods: {
    loadResults (endpoint, searchData) {
      if (searchData.length < 3) {
        this.results = []
        return
      }

      endpoint = endpoint + searchData

      tasks.all(endpoint)
        .then(({ data: results }) => {
          this.results = results.data
        })
    },
    goTo (result) {
      this.$router.push({
        name: 'admin.tasks.edit',
        params: {
          task: result.slug
        }
      })
    }
  }
}
</script>

<style scoped>

</style>
