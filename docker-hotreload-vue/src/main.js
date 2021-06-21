import Vue from 'vue'
import './plugins/vuetify'
import App from './App.vue'
import router from './router'
import Vuex from 'vuex'
import Vuetify from 'vuetify';
import store from './store'
// import '@fortawesome/fontawesome-free/css/all.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import Vuelidate from 'vuelidate'

let axiosDefaults = require('axios/lib/defaults');
let baseUrl = window.location;
Vue.use(Vuex)
Vue.use(Vuelidate)
Vue.config.productionTip = false
Vue.use(Vuetify, {
  theme: {
    primary: '#F2F5FF',
    secondary: '#333333',
    accent: 'ff1d5e',

    // darkColor: '#292826',
    darkColor: '#201F2F',
    yellowSecondary: '#ffc500',
    darkPink: '#F64C54',
    lightPink: '#FF7E4E'
  }
})
Vue.use(Vuetify, {
  iconfont: 'fa'
})

axiosDefaults.baseURL = baseUrl.protocol + '//' + baseUrl.hostname + process.env.VUE_APP_API_PORT;
new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
