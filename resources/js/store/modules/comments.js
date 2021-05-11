import comments from '~/utils/requests'
import { COMMENTS, COMMENTS_BY_USER } from '~/utils/endpoints'

// state
export const state = {
  comments: []
}

// getters
export const getters = {
  comments: state => state.comments
}

// mutations
export const mutations = {
  FETCH_COMMENTS (state, comments) {
    state.comments = comments
    return state.comments
  },
  DELETE_COMMENTS (state, payload) {
    state.comments = state.comments.filter((comment, index) => {
      return comment.id !== payload.id
    })
  },
  CREATE_COMMENT (state, comment) {
    state.comments.unshift(comment)
  }
}

// actions
export const actions = {
  fetchComments (store) {
    comments.all(COMMENTS)
      .then(({ data: comments }) => {
        store.commit('FETCH_COMMENTS', comments.data)
      })
      .catch(error => console.log(error))
  },
  fetchCommentsByUser (store) {
    comments.all(COMMENTS_BY_USER)
      .then(({ data: comments }) => {
        store.commit('FETCH_COMMENTS', comments.data)
      })
      .catch(error => console.log(error))
  },
  removeComment (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('DELETE_COMMENTS', payload)
      resolve()
    })
  },
  createComment (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('CREATE_COMMENT', payload)
      resolve()
    })
  }
}
