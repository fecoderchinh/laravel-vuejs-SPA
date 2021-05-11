<template>
  <box>
    <div class="w-full">
      <tag-input v-model="categories" label="Add categories" name="category" />
      <span v-if="errors.has('names')">{{ errors.get('names') }}</span>
      <div>
        <button @click="create">
          Apply
        </button>
      </div>
    </div>
  </box>
</template>

<script>
import cats from '~/utils/requests'
import { CATEGORIES } from '~/utils/endpoints'
import TagInput from '~/components/TagInput'
import Errors from '~/utils/Errors'

export default {
  name: 'CategoriesCreate',
  middleware: ['auth'],
  components: {
    TagInput
  },
  data () {
    return {
      categories: null,
      errors: new Errors()
    }
  },
  methods: {
    create () {
      cats.store(CATEGORIES, { names: this.categories })
        .then(({ data: categories }) => {
          return this.$store.dispatch('categories/storeCategories', categories.data)
        })
        .then(() => {
          this.$store.dispatch('alert/alert', { message: 'Categories stored successfully' })
          this.$router.push({
            'name': 'admin.categories.index'
          })
        })
        .catch((error) => {
          if (error.response.data.errors) {
            this.errors.record(error.response.data.errors)
          } else {
            this.$store.dispatch('alert/alert', {
              message: 'There is an error with the request',
              type: 'dangerr'
            })
          }
        })
    }
  }
}
</script>

<style scoped>

</style>
