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
                        <h2 class="text-2xl">New Tournament</h2>
                        <button class="rounded-full bg-purple-500 text-white px-4 py-2" @click="closeModal()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="flex mb-6">
                        <input type="text" placeholder="Name" v-model="tournamentTeamsRegister.name" class="w-full py-2 px-4 outline-none border-b-2 border-transparent focus:border-purple-400  text-center transition duration-500 ease-in-out">
                        <input type="text" placeholder="Edition" v-model="tournamentTeamsRegister.edition" class="w-full py-2 px-4 outline-none ml-4 border-b-2 border-transparent focus:border-purple-400  text-center transition duration-500 ease-in-out">
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
                            <tr v-if="!teams.data.length">
                                <td colspan="2" class="py-6 text-center">There are no registered teams</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex flex-row justify-center p-6">
                        <button @click="updateTableTeamsModal(teams.first_page_url)"
                                v-bind:class="{ 'bg-white border-2 border-purple-400 rounded-md': 1 != teams.current_page}"
                                class=" focues:outline-none text-purple-400 py-1 px-2 m-1"><i class="fas fa-angle-double-left"></i></button>
                        <button @click="updateTableTeamsModal(teams.prev_page_url)"
                                v-bind:class="{ 'bg-white border-2 border-purple-400 rounded-md': teams.prev_page_url != null}"
                                class="focues:outline-none text-purple-400 py-1 px-2 m-1"><i class="fas fa-angle-left"></i></button>
                        <button class="focues:outline-none text-purple-400 py-1 px-2 m-1"> {{teams.current_page}}</button>
                        <button @click="updateTableTeamsModal(teams.next_page_url)"
                                v-bind:class="{ 'bg-white border-2 border-purple-400 rounded-md': teams.next_page_url != null}"
                                class="focues:outline-none text-purple-400 py-1 px-2 m-1"><i class="fas fa-chevron-right"></i></button>
                        <button @click="updateTableTeamsModal(teams.last_page_url)"
                                v-bind:class="{ 'bg-white border-2 border-purple-400 rounded-md': teams.last_page != teams.current_page}"
                                class="focues:outline-none text-purple-400 py-1 px-2 m-1"><i class="fas fa-angle-double-right"></i></button>
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
        <div class="flex flex-row justify-end">
            <button @click="openModal()" type="submit" class="flex-shirink-0 ml-4 bg-purple-700 text-white py-2 px-4 hover:bg-purple-800">New Tournament</button>
        </div>
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
                        <inertia-link v-bind:href="'/tournaments/' + tournament.id"
                                class="cursor-pointer rounded-full bg-purple-400 hover:bg-purple-600 text-white px-5 py-3 hover:transform hover:scale-125 outline-none active:outline-none focus:outline-none"
                                title="">
                            <i class="fas fa-info"></i>
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="!tournaments.length">
                    <td colspan="4" class="py-6 text-center">There are no registered tournaments</td>
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
            teams: [],
            name: '',
            edition: '',
        },
        teams: {},
    }
},
methods: {
    async addClubToTournament(clubId){
        this.tournamentTeamsRegister.teams = [...this.tournamentTeamsRegister.teams, clubId];
    },
    removeClubFromTournament(clubId){
        this.tournamentTeamsRegister.teams = this.tournamentTeamsRegister.teams.filter(id => clubId != id);
    },
    async openModal(id){
        await this.updateTableTeamsModal(route('teams.index.ajax').url());
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
            });
        }
    },
    async genarateTableTournament(){
        let response = this.$inertia.post(route('tournament.store').url(), this.tournamentTeamsRegister, {
            onSuccess: (res) => {
                console.log(res);
            }
        });
    },
    notEmptyObject(somObject){
        return Object.keys(somObject).length;
    },
}
}
</script>
<style lang="">

</style>
