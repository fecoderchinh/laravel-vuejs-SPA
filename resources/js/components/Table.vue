<template>
  <!-- eslint-disable max-len -->
  <div class="box-table">
    <div class="overflow-hidden">
      <div class="overflow-x-auto cms-scrollbar">
        <table>
          <slot />
        </table>
      </div>
    </div>
    <slot name="outside" />
  </div>
</template>

<script>
export default {}
</script>

<style lang="scss">
.box-table {
  table {
    @apply mx-auto w-full;
    thead {
      tr {
        @apply pb-4 border-b;
        th {
          &:not(:first-child) {
            @apply text-left;
          }
        }
      }
    }
    tbody {
      tr {
        @apply py-2 border-b;
        &:hover, .active {
          @apply bg-gray-200;
        }
      }
    }
  }

  &-header {
    th {
      @apply text-sm text-gray-900;
    }
  }

  &-body {
    th {
      @apply text-sm text-gray-900;
    }
  }

  &-header, &-body, &-footer {
    @apply flex flex-col;
    &.block {
      @apply block #{!important};
    }
  }
}
</style>
