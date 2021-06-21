<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <v-app class="main_wrapper white--text darkColor" dark>
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
      integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
      crossorigin="anonymous"
    >
    <!-- start overview refactor -->
    <v-navigation-drawer
      app
      fixed
      v-model="drawer"
      id="sidebar"
      clipped
      class="blueGradient"
      v-if="userExists && loggedin"
    >
      <v-list dense>
        <v-list-tile @click="goDashboard">
          <v-list-tile-title class="title">
            Dashboard
          </v-list-tile-title>
        </v-list-tile>

        <v-list-tile v-if="isStudent || isTeacher" @click="goCourses">
          <v-list-tile-title class="title">
            Vakken
          </v-list-tile-title>
        </v-list-tile>

        <v-list-tile v-if="isStudent || isTeacher" @click="goGrades">
          <v-list-tile-title class="title">
            Cijfers
          </v-list-tile-title>
        </v-list-tile>

        <v-list-tile v-if="isAdmin" @click="goStudentRegister">
          <v-list-tile-title class="title">
            Registreren student
          </v-list-tile-title>
        </v-list-tile>

        <v-list-tile v-if="isAdmin" @click="goTeacherRegister">
          <v-list-tile-title class="title">
            Registreren leraar
          </v-list-tile-title>
        </v-list-tile>

        <v-list-tile @click="logout">
          <v-list-tile-title class="title">Uitloggen</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>

    <v-toolbar v-if="loggedin && userExists" app fixed clipped-left id="navbar" class="white--text">
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-toolbar-title
        class="white--text"
        v-if="userExists"
      >Hallo {{getUser.first_name}} {{getUser.last_name}}</v-toolbar-title>
    </v-toolbar>

    <v-content class="darkColor">
      <router-view></router-view>
    </v-content>

    <v-footer app fixed class="darkColor white--text">
      <span class="pa-3">&copy; 2019</span>
    </v-footer>

    <!-- End overvieuw refactor -->
  </v-app>
</template>

<script>
import { mapGetters, mapActions, mapState } from "vuex";
import router from "./router";
export default {
  data: () => ({
    drawer: null
  }),
  props: {
    source: String
  },
  created() {},

  computed: {
    //Authentication map's
    ...mapState("auth", ["auth", "error"]),
    ...mapGetters("auth", ["loggedin", "getAuth"]),
    ...mapGetters("user", [
      "getUser",
      "userExists",
      "isAdmin",
      "isStudent",
      "isTeacher"
    ])
  },
  methods: {
    //Authentication map's
    ...mapActions("auth", ["login", "logoutAuth"]),
    ...mapActions("user", ["loadUser", "logoutUser"]),
    logout() {
      this.logoutUser();
      this.logoutAuth();
      router.push("/");
    },
    goDashboard() {
        router.push('/dashboard');
    },
    goCourses() {
        router.push('/courses');
    },
    goGrades() {
        router.push('/grades')
    },
    goStudentRegister() {
        router.push({name:'register', params:{ choice:'student' }})
    },
    goTeacherRegister() {
        router.push({name:'register', params:{ choice:'teacher' }})
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

@import url("https://fonts.googleapis.com/css?family=Nunito+Sans");

.main_wrapper {
  font-family: "Nunito Sans", sans-serif !important;
}

h3 {
  margin: 40px 0 0;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #1f6fb2;
  text-decoration: none;
}
.title {
  color: #fff;
  font-family: "Nunito Sans", sans-serif !important;
}
v-app {
  font-family: "Nunito Sans", sans-serif !important;
}

.v-list__tile__title {
  margin-left: 15px;
}

#navbar > div {
  height: 56px !important;
}

#navbar {
  background-color: #201f2f !important;
}

.v-toolbar {
  box-shadow: unset;
}

#sidebar {
  margin-top: 72px !important;
  height: 89% !important;
  width: 285px !important;
  margin: 15px;
  border-radius: 10px;
  /* min-height: 100% !important; */
  /* max-height: 100% - 36px !important; */
}

.v-navigation-drawer .v-list {
  background: transparent !important;
  margin-top: 15px;
}

.blueGradient {
  background: #4776e6; /* fallback for old browsers */
  background: -webkit-linear-gradient(
    to bottom right,
    #8e54e9,
    #4776e6
  ); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(
    to bottom right,
    #8e54e9,
    #4776e6
  ); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
.goodGrade {
  background-color: lightgreen;
}

.badGrade {
  background-color: lightcoral;
}
</style>
