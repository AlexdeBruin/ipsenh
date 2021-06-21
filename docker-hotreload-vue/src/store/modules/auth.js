import axios from 'axios'

const SET_AUTH = 'SET_AUTH';
const SET_LOADING_STATE = 'SET_LOADING_STATE';
const SET_LOGIN_ERROR = 'SET_LOGIN_ERROR';
const LOGOUT_AUTH = 'LOGOUT_AUTH';
const RESET_ERROR_MESSAGE = 'RESET_ERROR_MESSAGE';

export default {
    namespaced:true,
    
    state: {
        auth: null,
        error: '',
        loading: false,
    },

    getters: {
        loggedin: state => {
            return !!state.auth;
            // return !!localStorage.getItem('token')
        },
        isLoading: state => {
            return state.loading;
        },
        getError: state => {
            return state.error;
        },
        getAuth: state => {
            return state.auth;
            // return localStorage.getItem('token')
        },
    },

    mutations: {
        [SET_AUTH](state, auth) {
            state.auth = auth.token_type + ' ' + auth.access_token;
            // localStorage.setItem('token', auth.token_type + ' ' + auth.access_token)
        },
        [SET_LOADING_STATE](state, loading) {
            state.loading = loading;
        },
        [SET_LOGIN_ERROR](state, error) {
            state.error = error;
        },
        [LOGOUT_AUTH](state) {
            state.auth = null;
        },
        [RESET_ERROR_MESSAGE](state) {
            state.error = '';
        }
    },

    actions: {
        login({commit}, credentials) {
            commit(SET_LOADING_STATE, true)
            axios.post('api/auth/login', credentials).then(
                result => {
                    commit(SET_AUTH, result.data)
                    commit(SET_LOGIN_ERROR, '')
                },
                () => {
                    commit(SET_LOADING_STATE, false)
                    commit(SET_LOGIN_ERROR, "Verkeerde e-mail / wachtwoord")
                }
            )
        },
        setLoadingState({commit}, loadingBool) {
            commit(SET_LOADING_STATE, loadingBool)
        },
        logoutAuth({commit}) {
            commit(LOGOUT_AUTH)
        },
        resetErrorMessage({commit}) {
            commit(RESET_ERROR_MESSAGE)
        }
    }
}