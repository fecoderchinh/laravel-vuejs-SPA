import store from '~/store'

/**
 * This is middleware to check the current user role.
 *
 * middleware: 'role:admin,manager',
 */

export default (to, from, next, roles) => {
  // Grab the user
  const user = store.getters['auth/roles']

  // console.log(store.getters['auth/roles'].slug)

  // Split roles into an array
  roles = roles.split(',')

  // Check if the user has one of the required roles...
  if (!roles.includes(user.slug)) {
    next('/unauthorized')
  }

  next()
}
