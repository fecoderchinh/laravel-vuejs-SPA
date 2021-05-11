<template>
  <div class="search-bar relative text-gray-600 flex-auto">
    <form method="get" @submit.prevent="search">
      <input v-model="query"
             type="text"
             name="search"
             placeholder="Nhập từ khóa tìm kiếm..."
             class="bg-white h-10 w-full px-3 rounded border text-sm focus:outline-none text-14px font-lato text-menuItem pr-10 relative"
      >
      <button type="submit"
              class="absolute right-0 top-0 mt-3 mr-4 focus:outline-none"
      >
        <fa v-if="loading" :icon="['fas', 'circle-notch']" class="fa-spin" />
        <search-svg v-else class="h-4 w-4 fill-current" />
      </button>
    </form>
  </div>
</template>

<script>
export default {
  name: 'TasksSearchForm',
  data () {
    return {
      query: null,
      loading: false
    }
  },
  methods: {
    search () {
      this.loading = true
      this.$router.push({
        name: 'admin.tasks.search',
        params: {
          tasks: this.query
        }
      })
      this.loading = false
    }
  }
}
</script>

<style scoped>

</style>
