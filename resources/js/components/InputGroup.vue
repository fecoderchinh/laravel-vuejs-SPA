<template>
  <div class="tc-input-group relative flex flex-wrap items-stretch w-100">
    <slot />
  </div>
</template>

<script>
export default {
  name: 'InputGroup'
}
</script>

<style scoped lang="scss">
  .tc-input-group {
    &__text {
      @apply flex items-center py-1 px-3 text-base font-normal leading-6 text-current text-center whitespace-no-wrap rounded;
      &.within-group {
        @apply absolute mt-2 z-10;
        &.left {
          @apply left-0;
          + .tc-input {
            @apply pl-10;
          }
        }
        &.right {
          @apply right-0;
          + .tc-input {
            @apply pr-10;
          }
        }
      }
    }
    > * {
      &:first-child {
        @apply rounded-r-none;
      }
      &:last-child {
        @apply rounded-l-none;
      }
      &:not(:first-child) {
        @apply rounded-l-none;
      }
      &:not(:last-child) {
        @apply rounded-r-none;
      }
    }
    .tc-input {
      @apply relative flex-auto w-1/100 min-w-0;
    }
  }
</style>
