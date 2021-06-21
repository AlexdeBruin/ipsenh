<template>
  <v-form v-model="valid" light>
    <confirmation-box
      :showDialog="showDialog"
      :title="dialogTitle"
      buttonText="Invoeren"
      :loadingText="dialogLoadingText"
      :method="insertGrades"
      v-on:toggle-dialog="onDialogClose"
    />
    <v-flex xs14 md4 class="center">
      <v-card>
        <v-card-title primary-title>Gegeven op: {{title}}</v-card-title>
        <v-container v-if="gradesWithStudents">
          <v-layout v-for="(student, index) in students" :key="student.id">
            <p class="padding">{{ student.first_name }}</p>&nbsp;&nbsp;
            <v-text-field
              v-model="gradesWithStudents[index].grade"
              :rules="gradeRules"
              :counter="3"
              label="Cijfer"
              required
              class="input"
            ></v-text-field>
          </v-layout>
          <v-btn :disabled="!valid" color="success" @click="fillAndShowDialog()">Invoeren</v-btn>
        </v-container>
        <v-container v-if="!gradesWithStudents">Gegevens ophalen...</v-container>
      </v-card>
    </v-flex>
  </v-form>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";
import Confirmation from "../Dialogs/Confirmation.vue";

export default {
  name: "TestsForm",
  data: () => ({
    valid: false,
    gradesWithStudents: [],
    gradeRules: [
      v => !!v || "Cijfer is vereist",
      v => (v <= 10 && v >= 1) || "Het cijfer moet tussen een '1' en '10' zijn."
    ],
    students: [],
    defaultTitle: "...",
    showDialog: false,
    dialogTitle: "",
    dialogLoadingText: "Cijfers invoeren..."
  }),
  methods: {
    loadStudents() {
      this.emptyStudentsArray();
      let self = this;
      let getStudentsUrl = "api/tests/" + this.test.id + "/students";
      axios
        .get(getStudentsUrl, { headers: { Authorization: this.getAuth } })
        .then(function(response) {
          self.students = response.data;
        });
    },
    onDialogClose() {
      this.showDialog = false;
      this.$emit("succesful-insert");
    },
    emptyStudentsArray() {
      this.students = [];
      this.gradesWithStudents = [];
    },
    fillAndShowDialog() {
      this.dialogTitle =
        "Cijfers invoeren voor de toets " +
        this.courseName +
        " geven op " +
        this.test.formatted_given_at +
        "?";
      this.showDialog = true;
    },
    insertGrades() {
      let postGradesUrl = "api/tests/" + this.test.id + "/grades";
      return axios
        .post(postGradesUrl, this.gradesWithStudents, {
          headers: { Authorization: this.getAuth }
        })
        .then(() => {
          this.$router.push({ name: "dashboard" });
        });
    }
  },
  computed: {
    ...mapGetters("auth", ["getAuth"])
  },
  components: {
    "confirmation-box": Confirmation
  },
  props: {
    test: Object,
    title: String,
    courseName: String
  },
  watch: {
    gradesWithStudents: {
      deep: true,
      handler() {
        for (var i = 0; i < this.gradesWithStudents.length; i++) {
          return (this.gradesWithStudents[i].grade = this.gradesWithStudents[
            i
          ].grade.replace(",", "."));
        }
      }
    },
    students() {
      for (var i = 0; i < this.students.length; i++) {
        let gradeWithStudent = {
          user_id: this.students[i].id,
          grade: "0",
          test_id: this.test.id
        };
        this.gradesWithStudents.push(gradeWithStudent);
      }
    },
    test() {
      this.loadStudents();
    }
  },
  created() {
    this.loadStudents();
  }
};
</script>

<style scoped>
.input {
  min-width: 45% !important;
  padding: 15px;
}

.container {
  width: fit-content;
  display: flex;
  flex-flow: row wrap;
}

.v-card {
  width: fit-content;
  display: flex;
  flex-flow: row wrap;
  width: 50vw;
}

.layout {
  width: 50%;
}

p {
  width: 35%;
}
</style>
