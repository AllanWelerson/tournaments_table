<template lang="">
    <layout>
        <div class="bg-green-200 my-6 py-4 px-4 border border-green-300" v-if="$page.flash.success">
            {{$page.flash.success}} afdf
        </div>
        <div v-for="(erro, index) in errors" :key="index" class="bg-red-200 my-6 py-4 px-4 border border-red-300">
            {{erro}}
        </div>
        <div v-if="toggleModal"
             class="fixed overflow-x-hidden overflow-y-auto inset-0 flex justify-center items-center z-50">
            <div class="relative  min-w-full flex justify-center item-start">
                <div class="bg-white w-full rounded shadow-2xl flex flex-col max-w-2xl py-4 px-3">
                    <div class="flex flex-row mt-1 mb-4 mr-2 items-center justify-between pb-4 ">
                        <h2 class="text-2xl">{{tournamentTeamsRegister.name}}</h2>
                        <button class="rounded-full bg-purple-500 text-white px-4 py-2" @click="closeModal()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <table class="" v-if="notEmptyObject(teams)">
                        <thead>
                            <tr>
                                <th class="border-b-2 border-purple-400 py-4">Name</th>
                                <th class="border-b-2 border-purple-400 py-4">Add/Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="team in teams.data" :key="team.id" class="border-b-2 border-purple-200 py-4">
                                <td class="py-2 text-center">{{team.name}}</td>
                                <td class="py-2 text-center">
                                    <button @click="addClubToTournament(team.id)" v-if="!inTeamsArrayToRegisterInTournament(team.id)" class="rounded-full bg-green-500 text-white px-2 py-1">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button @click="removeClubFromTournament(team.id)" v-if="inTeamsArrayToRegisterInTournament(team.id)" class="rounded-full bg-red-500 text-white px-2 py-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex flex-row justify-center p-6">
                        <button @click="updateTableTeamsModal(teams.first_page_url)"
                                v-bind:class="{ 'bg-white border-2 border-purple-400 rounded-md': 1 != teams.current_page}"
                                class=" hover:outiline-none text-purple-400 py-1 px-2 m-1"><i class="fas fa-angle-double-left"></i></button>
                        <button @click="updateTableTeamsModal(teams.prev_page_url)"
                                v-bind:class="{ 'bg-white border-2 border-purple-400 rounded-md': teams.prev_page_url != null}"
                                class="hover:outiline-none text-purple-400 py-1 px-2 m-1"><i class="fas fa-angle-left"></i></button>
                        <button class="hover:outiline-none text-purple-400 py-1 px-2 m-1"> {{teams.current_page}}</button>
                        <button @click="updateTableTeamsModal(teams.next_page_url)"
                                v-bind:class="{ 'bg-white border-2 border-purple-400 rounded-md': teams.next_page_url != null}"
                                class="hover:outiline-none text-purple-400 py-1 px-2 m-1"><i class="fas fa-chevron-right"></i></button>
                        <button @click="updateTableTeamsModal(teams.last_page_url)"
                                v-bind:class="{ 'bg-white border-2 border-purple-400 rounded-md': teams.last_page != teams.current_page}"
                                class="hover:outiline-none text-purple-400 py-1 px-2 m-1"><i class="fas fa-angle-double-right"></i></button>
                    </div>
                    <div class="flex flex-row justify-center p-6">
                        <button class="bg-purple-400 hover:bg-purple-600 text-white py-2 px-4 rounded-md" @click="genarateTableTournament()">Gerar Tabela</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="toggleModal"
             class="fixed z-40 inset-0 opacity-25 bg-black">
        </div>
        <form @submit.prevent="handleForm" class="flex">
            <input type="text" placeholder="Name" v-model="form.name" class="w-full py-2 px-4 outline-none">
            <input type="text" placeholder="Edition" v-model="form.edition" class="w-full py-2 px-4 outline-none ml-4">
            <button type="submit" class="flex-shirink-0 ml-4 bg-purple-700 text-white py-2 px-4 hover:bg-purple-800">Save</button>
        </form>
        <table class="border border-purple-300 min-w-full mt-10">
            <thead>
                <tr class="bg-purple-400 text-white">
                    <th class="border border-purple-300 py-4">Id</th>
                    <th class="border border-purple-300 py-4">Name</th>
                    <th class="border border-purple-300 py-4">Edition</th>
                    <th class="border border-purple-300 py-4">Details</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="tournament in tournaments" :key="tournament.id" class="border border-purple-300 text-center">
                    <td class="py-4">
                        {{tournament.id}}
                    </td>
                    <td class="py-4">
                        {{tournament.name}}
                    </td>
                    <td class="py-4">
                        {{tournament.edition}}
                    </td>
                    <td class="py-4">
                        <button class="cursor-pointer rounded-full bg-purple-400 hover:bg-purple-600 text-white px-5 py-3 hover:transform hover:scale-125 outline-none active:outline-none focus:outline-none"
                                @click="openModal(tournament.id)">
                            <i class="fas fa-info"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </layout>
</template>
<script>
import Layout from "../../Layout";
import axios from 'axios';

export default {
components: { Layout },
props: {
    tournaments: Array,
    errors: Object,
},
data: () => {
    return {
        form: {
            name: null,
            edition: null,
        },
        toggleModal: false,
        tournamentTeamsRegister: {
            id: Number,
            teams: Array,
            name: String,
        },
        teams: {},
    }
},
methods: {
    async handleForm(){
        let response = this.$inertia.post('/tournaments', this.form, {
            onSuccess: (res) => {
                if(this.$page.flash.success){
                    this.form.name = null;
                    this.form.edition = null;
                }else{
                }
            }
        })
    },
    async addClubToTournament(clubId){
        axios.post(`http://localhost:8000/api/tournamentClubs/${this.tournamentTeamsRegister.id}`, {clubId})
            //  .then( res => console.log(res));
        this.tournamentTeamsRegister.teams = [...this.tournamentTeamsRegister.teams, clubId];
    },
    removeClubFromTournament(clubId){
        axios.delete(`http://localhost:8000/api/tournamentClubs/${this.tournamentTeamsRegister.id}/${clubId}`)
            //  .then( res => console.log(res));
        this.tournamentTeamsRegister.teams = this.tournamentTeamsRegister.teams.filter(id => clubId != id);
    },
    async openModal(id){
        await this.updateTableTeamsModal(`http://localhost:8000/api/teams`);
        this.tournamentTeamsRegister.teams = [];
        await this.updateTournamentInfo(id);
        this.tournamentTeamsRegister.id = id;
        this.toggleModal = !this.toggleModal;
    },
    closeModal(){
        this.toggleModal = !this.toggleModal;
    },
    inTeamsArrayToRegisterInTournament(id){
        return this.tournamentTeamsRegister.teams.includes(id);
    },
    async updateTableTeamsModal(url = null){
        if(url != null){
            axios.get(url)
                .then(response => {
                this.teams = response.data.teams;
                // console.log('teams', this.teams);
            });
        }
    },
    async genarateTableTournament(){
        let response = this.$inertia.post(`/tournaments/${this.tournamentTeamsRegister.id }/round`, {
            onSuccess: (res) => {
                console.log(res);
            }
        });
    },
    notEmptyObject(somObject){
        return Object.keys(somObject).length;
    },
    async updateTournamentInfo(tournamentId){
        axios.get(`http://localhost:8000/api/tournaments/${tournamentId}`)
             .then(response => {
                 this.tournamentTeamsRegister.name = response.data.tournament.name;
                 this.tournamentTeamsRegister.teams = response.data.tournament.teams
                    .map(tournamentClub => {
                        return tournamentClub.id;
                    });
             });
    }
}
}
</script>
<style lang="">

</style>
