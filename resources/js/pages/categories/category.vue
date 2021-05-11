<template>
  <div>
    <Header>
      <template slot="title">
        {{ $t('post_by_category') }} <span class="capitalize">{{ this.category.name }}</span>
      </template>
      <template slot="desc">
        {{ $t('search_count') }} {{ this.posts.length }}
      </template>
    </Header>
    <section id="content" class="w-100 bg-gray-200">
      <container>
        <div class="grid grid-cols-4 gap-5 py-5">
          <div class="mins:col-span-3 maxs:col-span-4 mins:order-last maxs:order-first">
            <div class="shadow">
              <search />
              <tasks :data="posts" />
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

import request from '~/utils/requests'
import { CATEGORIES } from '~/utils/endpoints'

export default {
  name: 'Category',
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
      posts: [],
      endpoint: `${CATEGORIES}`,
      pagination: {},
      category: {}
    }
  },
  watch: {
    '$route.params' (newParam, oldParam) {
      let endpoint = this.getEndpoint(newParam.category)
      this.loadPosts(endpoint)
      this.loadCategory(newParam.category)
    }
  },
  created () {
    let endpoint = this.getEndpoint(this.$route.params.category)
    this.loadPosts(endpoint)
    this.loadCategory(this.$route.params.category)
  },
  methods: {
    loadCategory (category) {
      request.find(CATEGORIES, category)
        .then((res) => { this.category = res.data.data })
        .catch(error => console.log(error))
    },
    loadPosts (endpoint) {
      request.all(endpoint)
        .then(({ data: posts }) => {
          this.pagination = posts.meta
          this.posts = posts.data
          // console.log(posts)
        })
        .catch(error => console.log(error.response))
    },
    getEndpoint (params) {
      return this.endpoint + `/${params}/tasks`
    },
    paginate (page) {
      this.loadPosts(`${CATEGORIES}/${this.$route.params.category}/tasks?page=${page}`)
    }
  }
}
</script>

<style lang="scss" scoped>
</style>
