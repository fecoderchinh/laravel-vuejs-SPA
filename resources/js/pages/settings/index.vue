<template>
  <div class="flex flex-col">
    <div class="bg-white flex">
      <div class="flex mx-auto">
        <router-link
          v-for="tab in tabs"
          :key="tab.route"
          :to="{ name: tab.route }"
          class="p-4"
          active-class="text-gray-800 border-teal-500 bg-blue-300"
        >
          <component :is="tab.icon" class="inline-flex w-4 h-4 mr-3 fill-current -mt-px" />
          {{ tab.name }}
        </router-link>
      </div>
    </div>

    <box class="flex">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </box>
  </div>
</template>

<script>
export default {
  middleware: 'auth',
  layout: 'admin',

  computed: {
    tabs () {
      return [
        {
          icon: 'user-svg',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'lock-svg',
          name: this.$t('password'),
          route: 'settings.password'
        }
      ]
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
