import axios from 'axios'

const state = {
    token: null,
    user: null,
    isLoggedIn: false
}

const mutations = {
    LOGIN_SUCCESS: (state, data) => {
        state.token = data.token
        state.user = data.user
        state.isLoggedIn = true
    },

}

const actions = {
    login: async ({ commit }, credentials) => {
        try {
            const response = await axios.post('api/login', credentials);

            commit('LOGIN_SUCCESS', response.data);

            return Promise.resolve();
        }
        catch (error) {
            return Promise.reject(error)
        }
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