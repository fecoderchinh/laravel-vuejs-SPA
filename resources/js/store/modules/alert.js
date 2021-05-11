import axios from 'axios'

// state
export const state = {
  flash: {
    show: false,
    message: '',
    type: 'success'
  }
}

// getters
export const getters = {
  flash (state) {
    return state.flash
  }
}

// mutations
export const mutations = {
  SHOW_FLASH (state, payload) {
    let { message, type = 'success' } = payload

    state.flash = { message, type, show: true }

    setTimeout(() => {
      state.flash.show = false
    }, 3000)
  }
}

// actions
export const actions = {
  alert (store, payload) {
    return new Promise(function (resolve, reject) {
      store.commit('SHOW_FLASH', payload)
      resolve()
    })
  }
}
