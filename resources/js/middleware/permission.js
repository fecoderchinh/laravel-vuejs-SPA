import store from '~/store'

/**
 * This is middleware to check the current user role.
 *
 * middleware: 'permission: edit-user, create-user',
 */

export default (to, from, next, permissions) => {

  // console.log(store.getters['auth/user'].data.permissions)

  // Split permissions into an array
  permissions = permissions.split(',').map(val => val.trim())

  if (store.getters['auth/user'].data.permissions.map(permission => permission.slug).map(
    permission => permission
  ).some(val => permissions.includes(val))) {
    next()
  } else {
    alert('You can\'t access this page!')
    next({ name: 'welcome' })
  }
}
