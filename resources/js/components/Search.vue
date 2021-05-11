<template>
  <box>
    <form method="get" @submit.prevent="search">
      <input-group>
        <span class="tc-input-group__text within-group left">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
          </svg>
        </span>
        <input
          id="search"
          v-model="query"
          name="search"
          class="tc-input"
          :placeholder="$t('search_placeholder')"
        >
        <button id="button-addon2" class="tc-button tc-button__fill tc-button__primary m-0" type="submit">
          <fa v-if="loading" :icon="['fas', 'circle-notch']" class="fa-spin" />
          <search-svg v-else class="h-4 w-4 fill-current" />
        </button>
      </input-group>
    </form>
  </box>
</template>

<script>
import Box from '~/components/Box'
import InputGroup from '~/components/InputGroup'

export default {
  name: 'Search',
  components: {
    Box,
    InputGroup
  },
  data () {
    return {
      query: '',
      loading: false
    }
  },
  methods: {
    search () {
      this.loading = true
      this.$router.push({
        name: 'tasks.search',
        params: {
          tasks: this.query
        }
      }).catch(err => {})
      this.loading = false
    }
  }
}
</script>

<style scoped>

</style>
