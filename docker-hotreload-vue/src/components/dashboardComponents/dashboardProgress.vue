<template >
  <v-container class="pa-0 ma-0">
    <v-card class="testing pa-0 ma-0 elevation-6" height="40vh" color="#FFFFFF">
      <v-card-title class="white--text headline justify-center">Voortgang</v-card-title>

      <v-card-text>
        <div class="progress_medium">
          <div class="toprow">
            <!-- 100% / 60 EC = 1.67  -->
            <v-progress-circular
              :rotate="-90"
              :size="120"
              :width="20"
              :value="amountOfECFirstYear * 1.67"
              color="#00ff7f"
              class="toprow"
            >{{amountOfECFirstYear}}</v-progress-circular>
            <p class="text-xs-center">Eerste jaar</p>
          </div>
          <div class="toprow">
            <v-progress-circular
              :rotate="-90"
              :size="120"
              :width="20"
              :value="amountOfECSecondYear * 1.67"
              color="#00ff7f"
              class="toprow"
            >{{amountOfECSecondYear}}</v-progress-circular>
            <p class="text-xs-center">Tweede jaar</p>
          </div>
        </div>
        <div width="fit-content" class="progress_medium">
          <div class="bottom-row" width="40%">
            <v-progress-circular
              :rotate="-90"
              :size="70"
              :width="11"
              :value="amountOfECStage * 1.67 * 2"
              color="#00ff7f"
              class="bottom-row"
            >{{amountOfECStage}}</v-progress-circular>
            <p class="text-xs-center">Stage</p>
          </div>
          <div class="bottom-row" width="40%">
            <v-progress-circular
              :rotate="-90"
              :size="70"
              :width="11"
              :value="amountOfECHoofdfase * 1.67 * 2"
              color="#00ff7f"
              class="bottom-row"
            >{{amountOfECHoofdfase}}</v-progress-circular>
            <p class="text-xs-center">Hoofdfase</p>
          </div>
          <div class="bottom-row" width="40%">
            <v-progress-circular
              :rotate="-90"
              :size="70"
              :width="11"
              :value="amountOfECMinor * 1.67 * 2"
              color="#00ff7f"
              class="bottom-row"
            >{{amountOfECMinor}}</v-progress-circular>
            <p class="text-xs-center">Minor</p>
          </div>
          <div class="bottom-row" width="40%">
            <v-progress-circular
              :rotate="-90"
              :size="70"
              :width="11"
              :value="amountOfECAfstudeerstage * 1.67 * 2"
              color="#00ff7f"
              class="bottom-row"
            >{{amountOfECAfstudeerstage}}</v-progress-circular>
            <p class="text-xs-center progress_medium">Afstudeerstage</p>
          </div>
        </div>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions, mapGetters, mapState } from "vuex";
export default {
  data() {
    return {
      amountOfECFirstYear: 0,
      amountOfECSecondYear: 0,
      amountOfECStage: 0,
      amountOfECMinor: 0,
      amountOfECHoofdfase: 0,
      amountOfECAfstudeerstage: 0
    };
  },
  computed: {
    ...mapState("auth", ["auth"]),
    ...mapState("user", ["user"]),
    ...mapState("grades", ["grades", "progress"]),
    ...mapGetters("user", ["getUser"]),
    ...mapGetters("grades", ["getGrades", "getProgress"])
  },
  methods: {
    ...mapActions('grades', ['loadGrades','loadProgress']),
    getProgressAtStartup: function() {
      let parameters = {
        auth: this.auth
      };
      this.loadGrades(parameters);
      this.loadProgress(parameters);
    },
    ...mapActions("grades", ["loadGrades", "loadProgress"]),
    courseIsDone: function(courseName) {
      var found = this.grades.find(grade => grade.name === courseName);
      if (found && found.grade > 5.4) {
        return 30;
      }
      return 0;
    }
  },
  watch: {
    grades() {
      this.amountOfECMinor = this.courseIsDone("MINOR");
      this.amountOfECStage = this.courseIsDone("STAGE");
      this.amountOfECAfstudeerstage = this.courseIsDone("AF-STAGE");
    },
    progress() {
      this.amountOfECFirstYear = this.progress['1'] || 0;
      this.amountOfECSecondYear = this.progress['2'] || 0;
      this.amountOfECHoofdfase =
        this.progress['3'] -
          this.amountOfECMinor -
          this.amountOfECStage -
          this.amountOfECAfstudeerstage || 0;
    }
  },
  beforeMount() {
    this.getProgressAtStartup();
  }
};
</script>

<style lang="scss" scoped>
.testing {
  min-height: fit-content;
  background-color: #3c3f5c !important;
  border-radius:10px;
}

.toprow {
  margin: 5%;
}
.bottom-row {
  margin: 3%;
  width: 70px;
  display: inline-block;
  word-break: break-all;
  font-size: 15px;
}
.v-progress-circular {
  .text {
    color: white;
  }
}

.progress_medium {
  align-content: center;
  display: flex;
  justify-content: center;
  flex-flow:row wrap;
}

.collective_bot_row {
  display: flex;
  align-content: center;
  flex-wrap: wrap;
}

@media only screen and (min-width: 960px) and (max-width: 1024px) {
  .progress_medium {
        flex-flow: row wrap;
  }
  .bottom-row {
    margin: 1%;
  }
}
</style>
