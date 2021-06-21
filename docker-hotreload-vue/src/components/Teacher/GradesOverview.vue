<template>
  <v-layout row>
    <v-flex pa-2 shrink>
      <div class="testlist">
        <test-list @update-test="updateTest" :inserted="1"></test-list>
      </div>
    </v-flex>
    <v-flex pa-2 grow>
      <div v-if="test" class="testform">
        <grades-table :test="test"/>
      </div>
    </v-flex>
  </v-layout>
</template>

<script>
import TestsList from "./TestsList.vue";
import GradesTable from "./GradesTable.vue";
export default {
  data: () => ({
    test: null
  }),
  methods: {
    updateTest(test) {
      this.test = test;
    }
  },
  components: {
    "test-list": TestsList,
    "grades-table": GradesTable
  }
};
</script>

<style scoped>
</style>


