<template>
  <modal @close="$emit('close')">
    <h5 slot="header">
      Edit category: {{ category.name }}
    </h5>
    <div slot="body" class="w-full">
      <box>
        <ValidationObserver ref="form">
          <ValidationProvider v-slot="{ errors }" rules="required">
            <div class="w-full">
              <label for="name">Edit a category</label>
              <input id="name"
                     v-model="category.name"
                     type="text"
                     class="tc-input"
              >
              <span>{{ errors[0] }}</span>
            </div>
          </ValidationProvider>
          <div class="w-full">
            <button class="tc-button tc-button__primary tc-button__fill"
                    @click="update"
            >
              Update
            </button>
          </div>
        </ValidationObserver>
      </box>
    </div>
  </modal>
</template>
<script>
import Modal from '~/components/modals/Modal'
import cats from '~/utils/requests'
import { CATEGORIES } from '~/utils/endpoints'
import { ValidationObserver, ValidationProvider } from 'vee-validate'

export default {
  name: 'EditCategoryModal',
  components: {
    Modal,
    ValidationObserver,
    ValidationProvider
  },
  props: ['data'],
  data () {
    return {
      category: null
    }
  },
  created () {
    this.category = this.data
  },
  methods: {
    update () {
      cats.update(CATEGORIES, this.category.slug, {
        name: this.category.name
      })
        .then(({ data: category }) => {
          this.$notify({
            title: `Success update name for category #${this.category.id}`,
            text: category.data.message,
            type: 'success'
          })
          return this.$store.dispatch('categories/updateCategory', category)
        })
        .then(() => {
          this.$emit('close')
        })
        .catch(error => {
          this.$notify({
            title: `Error update name for category #${this.category.id}`,
            text: error.response.data.message,
            type: 'error'
          })
        })
    }
  }
}
</script>

<style scoped>

</style>
