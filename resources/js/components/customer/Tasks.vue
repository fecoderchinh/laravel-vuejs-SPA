<template>
  <div v-if="data.length > 0">
    <div v-for="(item, index) in data" :key="index">
      <task :data="item" class="border-t" />
    </div>
  </div>
  <div v-else>
    <box>{{ $t('no_task') }}</box>
  </div>
</template>

<script>
import Task from '~/components/customer/Task'

export default {
  name: 'Tasks',
  components: {
    Task
  },
  props: [ 'data' ]
}
</script>

<style scoped>

</style>
