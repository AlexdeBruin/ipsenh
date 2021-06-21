<template>
    <v-container grid-list-md>
        <v-layout row wrap align-space-around>
            <v-flex xs12>
                <v-card class="elevation-6">
                    <v-card-text class="px-0">
                        <router-link :to="{name : 'courses'}">
                            <h1 class="headline pa-2 text-xs-left">
                                <v-icon large>keyboard_arrow_left</v-icon>
                                Terug naar alle cursussen
                            </h1>
                        </router-link>
                    </v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs12>
                <v-card class="elevation-6 pb-4">
                    <v-card-title primary-title>
                        <h1>Mededelingen</h1>
                    </v-card-title>
                    <template v-if="announcements">
                        <v-container row wrap align-space-around>
                            <v-layout row wrap>
                                <v-flex xs6 v-for="announcement in announcements"
                                            v-bind:key="announcement.id">
                                    <router-link :to="{name : 'announcement', params: {id: announcement.id}}">
                                        <v-hover>
                                            <v-card slot-scope="{ hover }"
                                                    :class="`elevation-${hover ? 12 : 2}`">
                                                <v-card-title primary-title>
                                                    <span class="grey--text">Gepubliceerd op {{announcement.formatted_created_at}}</span>
                                                </v-card-title>
                                                <v-card-text>
                                                    <span class="text-xs-left">{{announcement.announcement}}</span>
                                                </v-card-text>
                                            </v-card>
                                        </v-hover>
                                    </router-link>
                                </v-flex>

                            </v-layout>
                        </v-container>
                    </template>
                    <template v-else>
                        <half-circle-spinner class="spinner"
                                             :animation-duration="1000"
                                             :size="60"
                                             color="#ff1d5e"/>
                    </template>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import axios from "axios";
    import {HalfCircleSpinner} from 'epic-spinners';
    import {mapState} from "vuex";

    export default {
        name: "CourseInfo",
        props: [],
        components: {
            HalfCircleSpinner
        },

        data: () => ({
            course: null,
            announcements: null
        }),
        computed: {
            ...mapState("auth", ["auth"])
        },
        created() {
            axios
                .get("api/courses/" + this.$route.params.id, { headers: {Authorization: this.auth} })
                .then(response => (this.course = response.data));
            axios
                .get("api/courses/announcements/" + this.$route.params.id, { headers: {Authorization: this.auth} })
                .then(response => (this.announcements = response.data));
        },
    }
</script>

<style scoped lang="scss">
    .half-circle-spinner {
        margin: auto;
    }
    .v-card {
        background-color: #3c3f5c !important;
        border-radius:10px;
    }
</style>