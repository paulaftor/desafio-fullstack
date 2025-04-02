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

.modal-overlay {
  position: fixed;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  width: 100%;
  height: 100%;
  top: 0;
}

.modal-container {
  background: white;
  border-radius: 8px;
  width: 80%; 
  max-width: 90%;
  max-height: 85%; 
  position: absolute;
  top: 100px;
  overflow: auto;
}


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
