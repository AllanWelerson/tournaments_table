<template lang="">
    <layout>
        <div class="bg-gray-100">
            Olá eu sou {{user}} na home no vuejs
        </div>
        <div v-if="$page.flash.success" style="border: 1px solid green; margin-top:10px;">
            {{$page.flash.success}}
        </div>
    </layout>
</template>
<script>
import Layout from '../Layout'
export default {
components: {Layout},
props: {
    user: String,
}
}
</script>
<style lang="">

</style>
