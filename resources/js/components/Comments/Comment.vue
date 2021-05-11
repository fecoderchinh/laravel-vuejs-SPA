<template>
  <div class="w-full mt-5">
    <box class="shadow mb-5">
      <div class="w-full">
        <span>{{ data.author_name }}</span>
        <span class="block text-secondary">{{ data.created_at }}</span>
      </div>
      <div class="w-full">
        <p>
          {{ data.content }}
        </p>
      </div>
      <div v-if="auth" class="card-footer d-flex justify-content-end">
        <button class="tc-button tc-button__primary tc-button__fill" @click="deleteComment">
          Delete
        </button>
      </div>
    </box>
  </div>
</template>

<script>
import { COMMENTS } from '~/utils/endpoints'
import comments from '~/utils/requests'
import Swal from 'sweetalert2'

export default {
  name: 'Comment',
  props: ['data'],
  computed: {
    auth () {
      return !!(this.$store.getters['auth/check'] && this.data.user_id === this.$store.getters['auth/user'].id)
    }
  },
  methods: {
    deleteComment () {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          // Send Request to server
          comments.del(COMMENTS, this.data.id)
            .then(({ data: category }) => {
              this.$emit('delete', this.data)
              return this.$store.dispatch('comments/removeComment', this.data)
            })
            .then(() => {
              Swal.fire(
                'Deleted!',
                'Comment deleted successfully',
                'success'
              )
            })
            .catch(() => {
              Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href>Why do I have this issue?</a>'
              })
            })
        }
      })
    }
  }
}
</script>

<style scoped>

</style>
