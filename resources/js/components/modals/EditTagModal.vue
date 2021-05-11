<template>
  <modal @close="$emit('close')">
    <h5 slot="header">
      Edit Tag: {{ tag.name }}
    </h5>
    <div slot="body" class="w-full">
      <box>
        <ValidationObserver ref="form">
          <ValidationProvider v-slot="{ errors }" rules="required">
            <div class="w-full">
              <label for="name">Edit a category</label>
              <input id="name"
                     v-model="tag.name"
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
import request from '~/utils/requests'
import { TAGS } from '~/utils/endpoints'
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
      tag: null
    }
  },
  created () {
    this.tag = this.data
  },
  methods: {
    update () {
      request.update(TAGS, this.tag.slug, {
        name: this.tag.name
      })
        .then(({ data: tag }) => {
          this.$notify({
            title: `Success update name for tag #${this.tag.id}`,
            text: tag.data.message,
            type: 'success'
          })
        })
        .then(() => {
          this.$emit('close')
        })
        .catch(error => {
          this.$notify({
            title: `Error update name for tag #${this.tag.id}`,
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
