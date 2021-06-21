<template>
  <div>
    <h1>{{title}}</h1>
    <v-layout row>
      <v-flex pa-2 shrink>
        <div class="testlist">
          <TestsList @update-test="updateTest"/>
        </div>
      </v-flex>
      <v-flex pa-2 grow>
        <div v-if="test" class="testform">
          <TestsForm
            :test="test"
            :title="testsFormTitle"
            :courseName="title"
            @succesful-insert="showAlert"
          />
        </div>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";
import TestsList from "./TestsList.vue";
import TestsForm from "./TestsForm.vue";

export default {
  data: () => ({
    title: "...",
    testsFormTitle: "",
    course: null,
    test: null
  }),
  computed: {
    ...mapGetters("auth", ["getAuth"])
  },
  created() {
    this.loadCourses();
  },
  methods: {
    updateTest(test) {
      this.setTest(test);
      this.setFormTitle(test);
    },
    setTest(test) {
      this.test = test;
    },
    setFormTitle(test) {
      this.testsFormTitle = test.formatted_given_at;
    },
    loadCourses() {
      let self = this;
      let getCourseUrl = "api/courses/" + this.$route.params.id;
      axios
        .get(getCourseUrl, { headers: { Authorization: this.getAuth } })
        .then(function(response) {
          self.title = response.data.course_code;
        });
    },
    showAlert() {
      
    }
  },
  components: {
    TestsList,
    TestsForm
  }
};
</script>

<style lang="scss" scoped>
.padding {
  padding-top: 15px;
}
h1 {
  text-align: center;
}
.center {
  margin-left: auto;
  margin-right: auto;
}
.testlist {
  width: 200px;
}
.testform {
  width: 700px;
  color:white;
}
</style>