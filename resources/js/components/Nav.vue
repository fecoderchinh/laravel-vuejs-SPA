<template>
  <!-- eslint-disable max-len -->
  <div class="w-full shadow-sm bg-white md:h-16 sm:h-auto md:px-5 border-b sm:max-flex-col md:flex items-center justify-start">
    <div class="flex flex-auto sm:p-3 md:p-0 md:border-0">
      <!-- top navbar -->
      <div class="flex-auto flex">
        <!-- mobile hamburger -->
        <div class="flex items-center">
          <div class="lg:hidden flex items-center md:mr-4 sm:mr-3">
            <button class="group focus:outline-none p-2"
                    @click="$emit('toggle-sidebar')"
            >
              <menubar-svg class="w-4 text-labelAndTitle group-focus:fill-buttonAndURL" />
            </button>
          </div>
        </div>

        <!-- search bar -->
        <search-form />
        <locale-dropdown />
      </div>
      <div class="flex mx-5">
        <router-link :to="{name: 'welcome'}"
                     class="text-blue-500 cms-typo text-base flex h-full items-center relative sm:mr-2"
        >
          <home-svg class="fill-current w-4 group-hover:fill-current" />
          <span class="ml-2">{{ $t('go_home') }}</span>
        </router-link>
      </div>
    </div>
    <div class="flex my-auto">
      <div class="my-auto">
        <!-- Notifications -->
      </div>
      <div class="my-auto flex">
        <dropdown-menu v-if="user" class="my-auto">
          <div class="flex">
            <div class="my-auto mr-3 rounded-full border-2 border-gray-200 overflow-hidden select-none">
              <user-svg class="w-4 h-4 fill-menuIcon" />
            </div>
          </div>

          <template v-slot:items>
            <div class="py-1">
              <router-link :to="{name: 'settings.profile'}"
                           class="font-semibold block px-4 py-2 text-sm leading-5 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition-all duration-100 ease-in-out outline-none"
                           role="menuitem"
              >
                Settings
              </router-link>
            </div>
            <div class="border-t border-gray-100" />
            <div class="py-1">
              <a href="#"
                 class="font-semibold block px-4 py-2 text-sm leading-5 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition-all duration-100 ease-in-out outline-none"
                 role="menuitem"
                 @click="openModal(user)"
              >
                Change Password
              </a>
            </div>
            <div class="border-t border-gray-100" />
            <div class="py-1">
              <span
                class="font-semibold cursor-pointer block px-4 py-2 text-sm leading-5 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition-all duration-100 ease-in-out outline-none"
                role="menuitem"
                @click="logout"
              >
                Logout
              </span>
            </div>
          </template>
        </dropdown-menu>
      </div>
    </div>
  </div>
</template>
<script>
import DropdownMenu from '~/components/DropdownMenu'
import PasswordModal from '~/components/modals/PasswordModal'
import SearchForm from '~/components/admin/parts/TasksSearchForm'
import LocaleDropdown from '~/components/LocaleDropdown'
import { mapGetters } from 'vuex'

export default {
  components: {
    DropdownMenu,
    SearchForm,
    LocaleDropdown
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      await this.$router.push({ name: 'login' })
    },
    openModal (user) {
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

      this.$modal.show(PasswordModal, { data: user }, options, events)
    }
  }
}
</script>
<style scoped lang="scss">

</style>
