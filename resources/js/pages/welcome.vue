<template>
  <div>
    <Header>
      <template slot="title">
        {{ $t('welcome') }}
      </template>
      <template slot="desc">
        {{ $t('main_desc') }}
      </template>
      <template slot="actions">
        <ul v-if="!auth" class="list-none">
          <li class="inline-block">
            <router-link :to="{ name: 'login' }" class="block tc-button tc-button__transition tc-button__primary tc-button__fill">
              {{ $t('login') }}
            </router-link>
          </li>
          <li class="inline-block">
            <router-link :to="{ name: 'register' }" class="block tc-button tc-button__transition tc-button__primary">
              {{ $t('register') }}
            </router-link>
          </li>
        </ul>
        <ul v-else class="list-none">
          <li class="inline-block">
            <router-link :to="{ name: 'admin.dashboard' }" class="block tc-button tc-button__transition tc-button__primary tc-button__fill">
              {{ $t('dashboard') }}
            </router-link>
          </li>
        </ul>
      </template>
    </Header>
    <section id="content" class="w-100 bg-gray-200">
      <container>
        <div class="grid grid-cols-4 gap-5 py-5">
          <div class="mins:col-span-3 maxs:col-span-4 mins:order-last maxs:order-first">
            <div class="shadow">
              <search />
              <tasks :data="tasks" />
              <pagination v-if="tasks.length > 0" :meta="pagination" @changed="paginate" />
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
import { mapGetters } from 'vuex'
import Pagination from '~/components/Pagination'
import tasks from '~/utils/requests'
import { TASKS } from '~/utils/endpoints'

export default {
  layout: 'basic',
  components: {
    Header,
    Container,
    Sidebar,
    Search,
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
    }),
    auth () {
      return !!this.$store.getters['auth/check']
    }
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
          // console.log(tasks)
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
      return popular !== null ? `${TASKS}?popular=1` : TASKS
    },
    paginate (page) {
      let endpoint = `${TASKS}?page=${page}`
      this.fetchTasks(endpoint)
    }
  }
}
</script>
