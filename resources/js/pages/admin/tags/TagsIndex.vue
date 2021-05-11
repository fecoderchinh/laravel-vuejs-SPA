<template>
  <div>
    <table>
      <thead>
        <tr>
          <th scope="col">
            #
          </th>
          <th scope="col">
            Name
          </th>
          <th scope="col">
            Posts
          </th>
          <th scope="col">
            Actions
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(tag, index) in tags">
          <th scope="row">
            {{ index + 1 }}
          </th>
          <td>{{ tag.name }}</td>
          <td>
            <span>{{ tag.posts_count }}</span>
          </td>
          <td>
            <router-link href="#" class="btn btn-outline-info rounded-circle round"
                         :to="{
                           name: 'admin.tags.edit',
                           params: {
                             tag: tag.slug
                           }
                         }"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
              </svg>
            </router-link>
            <a href="#" @click.prevent="deleteTags(tag)">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
              </svg>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import tags from '~/utils/requests'
import { TAGS } from '~/utils/endpoints'

export default {
  name: 'TagsIndex',
  middleware: ['auth'],
  layout: 'admin',
  computed: {
    ...mapGetters({
      tags: 'tag/tags'
    })
  },
  created () {
    this.$store.dispatch('tag/fetchTagsByUser')
  },
  methods: {
    deleteTags (tag) {
      let message = 'Are you sure you want to delete it ?'
      if (!tags.confirm(message)) {
        return
      }
      tags.del(TAGS, tag.slug)
        .then(({ data: tagData }) => {
          this.$store.dispatch('tag/removeTag', tag)
        })
        .then(() => {
          this.$store.dispatch('alert/alert', { message: 'Tag deleted successfully' })
        })
        .catch(error => console.log(error))
    }
  }
}
</script>

<style scoped>

</style>
