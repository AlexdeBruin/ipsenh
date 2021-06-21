<template>
  <div class="pa-0">
    <router-link :to="{name : 'courseRegister'}">
      <v-btn v-if="showSubscribeButton" class="success">
        Inschrijven &nbsp; &nbsp;
        <v-icon>fas fa-plus</v-icon>
      </v-btn>
    </router-link>
    <template v-if="showCards">
      <v-layout row wrap>
        <v-flex v-for="course of courses" :key="course.course_code" xs12 sm3 class="pa-2">
          <v-card class="elevation-6">
            <router-link :to="{name : 'courseInfo', params: {id: course.id}}">
              <v-card-title primary-title>
                <div>
                  <div class="headline" v-text="course.course_code"></div>
                  <span v-text="course.course_description"></span>
                </div>
              </v-card-title>
            </router-link>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn fab small icon>
                <v-icon @click="setAndToggleDialog(course)" medium color="red">delete</v-icon>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
    </template>
    <template v-if="!showCards">
      <v-card class="show-courses elevation-6">
        <v-card-title class="headline justify-center">Vakken</v-card-title>
        <v-list class="ma-0 pa-3" v-if="isStudent">
          <template v-for="(course, index) of filteredCoursesList">
            <router-link
              :key="course.course_code"
              :to=" {name : 'courseInfo', params: {id:course.id}}"
            >
              <v-list-tile class="listItem">
                <v-list-tile-content>
                  <v-list-tile-title v-text="course.course_code"></v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-avatar v-text="course.course_description"></v-list-tile-avatar>
              </v-list-tile>
            </router-link>
            <v-divider v-if="index + 1 < filteredCoursesList.length" :key="`divider-${index}`"></v-divider>
          </template>
          <v-divider v-if="courses"></v-divider>
        </v-list>

        <v-list class="ma-0 pa-3" v-if="isTeacher">
          <template v-for="(course, index) of filteredCoursesList">
            <router-link
              :key="course.course_code"
              :to=" {name : 'courseDashboard', params: {id:course.id}}"
            >
              <v-list-tile class="listItem">
                <v-list-tile-content>
                  <v-list-tile-title v-text="course.course_code"></v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-avatar v-text="course.course_description"></v-list-tile-avatar>
              </v-list-tile>
            </router-link>
            <v-divider v-if="index + 1 < filteredCoursesList.length" :key="`divider-${index}`"></v-divider>
          </template>
          <v-divider v-if="courses"></v-divider>
        </v-list>
      </v-card>
    </template>
    <confirmation-box
      :showDialog="dialog"
      :title="dialogTitle"
      buttonText="Uitschrijven"
      :loadingText="dialogLoadingText"
      :method="unsubsribeFromCourse"
      v-on:toggle-dialog="dialog = false"
    />

    <v-alert v-model="alert" dismissible :type="alertType">{{alertMsg}}</v-alert>
  </div>
</template>

<script>
import axios from "axios";
import Confirmation from "../Dialogs/Confirmation.vue";
import { mapGetters, mapState } from "vuex";
export default {
  name: "courses",
  props: {
    showSubscribeButton: {
      default: true,
      type: Boolean
    },
    showCards: {
      default: true,
      type: Boolean
    }
  },
  methods: {
    unsubsribeFromCourse() {
      let self = this;
      let url = "api/courses/" + this.selectedCourseId + "/user";
      return axios
        .delete(url, { headers: { Authorization: this.auth } })
        .then(function(response) {
          self.toggleAlert("success");
          self.removeCourseFromList(response);
        })
        .catch(function(error) {
          self.toggleAlert("error");
        });
    },
    removeCourseFromList(courses) {
      var index = this.courses
        .map(function(e) {
          return e.course_code;
        })
        .indexOf(courses.data.course_code);
      this.courses.splice(index, 1);
    },
    toggle() {
      this.dialog = !this.dialog;
    },
    setCurrentCourse(course) {
      this.selectedCourse = course.course_code;
      this.selectedCourseId = course.id;
    },
    setDialogInfo() {
      this.dialogTitle =
        "Wilt u zich uitschrijven voor het vak " + this.selectedCourse + "?";
      this.dialogLoadingText =
        "Uitschrijven voor het vak " + this.selectedCourse + "...";
    },
    setAndToggleDialog(course) {
      this.setCurrentCourse(course);
      this.setDialogInfo();
      this.toggle();
    },
    toggleAlert(alertType) {
      this.alert = !this.alert;
      if (alertType == "success") {
        this.alertMsg =
          "U bent uitgeschreven voor het vak " + this.selectedCourse + ".";
      } else {
        this.alertMsg = "Er is iets fout gegaan tijdens het uitschrijven.";
      }
      this.alertType = alertType;
    }
  },
  computed: {
    ...mapGetters("user", ["getUser", "isStudent", "isTeacher"]),
    ...mapState("auth", ["auth"]),
    filteredCoursesList: function() {
      this.filteredCourses = this.courses.slice(0, 5);
      return this.filteredCourses;
    }
  },
  data: () => ({
    courses: [],
    dialog: false,
    selectedCourse: "",
    selectedCourseId: 0,
    dialogTitle: "",
    dialogLoadingText: "",
    alert: false,
    alertMsg: "",
    alertType: "success",
    filteredCourses: []
  }),
  created() {
    axios
      .get("api/courses/user", { headers: { Authorization: this.auth } })
      .then(response => (this.courses = response.data));
  },
  components: {
    "confirmation-box": Confirmation
  }
};
</script>

<style lang="scss" scoped>

.listItem{
    :hover{
        background-color: slategray
    }
}

.show-courses {
  background-color: #3c3f5c !important;
  border-radius: 10px;
}

.course-list {
  background-color: #3c3f5c !important;
}

.show-courses .v-list {
  background-color: #3c3f5c !important;
}

.v-btn {
  border-radius: 5px;
  height: 50px;
  width: 180px;
  font-size: 14px;
}
</style>
