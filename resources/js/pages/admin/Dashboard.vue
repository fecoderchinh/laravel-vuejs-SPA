<template>
  <div v-if="data">
    <div class="grid grid-cols-6 gap-5">
      <div class="mins:col-span-2 maxs:col-span-6">
        <small-box background="bg-blue-500"
                   icon="tasks-svg"
                   route="admin.tasks.index"
        >
          <h3>
            {{ data.tasksCount }}
          </h3>
          <p>Tasks Total</p>
        </small-box>
      </div>
      <div class="mins:col-span-2 maxs:col-span-6">
        <small-box background="bg-green-500"
                   icon="comment-svg"
                   route="admin.comments.index"
        >
          <h3>
            {{ data.commentsCount }}
          </h3>
          <p>Comments Total</p>
        </small-box>
      </div>
      <div class="mins:col-span-2 maxs:col-span-6">
        <small-box background="bg-orange-500"
                   icon="info-svg"
                   route="admin.categories.index"
        >
          <h3>
            {{ data.viewsCount }}
          </h3>
          <p>Views Total</p>
        </small-box>
      </div>
    </div>
    <div class="w-full mt-5">
      <h3 class="mb-5">
        Latest Comments
      </h3>
      <box v-if="data.latestComments.length > 0">
        <v-table>
          <thead>
            <tr>
              <th scope="col">
                #
              </th>
              <th scope="col">
                Email
              </th>
              <th scope="col">
                Author name
              </th>
              <th scope="col">
                Description
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(comment, index) in data.latestComments" :key="index">
              <th scope="row">
                {{ comment.id }}
              </th>
              <td>
                {{ comment.author_email }}
              </td>
              <td>
                {{ comment.author_name }}
              </td>
              <td>
                {{ comment.description }}
              </td>
            </tr>
          </tbody>
        </v-table>
      </box>
      <box v-else>
        {{ $t('no_comment') }}
      </box>
    </div>
    <div class="w-full mt-5">
      <h3 class="mb-5">
        Popular Tasks
      </h3>
      <box v-if="data.popularTasks.length > 0">
        <v-table>
          <thead>
            <tr>
              <th scope="col">
                #
              </th>
              <th scope="col">
                Title
              </th>
              <th scope="col">
                Category
              </th>
              <th scope="col">
                Views
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(post, index) in data.popularTasks" :key="index">
              <th scope="row">
                {{ post.id }}
              </th>
              <td>{{ post.title }}</td>

              <td>
                {{ post.category.name }}
              </td>
              <td>
                <span>{{ post.visits }}</span>
              </td>
            </tr>
          </tbody>
        </v-table>
      </box>
      <box v-else>
        {{ $t('no_task') }}
      </box>
    </div>

    <div class="w-full mt-5">
      <h3 class="mb-5">
        New members
      </h3>
      <box v-if="data.lastestUsers.length > 0">
        <v-table>
          <thead>
          <tr>
            <th scope="col">
              #
            </th>
            <th scope="col">
              Name
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(post, index) in data.lastestUsers" :key="index">
            <th scope="row">
              {{ index+1 }}
            </th>
            <td>{{ post.name }}</td>
          </tr>
          </tbody>
        </v-table>
      </box>
    </div>
  </div>
</template>

<script>
import stats from '~/utils/requests'
import { STATS } from '~/utils/endpoints'
import SmallBox from '~/components/SmallBox'
import vTable from '~/components/Table'

export default {
  name: 'Dashboard',
  middleware: ['auth'],
  components: {
    SmallBox,
    vTable
  },
  data () {
    return {
      data: null
    }
  },
  created () {
    stats.all(STATS)
      .then((res) => {
        this.data = res.data.data
      })
      .catch(error => this.$store.dispatch('alert/alert', {
        type: 'danger',
        message: 'Can not load data. Network connection...'
      }))
  }
}
</script>

<style scoped>

</style>
