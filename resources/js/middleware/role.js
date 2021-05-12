import store from '~/store'

/**
 * This is middleware to check the current user role.
 *
 * middleware: 'role:admin,manager',
 */

export default (to, from, next, roles) => {

  // Split roles into an array
  roles = roles.split(',').map(val => val.trim())

  // console.log(store.getters['auth/user'].data)

  // Check if the user has one of the required roles...
  if (!roles.includes(...store.getters['auth/user'].data.roles.map(role => role.slug))) {
    alert('You don\'t have permission to access!')
    next({ name: 'welcome' })
  }

  next()
}
