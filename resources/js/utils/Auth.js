// import Storage from '~/utils/Storage'
import Cookies from 'js-cookie'

class Auth {
  get loggedIn () {
    // return Storage.has('access_token')
    return Cookies.get('token') !== null
  }

  get token () {
    // return Storage.get('access_token')
    return Cookies.get('token')
  }

  login (payload) {
    const entries = Object.entries(payload)

    entries.forEach((item) => {
      Storage.record(item[0], item[1])
    })
  }

  logOut () {
    Storage.clear()
  }
}

export default new Auth()
