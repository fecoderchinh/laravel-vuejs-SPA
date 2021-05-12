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
      </tr>
      </thead>
      <tbody>
      <tr v-for="(user, index) in users" :key="index">
        <th scope="row">
          {{ index + 1 }}
        </th>
        <td>
          <img :src="user.img" :alt="user.name" class="w-100">
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
      </tr>
      </tbody>
    </v-table>
  </box>
</template>

<script>
import { mapGetters } from 'vuex'
import vTable from '~/components/Table'

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
  }
}
</script>

<style scoped>

</style>
