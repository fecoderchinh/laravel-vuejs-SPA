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
  }
}
