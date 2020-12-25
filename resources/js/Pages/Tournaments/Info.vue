<template lang="">
    <layout>
        <div class="bg-green-200 my-6 py-4 px-4 border border-green-300" v-if="$page.flash.success">
            {{$page.flash.success}} afdf
        </div>
        <div v-for="(erro, index) in errors" :key="index" class="bg-red-200 my-6 py-4 px-4 border border-red-300">
            {{erro}}
        </div>
        Teste
    </layout>
</template>
<script>
import Layout from "../../Layout";
import axios from 'axios';

export default {
components: { Layout },
props: {},
data: () => {
    return {}
},
methods: {

}
}
</script>
<style lang="">

</style>
