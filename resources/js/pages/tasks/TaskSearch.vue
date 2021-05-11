<template>
  <div>
    <Header>
      <span slot="title">
        <template v-if="this.param.length >= 3">
          {{ $t('search_for') }} {{ this.param }}
        </template>
        <template v-else>
          {{ $t('key_count_error') }}
        </template>
      </span>
      <span slot="desc">
        {{ $t('search_count') }} {{ this.results.length }}
      </span>
    </Header>
    <section id="content" class="w-100 bg-gray-200">
      <container>
        <div class="grid grid-cols-4 gap-5 py-5">
          <div class="mins:col-span-3 maxs:col-span-4 mins:order-last maxs:order-first">
            <div class="shadow">
              <search />
              <tasks :data="results" />
              <pagination :meta="pagination" @changed="paginate" />
            </div>
          </div>
          <div class="mins:col-span-1 maxs:col-span-4 mins:order-first maxs:order-last">
            <sidebar />
          </div>
        </div>
      </container>
    </section>
  </div>
</template>

<script>
import Container from '~/components/Container'
import Header from '~/components/Header'
import Sidebar from '~/components/customer/Sidebar'
import Search from '~/components/Search'
import Tasks from '~/components/customer/Tasks'
import Pagination from '~/components/Pagination'

import tasks from '~/utils/requests'
import { TASKS } from '~/utils/endpoints'

export default {
  name: 'TaskSearch',
  components: {
    Container,
    Header,
    Sidebar,
    Search,
    Tasks,
    Pagination
  },
  data () {
    return {
      results: {},
      endpoint: `${TASKS}?search=`,
      pagination: {},
      param: null
    }
  },
  watch: {
    '$route': function () {
      this.loadResults(this.endpoint, this.$route.params.tasks)
    }
  },
  updated () {
    this.param = this.$route.params.tasks
  },
  created () {
    this.param = this.$route.params.tasks
    this.loadResults(`${TASKS}?search=`, this.param)
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
          this.pagination = results.meta
          console.log(results)
        })
    },
    goTo (result) {
      this.$router.push({
        name: 'tasks.view',
        params: {
          task: result.slug
        }
      })
    },
    paginate (page) {
      this.loadResults(`${TASKS}?search=`, this.$route.params.tasks + '&page=' + page)
    }
  }
}
</script>

<style scoped>

</style>
