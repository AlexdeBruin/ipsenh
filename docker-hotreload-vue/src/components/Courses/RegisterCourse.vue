<template>
  <div class="pa-4">
    <h1 class="headline pa-2">
      <v-icon @click="back" large>keyboard_arrow_left</v-icon>Inschrijven voor een vak.
    </h1>
    <v-card class="elevation-6" v-if="courses.length > 0">
      <v-card-title>
        Vakken
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Zoeken..."
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>

      <v-data-table
        :headers="headers"
        :items="courses"
        :search="search"
        hide-actions
        :pagination.sync="pagination"
        item-key="name"
      >
        <template v-slot:items="props">
          <tr>
            <td>{{ props.item.course_description }}</td>
            <td>{{ props.item.course_code }}</td>
            <td>{{ props.item.semester }}</td>
            <td>{{ props.item.year }}</td>
            <td>{{ props.item.ec }}</td>
            <td class="justify-center">
              <v-icon large color="green" @click.stop="setAndToggleDialog(props.item)">add</v-icon>
            </td>
          </tr>
        </template>

        <template v-slot:no-results>
          <v-alert
            :value="true"
            color="warning"
            icon="warning"
          >Zoekopdracht: "{{ search }}" heeft geen resultaten opgeleverd.</v-alert>
        </template>
      </v-data-table>
      <div class="text-xs-center pt-2">
        <v-pagination v-model="pagination.page" :length="pages"></v-pagination>
      </div>
    </v-card>
    <v-alert v-model="alert" dismissible :type="alertType">{{alertMsg}}</v-alert>

    <confirmation-box
      :showDialog="dialog"
      :title="dialogTitle"
      buttonText="Inschrijven"
      :loadingText="dialogLoadingText"
      :method="subscribeToCourse"
      v-on:toggle-dialog="dialog = false"
    />
  </div>
</template>

<script lang="js">
import router from '../../router';
import axios from 'axios';
import { mapGetters, mapState } from "vuex";
import Confirmation from '../Dialogs/Confirmation.vue';

export default {
  data: () => ({
    selectedCourse: "",
    selectedCourseId: 0,
    dialogTitle: "",
    dialogLoadingText: "",
    dialog: false,
    alert: false,
    alertMsg: "",
    alertType: "success",
    search: "",
    pagination: {
      rowsPerPage: 20
    },
    headers: [
      {
        text: "Vak",
        sortable: false,
        value: "course_description"
      },
      { text: "Vak code", sortable: false, value: "course_code"},
      { text: "Semester", sortable: false },
      { text: "Jaar", sortable: false },
      { text: "EC", sortable: false },
      { text: "Acties", sortable: false }
    ],
    courses: []
  }),
  methods: {
    toggle() {
      this.dialog = !this.dialog;
    },
    toggleAlert(alertType) {
      this.alert = !this.alert;
      if(alertType == "success") {
        this.alertMsg = "U bent ingeschreven voor het vak " + this.selectedCourse + ".";
      }else {
        this.alertMsg = "U heeft zich al ingeschreven voor het vak " + this.selectedCourse + ".";
      }
      this.alertType = alertType;
    },
    setCurrentCourse(course) {
      this.selectedCourse = course.course_code;
      this.selectedCourseId = course.id;
    },
    setDialogInfo() {
      this.dialogTitle =
        "Wilt u zich inschrijven voor het vak " + this.selectedCourse + "?";
      this.dialogLoadingText =
        "Inschrijven voor het vak " + this.selectedCourse + "...";
    },
    setAndToggleDialog(course) {
      this.setCurrentCourse(course);
      this.setDialogInfo();
      this.toggle();
    },
    back() {
      router.push({ name: 'courses'});
    },
    subscribeToCourse() {
      let self = this;
      let url = 'api/courses/' + this.selectedCourseId + '/user'
      return axios.post(url,{},{ headers: { 'Authorization': this.auth } })
        .then(function (response){
          self.toggleAlert("success");
        }).catch(function (error) {
          self.toggleAlert("error");
        });
    }
  },
  computed: {
    pages() {
      if (
        this.pagination.rowsPerPage == null ||
        this.pagination.totalItems == null
      )
        return 0;
      return Math.ceil(
        this.pagination.totalItems / this.pagination.rowsPerPage
      );
    },
    ...mapGetters("user", ["getUser"]),
    ...mapState("auth", ["auth"])
  },
  created() {
    axios.get("api/courses", {headers: { "Authorization": this.auth }}).then(response => (this.courses = response.data));
  },
  components: {
    "confirmation-box": Confirmation
  }
};
</script>

<style>
.theme--dark.v-pagination .v-pagination__item--active {
  color: black;
}

.v-card {
    background-color: #3c3f5c !important;
    border-radius:10px;
}
.v-datatable {
      background-color: #3c3f5c !important;
}
</style>