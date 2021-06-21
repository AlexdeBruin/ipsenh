import axios from 'axios';
import rootState from 'vuex';

const SET_GRADES = 'SET_GRADES';
const SET_LOADING_STATE = 'SET_LOADING_STATE';
const SET_PROGRESS = 'SET_PROGRESS';

export default {
    namespaced: true,
    state: {
        grades: null,
        progress: null,
        loading: false,
    },

    getters: {
        getGrades: state => {
            return state.grades;
        },
        gradesExist: state => {
            return !!state.grades;
        },
        isLoading: state => {
            return state.loading;
        },
        getProgress: state => {
            return state.progress;
        }

    },

    mutations: {
        [SET_GRADES](state, grades) {
            state.grades = grades;
            //localstorage.setGrades('grades', grades)
        },
        [SET_LOADING_STATE](state, loading) {
            state.loading = loading;
        },
        [SET_PROGRESS](state, progress) {
            state.progress = progress;
        }
    },

    actions: {

        loadGrades({ commit }, parameters) {
            commit(SET_LOADING_STATE, true)
            let authentication = parameters.auth;
            let url = 'api/student/grades/';
            axios.get(url, { headers: { 'Authorization': authentication } }).then(
                result => {
                    commit(SET_GRADES, result.data);
                },
                () => {
                    commit(SET_LOADING_STATE, false)

                }
            )
        },
        setLoadingState({ commit }, loadingBoolean) {
            commit(SET_LOADING_STATE, loadingBoolean);
        },
        loadProgress({ commit }, parameters) {
            commit(SET_LOADING_STATE, true)
            let authentication = parameters.auth;
            let url = 'api/student/ECPerYear/';
            axios.get(url, { headers: { 'Authorization': authentication } }).then(
                result => {
                    commit(SET_PROGRESS, result.data);
                },
                () => {
                    commit(SET_LOADING_STATE, false)
                }
            )
        }
    }

}