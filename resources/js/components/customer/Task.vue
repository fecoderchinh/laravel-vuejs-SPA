<template>
  <box>
    <h2 class="tc-task__title text-2xl">
      <router-link
        v-if="!single"
        :to="{
          name: 'tasks.view',
          params: {
            task: data.slug
          }
        }"
      >
        {{ data.title }}
      </router-link>
      <template v-else>
        {{ data.title }}
      </template>
    </h2>
    <h4 class="tc-task__customer my-3">
      <span class="inline-flex">
        <user-svg class="w-4 h-4 fill-menuIcon" />
      </span>
      <span class="inline-flex">
        {{ data.creator.name }}
      </span>
    </h4>
    <p v-if="!single">
      {{
        data.description
      }}
    </p>
    <div v-if="single" class="ql-snow">
      <div class="ql-editor" v-html="data.content" />
    </div>
    <vue-editor :disabled="true" :editor-toolbar="customToolbar" class="hidden" />
    <div class="w-full">
      <ul class="list-none">
        <template v-for="tag in data.tags">
          <li class="inline-block mr-3 mt-3">
            <router-link :to="{
                           name: 'tags.tag',
                           params: {
                             tag: tag.slug
                           }
                         }"
                         class="py-1 px-3 bg-blue-300 rounded text-sm"
            >
              {{ tag.name }}
            </router-link>
          </li>
        </template>
      </ul>
    </div>
  </box>
</template>

<script>
import { VueEditor } from 'vue2-editor'

export default {
  name: 'Task',
  components: { VueEditor },
  props: [ 'data', 'single' ],
  data () {
    return {
      customToolbar: ['']
    }
  }
}
</script>

<style scoped lang="scss">
  .tc-task {
    &__title {
      @apply text-blue-500
    }
  }
  .ql-editor {
    @apply p-0 min-h-0 #{!important}
  }
</style>
