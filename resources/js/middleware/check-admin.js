import store from '~/store'
/*
* This middleware must go with AUTH middleware
* */
export default async (to, from, next) => {
  if (store.getters['auth/user'].roles.slug === 'developer') {
    next()
  } else {
    next({ name: 'dashboard.home' })
  }
}
