<template>
  <v-table>
    <thead>
      <tr>
        <th scope="col">
          #
        </th>
        <th scope="col">
          Title
        </th>
        <th scope="col">
          Description
        </th>
        <th scope="col">
          Category
        </th>
        <th scope="col">
          Views
        </th>
        <th scope="col">
          Online ?
        </th>
        <th scope="col">
          Actions
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(post, index) in data" :key="index">
        <th scope="row">
          {{ index + 1 }}
        </th>
        <td>{{ post.title }}</td>
        <td>{{ post.description }}</td>
        <td>
          {{ post.category.name }}
        </td>
        <td>
          <span>{{ post.visits_count }}</span>
        </td>
        <td>
          <span :class="post.online ? 'text-green-500' : 'text-red-500'">
            <eye-fill-svg v-if="post.online" class="w-6 fill-current inline" />
            <eye-slash-svg v-else class="w-6 fill-current inline" />
          </span>
        </td>
        <td>
          <router-link
            :to="{
              name: 'admin.tasks.edit',
              params: {
                task: post.slug
              }
            }"
          >
            <edit-svg class="w-4 fill-current inline" />
          </router-link>
          <a href="#" @click.prevent="del2(post)">
            <remove-svg class="w-4 fill-current inline" />
          </a>
        </td>
      </tr>
    </tbody>
  </v-table>
</template>

<script>
import request from '~/utils/requests'
import { TASKS } from '~/utils/endpoints'

import vTable from '~/components/Table'
import Swal from 'sweetalert2'

export default {
  name: 'Tasks',
  components: {
    vTable
  },
  props: [ 'data' ],
  methods: {
    del (task) {
      let message = 'Are you sure you want to delete it ?'
      if (!request.confirm(message)) {
        return
      }
      request.del(TASKS, task.slug)
        .then(({ data: dataTask }) => {
          return this.$store.dispatch('task/deleteTask', task)
        })
        .then(() => {
          this.$store.dispatch('categories/removeCategoryPostsCount', task.category)
        })
        .then(() => {
          this.$store.dispatch('alert/alert', { message: 'Task deleted successfully' })
        })
        .catch(error => console.log(error))
    },
    del2 (task) {
      Swal.fire({
        title: 'Are you sure you want to delete task ' + task.id + '?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          // Send Request to server
          request.del(TASKS, task.slug)
            .then(({ data: dataTask }) => {
              return this.$store.dispatch('task/deleteTask', task)
            })
            .then(() => {
              this.$store.dispatch('categories/removeCategoryPostsCount', task.category)
            })
            .then(() => {
              Swal.fire(
                'Deleted!',
                'Task deleted successfully',
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
