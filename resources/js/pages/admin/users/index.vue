<template>
  <transition name="fade" mode="out-in">
    <router-view />
  </transition>
</template>

<script>
export default {
  // middleware: ['auth', 'role:admin, company', 'permission: edit-users'],
  middleware: ['auth', 'role:admin'],
  layout: 'admin'
}
</script>
