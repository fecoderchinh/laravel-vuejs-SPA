import tags from '~/utils/requests'
import { TAGS, TAGS_BY_USER } from '~/utils/endpoints'

// state
export const state = {
  tags: []
}

// getters
export const getters = {
  tags: state => state.tags
}

// mutations
export const mutations = {
  FETCH_TAGS (state, tags) {
    state.tags = tags
    return state.tags
  },
  DELETE_TAG (state, payload) {
    state.tags = state.tags.filter((tag, index) => {
      return tag.id !== payload.id
    })
  }
}

// actions
export const actions = {
  fetchTags (store) {
    tags.all(TAGS)
      .then(({ data: tags }) => {
        store.commit('FETCH_TAGS', tags.data)
      })
      .catch(error => console.log(error))
  },
  fetchTagsByUser (store) {
    tags.all(TAGS_BY_USER)
      .then(({ data: tags }) => {
        store.commit('FETCH_TAGS', tags.data)
      })
      .catch(error => console.log(error))
  },
  removeTag (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('DELETE_TAG', payload)
      resolve()
    })
  }
}
