<template>
  <box>
    {{ users }}
  </box>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'AllUsers',
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
