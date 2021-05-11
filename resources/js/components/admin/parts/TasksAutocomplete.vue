<template>
  <div class="post-search--wrapper">
    <div class="form-inline my-2 my-lg-0">
      <input v-model="query" class="tc-input" type="text"
             placeholder="Search an article" @focus="showResults" @keyup="loadResults"
      >
    </div>
    <div v-if="search" class="list-group list-group-flush shadow-sm post-search--results">
      <a v-for="result in results" :key="result.id" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center result"
         href="#" :data-result="result.slug" @click.prevent="goTo(result)"
      >
        {{ result.title }}
      </a>
    </div>
  </div>
</template>

<script>
import tasks from '~/utils/requests'
import { TASKS } from '~/utils/endpoints'

export default {
  name: 'TaskSearch',
  data () {
    return {
      query: '',
      search: false,
      results: [],
      endpoint: `${TASKS}?search=`
    }
  },
  methods: {
    showResults () {
      this.search = true
    },
    // removeResults () {
    //   let isResultClicked = event.relatedTarget.classList.contains('result')
    //
    //   if (isResultClicked) {
    //     this.goTo(event.relatedTarget.dataset.result)
    //   }
    //
    //   this.search = false
    // },
    loadResults () {
      if (this.query.length < 3) {
        this.results = []
        return
      }

      let endpoint = this.endpoint + this.query

      tasks.all(endpoint)
        .then(({ data: results }) => {
          this.results = results.data
        })
    },
    goTo (slug) {
      let result = this.results.find((result) => result.slug === slug)

      this.$router.push({
        name: 'tasks.show',
        params: {
          category: result.category.slug,
          slug: result.slug
        }
      })
    }
  }
}
</script>

<style scoped>
.post-search--wrapper {
  position: relative;
}

.post-search--results {
  position: absolute;
  width: 100%;
  z-index: 100;
  margin-top: 8px;
}
</style>
