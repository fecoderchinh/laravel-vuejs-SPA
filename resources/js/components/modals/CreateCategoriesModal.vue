<template>
  <modal @close="$emit('close')">
    <h5 slot="header">
      Create Multiple Categories
    </h5>
    <div slot="body" class="w-full">
      <ValidationObserver ref="form">
        <ValidationProvider v-slot="{ errors }" rules="required">
          <tag-input v-model="categories" :label="$t('add_categories_label')" name="category" />
          <span>{{ errors[0] }}</span>
        </ValidationProvider>
        <div>
          <button class="tc-button tc-button__primary" @click="create">
            <fa v-if="loading" :icon="['fas', 'circle-notch']" class="fa-spin" />
            <span v-else>{{ $t('apply_actions') }}</span>
          </button>
        </div>
      </ValidationObserver>
    </div>
  </modal>
</template>
<script>
import Modal from '~/components/modals/Modal'
import cats from '~/utils/requests'
import { CATEGORIES } from '~/utils/endpoints'
import TagInput from '~/components/TagInput'
import { ValidationObserver, ValidationProvider } from 'vee-validate'

export default {
  name: 'CreateCategoriesModal',
  components: {
    Modal,
    TagInput,
    ValidationObserver,
    ValidationProvider
  },
  data () {
    return {
      categories: null,
      loading: false
    }
  },
  methods: {
    create () {
      this.loading = true
      cats.store(CATEGORIES, { names: this.categories })
        .then(({ data: categories }) => {
          this.$notify({
            title: `Success added categories`,
            text: categories.data.message,
            type: 'success'
          })
          return this.$store.dispatch('categories/storeCategories', categories.data)
        })
        .then(() => {
          this.loading = false
          this.$emit('close')
        })
        .catch(error => {
          // console.log(error)
          // display error notification
          this.$notify({
            title: `Error added categories`,
            text: error.response.data.message,
            type: 'error'
          })
          this.loading = false
        })
    }
  }
}
</script>

<style scoped>

</style>
