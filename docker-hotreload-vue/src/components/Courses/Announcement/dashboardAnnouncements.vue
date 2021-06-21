<template>
    <v-container class="pa-0 ma-0">
        <template>
            <v-card class="pa-0 ma-0 elevation-6">
                <v-card-title class="headline justify-center">
                    Mededelingen
                </v-card-title>
                <v-list class="ma-3 latest_announcements" v-if="this.latestAnnouncements" two-line>
                    <v-hover v-for="(ann, index) in this.latestAnnouncements"  :key="ann.id">
                        <template slot-scope="{ hover }"
                            :class="`elevation-${hover? 12 : 2}`">
                            <router-link :to="{name:'announcement', params:{id: ann.id}}">
                                <v-list-tile class="listItem">
                                    <v-list-tile-content >
                                        <v-list-tile-sub-title>Created at: {{ann.formatted_created_at}}</v-list-tile-sub-title>
                                        <v-list-tile-title class="">{{ann.announcement}}</v-list-tile-title>             
                                    </v-list-tile-content>
                                </v-list-tile>
                                <v-divider v-if="index + 1 < latestAnnouncements.length" :key="`divider-${index}`"></v-divider>
                            </router-link>
                        </template>
                    </v-hover>
                    <v-divider></v-divider>
                </v-list>
            </v-card>
        </template>
    </v-container>
</template>

<script>

import axios from 'axios'
import {mapState} from 'vuex'

export default {
    name: 'dashboardAnnouncements',
    data: () => ({
        dataLoaded: false,
        latestAnnouncements: null,
        amountOfAnnouncements: 10
    }),
    computed: {
        ...mapState("auth", ["auth"])
    },
    watch: {
        $route() {
            this.loadData()
        }
    },
    methods: {
        loadData: function () {
            let self = this;
            self.dataLoaded = false;
            axios
                .get("api/student/announcements/" + self.amountOfAnnouncements, { headers: {Authorization: this.auth}})
                .then(function(response) {
                   self.latestAnnouncements = response.data;
                   self.dataLoaded = true; 
                });
       }
    },



    created() {
        this.loadData();
    }


}
</script>
 <style lang="scss" scoped>
    .listItem{
        :hover{
           background-color: slategray;
        }
    }

    .v-card {
        background-color: #3c3f5c !important;
        border-radius:10px;
        min-height:100%;
        max-height:80vh;
        overflow-y: scroll;
    }

    .latest_announcements {
        background-color:transparent;
    }
 </style>
 