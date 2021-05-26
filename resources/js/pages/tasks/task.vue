<template>
  <div v-if="!loading">
    <Header>
      <template slot="title">
        {{ task.title }}
      </template>
      <template slot="desc">
        {{ task.description }}
      </template>
    </Header>
    <div class="container py-5">
      <img :src="task.cover_path" :alt="task.title" class="mx-auto">
      <task :data="task" :single="true" />
      <box>
        <h3 class="text-2xl my-5">
          {{ $t('comments') }}
        </h3>
        <CommentForm v-if="user" :data="user" @submit="addComment" />
        <router-link v-else :to="{ name: 'login' }" class="tc-button tc-button__fill tc-button__primary">
          {{ $t('comments') }}
        </router-link>
        <Comment v-for="comment in task.comments" :key="comment.id" :data="comment" @delete="removeComment(comment)" />
      </box>
    </div>
  </div>
</template>

<script>
import Task from '~/components/customer/Task'
import tasks from '~/utils/requests'
import { TASKS } from '~/utils/endpoints'

import CommentForm from '~/components/Comments/CommentForm'
import Comment from '~/components/Comments/Comment'
import Header from '~/components/Header'
import Swal from 'sweetalert2'

export default {
  name: 'TaskView',
  components: {
    Task,
    CommentForm,
    Comment,
    Header
  },
  data () {
    return {
      task: {},
      endpoint: TASKS,
      loading: false,
      userData: {}
    }
  },
  computed: {
    user () {
      return this.$store.getters['auth/check']
    }
  },
  watch: {
    '$route.params' (newVal, oldVal) {
      this.loadTask(newVal)
    }
  },
  created () {
    this.loadTask(this.$route.params.task)
  },
  methods: {
    loadTask (id) {
      this.loading = true
      tasks.find(TASKS, id)
        .then((res) => {
          if (!res.data.data.online) {
            Swal.fire({
              type: 'warning',
              title: this.$t('key_entered_notfound_title'),
              text: this.$t('key_entered_notfound_text'),
              reverseButtons: true,
              confirmButtonText: this.$t('go_home'),
              cancelButtonText: this.$t('cancel')
            }).then(() => {
              this.$router.push({ name: 'welcome' })
            })
          } else {
            this.task = res.data.data
            // console.log(this.task)
            this.loading = false
          }
        })
        .catch(error => {
          if (error.response.status === 404) {
            Swal.fire({
              type: 'warning',
              title: this.$t('key_entered_notfound_title'),
              text: this.$t('key_entered_notfound_text'),
              reverseButtons: true,
              confirmButtonText: this.$t('go_home'),
              cancelButtonText: this.$t('cancel')
            }).then(() => {
              this.$router.push({ name: 'welcome' })
            })
          }
        })
    },
    addComment (comment) {
      this.task.comments.unshift(comment)
    },
    removeComment (data) {
      this.task.comments = this.task.comments.filter(comment => comment.id !== data.id)
    }
  }
}
</script>

<style scoped lang="scss">
</style>
