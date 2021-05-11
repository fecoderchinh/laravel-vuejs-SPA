import cats from '~/utils/requests'
import { CATEGORIES } from '~/utils/endpoints'

// state
export const state = {
  categories: []
}

// getters
export const getters = {
  categories: state => state.categories
}

// mutation
export const mutations = {
  // FETCH_CATEGORIES (state, categories) {
  //   state.categories = [ ...state.categories, ...categories ]
  // },
  FETCH_CATEGORIES (state, categories) {
    state.categories = categories
    return state.categories
  },
  ADD_CATEGORIES (state, categories) {
    state.categories = [ ...categories, ...state.categories ]
  },
  UPDATE_CATEGORY (state, { data }) {
    state.categories = state.categories.map((category) => {
      if (data.id === category.id) {
        category = data
      }
      return category
    })
  },
  DELETE_CATEGORY (state, payload) {
    state.categories = state.categories.filter((category, index) => {
      return category.id !== payload.id
    })
  },
  ADD_POSTS_COUNT (state, { id }) {
    state.categories.forEach(category => {
      if (category.id === id) {
        category.tasks_count++
      }
    })
  },
  REMOVE_POSTS_COUNT (state, { id }) {
    state.categories.forEach(category => {
      if (category.id === id) {
        category.tasks_count--
      }
    })
  }
}

// actions
export const actions = {
  fetchCategories (store) {
    cats.all(CATEGORIES)
      .then(({ data: categories }) => {
        store.commit('FETCH_CATEGORIES', categories.data)
      })
      .catch(error => console.log(error))
  },
  fetchAllCategories (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('FETCH_CATEGORIES', payload)
      resolve()
    })
  },
  storeCategories (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('ADD_CATEGORIES', payload)
      resolve()
    })
  },
  updateCategory (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('UPDATE_CATEGORY', payload)
      resolve()
    })
  },
  removeCategory (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('DELETE_CATEGORY', payload)
      resolve()
    })
  },
  addCategoryPostCount (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('ADD_POSTS_COUNT', payload)
      resolve()
    })
  },
  removeCategoryPostsCount (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('REMOVE_POSTS_COUNT', payload)
      resolve()
    })
  },
  changeCategoriesPostsCount (store, payload) {
    store.commit('REMOVE_POSTS_COUNT', payload.old)
    store.commit('ADD_POSTS_COUNT', payload.new)
  }
}
