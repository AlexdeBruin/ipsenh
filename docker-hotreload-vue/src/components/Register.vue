<template lang="html">

    <v-container class="register" fluid flex>

      <!-- The Teacher stepper -->
      <v-stepper v-model="e6" class="elevation-6" vertical v-if="choice == 'teacher'">

        <!-- Begin step 1 -->
        <v-stepper-step :complete="e6 > 1" step="1" color="accent">
          Persoons gegevens
          <small>Gegevens over de persoon zelf.</small>
        </v-stepper-step>

        <v-stepper-content step="1">

          <v-card class="mb-5 elevation-6">

            <v-layout row wrap justify-space-around>

              <v-flex xs12 sm11 md11>
                <v-text-field
                v-model="user_form.email"
                ref="email"
                label="E-mail"
                :error-messages="emailErrors"
                @input="$v.user_form.email.$touch()"
                @blur="$v.user_form.email.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm5 md5>
                <v-text-field
                v-model="user_form.password"
                
                :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                :type="showPassword ? 'text' : 'password'"
                @click:append="showPassword = !showPassword"

                label="Wachtwoord"
                :error-messages="passwordErrors"
                @input="$v.user_form.password.$touch()"
                @blur="$v.user_form.password.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm5 md5>
                <v-text-field
                v-model="user_form.password_confirmation"

                :append-icon="showPasswordConfirmation ? 'visibility' : 'visibility_off'"
                :type="showPasswordConfirmation ? 'text' : 'password'"
                @click:append="showPasswordConfirmation = !showPasswordConfirmation"

                label="Herhaal wachtwoord"
                :error-messages="repeatPasswordErrors"
                @input="$v.user_form.password_confirmation.$touch()"
                @blur="$v.user_form.password_confirmation.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm5 md5>
                <v-text-field
                v-model="user_form.first_name"
                label="Voornaam"
                :error-messages="firstNameErrors"
                @input="$v.user_form.first_name.$touch()"
                @blur="$v.user_form.first_name.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm5 md5>
                <v-text-field
                v-model="user_form.last_name"
                label="Achternaam"
                :error-messages="lastNameErrors"
                @input="$v.user_form.last_name.$touch()"
                @blur="$v.user_form.last_name.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm11 md11>
                <v-text-field
                v-model="user_form.birthdate"
                label="Geboorte datum"
                :error-messages="birthdateErrors"
                @input="$v.user_form.birthdate.$touch()"
                @blur="$v.user_form.birthdate.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm7 md7>
                <v-text-field
                v-model="user_form.address"
                label="Address + Huis nummer"
                :error-messages="addressErrors"
                @input="$v.user_form.address.$touch()"
                @blur="$v.user_form.address.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm3 md3>
                <v-text-field
                v-model="user_form.zip_code"
                label="Postcode"
                :error-messages="zipcodeErrors"
                @input="$v.user_form.zip_code.$touch()"
                @blur="$v.user_form.zip_code.$touch()"
                >
                </v-text-field>
              </v-flex>

            </v-layout>

          </v-card>

          <v-btn color="success" @click="startRegistration">Registreer</v-btn>
        </v-stepper-content>
        <!-- End step 1 -->
      </v-stepper>






      <!-- The student stepper -->
      <v-stepper v-model="e6" class="elevation-6" vertical v-if="choice == 'student'">
        
        <!-- Begin step 1 -->
        <v-stepper-step :complete="e6 > 1" step="1" color="accent">
          Student gegevens
          <small>Alleen de student gegevens.</small>
        </v-stepper-step>

        <v-stepper-content step="1">

          <v-card class="mb-5 elevation-6">
            <v-text-field v-model="user_form.student_number"
            ref="student_number"
              label="Student nummer"
                :error-messages="studentNumberErrors"
                @input="$v.user_form.student_number.$touch()"
                @blur="$v.user_form.student_number.$touch()"
                ></v-text-field>
          </v-card>

          <v-btn color="success" @click="e6 = 2">{{volgende}}</v-btn>
        </v-stepper-content>
        <!-- End step 1 -->

        <!-- Begin step 2 -->
        <v-stepper-step :complete="e6 > 2" step="2" color="accent">
          Persoons gegevens
          <small>Gegevens over de persoon zelf.</small>
        </v-stepper-step>

        <v-stepper-content step="2">

          <v-card class="mb-5 elevation-6">

            <v-layout row wrap justify-space-around>

              <v-flex xs12 sm11 md11>
                <v-text-field
                v-model="user_form.email"
                label="E-mail"
                :error-messages="emailErrors"
                @input="$v.user_form.email.$touch()"
                @blur="$v.user_form.email.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm5 md5>
                <v-text-field
                v-model="user_form.password"
                
                :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                :type="showPassword ? 'text' : 'password'"
                @click:append="showPassword = !showPassword"

                label="Wachtwoord"
                :error-messages="passwordErrors"
                @input="$v.user_form.password.$touch()"
                @blur="$v.user_form.password.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm5 md5>
                <v-text-field
                v-model="user_form.password_confirmation"

                :append-icon="showPasswordConfirmation ? 'visibility' : 'visibility_off'"
                :type="showPasswordConfirmation ? 'text' : 'password'"
                @click:append="showPasswordConfirmation = !showPasswordConfirmation"

                label="Herhaal wachtwoord"
                :error-messages="repeatPasswordErrors"
                @input="$v.user_form.password_confirmation.$touch()"
                @blur="$v.user_form.password_confirmation.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm5 md5>
                <v-text-field
                v-model="user_form.first_name"
                label="Voornaam"
                :error-messages="firstNameErrors"
                @input="$v.user_form.first_name.$touch()"
                @blur="$v.user_form.first_name.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm5 md5>
                <v-text-field
                v-model="user_form.last_name"
                label="Achternaam"
                :error-messages="lastNameErrors"
                @input="$v.user_form.last_name.$touch()"
                @blur="$v.user_form.last_name.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm11 md11>
                <v-text-field
                v-model="user_form.birthdate"
                label="Geboorte datum (jaar-maand-dag)"
                :error-messages="birthdateErrors"
                @input="$v.user_form.birthdate.$touch()"
                @blur="$v.user_form.birthdate.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm7 md7>
                <v-text-field
                v-model="user_form.address"
                label="Address"
                :error-messages="addressErrors"
                @input="$v.user_form.address.$touch()"
                @blur="$v.user_form.address.$touch()"
                >
                </v-text-field>
              </v-flex>

              <v-flex xs12 sm3 md3>
                <v-text-field
                v-model="user_form.zip_code"
                label="Postcode"
                :error-messages="zipcodeErrors"
                @input="$v.user_form.zip_code.$touch()"
                @blur="$v.user_form.zip_code.$touch()"
                >
                </v-text-field>
              </v-flex>

            </v-layout>

          </v-card>

          <v-btn color="secondary" @click="e6 = e6 - 1">{{vorige}}</v-btn>
           <v-btn color="success" @click="startRegistration">Registreer</v-btn>
        </v-stepper-content>
        <!-- End step 2 -->
      </v-stepper>

      <v-card v-if="ShowTestCard">
        <p>Student nummer : {{user_form.student_number}}</p>
        <p>e-mail : {{user_form.email}}</p>
        <p>First name : {{user_form.first_name}}</p>
        <p>Last name : {{user_form.last_name}}</p>
        <p>birthdate : {{user_form.birthdate}}</p>
        <p>Address : {{user_form.address}}</p>
        <p>zip code : {{user_form.zip_code}}</p>
        <p>role_assignment: {{user_form.role_assignment}}</p>
        <!-- <p>role_assignment: {{choice}}</p> -->
      </v-card>

    </v-container>

</template>

<script lang="js">

  import { mapActions } from 'vuex'
  import { validationMixin } from 'vuelidate'
  import { required, minLength, maxLength, email, sameAs } from 'vuelidate/lib/validators';
  import router from '../router';

  export default  {
    name: 'register',
    mixins: [validationMixin],
    created() {
      this.user_form.role_assignment = this.choice;
    },
    props: ['choice'],
    data () {
      return {
        e6: 1,
        volgende:"Volgende",
        vorige:"Vorige",
        ShowTestCard:false,
        showPassword:false,
        showPasswordConfirmation:false,
        user_form: {
          student_number: null,
          password: '',
          password_confirmation: '',
          email: '',
          first_name: '',
          last_name: '',
          birthdate: new Date().toISOString().substr(0, 10),
          address: '',
          zip_code: '',
          role_assignment: '',
        }
      }
    },
      validations: {
      user_form: {
        email: {
          required,
          email
        },
        password: {
          required,
          minLength: minLength(6)
        },
        password_confirmation: {
          required,
          minLength: minLength(6),
          sameAsPassword: sameAs('password')
        },
        first_name: {
          required
        },
        last_name: {
          required
        },
        birthdate: {
          required
        },
        address: {
          required
        },
        zip_code: {
          required,
          minLength: minLength(6),
          maxLength: maxLength(6)
        },
        student_number: {
          required,
          minLength: minLength(7),
          maxLength: maxLength(7)
        }
      }
    },
    watch: {
      choice: function(new_choice) {
          this.user_form.role_assignment = new_choice;
          this.resetForm();
      }
    },
    computed: {
      studentNumberErrors () {
        const errors = []
        if (!this.$v.user_form.student_number.$dirty) { 
          return errors
        }
        !this.$v.user_form.student_number.required && errors.push('Student number is required.')
        !this.$v.user_form.student_number.minLength && errors.push('Student number can only be 7 characters long.')
        !this.$v.user_form.student_number.maxLength && errors.push('Student number can only be 7 characters long.')
        return errors
      },
      passwordErrors () {
        const errors = []
        if (!this.$v.user_form.password.$dirty) { 
          return errors
        }
        !this.$v.user_form.password.required && errors.push('Password is required.')
        !this.$v.user_form.password.minLength && errors.push('Minimal 6 characters.')
        return errors
      },
      repeatPasswordErrors () {
        const errors = []
        if (!this.$v.user_form.password_confirmation.$dirty) { 
          return errors
        }
        !this.$v.user_form.password_confirmation.required && errors.push('Password is required.')
        !this.$v.user_form.password_confirmation.minLength && errors.push('Minimal 6 characters.')
        !this.$v.user_form.password_confirmation.sameAsPassword && errors.push('This password is different.')
        return errors
      },
      emailErrors () {
        const errors = []
        if (!this.$v.user_form.email.$dirty) {
          return errors
        }
        !this.$v.user_form.email.email && errors.push('Must be valid e-mail')
        !this.$v.user_form.email.required && errors.push('E-mail is required')
        return errors
      },
      firstNameErrors () {
        const errors = []
        if (!this.$v.user_form.first_name.$dirty) { 
          return errors
        }
        !this.$v.user_form.first_name.required && errors.push('First name is required.')
        return errors
      },
      lastNameErrors () {
        const errors = []
        if (!this.$v.user_form.last_name.$dirty) { 
          return errors
        }
        !this.$v.user_form.last_name.required && errors.push('Last name is required.')
        return errors
      },
      birthdateErrors () {
        const errors = []
        if (!this.$v.user_form.birthdate.$dirty) { 
          return errors
        }
        !this.$v.user_form.birthdate.required && errors.push('Birthdate is required.')
        return errors
      },
      addressErrors () {
        const errors = []
        if (!this.$v.user_form.address.$dirty) { 
          return errors
        }
        !this.$v.user_form.address.required && errors.push('Address is required.')
        return errors
      },
      zipcodeErrors () {
        const errors = []
        if (!this.$v.user_form.zip_code.$dirty) { 
          return errors
        }
        !this.$v.user_form.zip_code.required && errors.push('Zipcode is required.')
        !this.$v.user_form.zip_code.minLength && errors.push('Zipcode can only be 6 characters.')
        !this.$v.user_form.zip_code.maxLength && errors.push('Zipcode can only be 6 characters.')
        return errors
      },
    },
    methods: {
      ...mapActions('register',[
        'register',
      ]),

      startRegistration() {
        this.register(this.user_form).then(
          result => {
            router.push("/dashboard")
          }
        )
      },
      resetForm() {
          this.user_form.student_number = null;
          this.user_form.password = '';
          this.user_form.password_confirmation = '';
          this.user_form.email = '';
          this.user_form.first_name = '';
          this.user_form.last_name = '';
          this.user_form.address = '';
          this.user_form.zip_code = '';
      }
    }
 
}
</script>

<style scoped>

.v-stepper--vertical {
    background-color: #3c3f5c !important;
    border-radius:10px;
}

.v-card {
    width: 99%;
    margin-top: 5px;
    margin-left: auto;
    margin-right: auto;
    position: Relative;
    padding:15px;
    height:fit-content;

    background-color: #3c3f5c !important;
    border-radius:10px;
}

</style>