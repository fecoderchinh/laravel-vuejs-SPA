<template>
  <box>
    <v-table>
      <thead>
        <tr>
          <th scope="col">
            #
          </th>
          <th scope="col">
            #
          </th>
          <th scope="col">
            Name
          </th>
          <th scope="col">
            Email
          </th>
          <th scope="col">
            Roles
          </th>
          <th scope="col">
            Permissions
          </th>
          <th scope="col">
            Created at
          </th>
          <th scope="col">
            Updated at
          </th>
          <th scope="col">
            Actions
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, index) in users" :key="index">
          <th scope="row">
            {{ index + 1 }}
          </th>
          <td>
            <img :src="user.img" :alt="user.name" class="w-1/4">
          </td>
          <td>
            {{ user.name }}
          </td>
          <td>
            {{ user.email }}
          </td>
          <td>
            <span v-for="role in user.roles" :key="role.id">
              {{ role.name }}
            </span>
          </td>
          <td>
            <span v-for="permission in user.permissions" :key="permission.id">
              {{ permission.name }}
            </span>
          </td>
          <td>
            {{ user.created_at }}
          </td>
          <td>
            {{ user.updated_at }}
          </td>
          <td>
            <a href="#" @click.prevent="del(user)">
              <remove-svg class="w-4" />
            </a>
          </td>
        </tr>
      </tbody>
    </v-table>
  </box>
</template>

<script>
import { mapGetters } from 'vuex'
import vTable from '~/components/Table'

import requests from '~/utils/requests'
import { USERS } from '~/utils/endpoints'
import Swal from 'sweetalert2'

export default {
  name: 'AllUsers',
  components: {
    vTable
  },
  computed: {
    ...mapGetters({
      users: 'users/users'
    })
  },
  created () {
    this.$store.dispatch('users/fetchUsers')
  },
  methods: {
    del (data) {
      Swal.fire({
        title: 'Are you sure you want to delete task ' + data.id + '?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          // Send Request to server
          requests.del(USERS, data.id)
            .then(({ data: userData }) => {
              return this.$store.dispatch('users/deleteUser', data)
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
    }
  }
}
</script>

<style scoped>

</style>
