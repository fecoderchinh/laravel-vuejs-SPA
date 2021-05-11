import store from '~/store'

export default async (to, from, next) => {
  if (store.getters['auth/user'].roles.slug !== 'admin') {
    next({ name: 'dashboard.home' })
  } else {
    next()
  }
}
