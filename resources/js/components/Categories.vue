<template>
  <v-table>
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
      <tr v-for="(category, index) in categories" :key="index">
        <th scope="row">
          {{ index + 1 }}
        </th>
        <td>
          {{ category.name }}
        </td>
        <td>
          <span>{{ category.tasks_count }}</span>
        </td>
        <td>
          <!--          <router-link-->
          <!--            :to="{-->
          <!--              name: 'admin.categories.edit',-->
          <!--              params: {-->
          <!--                category: category.slug-->
          <!--              }-->
          <!--            }"-->
          <!--            class="inline mr-3"-->
          <!--          >-->
          <!--            <edit-svg class="w-4 fill-current inline" />-->
          <!--          </router-link>-->
          <a href="#" class="inline mr-3 btn btn-outline-danger rounded-circle round" @click="openModal(category)">
            <edit-svg class="w-4 fill-current inline" />
          </a>
          <a href="#"
             class="inline mr-3 btn btn-outline-danger rounded-circle round"
             @click.prevent="del2(category)"
          >
            <remove-svg class="w-4 fill-current inline" />
          </a>
        </td>
      </tr>
    </tbody>
  </v-table>
</template>

<script>
import cats from '~/utils/requests'
import { CATEGORIES } from '~/utils/endpoints'

import Swal from 'sweetalert2'

import EditCategoryModal from '~/components/modals/EditCategoryModal'
import vTable from '~/components/Table'

export default {
  name: 'Categories',
  components: {
    vTable
  },
  props: [ 'categories' ],
  methods: {
    del (cat) {
      let message = 'Are you sure you want to delete it ?'
      if (!cats.confirm(message)) {
        return
      }
      cats.del(CATEGORIES, cat.slug)
        .then(({ data: category }) => {
          return this.$store.dispatch('categories/removeCategory', cat)
        })
        .then(() => {
          this.$store.dispatch('alert/alert', { message: 'Categories deleted successfully' })
        })
        .catch(error => console.log(error))
    },
    del2 (cat) {
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
          cats.del(CATEGORIES, cat.slug)
            .then(({ data: category }) => {
              return this.$store.dispatch('categories/removeCategory', cat)
            })
            .then(() => {
              Swal.fire(
                'Deleted!',
                'User deleted successfully',
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
    openModal (category) {
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

      this.$modal.show(EditCategoryModal, { data: category }, options, events)
    }
  }
}
</script>

<style scoped>

</style>
