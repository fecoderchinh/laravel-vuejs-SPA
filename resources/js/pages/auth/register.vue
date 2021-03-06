<template>
  <div class="container min-h-screen mt-5">
    <card v-if="mustVerifyEmail" :title="$t('register')">
      <div class="alert alert-success" role="alert">
        {{ $t('verify_email_address') }}
      </div>
    </card>
    <div class="grid grid-col-6">
      <div class="col-span-3 mx-auto text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-1 tracking-tight">
          {{ $t('register') }}
        </h1>
        <h2 class="text-lg text-gray-800 font-medium">
          {{ $t('already_registered') }}
          <router-link :to="{name: 'login'}"
                       class="text-teal-500 hover:text-teal-600 transition-all duration-100 ease-in-out"
          >
            {{ $t('login') }}
          </router-link>
        </h2>
      </div>
      <div class="col-span-3 mx-auto">
        <div class="bg-white rounded shadow p-5 m-5">
          <form @submit.prevent="register">
            <div class="block mt-3">
              <label for="roles" class="font-bold text-gray-700 select-none">{{ $t('roles') }}</label>
              <div class="flex flex-col">
                <select id="roles" v-model="role_id" name="role_id"
                        class="form-input block w-full text-gray-800 mt-2"
                >
                  <option disabled value="">
                    {{ $t('please_select') }}
                  </option>
                  <option v-for="(role, roleIndex) in roles" :key="roleIndex" :value="role.id">
                    {{ role.name }}
                  </option>
                </select>
                <span class="text-red-500" v-if="errors.has('role_id')">{{ errors.get('role_id') }}</span>
              </div>
            </div>

            <div class="block mt-3">
              <label class="font-bold text-gray-700 select-none" for="name">{{ $t('name') }}</label>
              <div class="flex flex-col">
                <input id="name"
                       v-model="name"
                       type="name"
                       name="name"
                       :data-vv-as="$t('name')"
                       class="tc-input"
                >
                <span class="text-red-500" v-if="errors.has('name')">{{ errors.get('name') }}</span>
              </div>
            </div>

            <div class="block mt-3">
              <label class="font-bold text-gray-700 select-none" for="email">{{ $t('email') }}</label>
              <div class="flex flex-col">
                <input id="email"
                       v-model="email"
                       type="email"
                       name="email"
                       :data-vv-as="$t('email')"
                       class="tc-input"
                >
                <span class="text-red-500" v-if="errors.has('email')">{{ errors.get('email') }}</span>
              </div>
            </div>

            <div class="block mt-3">
              <label class="font-bold text-gray-700 select-none" for="password">{{ $t('password') }}</label>
              <div class="flex flex-col">
                <input id="password"
                       v-model="password"
                       type="password"
                       name="password"
                       :data-vv-as="$t('password')"
                       class="tc-input"
                >
                <span class="text-red-500" v-if="errors.has('password')">{{ errors.get('password') }}</span>
              </div>
            </div>

            <div class="block mt-3">
              <label class="flex items-center cursor-pointer">
                <input v-model="terms" type="checkbox" class="form-checkbox text-teal-500 cursor-pointer">
                <span class="ml-2 font-medium text-gray-700 select-none cursor-pointer">
                  {{ $t('i_agree') }} <router-link class="text-teal-500 hover:text-teal-600" :to="{name: 'terms'}">{{ $t('term_condition') }}</router-link>
                </span>
              </label>
              <span class="text-red-500" v-if="errors.has('terms')">{{ errors.get('terms') }}</span>
            </div>

            <div>
              <button type="submit"
                      class="tc-button tc-button__primary tc-button__fill mt-3"
              >
                <fa v-if="loading" :icon="['fas', 'circle-notch']" class="fa-spin" />
                <span v-else>{{ $t('register') }}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import Errors from '~/utils/Errors'
import i18n from '~/plugins/i18n'

export default {
  middleware: 'guest',
  layout: 'basic',

  metaInfo () {
    return { title: this.$t('register') }
  },

  data: () => ({
    name: '',
    email: '',
    password: '',
    terms: false,
    role_id: '',
    mustVerifyEmail: false,
    loading: false,
    errors: new Errors()
  }),

  computed: {
    ...mapGetters({
      roles: 'role/roles'
    })
  },
  created () {
    this.$store.dispatch('role/fetchRoles')
  },

  methods: {
    async register () {
      // Register the user.
      this.loading = true
      const { data } = await axios.post('/api/register', {
        name: this.name,
        email: this.email,
        password: this.password,
        terms: this.terms,
        role_id: this.role_id
      })
        .catch((error) => {
          this.loading = false
          // console.log(error.response)
          if (error.response.status === 422) {
            // display error notification
            this.$notify({
              title: `Error!`,
              text: error.response.data.message,
              type: 'error'
            })
            this.errors.record(error.response.data.errors)
          }
        })

      // Must verify email fist.
      if (data.status) {
        this.mustVerifyEmail = false
      } else {
        // Log in the user.
        this.loading = false
        // display success notification
        this.$notify({
          title: `Success!`,
          text: i18n.t('register_success'),
          type: 'success'
        })
        const { data: { token } } = await axios.post('/api/login', {
          email: this.email,
          password: this.password
        })

        // Save the token.
        await this.$store.dispatch('auth/saveToken', { token })

        // Update the user.
        await this.$store.dispatch('auth/updateUser', { user: data })

        // Redirect home.
        await this.$router.push({ name: 'welcome' })
      }
    }
  }
}
</script>
