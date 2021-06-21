<template lang="html">
  <v-container height="100vh">
    <v-layout align-center justify-center>
      <v-flex xs12 sm8 md8 lg6>
        <section class="logo">
          <img src='../assets/logondlo.svg' />
        </section>

        <section class="login blueGradient">
          <form class="elevation-6 inlog_form" v-if="!isLoading">
            <v-alert v-if="getError != ''" :value="true" type="error">
              {{getError}}
            </v-alert>
            <h2>Login</h2>
            <v-text-field
              v-on:keydown.enter="startLogin"
              v-model="form.email" 
              :disabled='isLoading == true'
              :error-messages="emailErrors"
              label="E-mail"
              :dark="true"
              required
              @input="$v.form.email.$touch()"
              @blur="$v.form.email.$touch()"
            ></v-text-field>
            <v-text-field
              v-on:keydown.enter="startLogin"
              v-model="form.password"
              :disabled='isLoading == true'
              :error-messages="nameErrors"
              :dark="true"
              :type="'password'"
              label="Wachtwoord"
              required
              @input="$v.form.password.$touch()"
              @blur="$v.form.password.$touch()"
            ></v-text-field>

            <v-btn class="success" @click="startLogin" :disabled='isLoading == true'>Inloggen</v-btn>
          </form>

          <section class="loadingScreen elevation-6" v-if="isLoading">

            <h2>{{progress_bar.progress_info}}</h2>

            <half-circle-spinner class="spinner"
              :animation-duration="1000"
              :size="60"
              color="#F64C54"
            />

            <v-progress-linear
              v-model="progress_bar.value"
              :active="progress_bar.show"
              :query="true"
              :height="15"
              color="#F64C54"
            ></v-progress-linear>
          </section>
        </section>
        </v-flex>
    </v-layout>
  </v-container>
</template>

<script lang="js">
  import { validationMixin } from 'vuelidate'
  import { required, email } from 'vuelidate/lib/validators'
  import { mapGetters, mapActions, mapState } from 'vuex'
  import { HalfCircleSpinner } from 'epic-spinners'
  import router from '../router'

  export default {
    name: 'login',
    mixins: [validationMixin],

    created() {

      this.resetErrorMessage();
      
      if(this.loggedin) {
        router.push("/dashboard")
      }
    },

    components: {
      HalfCircleSpinner
    },

    validations: {
      form: {
        password: { required },
        email: { required, email },
      }
    },

    data () {
      return {
        form: {
          password: '',
          email: '',
        },
        progress_bar: {
          value: 0,
          show: true,
          interval: 0,
          progress_info: ''
        }
      }
    },

    computed: {
      nameErrors () {
        const errors = []
        if (!this.$v.form.password.$dirty) { 
          return errors
        }
        !this.$v.form.password.required && errors.push('Password is required.')
        return errors
      },
      emailErrors () {
        const errors = []
        if (!this.$v.form.email.$dirty) {
          return errors
        }
        !this.$v.form.email.email && errors.push('Must be valid e-mail')
        !this.$v.form.email.required && errors.push('E-mail is required')
        return errors
      },
      ...mapState('user', [
        'user'
      ]),
      ...mapState('auth', [
        'auth',
        'error',
        'loading',
      ]),
      ...mapGetters('auth', [
        'loggedin',
        'isLoading',
        'getError',
        'getAuth',
      ]),
    },

    methods: {
      clear () {
        this.$v.form.$reset()
        this.form.password = ''
        this.form.email = ''
      },
      startLogin() {
        this.progress_bar.value = 0;
        this.progress_bar.value += 50;
        this.progress_bar.progress_info = "1/2 Autoriseren ..."
        this.login(this.form)        
      },
      ...mapActions('auth',[
        'login',
        'setLoadingState',
        'resetErrorMessage'
      ]),
      ...mapActions('user',[
        'loadUser'
      ])
    },
    watch: {
      auth: function(newAuth) {
        if(newAuth) {
          this.setLoadingState(true)
          this.progress_bar.value += 50;
          this.progress_bar.progress_info = "2/2 Gebruiker inloggen ..."
          this.loadUser(newAuth)
        }
      },
      user: function(newUser) {
        if(newUser) {
          this.setLoadingState(false)
          router.push("/dashboard")
        }
      },

    },
}
</script>

<style scoped>

.login {
  border-radius:10px;
  margin:auto;
      margin-top: -50px;
}

.maxHeight {
  height:100vh !important;
}

.inlog_form,
form {
  padding: 25px;
  /* background-color:#FFFFF0; */
  border-radius:10px;
  height: fit-content;
  min-height:100%;
}

.spinner {
  position: relative;
  left: 0px;
  right: 0px;
  margin-left: auto;
  margin-right: auto;
}

.input-group__input * {
  color: rgba(0,0,0,0.87) !important
}

.v-alert {
  margin-bottom:20px;
} 

.v-progress-linear {
  border-radius:25px;
}

.loadingScreen {
  text-align:center;
  position:relative;
  padding:3vw;
  border-radius:5px;
}

.loadingScreen h2 {
  /* color:white; */
  font-style:italic;
}

.loadingScreen h2,
.loadingScreen .spinner {
  margin-bottom: 25px;
}

.logo {
    width: 100%;
    height: 50vh;
    position: relative;
    margin: auto;
}

img {
    height: 100%;
    width: 100%;
}

</style>
