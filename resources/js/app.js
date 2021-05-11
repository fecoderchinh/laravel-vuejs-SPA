import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'

import '~/plugins'
import '~/components'

import VModal from 'vue-js-modal'
import Notifications from 'vue-notification'
import velocity from 'velocity-animate'
import { extend } from 'vee-validate'
import { required } from 'vee-validate/dist/rules'
import VueBreadcrumbs from 'vue-2-breadcrumbs'

extend('required', {
  ...required,
  message: 'This field is required'
})

Vue.config.productionTip = false
Vue.use(VModal, { dynamic: true, injectModalsContainer: true })
Vue.use(Notifications, { velocity })

Vue.use(VueBreadcrumbs, {
  template:
    `<nav v-if="$breadcrumbs.length" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li v-for="(crumb, key) in $breadcrumbs" v-if="crumb.meta.breadcrumb" :key="key" class="breadcrumb-item active" aria-current="page">
          <router-link v-if="key+1 !== $breadcrumbs.length" :to="{ path: getPath(crumb) }">
            <dashboard-svg class="w-4 inline-flex items-center -mt-1 mr-1 fill-current" v-if="key===0"/>
            {{ getBreadcrumb(crumb.meta.breadcrumb) }}
          </router-link>
          <span v-else>{{ getBreadcrumb(crumb.meta.breadcrumb) }}</span>
        </li>
      </ol>
    </nav>`
})

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  data: {
    user: window.customData
  },
  ...App
})
