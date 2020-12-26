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
                    <tr class="text-center">
                        <th class="border-b-4 border-gray-300 py-8 px-2">Position</th>
                        <th class="border-b-4 border-gray-300 py-8 px-2">Team</th>
                        <th class="border-b-4 border-gray-300 py-8 px-2">Points</th>
                        <th class="border-b-4 border-gray-300 py-8 px-2">Played</th>
                        <th class="border-b-4 border-gray-300 py-8 px-2">Won</th>
                        <th class="border-b-4 border-gray-300 py-8 px-2">Drawn</th>
                        <th class="border-b-4 border-gray-300 py-8 px-2">Lost</th>
                        <th class="border-b-4 border-gray-300 py-8 px-2">GF</th>
                        <th class="border-b-4 border-gray-300 py-8 px-2">GA</th>
                        <th class="border-b-4 border-gray-300 py-8 px-2">GD</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(team, index) of table" :key="team.id" class="text-center">
                        <td class="border-b-2 border-gray-300 py-8 px-2">{{index + 1}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-2">{{team.name}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-2">{{calculatePoints(team.won, team.drawn)}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-2">{{team.played}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-2">{{team.won}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-2">{{team.drawn}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-2">{{team.lost}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-2">{{team.goals_for}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-2">{{team.goals_against}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-2">{{team.goals_for - team.goals_against}}</td>
                    </tr>
                </tbody>
            </table>
            <table class="border-t-2 border-gray-300 mb-8 mt-4">
                <thead>
                    <tr>
                        <td class="border-b-4 border-gray-300 py-4 px-10 text-center" colspan="5">Matches</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(match, index) of matchesOfCurrentRound" :key="match.id">
                        <td class="border-b-2 border-gray-300 py-8 px-10">{{match.team1.name}}</td>
                        <td class="border-b-2 border-gray-300 py-8 px-10">
                            <input @keyup="updateTable()" v-model="rounds[currentRoundIndex].matches[index].goals_team_1" type="text" class="w-8 py-2 text-center rounded-md">
                        </td>
                        <td class="border-b-2 border-gray-300 py-8 px-10 text-gray-400">x</td>
                        <td class="border-b-2 border-gray-300 py-8 px-10">
                            <input @keyup="updateTable()" v-model="rounds[currentRoundIndex].matches[index].goals_team_2" type="text" class="w-8 py-2 text-center rounded-md">
                        </td>
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
        table: [],
    }
},

computed: {
    matchesOfCurrentRound: function(){
        return this.rounds[this.currentRoundIndex].matches;
    },
},
mounted: function(){
    this.updateTable();
},
methods: {
    nextRound(){
        this.updateTable();
        if(this.rounds.length > this.currentRoundIndex + 1){
            this.currentRoundIndex = this.currentRoundIndex + 1;
        }
    },
    prevRound(){
        if(this.currentRoundIndex - 1 >= 0){
            this.currentRoundIndex = this.currentRoundIndex - 1;
        }
    },
    initializeTable(){
        this.table = [];
        this.tournament.teams.forEach(team => {
            this.table = [...this.table, {
                won: 0,
                goals_for: 0,
                goals_against: 0,
                drawn: 0,
                lost: 0,
                played: 0,
                name: team.name,
                id: team.id,
            }];
        });
    },
    updateTable(){
        this.initializeTable();
        this.rounds.forEach(round => {
            round.matches.forEach(match => {
                if(Number.isInteger(parseInt(match.goals_team_1)) && Number.isInteger(parseInt(match.goals_team_2))){
                    this.assignResultToTable(match.team_1_id, match.goals_team_1, match.goals_team_2);
                    this.assignResultToTable(match.team_2_id, match.goals_team_2, match.goals_team_1);
                }
            });
        });
        // map and update table
        this.table = this.table
                .map(team => {
                    team.points = this.calculatePoints(team.won, team.drawn);
                    team.goals_difference = team.goals_for - team.goals_against;
                    return team;
                })
                .sort(function(team1, team2){
                if(team1.points > team2.points){
                    return -1;
                }else if(team1.points < team2.points){
                    return 1;
                }

                if(team1.goals_difference > team2.goals_difference){
                    return -1;
                }else if(team1.goals_difference < team2.goals_difference){
                    return 1;
                }

                if(team1.goals_for > team2.goals_for){
                    return -1;
                }else if(team1.goals_for < team2.goals_for){
                    return 1;
                }

                if(team1.name.toLowerCase() > team2.name.toLowerCase()){
                    // console.log(`${team1.name} - ${team2.name}`);
                    return 1;
                }else if(team1.name < team2.name){
                    // console.log(`${team2.name} - ${team1.name}`);
                    return -1;
                }

                return 0;

            });
    },
    calculatePoints(won, drawn){
        return won * 3 + drawn;
    },
    assignResultToTable(team_id, goals_for, goals_against){
        let won = 0;
        let drawn = 0;
        let lost = 0;
        let played = 1;
        if(goals_for === goals_against){
            drawn = 1;
        }else if(goals_for > goals_against){
            won = 1;
        }else{
            lost = 1;
        }
        this.table = this.table.map(team => {
            if(team.id === team_id){
                team.goals_for = parseInt(team.goals_for) + parseInt(goals_for);
                team.goals_against = parseInt(team.goals_against) + parseInt(goals_against);
                team.won = parseInt(team.won) + parseInt(won);
                team.drawn = parseInt(team.drawn) + parseInt(drawn);
                team.lost = parseInt(team.lost) + parseInt(lost);
                team.played = parseInt(team.played) + parseInt(played);
            }
            return team;
        });
    }
}
}
</script>
<style lang="">

</style>
