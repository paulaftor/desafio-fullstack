<template>
  <div>
    <FormularioCadastro @save="registerUser" />
  </div>
</template>

<script>
import FormularioCadastro from '@/components/FormularioCadastro.vue';

export default {
  components: { FormularioCadastro },
  methods: {
    registerUser(user) {
      console.log('Cadastrando usuário:', user);
      // Chamar API para cadastrar
    }
  }
};
</script>
