<template>
  <div>
    <Header>
      <template slot="title">
        {{ $t('tags') }}
      </template>
    </Header>
    <div class="container py-5">
      <div class="w-full">
        <ul class="list-none">
          <template v-for="tag in tags">
            <li class="inline-block mr-3 mt-3">
              <router-link :to="{
                             name: 'tags.tag',
                             params: {
                               tag: tag.slug
                             }
                           }"
                           class="py-1 capitalize px-3 bg-blue-300 rounded text-sm"
              >
                {{ tag.name }}
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import Header from '~/components/Header'
import { mapGetters } from 'vuex'

export default {
  name: 'Categories',
  components: {
    Header
  },
  computed: {
    ...mapGetters({
      tags: 'tag/tags'
    })
  },
  created () {
    this.$store.dispatch('tag/fetchTags')
  }
}
</script>

<style scoped lang="scss">
</style>
