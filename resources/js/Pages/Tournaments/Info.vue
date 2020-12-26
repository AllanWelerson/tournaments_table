<template lang="">
    <layout>
        <div class="bg-green-200 my-6 py-4 px-4 border border-green-300" v-if="$page.flash.success">
            {{$page.flash.success}}
        </div>
        <div v-for="(erro, index) in errors" :key="index" class="bg-red-200 my-6 py-4 px-4 border border-red-300">
            {{erro}}
        </div>
        <div class="flex flex-col justify-center items-center">
            <h1 class="p-6 text-2xl capitalize">{{tournament.name}} - {{tournament.edition}}</h1>

            <table class="border-t-2 border-gray-300 mb-8 mt-4">
                <thead>
                    <tr>
                        <td class="border-b-4 border-gray-300 py-4 px-10 text-center" colspan="5">Matches</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="match of matchesOfCurrentRound" :key="match.id">
                        <td class="border-b-2 border-gray-300 py-8 px-10">{{match.team1.name}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-10">{{match.goals_team_1}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-10 text-gray-400">x</td>
                        <td class="border-b-2 border-gray-300 py-8 px-10">{{match.goals_team_2}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-10">{{match.team2.name}}</td>
                    </tr>
                    <tr class="border-b-4 border-gray-300 mb-8 mt-4">
                        <td class="text-center py-8">
                            <button
                                v-bind:class="(currentRoundIndex > 0) ? 'hover:text-purple-600': 'text-gray-400 cursor-default'"
                                @click="prevRound()" class="focus:outline-none py-4 px-6">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        </td>
                        <td class="text-center py-8" colspan="3">Round {{currentRoundIndex + 1}}</td>
                        <td class="text-center py-8">
                            <button
                                v-bind:class="(rounds.length > currentRoundIndex + 1) ? 'hover:text-purple-600': 'text-gray-400 cursor-default'"
                                @click="nextRound()" class="focus:outline-none py-4 px-6">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </layout>
</template>
<script>
import Layout from "../../Layout";
import axios from 'axios';

export default {
components: { Layout },
props: {
    errors: Object,
    tournament: Object,
    rounds: Array,
},
data: () => {
    return {
        currentRoundIndex: 0,
    }
},
computed: {
    matchesOfCurrentRound: function(){
        return this.rounds[this.currentRoundIndex].matches;
    }
},
methods: {
    nextRound(){
        console.log(this.rounds.length);
        if(this.rounds.length > this.currentRoundIndex + 1){
            this.currentRoundIndex = this.currentRoundIndex + 1;
        }
    },
    prevRound(){
        if(this.currentRoundIndex - 1 >= 0){
            this.currentRoundIndex = this.currentRoundIndex - 1;
        }
    }
}
}
</script>
<style lang="">

</style>
