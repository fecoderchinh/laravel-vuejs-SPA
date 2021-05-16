<template>
  <transition name="fade" mode="out-in">
    <router-view />
  </transition>
</template>

<script>
export default {
  // middleware: ['auth', 'permission: edit-users'],
  middleware: ['auth', 'role:admin'],
  layout: 'admin'
}
</script>
