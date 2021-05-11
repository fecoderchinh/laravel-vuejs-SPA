<template>
  <button
    :type="nativeType"
    :disabled="loading"
  >
    <slot v-if="!loading" />
    <fa v-if="loading" :icon="['fas', 'circle-notch']" class="fa-spin" />
  </button>
</template>

<script>
export default {
  name: 'VButton',

  props: {
    type: {
      type: String,
      default: 'primary'
    },

    nativeType: {
      type: String,
      default: 'submit'
    },

    loading: {
      type: Boolean,
      default: false
    },

    block: {
      type: Boolean,
      default: false
    },

    large: {
      type: Boolean,
      default: false
    }
  }
}
</script>
