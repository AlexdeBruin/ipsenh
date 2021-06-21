<template>
  <div>
    <v-toolbar>
      <v-toolbar-side-icon class="icon">
        <v-icon color="white" large @click="$router.go(-1)">keyboard_arrow_left</v-icon>
      </v-toolbar-side-icon>
      <v-tabs grow v-model="tabs">
        <v-tab>Cijfers invoeren</v-tab>
        <v-tab>Cijfers inzien</v-tab>
      </v-tabs>
    </v-toolbar>

    <v-tabs-items v-model="tabs">
      <v-tab-item>
        <insert-grades/>
      </v-tab-item>
      <v-tab-item>
        <grades-overview/>
      </v-tab-item>
    </v-tabs-items>
  </div>
</template>

<script>
import InsertGrades from "./InsertGrades.vue";
import GradesOverview from "./GradesOverview.vue";

export default {
  data: () => ({
    tabs: null
  }),
  components: {
    "insert-grades": InsertGrades,
    "grades-overview": GradesOverview
  }
};
</script>

<style scoped>
.icon {
  float: left;
}
.v-toolbar {
  background-color: #3c3f5c !important;
  border-radius:10px;
  width:98.5%;
  margin-top: 8px !important;
  margin-left:auto;
  margin-right:auto;
}

.v-tabs__container,
.v-tabs__div {
    background-color: #3c3f5c !important;
}
</style>



