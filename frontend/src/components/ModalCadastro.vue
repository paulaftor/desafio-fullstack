<template>
    <div v-if="isOpen" class="modal-overlay" @click.self="close">
      <div class="modal-container">
        <slot></slot> <!-- Aqui vai o conteúdo do modal -->
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
      }
    }
  };
  </script>
  
  <style scoped>
 .modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-container {
  background: white;
  padding: 10px;
  border-radius: 8px;
  width: 100%; /* A largura agora ocupa 80% da tela */
  overflow-y: auto; /* Adiciona rolagem no caso de conteúdo muito longo */
  box-sizing: border-box;
}
  </style>
  