<template>
  <modal @close="$emit('close')">
    <h5 slot="header">
      Change password
    </h5>
    <div slot="body" class="w-full">
      <ValidationObserver ref="form">
        <ValidationProvider v-slot="{ errors }" rules="required">
          <div class="field">
            <label class="block text-sm">Current Password</label>
            <input v-model="password"
                   type="password"
                   name="password"
                   data-vv-as="current password"
                   class="tc-input"
            >
            <span class="text-red-500">{{ errors[0] }}</span>
          </div>
        </ValidationProvider>

        <ValidationProvider v-slot="{ errors }" rules="required">
          <div class="field">
            <label class="block text-sm">New Password</label>
            <input v-model="new_password"
                   type="password"
                   name="new_password"
                   data-vv-as="new password"
                   class="tc-input"
            >
            <span class="text-red-500">{{ errors[0] }}</span>
          </div>
        </ValidationProvider>

        <ValidationProvider v-slot="{ errors }" rules="required">
          <div class="field">
            <label class="block text-sm">Confirm Password</label>
            <input v-model="confirm_password"
                   type="password"
                   name="confirm_password"
                   data-vv-as="confirm password"
                   class="tc-input"
            >
            <span class="text-red-500">{{ errors[0] }}</span>
          </div>
        </ValidationProvider>

        <button type="submit"
                class="tc-button tc-button__primary tc-button__fill"
                @click="changePassword"
        >
          Change password
        </button>
      </ValidationObserver>
    </div>
  </modal>
</template>

<script>
import Modal from '~/components/modals/Modal'
import axios from 'axios'
import { SETTINGS } from '~/utils/endpoints'
import { ValidationObserver, ValidationProvider } from 'vee-validate'

export default {
  name: 'PasswordModal',
  components: {
    Modal,
    ValidationObserver,
    ValidationProvider
  },
  props: ['data'],
  data () {
    return {
      password: '',
      new_password: '',
      confirm_password: ''
    }
  },
  methods: {
    changePassword () {
      const token = this.$store.getters['auth/token']
      axios.patch(`${SETTINGS}/password`, {
        password: this.password,
        new_password: this.new_password,
        confirm_password: this.confirm_password
      },
      {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
        .then(response => {
          // clear form inputs
          this.password = this.new_password = this.confirm_password = ''
          // display success notification
          this.$notify({
            title: `Success update password for user #${this.data.id}`,
            text: response.data.message,
            type: 'success'
          })
          // clear form error messages
          this.$nextTick(() => {
            this.$refs.form.reset()
          })
        })
        .then(() => {
          this.$emit('close')
        })
        .catch(error => {
          // clear form inputs
          this.password = this.new_password = this.confirm_password = ''
          // clear form error messages
          this.$nextTick(() => {
            this.$refs.form.reset()
          })
          // display error notification
          this.$notify({
            title: `Error update password for user #${this.data.id}`,
            text: error.response.data.message,
            type: 'error'
          })
        })
    }
  }
}
</script>

<style scoped>

</style>
