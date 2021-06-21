<template>
  <div>
    <v-data-table :headers="headers" :items="studentsWithGrade" class="elevation-1">
      <template v-slot:items="props">
        <td>{{ props.item.first_name }}</td>
        <td>{{ props.item.last_name }}</td>
        <td>{{ props.item.updated_at }}</td>
        <td>{{ props.item.pivot.grade }}</td>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    headers: [
      {
        text: "Voornaam",
        align: "left",
        sortable: false,
        value: "first_name"
      },
      { text: "Achternaam", value: "last_name", sortable: false },
      { text: "Datum", value: "date", sortable: false },
      { text: "Cijfer", value: "grade", sortable: false }
    ],
    studentsWithGrade: []
  }),
  methods: {
    loadTestsData() {
      this.emptyStudentsWithGrade();
      let getStudentsForTestUrl = "api/tests/" + this.test.id + "/students";
      let self = this;
      axios
        .get(getStudentsForTestUrl, {
          headers: { Authorization: this.getAuth }
        })
        .then(function(response) {
          self.studentsWithGrade = response.data;
        });
    },
    emptyStudentsWithGrade() {
      this.studentsWithGrade = [];
    }
  },
  props: {
    test: Object
  },
  created() {
    this.loadTestsData();
  },
  watch: {
    test() {
      this.loadTestsData();
    }
  }
};
</script>

<style scoped>
</style>


