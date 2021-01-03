<template lang="">
    <div class="">
        <div class="w-full grid gri-cols-1 bg-indigo-100 bg-purple-700 text-white px-2 py-4 text-center text-2xl font-semibold font-mono">
            App Tournaments Tables
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-12 md:min-h-screen">
            <div class="bg-purple-400 xl:col-span-2 h-full">
                <nav class="mx-4 my-4 md:my-6">
                <ul class="flex flex-row md:flex-col text-white">
                    <li class="py-1 px-2">
                        <inertia-link v-bind:class="(isCurrentURL('team.index')) ? 'bg-purple-500' : ''"
                                      class="text-gray-300 hover:bg-purple-600 hover:text-white block px-3 py-2 rounded-md text-base font-medium" href="/team">Teams</inertia-link></li>
                    <li class="py-1 px-2">
                        <inertia-link v-bind:class="(isCurrentURL('tournament.index')) ? 'bg-purple-500' : ''"
                                      class="text-gray-300 hover:bg-purple-600 hover:text-white block px-3 py-2 rounded-md text-base font-medium" href="/tournaments">Tournaments</inertia-link></li>
                    <li class="py-1 px-2">
                        <form @submit.prevent="logout">
                            <button class="text-gray-300 hover:bg-purple-600 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Logout</button>
                        </form>
                    </li>
                </ul>
                </nav>
            </div>
            <div class="bg-gray-200 col-span-3 lg:col-span-4 xl:col-span-10 min-h-screen overflow-x-scroll">
                <div class="m-5">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
methods:{
    isCurrentURL(urlName){
        return route().current(urlName);
    },
    logout(){
        axios.post(route('logout').url()).then(response => {
            window.location = '/';
        })
    }
}
};
</script>
<style lang="css">
</style>
