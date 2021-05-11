<template>
  <box>
    <v-table>
      <thead>
        <tr>
          <th scope="col">
            #
          </th>
          <th scope="col">
            Email
          </th>
          <th scope="col">
            Author name
          </th>
          <th scope="col">
            Description
          </th>
          <th scope="col">
            Actions
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(comment, index) in comments" :key="index">
          <th scope="row">
            {{ index + 1 }}
          </th>
          <td>
            {{ comment.author_email }}
          </td>
          <td>
            {{ comment.author_name }}
          </td>
          <td>
            {{ comment.description }}
          </td>
          <td>
            <a href="#" class="btn btn-outline-info rounded-circle round" data-toggle="modal" @click.prevent="openModal(comment)">
              <info-svg class="w-4 fill-current inline" />
            </a>
            <a href="#" class="btn btn-outline-danger rounded-circle round" @click.prevent="deleteComment(comment)">
              <remove-svg class="w-4 fill-current inline" />
            </a>
          </td>
        </tr>
      </tbody>
    </v-table>
  </box>
</template>

<script>
import { mapGetters } from 'vuex'
import comments from '~/utils/requests'
import vTable from '~/components/Table'
import { COMMENTS } from '~/utils/endpoints'
import CommentModal from '~/components/modals/CommentModal'
import Swal from 'sweetalert2'

export default {
  name: 'CommentsIndex',
  middleware: ['auth'],
  layout: 'admin',
  components: {
    vTable
  },
  data () {
    return {
      comment: {},
      showModal: false,
      endpoint: COMMENTS
    }
  },
  computed: {
    ...mapGetters({
      comments: 'comments/comments'
    })
  },
  created () {
    this.$store.dispatch('comments/fetchCommentsByUser')
  },
  methods: {
    // deleteComment (cmt) {
    //   let message = 'Are you sure you want to delete it ?'
    //   if (!comments.confirm(message)) {
    //     return
    //   }
    //   comments.del(COMMENTS, cmt.id)
    //     .then(({ data: cmtData }) => {
    //       this.$store.dispatch('comments/removeComment', cmt)
    //     })
    //     .then(() => {
    //       this.$store.dispatch('alert/alert', { message: 'Comment deleted successfully' })
    //     })
    //     .catch(error => console.log(error))
    // },
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
          comments.del(COMMENTS, data.id)
            .then(({ data: category }) => {
              return this.$store.dispatch('comments/removeComment', data)
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
    },
    openModal (data) {
      const styles = {
        class: 'cms-modal modal-md'
      }
      const options = {
        width: 720, height: 'auto', shiftX: 0.5, adaptive: true, ...styles
      }
      const events = {
        // opened: () => console.log('Opened'),
        closed: () => this.$emit('close')
      }

      this.$modal.show(CommentModal, { comment: data }, options, events)
    }
  }
}
</script>

<style scoped>

</style>
