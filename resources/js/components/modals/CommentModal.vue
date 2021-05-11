<template>
  <modal @close="$emit('close')">
    <template slot="header">
      <h5>
        {{ comment.author_name }}
        <br>
        <small>{{ comment.author_email }}</small>
      </h5>
    </template>

    <template slot="body">
      {{ comment.content }}
    </template>

    <template slot="footer">
      <button type="button" class="tc-button tc-button__primary mr-5" @click="deleteComment(comment)">
        <remove-svg class="w-4 fill-current inline" /> Delete
      </button>
      <button type="button" class="tc-button tc-button__primary tc-button__fill" @click="$emit('close')">
        Close
      </button>
    </template>
  </modal>
</template>

<script>
import Modal from '~/components/modals/Modal'
import cmt from '~/utils/requests'
import { COMMENTS } from '~/utils/endpoints'
import Swal from 'sweetalert2'

export default {
  name: 'CommentModal',
  components: {
    Modal
  },
  props: ['comment'],
  methods: {
    // deleteComment (data) {
    //   let message = 'Are you sure you want to delete it ?'
    //   if (!cmt.confirm(message)) {
    //     return
    //   }
    //   cmt.del(COMMENTS, data.id)
    //     .then(({ data: comment }) => {
    //       return this.$store.dispatch('comments/removeComment', data)
    //     })
    //     .then(() => {
    //       this.$store.dispatch('alert/alert', { message: 'Comment deleted successfully' })
    //     })
    //     .catch(error => console.log(error))
    //   this.$emit('close')
    // }
    deleteComment (data) {
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
          cmt.del(COMMENTS, data.id)
            .then(({ data: category }) => {
              return this.$store.dispatch('comments/removeComment', data)
            })
            .then(() => {
              this.$emit('close')
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
