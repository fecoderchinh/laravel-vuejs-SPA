<template>
  <box class="border">
    <!--    <form @submit.prevent="updatePost">-->
    <form>
      <div class="w-full">
        <cover-uploader :cover="task.cover_path" @loaded="updateCover" />
        <small v-if="errors.has('cover')" class="text-red-500">{{ errors.get('cover') }}</small>
      </div>

      <div class="grid grid-cols-6 items-center">
        <div v-if="categories.length > 0" class="maxs:col-span-6 mins:col-span-2">
          <label for="category">{{ $t('category') }}</label>
          <select id="category"
                  v-model="form.category_id"
                  class="form-input block w-full text-gray-800 mt-2"
                  @change="errors.clear('category_id')"
          >
            <option disabled>
              {{ $t('please_select') }}
            </option>
            <option v-for="category in categories" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>
        <div class="maxs:col-span-6 mins:col-span-2 flex flex-col">
          <label for="category">&nbsp;</label>
          <button
            class="tc-button tc-button__primary tc-button__fill mb-0 mx-5"
            role="menuitem"
            @click.prevent="openModal()"
          >
            {{ $t('add_categories_label') }}
          </button>
        </div>
      </div>
      <small v-if="errors.has('category_id')" class="text-red-500 w-100 flex">{{ errors.get('category_id') }}</small>
      <div class="w-100">
        <label for="title">{{ $t('title') }}</label>
        <input id="title" v-model="form.title" type="text" class="tc-input" @keydown="errors.clear('title')">
        <small v-if="errors.has('title')" class="text-red-500">{{ errors.get('title') }}</small>
      </div>
      <div class="w-100">
        <label for="content">{{ $t('content') }}</label>
        <vue-editor id="content" v-model="form.content" />
        <small v-if="errors.has('content')" class="text-red-500">{{ errors.get('content') }}</small>
      </div>
      <div class="form-group">
        <input-tag v-model="form.tags" name="tags" :label="$t('tags')" />
        <small v-if="errors.has('tags')" class="text-red-500">{{ errors.get('tags') }}</small>
      </div>
      <div class="form-group">
        <div class="custom-control custom-switch">
          <checkbox v-model="form.online" name="online" :checked="form.online">
            {{ $t('online_status') }}
          </checkbox>
        </div>
      </div>
      <div class="w-full">
        <button class="block tc-button tc-button__transition tc-button__primary tc-button__fill" type="submit"
                @click.prevent="updatePost"
        >
          <fa v-if="loading" :icon="['fas', 'circle-notch']" class="fa-spin" />
          <span v-else>{{ $t('apply_actions') }}</span>
        </button>
      </div>
    </form>
  </box>
</template>

<script>
import CoverUploader from '~/components/CoverUploader'
import { VueEditor } from 'vue2-editor'
import Errors from '~/utils/Errors'
import InputTag from '~/components/TagInput'
import tasks from '~/utils/requests'
import { TASKS, CATEGORIES } from '~/utils/endpoints'
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {
  name: 'TasksEdit',
  middleware: ['auth'],
  layout: 'admin',
  components: {
    CoverUploader,
    VueEditor,
    InputTag
  },
  data () {
    return {
      task: {},
      endpoint: TASKS,
      errors: new Errors(),
      form: {
        cover: '',
        category_id: '',
        title: '',
        content: '',
        online: '',
        tags: ''
      },
      loading: false
    }
  },
  computed: {
    ...mapGetters({
      categories: 'categories/categories'
    })
  },
  created () {
    this.fetchCategories(`${CATEGORIES}/all`)
  },
  mounted () {
    this.endpoint = `${this.endpoint}/${this.$route.params.task}`
    this.loadTask(this.$route.params.task)
  },
  methods: {
    fetchCategories (endpoint) {
      tasks.all(endpoint)
        .then(({ data: categories }) => {
          // this.tasks = tasks.data
          this.$store.dispatch('categories/fetchAllCategories', categories.data)
        })
        .catch(error => {
          this.$notify({
            title: `Error loading categories`,
            text: error.response.data.message,
            type: 'error'
          })
        })
    },
    loadTask (id) {
      tasks.find(TASKS, id)
        .then((res) => {
          this.task = res.data.data
          this.setForm(this.task)
        })
        .catch(error => this.$store.dispatch('alert/alert', { message: 'An error occured', type: 'danger' }))
    },
    updateCover (cover) {
      this.form.cover = cover
    },
    setForm (post) {
      let tagNames = post.tags.map((tag) => tag.name)

      this.form = {
        cover: null,
        category_id: post.category.id,
        title: post.title,
        content: post.content,
        online: post.online,
        tags: tagNames.join(',')
      }
    },
    updatePost () {
      this.loading = true
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }

      let formData = new FormData()

      formData.append('cover', this.form.cover)
      formData.append('title', this.form.title)
      formData.append('content', this.form.content)
      formData.append('category_id', this.form.category_id)
      formData.append('online', this.form.online)
      formData.append('tags', this.form.tags)
      formData.append('_method', 'PUT')

      this.store(formData, config)
    },
    store (data, config) {
      axios.post(this.endpoint, data, config)
        .then(({ data: post }) => {
          if (post.data.category.id !== this.task.category.id) {
            this.$store.dispatch('categories/changeCategoriesPostsCount', { old: this.task.category, new: post.data.category })
          }

          return this.$store.dispatch('alert/alert', {
            message: 'Task edited successfully'
          })
        })
        .then(() => {
          this.loading = false
          this.$router.push({
            name: 'admin.tasks.index'
          })
        })
        .catch((error) => {
          this.loading = false
          // console.log(error)
          if (error.response.data.errors) {
            this.errors.record(error.response.data.errors)
          } else {
            this.$store.dispatch('alert/alert', {
              message: 'There is an error with the request',
              type: 'dangerr'
            })
          }
        })
    }
  }
}
</script>

<style scoped>

</style>
