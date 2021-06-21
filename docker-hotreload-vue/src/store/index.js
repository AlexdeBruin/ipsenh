import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import user from './modules/user'
import auth from './modules/auth'
import register from './modules/register'
import grades from './modules/grades'
import createPersistedState from 'vuex-persistedstate';


Vue.use(Vuex, axios)

export default new Vuex.Store({
  modules: {
    user,
    auth,
    register,
    grades
  },
  plugins: [createPersistedState()],

  state: { // = data

  },

  getters: { // = computed properties

  },

  actions: {},

  mutations: {

  }
})