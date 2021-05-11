<template>
  <box class="border-t">
    <ul class="pagination">
      <li :class="pagination.current_page == pagination.from ? 'disabled': ''">
        <a href="#" @click.prevent="changePage(pagination.current_page - 1)">&laquo;</a>
      </li>
      <li v-for="(page, index) in pages" :key="index" :class="page == pagination.current_page ? 'active': '' ">
        <a href="#" @click.prevent="changePage(page)">{{ page }}</a>
      </li>
      <li :class="pagination.current_page == pagination.last_page ? 'disabled': ''">
        <a href="#" @click.prevent="changePage(pagination.current_page + 1)">&raquo;</a>
      </li>
    </ul>
  </box>
</template>

<script>
export default {
  name: 'Pagination',
  props: ['meta'],
  data () {
    return {
      pagination: {}
    }
  },
  computed: {
    pages () {
      let pages = []
      for (let i = 0; i < this.meta.last_page; i++) {
        let page = i + 1
        pages.push(page)
      }
      return pages
    }
  },
  updated () {
    this.pagination = this.meta
  },
  methods: {
    changePage (page) {
      window.scroll({
        behavior: 'smooth',
        left: 0,
        top: 0
      })

      this.pagination.current_page = page
      this.$emit('changed', page)
    }
  }
}
</script>

<style scoped lang="scss">
.pagination {
 @apply list-none;
  li {
    @apply inline-block mr-3;
    a {
      @apply block p-2 px-3 bg-gray-300;
    }
    &.active {
      a {
        @apply bg-blue-500 text-white;
      }
    }
    &.disabled {
      a {
        @apply bg-gray-500 text-gray-900 cursor-not-allowed;
      }
    }
  }
}
</style>
