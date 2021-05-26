<template>
  <div class="container min-h-screen mt-5">
    <div class="grid grid-col-6">
      <div class="col-span-3 mx-auto text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-1 tracking-tight">
          {{ $t('login') }}
        </h1>
        <h2 class="text-lg text-gray-800 font-medium">
          {{ $t('unregistered') }}
          <router-link :to="{name: 'register'}"
                       class="text-teal-500 hover:text-teal-600 transition-all duration-100 ease-in-out"
          >
            {{ $t('register') }}
          </router-link>
        </h2>
      </div>
      <div class="col-span-3 mx-auto">
        <div class="bg-white rounded shadow p-5 m-5">
          <ValidationObserver ref="form">
            <form @submit.prevent="login">
              <!-- Email -->
              <ValidationProvider v-slot="{ errors }" rules="required" class="block mt-3">
                <label class="font-bold text-gray-700 select-none">{{ $t('email') }}</label>
                <div class="flex flex-col">
                  <input v-model="email"
                         type="email"
                         name="email"
                         data-vv-as="Email"
                         class="tc-input"
                  >
                  <span class="text-red-500">{{ errors[0] }}</span>
                </div>
              </ValidationProvider>

              <ValidationProvider v-slot="{ errors }" rules="required" class="block mt-3">
                <label class="font-bold text-gray-700 select-none">{{ $t('password') }}</label>
                <div class="flex flex-col">
                  <input v-model="password"
                         type="password"
                         name="password"
                         data-vv-as="Password"
                         class="tc-input"
                  >
                  <span class="text-red-500">{{ errors[0] }}</span>
                </div>
              </ValidationProvider>

              <!-- Remember Me -->
              <div class="flex flex-col mt-3">
                <checkbox v-model="remember" name="remember">
                  {{ $t('remember_me') }}
                </checkbox>

                <router-link :to="{ name: 'password.request' }" class="small my-auto">
                  {{ $t('forgot_password') }}
                </router-link>
              </div>

              <div class="flex flex-col">
                <!-- Submit Button -->

                <button type="submit"
                        class="tc-button tc-button__primary tc-button__fill"
                >
                  <fa v-if="loading" :icon="['fas', 'circle-notch']" class="fa-spin" />
                  <span v-else>{{ $t('login') }}</span>
                </button>

                <!-- GitHub Login Button -->
                <login-with-github />
              </div>
            </form>
          </ValidationObserver>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Cookies from 'js-cookie'
import LoginWithGithub from '~/components/LoginWithGithub'
import { ValidationObserver, ValidationProvider } from 'vee-validate'

import Errors from '~/utils/Errors'

export default {
  components: {
    LoginWithGithub,
    ValidationObserver,
    ValidationProvider
  },

  middleware: 'guest',
  layout: 'basic',

  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    email: '',
    password: '',
    remember: false,
    loading: false,
    fromRoute: null,
    errors: new Errors()
  }),

  beforeRouteEnter (to, from, next) {
    next(vm => {
      vm.fromRoute = from
    })
  },

  methods: {
    async login () {
      // Submit the form.
      this.loading = true
      const { data } = await axios.post('/api/login', {
        email: this.email,
        password: this.password
      })
        .catch((error) => {
          // console.log(error.response)
          this.loading = false
          if (error.response.status === 422) {
            this.errors.record(error.response.data.errors)
            // display error notification
            this.$notify({
              title: `Error!`,
              text: error.response.data.errors.credentials[0],
              type: 'error'
            })
          }
        })
      // Save the token.
      await this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })
      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')
      // Redirect home.
      // this.redirect()
      this.handleBack()
    },
    redirect () {
      this.loading = false
      const intendedUrl = Cookies.get('intended_url')
      if (intendedUrl) {
        Cookies.remove('intended_url')
        this.$router.push({ path: intendedUrl })
      } else {
        this.$router.push({ name: 'admin.dashboard' })
      }
    },
    handleBack () {
      if (!this.fromRoute.name || this.fromRoute.name === 'login') {
        // this.$router.push(fallback)
        this.redirect()
      } else {
        this.$router.back()
      }
    }
  }
}
</script>
