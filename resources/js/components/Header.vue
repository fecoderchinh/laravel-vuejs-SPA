<template>
  <header class="tc-header">
    <div class="container">
      <div class="w-full px-4">
        <h1 class="tc-header__title">
          <slot name="title" />
        </h1>
        <h4 class="tc-header__desc">
          <slot name="desc" />
        </h4>
        <slot name="actions" />
      </div>
    </div>
  </header>
</template>

<script>
export default {
  name: 'Header'
}
</script>

<style scoped lang="scss">
.tc-header {
  @apply text-center border-b;
  > .container {
    @apply py-10;
    @media (max-width: 992px) {
      @apply pt-5 pb-4;
    }
  }
  &__title {
    @apply text-4xl mb-5;
    @media (max-width: 992px) {
      @apply text-2xl mb-4;
    }
  }
  &__desc {
    @apply text-sm mb-5;
    @media (max-width: 992px) {
      @apply mb-4;
    }
  }
}
</style>
