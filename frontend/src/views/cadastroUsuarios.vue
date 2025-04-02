<template>
  <div>
    <FormularioCadastro @save="registerUser" mode="cadastro"/>
  </div>
</template>

<script>
import FormularioCadastro from '@/components/FormularioCadastro.vue';

export default {
  components: { FormularioCadastro },
  methods: {
    registerUser(user) {
      console.log('Cadastrando usuário:', user);
    }
  }
};
</script>
