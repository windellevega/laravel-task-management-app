import axios from 'axios'
import env from './../../env'

axios.defaults.baseURL = env.API_HOST
axios.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded'
axios.defaults.headers.post['Content-Type'] = 'multipart/form-data'

if (localStorage.getItem('token')) {
    const Bearer = `Bearer ${ localStorage.getItem('token') }`
    axios.defaults.headers.common['Authorization'] = Bearer
}