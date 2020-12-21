<template lang="">
    <div>
        <div class="grid gri-cols-1 bg-indigo-100 bg-purple-700 text-white px-2 py-4 text-center text-2xl font-semibold font-mono">
            Tabelas
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-12 md:min-h-screen">
            <div class="bg-purple-400 xl:col-span-2">
                <nav class="mx-4 my-4 md:my-6">
                <ul class="flex flex-row md:flex-col text-white">
                    <li class="py-1 px-2 text-purple-700"><inertia-link class="text-gray-300 hover:bg-purple-500 hover:text-white block px-3 py-2 rounded-md text-base font-medium" href="/home">Home</inertia-link></li>
                    <li class="py-1 px-2"><inertia-link class="text-gray-300 hover:bg-purple-500 hover:text-white block px-3 py-2 rounded-md text-base font-medium" href="/team">Teams</inertia-link></li>
                    <li class="py-1 px-2"><inertia-link class="text-gray-300 hover:bg-purple-500 hover:text-white block px-3 py-2 rounded-md text-base font-medium" href="/tournaments">Tournaments</inertia-link></li>
                </ul>
                </nav>
            </div>
            <div class="bg-gray-200 col-span-3 lg:col-span-4 xl:col-span-10 min-h-screen">
                <div class="m-5">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {};
</script>
<style lang="">
</style>
