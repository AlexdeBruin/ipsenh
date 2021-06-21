import axios from 'axios'



export default {
    namespaced:true,

    actions: {
        register({commit}, userInfo) {
            return axios.post('api/auth/signup', userInfo);
        }
    }
}