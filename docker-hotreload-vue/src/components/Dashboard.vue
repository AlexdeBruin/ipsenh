<template>
  <div>
    <v-container grid-list-lg fluid flex v-if="isStudent">
      <v-layout row wrap align-space-around>
        <v-flex xs12 md8 order-xs2 order-md1 d-flex>
          <v-layout row wrap justify-space-around>
            <v-flex xs12 order-xs2 order-md1>
              <v-layout row wrap justify-space-between height="100vh" class="pb-4">
                <v-flex d-flex xs12 md6 id="progress">
                  <dashboard-progress class="pa-0 ma-0"/>
                </v-flex>
                <v-flex d-flex xs12 md6 id="grades">
                  <grades class="pa-0 ma-0" v-bind:onDashboard="true"/>
                </v-flex>
              </v-layout>
              <Courses
                class="pa-0 ma-0"
                v-bind:show-subscribe-button="false"
                v-bind:show-cards="false"
              />
            </v-flex>
          </v-layout>
        </v-flex>
        <v-flex xs12 md4 order-xs1 order-md2 d-flex id="notifications">
          <dashboardAnnouncements class="pa-0 ma-0"></dashboardAnnouncements>
        </v-flex>
      </v-layout>
    </v-container>
    <v-container fluid v-if="isTeacher">
      <v-layout row>
        <v-flex grow pa-1>
          <Courses id="course" v-bind:show-subscribe-button="false" v-bind:show-cards="false"/>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>


<script>
import Courses from "./Courses/Courses.vue";
import dashboardProgress from "./dashboardComponents/dashboardProgress.vue";
import { mapGetters } from "vuex";
import Grades from "./Grades/Grades.vue";
import dashboardAnnouncements from "./Courses/Announcement/dashboardAnnouncements.vue";

export default {
  components: {
    Courses,
    dashboardProgress,
    Grades,
    dashboardAnnouncements
  },
  computed: {
    ...mapGetters("user", ["isTeacher", "isStudent"])
  }
};
</script>

<style lang="css" scoped>
#notification {
  height: 84vh !important;
  background-color: #3c3f5c !important;
  border-radius: 10px;
}

.v-card {
  background-color: white;
}

@media only screen and (max-width: 959px) {
  #notification {
    height: 50vh !important;
  }
}
</style>

