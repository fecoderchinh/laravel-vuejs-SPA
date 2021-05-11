<template>
  <modal @close="$emit('close')">
    <h5 slot="header">
      Manage Tags
    </h5>
    <div slot="body" class="w-full">
      <ul v-if="tags.length > 0" class="list-none">
        <li v-for="(item, index) in tags" :key="index"
            class="inline-block p-2 my-2 mr-2 bg-indigo-300 hover:bg-indigo-500 hover:text-white"
        >
          <span class="inline mr-2 cursor-pointer" @click="updateValue(item)">{{ item.name }}</span>
          <span class="inline mr-2 cursor-pointer hover:text-white" @click="deleteTags(item)">
            <close-svg class="w-4 h-4 fill-current inline" />
          </span>
        </li>
      </ul>
      <p v-else>
        No tag is found.
      </p>
    </div>
  </modal>
</template>
<script>
import Modal from '~/components/modals/Modal'
import { mapGetters } from 'vuex'
import request from '~/utils/requests'
import { TAGS } from '~/utils/endpoints'

import EditTagModal from '~/components/modals/EditTagModal'
import Swal from 'sweetalert2'

export default {
  name: 'TagsModal',
  components: {
    Modal
  },
  data () {
    return {
      tag: {}
    }
  },
  computed: {
    ...mapGetters({
      tags: 'tag/tags'
    })
  },
  created () {
    this.$store.dispatch('tag/fetchTagsByUser')
  },
  methods: {
    // deleteTags (tag) {
    //   let message = 'Are you sure you want to delete it ?'
    //   if (!tags.confirm(message)) {
    //     return
    //   }
    //   request.del(TAGS, tag.slug)
    //     .then(({ data: tagData }) => {
    //       this.$store.dispatch('tag/removeTag', tag)
    //     })
    //     .then(() => {
    //       this.$store.dispatch('alert/alert', { message: 'Tag deleted successfully' })
    //     })
    //     .catch(error => console.log(error))
    // },
    deleteTags (tag) {
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
          request.del(TAGS, tag.slug)
            .then(({ data: tagData }) => {
              return this.$store.dispatch('tag/removeTag', tag)
            })
            .then(() => {
              Swal.fire(
                'Deleted!',
                'Tag deleted successfully',
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
    updateValue (tag) {
      const styles = {
        class: 'cms-modal modal-md'
      }
      const options = {
        width: 720, height: 'auto', shiftX: 0.5, adaptive: true, ...styles
      }
      const events = {
        // opened: () => console.log('Opened'),
        // closed: () => this.$emit('close')
      }

      this.$modal.show(EditTagModal, { data: tag }, options, events)
    }
  }
}
</script>

<style scoped>

</style>
