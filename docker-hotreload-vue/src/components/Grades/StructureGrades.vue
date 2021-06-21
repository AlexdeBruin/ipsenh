<template>
    <v-container>
        <v-card 
        id="grades" 
        class="cijfers pa-0 ma-0 elevation-6" 
        height="86vh" 
        xs12
        >
            <v-card-title class="headline justify-center ma-1" height="80vh">
                Cijfers
            </v-card-title>
            <Grades v-bind:onDashboard="false"></Grades>
        </v-card>
        <!-- <div id="progress"> -->
            <!-- place progress here if it is added -->
        <!-- </div> -->
    </v-container>
</template>

<script>
import Grades from './Grades.vue'

export default {
    components: {
        Grades
    }, 
    Data: {
        return: {
            id: 0
        }
    }
}
</script>

<style lang="scss" scoped>
    template{
        min-height: fit-content;
    }

    .cijfers {
        min-height: fit-content;
    }

    .headline {
        color:white;
    }

    .v-card {
        border-radius: 10px;
        background-color: #3c3f5c;
    }
</style>
