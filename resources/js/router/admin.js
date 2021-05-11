import helpers from '~/utils/helpers'

export default [
  {
    path: '/admin',
    component: helpers.page('admin/index.vue'),
    meta: {
      breadcrumb: 'Dashboard'
    },
    children: [
      { path: '', redirect: { name: 'admin.dashboard' } },
      {
        path: 'dashboard',
        component: helpers.page('admin/Dashboard.vue'),
        name: 'admin.dashboard'
      },
      {
        path: 'categories',
        component: helpers.page('admin/categories/index.vue'),
        meta: {
          breadcrumb: 'Categories'
        },
        children: [
          { path: '', redirect: { name: 'admin.categories.index' } },
          {
            path: 'all',
            component: helpers.page('admin/categories/CategoriesIndex.vue'),
            name: 'admin.categories.index'
          },
          {
            path: 'create',
            component: helpers.page('admin/categories/CategoriesCreate.vue'),
            name: 'admin.categories.create',
            meta: {
              breadcrumb: 'Create Category'
            }
          },
          {
            path: ':category/edit',
            component: helpers.page('admin/categories/CategoriesEdit.vue'),
            name: 'admin.categories.edit',
            meta: {
              breadcrumb: param => `Edit category: ${param.category}`
            }
          }
        ]
      },
      {
        path: 'tasks',
        component: helpers.page('admin/tasks/index.vue'),
        meta: {
          breadcrumb: 'Tasks'
        },
        children: [
          { path: '', redirect: { name: 'admin.tasks.index' } },
          {
            path: 'all',
            component: helpers.page('admin/tasks/TasksIndex.vue'),
            name: 'admin.tasks.index'
          },
          {
            path: 'search=:tasks',
            component: helpers.page('admin/tasks/TasksSearch.vue'),
            name: 'admin.tasks.search',
            meta: {
              breadcrumb: param => `Search for keyword: '${param.tasks}'`
            }
          },
          {
            path: 'create',
            component: helpers.page('admin/tasks/TasksCreate.vue'),
            name: 'admin.tasks.create',
            meta: {
              breadcrumb: 'Create Task'
            }
          },
          {
            path: ':task/edit',
            component: helpers.page('admin/tasks/TasksEdit.vue'),
            name: 'admin.tasks.edit',
            meta: {
              // breadcrumb: param => `Edit task: '${param.task}'`
              breadcrumb: 'Edit Task'
            }
          }
        ]
      },
      {
        path: 'tags',
        component: helpers.page('admin/tags/index.vue'),
        meta: {
          breadcrumb: 'Tags'
        },
        children: [
          { path: '', redirect: { name: 'admin.tags.index' } },
          {
            path: 'all',
            component: helpers.page('admin/tags/TagsIndex.vue'),
            name: 'admin.tags.index'
          },
          {
            path: ':tag/edit',
            component: helpers.page('admin/tags/TagsEdit.vue'),
            name: 'admin.tags.edit',
            meta: {
              breadcrumb: 'Edit Tag'
            }
          }
        ]
      },
      {
        path: 'comments',
        component: helpers.page('admin/comments/index.vue'),
        meta: {
          breadcrumb: 'Comments'
        },
        children: [
          { path: '', redirect: { name: 'admin.comments.index' } },
          {
            path: 'all',
            component: helpers.page('admin/comments/CommentsIndex.vue'),
            name: 'admin.comments.index'
          }
        ]
      }
    ]
  }
]
