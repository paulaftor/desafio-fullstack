<template>
  <div v-if="isOpen" class="modal-overlay" @click.self="close">
    <div class="modal-container">
      <button class="close-button" @click="close">&times;</button>
      <slot>
        <FormularioCadastro mode="cadastro" />
      </slot>
  </div>
  </div>
</template>

<script>
export default {
  props: {
    isOpen: Boolean
  },
  methods: {
    close() {
      this.$emit("close");
    },
    handleUpdatedUser(updatedUser) {
      this.$emit('updateUser', updatedUser);  
    }
  }
};
</script>

<style scoped>
/* Fundo escurecido do modal */
.modal-overlay {
  position: fixed;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
}

/* Container do modal */
.modal-container {
  background: white;
  border-radius: 8px;
  width: 80%; /* Ajustável conforme necessário */
  max-width: 90%; /* Evita que fique muito grande */
  position: relative; /* Necessário para posicionar o botão de fechar */
}

/* Botão de fechar (X) */
.close-button {
  position: absolute;
  top: 10px;
  right: 15px;
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #333;
}

.close-button:hover {
  color: red;
}
</style>
