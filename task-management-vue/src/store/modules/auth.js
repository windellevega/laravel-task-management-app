import axios from 'axios'

const state = {
    token: null,
    user: null,
    isLoggedIn: false
}

const mutations = {
    USER_LOGIN_SUCCESS: (state, data) => {
        state.token = data.token
        state.user = data.user
        state.isLoggedIn = true

        localStorage.setItem('token', data.token)
        axios.defaults.headers.common['Authorization'] = `Bearer ${data.token}`
    },

    USER_LOGOUT: state => {
        state.isLoggedIn = false
        localStorage.removeItem('token')
    }
}

const actions = {
    login: async ({ commit }, credentials) => {
        try {
            const response = await axios.post('api/login', credentials)

            commit('USER_LOGIN_SUCCESS', response.data)

            return Promise.resolve()
        }
        catch (error) {
            return Promise.reject(error)
        }
    },

    logout: ({ commit }) => {
        return new Promise(resolve => {
            axios.post('api/logout')
            commit('USER_LOGOUT')
            resolve()
        })
    }
}

const getters = {
    currentUser: state => state.user,
    token: state => state.token
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}