<template>
  <div>
    <div class="w-full">
      <!--      <router-link :to="{name: 'admin.categories.create'}">-->
      <!--        Add a category-->
      <!--      </router-link>-->
      <button
        class="tc-button tc-button__primary tc-button__fill"
        role="menuitem"
        @click="openModal()"
      >
        Add categories
      </button>
    </div>
    <div class="w-full mt-5">
      <box>
        <categories :categories="this.categories" />
        <pagination :meta="pagination" @changed="paginate" />
      </box>
    </div>
  </div>
</template>

<script>
import Categories from '~/components/Categories'
import { mapGetters } from 'vuex'
import cats from '~/utils/requests'
import { CATEGORIES } from '~/utils/endpoints'
import CreateCategoriesModal from '~/components/modals/CreateCategoriesModal'
import Pagination from '~/components/Pagination'

export default {
  name: 'CategoriesIndex',
  middleware: ['auth'],
  components: {
    Categories,
    Pagination
  },
  data () {
    return {
      pagination: {}
    }
  },
  computed: {
    ...mapGetters({
      categories: 'categories/categories'
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
  },
  methods: {
    fetchCategories (endpoint) {
      cats.all(endpoint)
        .then(({ data: categories }) => {
          this.pagination = categories.meta
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
    },
    getEndpoint (page = null) {
      return page !== null ? `${CATEGORIES}?page=${page}` : CATEGORIES
    },
    paginate (page) {
      let endpoint = `${CATEGORIES}?page=${page}`
      this.fetchCategories(endpoint)
    },
    openModal () {
      const styles = {
        class: 'cms-modal modal-md'
      }
      const options = {
        width: 720, height: 'auto', shiftX: 0.5, adaptive: true
      }
      const events = {
        // opened: () => console.log('Opened'),
        closed: () => this.$emit('close')
      }

      this.$modal.show(CreateCategoriesModal, styles, options, events)
    }
  }
}
</script>

<style scoped>

</style>
