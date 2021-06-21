<template>
  <v-layout row wrap pa-4 v-if="dataLoaded">
    <v-flex xs11 mb-3>
      <v-card dark>
        <v-card-text class="px-0">
          <router-link :to="{name : 'courseInfo', params: {id: announcement.course_id}}">
            <h1 class="headline white--text pa-2 text-xs-left">
              <v-icon color="white" large>keyboard_arrow_left</v-icon>Terug naar het cursusoverzicht
            </h1>
          </router-link>
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex xs7></v-flex>
    <v-flex xs7>
      <v-card v-if="announcement">
        <v-card-title>Gepubliceerd op {{announcement.formatted_created_at}}</v-card-title>
        <v-card-text>
          <span class="grey--text">{{announcement.announcement}}</span>
        </v-card-text>
      </v-card>
    </v-flex>

    <v-flex xs4 ml-1 justify-end v-if="latestAnnouncements">
      <v-hover v-for="latestAnnouncement in latestAnnouncements" v-bind:key="latestAnnouncement.id">
        <v-card slot-scope="{ hover }" :class="`elevation-${hover ? 12 : 2}`" class="mb-2">
          <router-link :to="{name : 'announcement', params: {id: latestAnnouncement.id}}">
            <v-card-title>{{latestAnnouncement.formatted_created_at}}</v-card-title>
            <v-card-text>
              {{ latestAnnouncement.announcement.length < 50 ? latestAnnouncement.announcement :
              latestAnnouncement.announcement.substring(0,50) + "..."}}
            </v-card-text>
          </router-link>
        </v-card>
      </v-hover>
    </v-flex>
  </v-layout>
  <v-layout row wrap pa-4 v-else>
    <half-circle-spinner class="spinner" :animation-duration="1000" :size="60" color="#ff1d5e"/>
  </v-layout>
</template>

<script>
import axios from "axios";
import { HalfCircleSpinner } from "epic-spinners";
import { mapState } from "vuex";

export default {
  name: "Announcement",
  methods: {
    loadData: function() {
      let self = this;
      self.dataLoaded = false;
      axios
        .get("api/courses/announcement/" + this.$route.params.id, {
          headers: { Authorization: this.auth }
        })
        .then(function(response) {
          self.announcement = response.data;
          axios
            .get("api/courses/announcements/" + self.announcement.course_id, {
              headers: { Authorization: self.auth }
            })
            .then(function(response) {
              self.latestAnnouncements = response.data;
              self.dataLoaded = true;
            });
        });
    }
  },
  components: {
    HalfCircleSpinner
  },
  data: () => ({
    dataLoaded: false,
    announcement: null,
    latestAnnouncements: null
  }),
  computed: {
    ...mapState("auth", ["auth"])
  },
  created() {
    this.loadData();
  },
  watch: {
    $route() {
      this.loadData();
    }
  }
};
</script>

<style scoped>
</style>