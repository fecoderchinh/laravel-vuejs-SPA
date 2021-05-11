<template>
  <div class="mins:w-1/2 maxs:w-full">
    <ValidationObserver v-if="user" ref="form">
      <div class="w-full">
        <span>{{ data.name }}</span>
      </div>
      <div class="w-full">
        <span>{{ data.email }}</span>
      </div>
      <ValidationProvider v-slot="{ errors }" rules="required" class="block mt-3">
        <label class="font-bold text-gray-700 select-none" for="content">{{ $t('content') }}</label>
        <textarea id="content" v-model="form.content" class="tc-input" :placeholder="$t('content')" />
        <span class="text-red-500">{{ errors[0] }}</span>
      </ValidationProvider>
      <div class="block">
        <button class="tc-button tc-button__primary tc-button__fill" @click="store">
          {{ $t('post_comment') }}
        </button>
      </div>
    </ValidationObserver>
    <router-link v-else :to="{ name: 'login' }" class="tc-button tc-button__fill tc-button__primary">
      {{ $t('login') }}
    </router-link>
  </div>
</template>

<script>
import request from '~/utils/requests'
import { ValidationObserver, ValidationProvider } from 'vee-validate'

export default {
  name: 'CommentForm',
  components: {
    ValidationObserver, ValidationProvider
  },
  props: ['data'],
  data () {
    return {
      form: {
        author_name: '',
        author_email: '',
        content: ''
      },
      loading: false
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
      if (this.user) {
        request.store(`/api/${this.$route.params.task}/comments`, {
          author_name: this.data.name,
          author_email: this.data.email,
          content: this.form.content,
          user_id: this.user.id
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
            this.$notify({
              title: `Error added comment`,
              text: error.response.data.message,
              type: 'error'
            })
            this.loading = false
          })
      }
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
