import axios from 'axios'

const SET_AUTH_USER = 'SET_AUTH_USER';
const LOGOUT_USER = 'LOGOUT_USER';

export default {
    namespaced: true,
    state: {
        user: null,
    },

    getters: {
        getUser: state => {
            return state.user;
        },
        userExists: state => {
            return !!state.user;
        },
        isTeacher: state => {
            if (state.user)
                return state.user.roles.some(e => e.name === "teacher");
        },
        isStudent: state => {
            if (state.user)
                return state.user.roles.some(e => e.name === "student");
        },
        isAdmin: state => {
            if (state.user)
                return state.user.roles.some(e => e.name === "admin");
        }
    },

    mutations: {
        [SET_AUTH_USER](state, user) {
            state.user = user;
            // localStorage.setItem('user', user)
        },
        [LOGOUT_USER](state) {
            state.user = null;
        }

    },

    actions: {
        loadUser({ commit }, token) {
            axios.get('api/user', { headers: { 'Authorization': token } }).then(
                result => {
                    commit(SET_AUTH_USER, result.data);
                }
            )
        },
        logoutUser({ commit }) {
            commit(LOGOUT_USER)
        }
    }
}