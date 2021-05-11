import helpers from '~/utils/helpers'

export default [
  {
    path: '/',
    component: helpers.page('index.vue'),
    meta: {
      breadcrumb: 'Homepage'
    },
    children: [
      { path: '', redirect: { name: 'welcome' } },
      {
        path: '/',
        component: helpers.page('welcome.vue'),
        name: 'welcome'
      },
      {
        path: 'tasks',
        component: helpers.page('tasks/index.vue'),
        meta: {
          breadcrumb: 'Tasks'
        },
        children: [
          { path: '', redirect: { name: 'tasks.index' } },
          {
            path: 'all',
            component: helpers.page('tasks/list.vue'),
            name: 'tasks.index'
          },
          {
            path: 'search=:tasks',
            component: helpers.page('tasks/TaskSearch.vue'),
            name: 'tasks.search',
            meta: {
              breadcrumb: param => `Search for keyword: '${param.tasks}'`
            }
          },
          {
            path: ':task',
            component: helpers.page('tasks/task.vue'),
            name: 'tasks.view',
            meta: {
              // breadcrumb: param => `Edit task: '${param.task}'`
              breadcrumb: 'View Task'
            }
          }
        ]
      },
      {
        path: 'categories',
        component: helpers.page('categories/index.vue'),
        meta: {
          breadcrumb: 'Categories'
        },
        children: [
          { path: '', redirect: { name: 'categories.index' } },
          {
            path: 'all',
            component: helpers.page('categories/list.vue'),
            name: 'categories.index'
          },
          {
            path: ':category/tasks',
            component: helpers.page('categories/category.vue'),
            name: 'categories.category',
            meta: {
              breadcrumb: 'View Category'
            }
          }
        ]
      },
      {
        path: 'tags',
        component: helpers.page('tags/index.vue'),
        meta: {
          breadcrumb: 'Tags'
        },
        children: [
          { path: '', redirect: { name: 'tags.index' } },
          {
            path: 'all',
            component: helpers.page('tags/list.vue'),
            name: 'tags.index'
          },
          {
            path: ':tag/tasks',
            component: helpers.page('tags/tag.vue'),
            name: 'tags.tag',
            meta: {
              breadcrumb: 'View Tag'
            }
          }
        ]
      }
    ]
  }
]
