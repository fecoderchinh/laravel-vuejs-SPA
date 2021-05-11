<template>
  <div id="main-body" class="leading-normal tracking-normal">
    <div class="flex flex-wrap">
      <div class="bg-white w-3/4 md:w-1/3 lg:w-64 fixed top-0 lg:pt-0 md:pt-16 sm:pt-16 md:left-0 h-screen lg:block border-r z-30 shadow overflow-hidden h-full" :class="onToggled ? '' : 'hidden'">
        <sidebar />
        <a v-if="onToggled" href="#" class="fixed inset-0 z-20" @click.self.prevent="onToggled = false" />
      </div>

      <!-- eslint-disable max-len -->
      <div id="main-content" class="w-full bg-gray-100 pl-0 lg:pl-64 min-h-screen" :class="onToggled ? 'overlay' : ''">
        <Navbar @toggle-sidebar="onToggleSidebarMethod" />

        <div class="p-5 bg-gray-100 container mx-auto">
          <Breadcrumbs />
          <child />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Nav'
import Sidebar from '~/components/admin/parts/Sidebar'

export default {
  name: 'AdminLayout',

  components: {
    Sidebar,
    Navbar
  },

  data () {
    return {
      onToggled: false
    }
  },

  methods: {
    onToggleSidebarMethod () {
      this.onToggled = !this.onToggled
    }
  }
}
</script>
