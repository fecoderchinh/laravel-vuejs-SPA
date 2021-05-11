<template>
  <!-- eslint-disable max-len -->
  <div class="modal-container" @click="modalClick">
    <div v-if="hasHeader" class="modal-header">
      <slot name="header" />
      <button class="modal-default-button group hover:shadow-none focus:outline-none no-effect" @click.stop="closeModal">
        <close-svg class="w-4 h-4 fill-curren group-hover:fill-current" />
      </button>
    </div>

    <div v-if="hasBody" class="modal-body" :class="bodyHeight">
      <slot name="body" />
    </div>

    <div v-if="hasFooter" class="modal-footer">
      <slot name="footer" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'Modal',
  props: {
    bodyHeight: {
      type: String,
      default: ''
    }
  },
  computed: {
    hasHeader () {
      return this.$slots.header
    },
    hasBody () {
      return this.$slots.body
    },
    hasFooter () {
      return this.$slots.footer
    }
  },
  methods: {
    closeModal () {
      this.$emit('close')
    },
    modalClick (event) {
      this.$emit('mclick', event)
    }
  }
}
</script>

<style lang="scss" scoped>
.cms-modal {
  @apply bg-white rounded-sm shadow mx-auto relative overflow-hidden;
  @apply transition duration-300 ease-out;
  // width: calc(100vw - 2.5rem);
  // @media (min-width: 1024px) {
  //   @apply w-11/12;
  // }
  // @media (max-width: 1023px) {
  //   width: calc(100vw - 2.5rem);
  // }
  &.modal-md {
    @screen md {
      max-width: 720px;
    }
  }
  &.modal-lg {
    @media (min-width: 1200px) {
      max-width: 1200px;
    }
  }
  .modal {
    &-header {
      @apply flex relative items-center p-5 border-b;
    }
    &-body {
      @apply p-5;
      overflow-y: scroll;
      width: calc( 100% + 20px );
      @media (pointer:coarse) {
        @apply w-full;
      }
    }
    &-footer {
      @apply bg-gray-200 p-5;
    }
    &-default-button {
      @apply absolute top-50 right-0 transform -translate-y-1/2 mr-5;
    }
  }
}
</style>
