import axios from 'axios'
import env from './../../env'
import store from './../store'

axios.defaults.baseURL = env.API_HOST
axios.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded'
axios.defaults.headers.post['Content-Type'] = 'multipart/form-data'

if (store.state.auth.token) {
    const Bearer = `Bearer ${ store.state.auth.token }`
    axios.defaults.headers.common['Authorization'] = Bearer
}