import axios from 'axios'

export default {
  all (endpoint) {
    return axios.get(endpoint)
  },
  find (endpoint, id) {
    return axios.get(`${endpoint}/${id}`)
  },
  store (endpoint, data) {
    return axios.post(`${endpoint}`, data)
  },
  update (endpoint, id, data) {
    return axios.put(`${endpoint}/${id}`, data)
  },
  del (endpoint, id) {
    return axios({
      method: 'delete',
      url: `${endpoint}/${id}`
    })
  },
  confirm (message) {
    return confirm(message)
  }
}
