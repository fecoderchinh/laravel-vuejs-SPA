import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  roles: []
}

// getters
export const getters = {
  roles: state => state.roles
}

export const mutations = {
  [types.FETCH_ROLES] (state, roles) {
    state.roles = roles
    return state.roles
  }
}

export const actions = {
  fetchRoles (store) {
    axios.get([types.ROLES_API])
      .then((res) => {
        // console.log(res)
        store.commit(types.FETCH_ROLES, res.data.data)
      })
      .catch(error => console.log(error))
  }
}
