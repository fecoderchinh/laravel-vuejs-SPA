<template>
  <div>
    <div class="form-group">
      <label for="name">Edit a tag</label>
      <input id="name" v-model="tag.name" type="text" class="form-control">
    </div>
    <span v-if="errors.has('name')" class="text-danger d-block mb-2">{{ errors.get('name') }}</span>
    <div class="form-group">
      <button class="btn btn-lg btn-info" @click="update">
        Update <i class="fa fa-check" />
      </button>
    </div>
  </div>
</template>

<script>
import tags from '~/utils/requests'
import { TAGS } from '~/utils/endpoints'
import Errors from '~/utils/Errors'

export default {
  name: 'TagsEdit',
  middleware: ['auth'],
  layout: 'admin',
  data () {
    return {
      tag: {
        name: null
      },
      endpoint: TAGS,
      errors: new Errors()
    }
  },
  mounted () {
    document.title = 'Edit a tag | SPA Blog'
    this.endpoint = this.endpoint + `/${this.$route.params.tag}`
    this.loadTag(this.$route.params.tag)
  },
  methods: {
    loadTag (id) {
      tags.find(TAGS, id)
        .then(({ data: tag }) => {
          this.tag = tag.data
        })
    },
    update () {
      tags.update(TAGS, this.$route.params.tag, {
        name: this.tag.name
      })
        .then(() => {
          this.$store.dispatch('alert/alert', { message: 'Tag updated successfully' })
          this.$router.push({
            name: 'admin.tags.index'
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
