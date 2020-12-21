<template lang="">
    <layout>
        <div class="bg-green-200 my-6 py-4 px-4 border border-green-300" v-if="$page.flash.success">
            {{$page.flash.success}} afdf
        </div>
        <div v-for="(erro, index) in errors" :key="index" class="bg-red-200 my-6 py-4 px-4 border border-red-300">
            {{erro}}
        </div>
        <form @submit.prevent="handleForm" class="flex">
            <input type="text" placeholder="Name" v-model="form.name" class="w-full py-2 px-4 outline-none">
            <button type="submit" class="flex-shirink-0 ml-4 bg-purple-700 text-white py-2 px-4 hover:bg-purple-800">Save</button>
        </form>
        <table class="border border-purple-300 min-w-full mt-10">
            <thead>
                <tr class="bg-purple-400 text-white">
                    <th class="border border-purple-300 py-4">Id</th>
                    <th class="border border-purple-300 py-4">Name</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="team in teams" :key="team.id" class="border border-purple-300 text-center">
                    <td class="py-4">
                        {{team.id}}
                    </td>
                    <td class="py-4">
                        {{team.name}}
                    </td>
                </tr>
            </tbody>
        </table>
    </layout>
</template>
<script>
import Layout from "../../Layout";
export default {
components: { Layout },
props: {
    teams: Array,
    errors: Object,
},
data: () => {
    return {
        form: {
            name: null,
        }
    }
},
methods: {
    resetFormSuccess(){

    },
    async handleForm(){
        let response = this.$inertia.post('/team', this.form, {
            onSuccess: (res) => {
                if(this.$page.flash.success){
                    console.log('sim');
                    this.form.name = null;
                }else{
                    console.log('nao');
                    console.log(this.errors);
                }
            }
        });
    }
}


}
</script>
<style lang="">

</style>
