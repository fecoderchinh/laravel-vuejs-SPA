<template>
  <nav class="tc-navbar">
    <div class="container flex items-center">
      <div class="w-full flex px-4">
        <router-link :to="{ name: 'welcome' }" class="tc-navbar__brand font-semibold">
          {{ $t('brand') }}
        </router-link>
        <button class="tc-navbar__toggler" type="button" @click="onClickShowNavbar">
          <list-svg class="w-6 fill-current" />
        </button>
        <div class="tc-navbar__list" :class="!this.showNavbar ? 'tc-navbar__collapse' : null">
          <ul class="tc-navbar__nav">
            <li class="nav-item">
              <router-link :to="{ name: 'welcome' }" class="nav-link">
                {{ $t('home') }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'tasks.index' }" class="nav-link">
                {{ $t('order') }}
              </router-link>
            </li>
          </ul>
          <dropdown-menu v-if="user" class="tc-navbar__nav ml-auto">
            <div class="flex">
              <div class="my-auto bg-gray-200 mr-3 rounded-full border-2 border-gray-200 overflow-hidden select-none">
<!--                <img :src="user.photo_url" class="select-none h-6" :alt="user.name">-->
                <user-svg class="w-4"></user-svg>
              </div>
              <div class="my-auto mr-4">
                <p class="font-semibold leading-none tracking-wide">
                  {{ user.name }}
                </p>
              </div>
            </div>

            <template v-slot:items>
              <div class="py-1">
                <router-link :to="{ name: 'admin.dashboard' }"
                             class="font-semibold block px-4 py-2 text-sm leading-5 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition-all duration-100 ease-in-out outline-none"
                             role="menuitem"
                >
                  {{ $t('dashboard') }}
                </router-link>
              </div>
              <div class="border-t border-gray-100" />
              <div class="py-1">
                <router-link :to="{name: 'settings.profile'}"
                             class="font-semibold block px-4 py-2 text-sm leading-5 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition-all duration-100 ease-in-out outline-none"
                             role="menuitem"
                >
                  {{ $t('settings') }}
                </router-link>
              </div>
              <div class="border-t border-gray-100" />
              <div class="py-1">
                <span
                  class="font-semibold cursor-pointer block px-4 py-2 text-sm leading-5 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition-all duration-100 ease-in-out outline-none"
                  role="menuitem"
                  @click="logout"
                >
                  {{ $t('logout') }}
                </span>
              </div>
            </template>
          </dropdown-menu>
          <template v-else>
            <ul class="tc-navbar__nav ml-auto">
              <li class="nav-item">
                <router-link :to="{ name: 'login' }" class="mx-4 transition-all duration-100 ease-in-out hover:text-teal-500">
                  {{ $t('login') }}
                </router-link>
              </li>
              <li class="nav-item">
                <router-link :to="{ name: 'register' }" class="mx-4 transition-all duration-100 ease-in-out hover:text-teal-500">
                  {{ $t('register') }}
                </router-link>
              </li>
            </ul>
          </template>
          <locale-dropdown />
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'

import DropdownMenu from '~/components/DropdownMenu'
import LocaleDropdown from '~/components/LocaleDropdown'

export default {
  components: {
    DropdownMenu,
    LocaleDropdown
  },
  data: () => ({
    appName: window.config.appName,
    showNavbar: false
  }),

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
    onClickShowNavbar () {
      this.showNavbar = !this.showNavbar
    }
  }
}
</script>

<style scoped lang="scss">
  .tc-navbar {
    @apply relative flex flex-wrap items-center justify-between py-2 shadow;
    > .container {
      @apply flex flex-wrap items-center justify-between;
      > div {
        @apply flex flex-wrap items-center justify-between;
      }
    }
    &__brand {
      @apply py-1 mr-4 text-xl whitespace-no-wrap;
    }
    &__toggler {
      @media (min-width: 992px) {
        @apply hidden;
      }
      @apply text-black text-opacity-50 border-black border-opacity-25;
    }
    &__nav {
      @apply flex flex-col pl-0 mb-0 list-none;
      @media (min-width: 992px) {
        @apply flex-row;
      }
      .nav-item {
        .nav-link {
          @apply block py-2 px-4 text-black text-opacity-50;
          &.active,
          &:hover, &:focus {
            @apply text-opacity-75;
          }
          @media (min-width: 992px) {
            @apply px-2;
          }
        }
      }
    }
    &__list {
      @apply flex-grow w-full items-center;
      @media (min-width: 992px) {
        @apply flex w-auto;
      }
      &.tc-navbar__collapse {
        @media (max-width: 992px) {
          @apply hidden;
        }
      }
    }
  }
</style>
