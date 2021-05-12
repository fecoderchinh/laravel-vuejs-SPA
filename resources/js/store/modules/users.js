import requests from '~/utils/requests'
import { USERS } from '~/utils/endpoints'

// state
export const state = {
  users: []
}

// getters
export const getters = {
  users: state => state.users
}

// mutations
export const mutations = {
  FETCH_USERS (state, users) {
    state.users = users
    return state.users
  }
}

// actions
export const actions = {
  fetchUsers (store) {
    requests.all(USERS)
      .then(({ data: comments }) => {
        store.commit('FETCH_USERS', comments.data)
      })
      .catch(error => console.log(error))
  }
}
