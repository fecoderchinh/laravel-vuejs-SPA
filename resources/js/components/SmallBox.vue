<template>
  <div class="small-box"
       :class="background"
  >
    <box class="inner">
      <slot />
    </box>
    <div class="icon">
      <component :is="icon" />
    </div>
    <router-link :to="{name: route}" class="small-box-footer">
      {{ $t('more_info') }} <rounded-arrow-svg class="w-4 fill-current ml-1 inline" />
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'SmallBox',
  props: {
    background: {
      type: String,
      default: 'bg-blue-500'
    },
    icon: {
      type: String,
      default: 'ellipse-svg'
    },
    route: {
      type: String,
      default: 'admin.dashboard'
    }
  }
}
</script>

<style scoped lang="scss">
.small-box {
  @apply text-white rounded relative block shadow;
  .icon {
    @apply absolute top-1 right-1 z-0 text-black;
    svg {
      @apply w-12 fill-current opacity-15;
    }
  }
  .inner {
    @apply bg-transparent;
  }
  &-footer {
    @apply relative text-center p-1 text-white block z-10 no-underline bg-black bg-opacity-15;
  }
  &:hover, &:focus {
    .small-box-footer {
      @apply bg-opacity-50;
    }
  }
}

</style>
