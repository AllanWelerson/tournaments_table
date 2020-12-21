<template lang="">
    <layout>
        <div class="container mx-auto">
            <div v-for="(erro, index) in errors" :key="index" style="border: 1px solid red;">
                {{erro}}
            </div>
           <form @submit.prevent="handleForm">
                <input type="text" placeholder="nome" v-model="form.name">
                <input type="email"  placeholder="email" v-model="form.email">
                <input type="password"  placeholder="password" v-model="form.password">
                <button type="submit">Cadastrar</button>
           </form>
        </div>
    </layout>
</template>
<script>
import Layout from "../Layout";
export default {
  components: { Layout },
  props: {
      errors: Object,
  },
  data: () => {
    return {
      form: {
        name: null,
        email: null,
        password: null,
      },
    };
  },

    methods: {
        handleForm(){
            this.$inertia.post('/register', this.form)
                .then(res => console.log(res));
        }
    }
};
</script>
<style lang="">
</style>
