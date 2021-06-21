<template>
  <div class="tests elevation-6" v-if="tests">
    <v-list>
      <template v-for="(test, index) in tests">
        <v-list-tile :key="test.name" @click="loadTestsForm(test)">
          <v-list-tile-content>
            <v-list-tile-title>{{test.formatted_given_at}}</v-list-tile-title>
            <v-list-tile-sub-title
              class="text--primary"
            >Herkansing: {{ test.retake ? 'Ja' : 'Nee' }}</v-list-tile-sub-title>
          </v-list-tile-content>
          <v-list-tile-action>
            <v-icon color="grey lighten-1">chevron_right</v-icon>
          </v-list-tile-action>
        </v-list-tile>
        <v-divider v-if="index + 1 < tests.length" :key="index"></v-divider>
      </template>
    </v-list>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";
export default {
  data: () => ({
    tests: []
  }),
  computed: {
    ...mapGetters("auth", ["getAuth"])
  },
  created() {
    let self = this;
    let getTestsUrl =
      "api/tests/course/" +
      this.$route.params.id +
      "?inserted=" +
      this.inserted;
    axios
      .get(getTestsUrl, { headers: { Authorization: this.getAuth } })
      .then(function(response) {
        self.tests = response.data;
      });
  },
  methods: {
    loadTestsForm(test) {
      this.$emit("update-test", test);
    },
    toDate(dateStr) {
      var dateParts = dateStr.split("-");
      return new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
    }
  },
  props: {
    inserted: {
      type: Number,
      default: 0
    }
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

.tests {
  background-color: #3c3f5c !important;
    border-radius:10px;
}

.v-list {
  background: unset;
}
</style>