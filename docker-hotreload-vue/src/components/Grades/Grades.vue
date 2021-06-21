<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <v-container class="pa-0 ma-0">
    <template v-if="onDashboard && isStudent">      
      <router-link to="/grades" width="100%">
      <v-card class="cijfers pa-0 ma-0 elevation-6" height="40vh">
        <v-card-title class="headline justify-center">  
          <button @click="getGradesFromStore()">  Cijfers</button>
        </v-card-title>
          <v-list class="ma-3" v-if="this.isLoading">
          <template v-for="(test, index) of this.filteredGradesList">
          <v-list-tile  :key="test.id" class="listItem">
              <v-list-tile-content>
                <v-list-tile-title v-text="test.name"> </v-list-tile-title>                            
              </v-list-tile-content>
                <v-list-tile-avatar v-text="test.pivot.grade"></v-list-tile-avatar>
             </v-list-tile>
          <v-divider v-if="index + 1 < filteredGradesList.length" :key="`divider-${index}`"></v-divider>
          </template>
          <v-divider></v-divider>
        </v-list>
          <v-spacer></v-spacer>
        </v-card> 
        </router-link>
      </template>
      <template v-if="!onDashboard && isStudent">
        <v-card v-if="tests.length > 0" class="cijfers pa-2 ma-0" flat height="80vh">
          <v-card-title>
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
             :items="tests"
             :search="search"
             hide-actions
             :pagination.sync="pagination"
             item-key="name"
            >
            <template v-slot:items="props">
              <tr v-if="props.item.pivot.grade > 5.4" class="goodGrade">
                <td>{{props.item.name}}</td>
                <td>{{props.item.semester}}</td>
                <td>{{props.item.percentage}}</td>
                <td>{{props.item.pivot.grade}}</td>
                <td>{{props.item.retake}}</td>
                <td>{{props.item.given_at}}</td>
              </tr>
              <tr v-if="props.item.pivot.grade < 5.5" class="badGrade">
                <td>{{props.item.name}}</td>
                <td>{{props.item.semester}}</td>
                <td>{{props.item.percentage}}</td>
                <td>{{props.item.pivot.grade}}</td>
                <td>{{props.item.retake}}</td>
                <td>{{props.item.given_at}}</td>
              </tr>
            </template>
            <template v-slot:no-results>
              <v-alert
              :value="true"
              color="warning"
              icon="warning"
              >Je zoek opdracht naar "{{search}}", heeft geen resultaten opgeleverd. Zorg dat je ingeschreven bent om je cijfer te kunnen bekijken.</v-alert>
            </template>
          </v-data-table>
          <div class="text-xs-center pt-2">
            <v-pagination v-model="pagination.page" :length="pages"></v-pagination>
          </div>
        </v-card>
      </template>
    </v-container>  
</template>
<script>
import { mapActions, mapGetters, mapState } from 'vuex';
export default {
  props:{
    onDashboard: {
    default: true,
    type: Boolean
    }, 
    isStudent: {
      default: true,
      type: Boolean
    }
  },
  data: () => ({
    search: "",
    pagination: {
      rowsPerPage: 14,
      pages:0
    },
    headers: [
      { text: 'Vak-code', sortable: true, value: "name" },
      { text: 'Periode', sortable: false, value: "semester" },
      { text: 'Percentage', sortable: false, value: "percentage" },
      { text: 'Cijfer', sortable: false, value: "pivot.grade" },
      { text: 'Herkansing', sortable: false, value: "retake" },
      { text: 'Jaar', sortable: false}
    ],
    tests: [],
    filteredGrades: [],
    amountOfItemsOnDisplay: 7,
  }),

  computed: {
    ...mapState("auth", ["auth"]),
    ...mapState("user", ["user"]),
    ...mapState("grades", ["grades"]),
    ...mapGetters("user", ["getUser"]),
    ...mapGetters("grades", ["getGrades", "isLoading", "gradesExist"]),
    
    pages: function() {
      if(this.pagination.rowsPerPage == null || this.pagination.totalItems == null) {
        return 0;
      }
      return Math.ceil(
        this.pagination.totalItems / this.pagination.rowsPerPage
      );
    },
    filteredGradesList: function() {
      this.filteredGrades = this.tests.slice(0, this.amountOfItemsOnDisplay);
      return this.filteredGrades
    }    
  },
  methods: {
    ...mapActions("grades", ["loadGrades"]),
    getGradesFromStore: function() {
      let parameters = {
        userId: this.getUser.id,
        auth: this.auth
      };
      this.loadGrades(parameters);
    }
  },
  watch: {
    grades() {
      this.tests = this.grades
    }
  },
  created() {
    this.getGradesFromStore();
  },
}
</script>
<style lang="scss" scoped>

    .listItem{
      :hover{
        background-color: slategray;
      }
    }

    .cijfers {
        min-height: fit-content;
        background-color: #3c3f5c !important;
        border-radius:10px;
    }

    .v-list {
      background-color: #3c3f5c !important;
    }

    .headline {
      color:white;
    }


</style>

