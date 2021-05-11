<template>
  <div>
    <div class="w-full">
      <label for="name">Edit a category</label>
      <input id="name" v-model="category.name" type="text">
    </div>
    <span v-if="errors.has('name')" class="text-danger d-block mb-2">{{ errors.get('name') }}</span>
    <div class="w-full">
      <button @click="update">
        Update
      </button>
    </div>
  </div>
</template>

<script>
import Errors from '~/utils/Errors'
import cats from '~/utils/requests'
import { CATEGORIES } from '~/utils/endpoints'

export default {
  name: 'CategoriesEdit',
  middleware: ['auth'],
  data () {
    return {
      category: {
        name: null
      },
      errors: new Errors()
    }
  },
  created () {
    cats.find(CATEGORIES, this.$route.params.category)
      .then((res) => { this.category = res.data.data })
      .catch(error => console.log(error))
  },
  methods: {
    update () {
      cats.update(CATEGORIES, this.$route.params.category, {
        name: this.category.name
      })
        .then(({ data: category }) => {
          return this.$store.dispatch('categories/updateCategory', category)
        })
        .then(() => {
          this.$store.dispatch('alert/alert', { message: 'Category updated successfully' })
          this.$router.push({
            name: 'admin.categories.index'
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
