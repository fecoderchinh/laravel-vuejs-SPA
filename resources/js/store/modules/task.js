import tasks from '~/utils/requests'
import { TASKS } from '~/utils/endpoints'

// state
export const state = {
  tasks: []
}

// getters
export const getters = {
  tasks: state => state.tasks
}

// mutations
export const mutations = {
  // FETCH_TASKS (state, tasks) {
  //   state.tasks = [ ...state.tasks, ...tasks ]
  // },
  CREATE_TASK (state, task) {
    state.tasks.unshift(task)
  },
  // for adding multi-data
  CREATE_TASKS (state, tasks) {
    state.tasks = [ ...state.tasks, ...tasks ]
  },
  FETCH_TASKS (state, tasks) {
    state.tasks = tasks
    return state.tasks
  },

  // DELETE_TASK (state, payload) {
  //   state.tasks = state.tasks.filter((task, index) => {
  //     return task.id !== payload.id
  //   })
  // },
  // DELETE_TASK (state, { task }) {
  //   state.tasks = state.tasks.splice(state.tasks.map(task => task.id).indexOf(task), 1)
  // },
  DELETE_TASK (state, payload) {
    state.tasks = state.tasks.filter((task, index) => {
      return task.id !== payload.id
    })
  },
  UPDATE_TASK (state, { data }) {
    state.tasks = state.tasks.map((task) => {
      if (data.id === task.id) {
        task = data
      }
      return task
    })
  }
}

// actions
export const actions = {
  // createTask ({ commit }, task) {
  //   axios.get(RESOURCE_API, task)
  //     .then(res => {
  //       commit('CREATE_TASK', task)
  //     }).catch(err => {
  //       console.log(err)
  //     })
  // },
  // createTask ({ commit }, task) {
  //   axios
  //     .get(RESOURCE_API, task)
  //     .then(res => (
  //       commit('CREATE_TASK', { task: res.data })
  //     ))
  //     .catch(err => console.log(err))
  // },
  fetchTasks (store) {
    tasks.all(TASKS)
      .then(({ data: tasks }) => {
        store.commit('FETCH_TASKS', tasks.data)
      })
      .catch(error => console.log(error))
  },
  fetchAllTasks (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('FETCH_TASKS', payload)
      resolve()
    })
  },
  getTask (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('GET_TASK', payload)
      resolve()
    })
  },
  createTask (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('CREATE_TASK', payload)
      resolve()
    })
  },
  // for adding multi-data
  createTasks (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('CREATE_TASKS', payload)
      resolve()
    })
  },
  // fetchTasks ({ commit }) {
  //   axios.get(RESOURCE_API)
  //     .then(res => {
  //       commit('FETCH_TASKS', res.data)
  //     }).catch(err => {
  //       console.log(err)
  //     })
  // },

  // fetchTasks (store, payload) {
  //   return new Promise((resolve, reject) => {
  //     store.commit('FETCH_TASKS', payload)
  //     resolve()
  //   })
  // },
  deleteTask (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('DELETE_TASK', payload)
      resolve()
    })
  },
  updateTask (store, payload) {
    return new Promise((resolve, reject) => {
      store.commit('UPDATE_TASK', payload)
      resolve()
    })
  }
}
