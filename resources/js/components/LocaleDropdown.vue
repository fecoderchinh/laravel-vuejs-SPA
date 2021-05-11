<template>
  <dropdown-menu class="tc-navbar__nav ml-5">
    <div class="flex">
      <div class="my-auto mr-4">
        <div class="my-auto bg-gray-200 mr-3 rounded-full border-2 border-gray-200 overflow-hidden select-none">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16">
            <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001" />
          </svg>
        </div>
        <!--        <p class="font-semibold leading-none tracking-wide">-->
        <!--          {{ locales[locale] }}-->
        <!--        </p>-->
      </div>
    </div>

    <template v-slot:items>
      <div v-for="(value, key) in locales" :key="key" class="py-1">
        <a href="#"
           class="font-semibold cursor-pointer block px-4 py-2 text-sm leading-5 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition-all duration-100 ease-in-out outline-none"
           @click.prevent="setLocale(key)"
        >{{ value }}</a>
      </div>
    </template>
  </dropdown-menu>
</template>

<script>
import { mapGetters } from 'vuex'
import { loadMessages } from '~/plugins/i18n'

import DropdownMenu from '~/components/DropdownMenu'

export default {
  components: {
    DropdownMenu
  },
  computed: mapGetters({
    locale: 'lang/locale',
    locales: 'lang/locales'
  }),

  methods: {
    setLocale (locale) {
      if (this.$i18n.locale !== locale) {
        loadMessages(locale)

        this.$store.dispatch('lang/setLocale', { locale })
      }
    }
  }
}
</script>
