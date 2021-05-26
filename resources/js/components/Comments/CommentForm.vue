<template>
  <div class="mins:w-1/2 maxs:w-full">
      <div class="w-full">
        <div class="w-full">
          <span>{{ user.data.name }}</span>
        </div>
        <div class="w-full">
          <span>{{ user.data.email }}</span>
        </div>
        <div class="block mt-3">
          <label class="font-bold text-gray-700 select-none" for="content">{{ $t('content') }}</label>
          <textarea id="content" v-model="form.content" class="tc-input" :placeholder="$t('content')" />
          <span class="text-red-500" v-if="errors.has('content')">{{ errors.get('content') }}</span>
        </div>
        <div class="block">
          <button class="tc-button tc-button__primary tc-button__fill" @click="store">
            {{ $t('post_comment') }}
          </button>
        </div>
      </div>
  </div>
</template>

<script>
import request from '~/utils/requests'
import Errors from '~/utils/Errors'

export default {
  name: 'CommentForm',
  data () {
    return {
      form: {
        author_name: '',
        author_email: '',
        content: ''
      },
      loading: false,
      errors: new Errors()
    }
  },
  computed: {
    user () {
      return this.$store.getters['auth/user']
    }
  },
  methods: {
    store () {
      this.loading = true
      request.store(`/api/${this.$route.params.task}/comments`, {
        author_name: this.user.data.name,
        author_email: this.user.data.email,
        content: this.form.content,
        user_id: this.user.data.id
      })
        .then(({ data: comment }) => {
          this.$notify({
            title: `Success added comment`,
            text: comment.data.message,
            type: 'success'
          })
          this.$emit('submit', comment.data)
          return this.$store.dispatch('comments/createComment', comment.data)
        })
        .then(() => {
          this.loading = false
          this.clearForm()
        })
        .catch(error => {
          // console.log(error)
          // display error notification
          this.errors.record(error.response.data.errors)
          this.$notify({
            title: `Error added comment`,
            text: error.response.data.message,
            type: 'error'
          })
          this.loading = false
        })
    },
    clearForm () {
      this.form = {
        author_name: '',
        author_email: '',
        content: ''
      }
    }
  }
}
</script>

<style scoped>

</style>
