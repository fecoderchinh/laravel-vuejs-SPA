import store from '~/store'

export default {
  page (path) {
    return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
  },
  show (type = '', text) {
    this.$notify({
      title: `${type} update password for user #${this.data.id}`,
      text,
      type
    })
  },
  is(roles='') {
    roles.split(',').map(val => val.trim())
    return roles.includes(...store.getters['auth/user'].data.roles.map(role => role.slug))
  },
  can(permissions='') {
    permissions.split(',').map(val => val.trim())
    return store.getters['auth/user'].data.permissions.map(permission => permission.slug).map(
      permission => permission
    ).some(val => permissions.includes(val))
  }
}
