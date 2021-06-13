import axios from 'axios'

const state = {
    token: null,
    user: null,
    isLoggedIn: false,
    isLoggingIn: false,
}

const mutations = {
    beforeUserLogin: state => {
        state.isLoggingIn = true
    },

    userLoginSuccess: (state, data) => {
        state.token = data.token
        state.user = data.user
        state.isLoggedIn = true

        localStorage.setItem('token', data.token)
        axios.defaults.headers.common['Authorization'] = `Bearer ${data.token}`

        state.isLoggingIn = false
    },

    userLoginFailed: state => {
        state.isLoggedIn = false
        state.isLoggingIn = false
    },

    userLogout: state => {
        state.isLoggedIn = false
        localStorage.removeItem('token')
    }
}

const actions = {
    login: async ({ commit }, credentials) => {
        commit('beforeUserLogin')

        try {
            const response = await axios.post('api/login', credentials)

            commit('userLoginSuccess', response.data)

            return Promise.resolve()
        }
        catch (error) {
            commit('userLoginFailed')

            return Promise.reject(error)
        }
    },

    logout: ({ commit }) => {
        return new Promise(resolve => {
            axios.post('api/logout')
            commit('userLogout')
            resolve()
        })
    }
}

const getters = {
    currentUser: state => { return state.user },
    token: state => { return state.token },
    isLoggingIn: state =>{ return state.isLoggingIn },
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}