<template>
  <div>
    <Header>
      <template slot="title">
        {{ $t('categories') }}
      </template>
    </Header>
    <div class="container py-5">
      <div class="w-full">
        <ul class="list-none">
          <template v-for="category in categories">
            <li class="inline-block mr-3 mt-3">
              <router-link :to="{
                             name: 'categories.category',
                             params: {
                               category: category.slug
                             }
                           }"
                           class="py-1 capitalize px-3 bg-blue-300 rounded text-sm"
              >
                {{ category.name }}
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import Header from '~/components/Header'
import { mapGetters } from 'vuex'
import request from '~/utils/requests'
import { CATEGORIES } from '~/utils/endpoints'

export default {
  name: 'Categories',
  components: {
    Header
  },
  computed: {
    ...mapGetters({
      categories: 'categories/categories'
    })
  },
  created () {
    this.fetchCategories(`${CATEGORIES}/all`)
  },
  methods: {
    fetchCategories (endpoint) {
      request.all(endpoint)
        .then(({ data: categories }) => {
          // this.tasks = tasks.data
          this.$store.dispatch('categories/fetchAllCategories', categories.data)
        })
        .catch(error => {
          this.$notify({
            title: `Error loading categories`,
            text: error.response.data.message,
            type: 'error'
          })
        })
    }
  }
}
</script>

<style scoped lang="scss">
</style>
