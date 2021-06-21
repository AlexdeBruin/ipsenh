<template>
  <v-dialog v-model="dialog" max-width="500px">
    <v-card>
      <v-card-title class="headline">
        <template v-if="!loading">{{title}}</template>
        <template v-if="loading">
          <v-progress-circular indeterminate color="red"></v-progress-circular>
          &nbsp;{{loadingText}}
        </template>
      </v-card-title>

      <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn @click="dialogAction()" color="green darken-1" flat="flat">{{buttonText}}</v-btn>

        <v-btn id="cancleButton" color="red darken-1" flat="flat" @click="toggle()">Annuleren</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "Confirmation",
  data: function() {
    return {
      loading: false,
      dialog: this.showDialog
    };
  },
  props: {
    // Function must return a Promise in order to work.
    method: { type: Function },
    buttonText: {
      type: String,
      required: true
    },
    title: {
      type: String,
      required: true
    },
    loadingText: {
      type: String,
      required: true
    },
    showDialog: {
      type: Boolean,
      default: false,
      required: true
    }
  },
  methods: {
    toggle() {
      this.dialog = false;
      this.$emit("toggle-dialog");
    },
    dialogAction() {
      this.loading = true;
      this.method()
        .then(() => {
          this.loading = false;
          this.toggle();
        })
        .catch(() => {
          this.loading = false;
          this.toggle();
        });
    }
  },
  watch: {
    showDialog: function(newVal, oldVal) {
      this.dialog = newVal;
    }
  }
};
</script>

<style lang="scss" scoped>
</style>