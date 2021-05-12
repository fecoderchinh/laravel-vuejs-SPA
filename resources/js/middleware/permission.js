import store from '~/store'

/**
 * This is middleware to check the current user role.
 *
 * middleware: 'permission: edit-user, create-user',
 */

export default (to, from, next, permissions) => {

  // console.log(permissions)
  // console.log(store.getters['auth/user'])
  // console.log(
  //   store.getters['auth/user'].permissions.map(permission => permission.slug).map(
  //     permission => permission
  //   )
  // )
  //
  // console.log(
  //   store.getters['auth/user'].permissions.map(permission => permission.slug).map(
  //     permission => {
  //       return (permissions.split(',').map(val => val.trim())).includes(permission)
  //     }
  //   )
  // )
  //
  // console.log(...store.getters['auth/user'].permissions.map(permission => permission.slug))

  // Split permissions into an array
  permissions = permissions.split(',').map(val => val.trim())

  if (store.getters['auth/user'].permissions.map(permission => permission.slug).map(
    permission => permission
  ).some(val => permissions.includes(val))) {
    next()
  } else {
    alert('You can\'t access this page!')
    next({ name: 'welcome' })
  }
}
