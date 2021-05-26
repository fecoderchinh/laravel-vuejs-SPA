<template>
  <aside class="w-100">
    <div class="tc-widget p-4 bg-white shadow mb-5">
      <h6 class="tc-widget__title text-xl font-semibold">
        {{ $t('categories') }}
      </h6>
      <ul v-if="this.categories.length > 0" class="list-none">
        <li v-for="category in this.categories" :key="category.id" class="block">
          <router-link :to="{
                         name: 'categories.category',
                         params: {
                           category: category.slug
                         }
                       }"
                       class="font-normal capitalize block px-4 py-2 text-sm leading-5 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition-all duration-100 ease-in-out outline-none"
          >
            {{ category.name }}
          </router-link>
        </li>
      </ul>
      <ul v-else>
        <span>{{ $t('no_category') }}</span>
      </ul>
    </div>

    <div class="tc-widget p-4 bg-white shadow mb-5">
      <h6 class="tc-widget__title text-xl font-semibold">
        {{ $t('tags') }}
      </h6>
      <ul v-if="this.tags.length > 0" class="list-none">
        <li v-for="tag in this.tags" :key="tag.id" class="inline-block mr-2 my-1">
          <router-link :to="{
                         name: 'tags.tag',
                         params: {
                           tag: tag.slug
                         }
                       }"
                       class="py-1 px-3 bg-blue-300 rounded text-sm"
          >
            {{ tag.name }}
          </router-link>
        </li>
      </ul>
      <ul v-else>
        <span>{{ $t('no_tag') }}</span>
      </ul>
    </div>
  </aside>
</template>

<script>
import { mapGetters } from 'vuex'
import cats from '~/utils/requests'
import { CATEGORIES_ALL } from '~/utils/endpoints'

export default {
  name: 'Sidebar',
  computed: {
    ...mapGetters({
      categories: 'categories/categories'
    }),
    ...mapGetters({
      tags: 'tag/tags'
    })
  },
  watch: {
    '$route.query' (newQuery, oldQuery) {
      let endpoint = this.getEndpoint(newQuery.page)
      this.fetchCategories(endpoint)
    }
  },
  created () {
    // this.$store.dispatch('categories/fetchCategories')
    this.fetchCategories(this.getEndpoint(this.$route.query.page))
    this.$store.dispatch('tag/fetchTags')
  },
  methods: {
    fetchCategories (endpoint) {
      cats.all(endpoint)
        .then(({ data: categories }) => {
          // this.tasks = tasks.data
          // console.log(categories)
          this.$store.dispatch('categories/fetchAllCategories', categories.data)
        })
        .catch(error => {
          this.$notify({
            title: `Error loading categories`,
            text: error.response,
            type: 'error'
          })
        })
    },
    getEndpoint (page = null) {
      return page !== null ? `${CATEGORIES_ALL}?page=${page}` : CATEGORIES_ALL
    }
  }
}
</script>

<style scoped>

</style>
