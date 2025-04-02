<template>
  <div class="users-list-container">
    <div class="modal-content">
      <div class="title">Lista de usuários</div>

      <!-- Tabela de Usuários -->
      <table class="users-table">
        <thead>
          <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.nome }}</td>
            <td>{{ user.cpf }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.telefone }}</td>
            <td>
              <button @click="editUser(user)" class="btn-outline">Editar</button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Paginação -->
      <div class="pagination">
        <button @click="previousPage" :disabled="currentPage === 1" class="btn-outline">
          <span class="icon">←</span> <!-- Ícone de seta para a esquerda -->
        </button>
        <button @click="nextPage" :disabled="currentPage === totalPages" class="btn-outline">
          <span class="icon">→</span> <!-- Ícone de seta para a direita -->
        </button>
      </div>
    </div>

    <!-- Modal -->
    <ModalCadastro :isOpen="showModal" @close="showModal = false">
      <FormularioCadastro :usuario="selectedUser" @updateUser="handleSave" mode="edicao" />
    </ModalCadastro>
  </div>
</template>

<script>
import ModalCadastro from "@/components/ModalCadastro.vue";
import FormularioCadastro from "@/components/FormularioCadastro.vue";

export default {
  components: {
    ModalCadastro,
    FormularioCadastro
  },
  data() {
    return {
      users: [],
      currentPage: 1,
      totalPages: 1,
      itemsPerPage: 5,
      showModal: false,
      selectedUser: null
    };
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await fetch(`http://localhost:8000/api/users?page=${this.currentPage}`);
        if (!response.ok) throw new Error("Erro na resposta da API");

        const data = await response.json();
        if (data.data) {
          this.users = data.data; // Dados dos usuários da página atual
          this.totalPages = data.last_page; // Total de páginas
        }
      } catch (error) {
        console.error("Erro ao buscar usuários:", error);
      }
    },

    editUser(user) {
      this.selectedUser = { ...user }; // Clona o objeto do usuário
      this.showModal = true;
    },

    handleSave(updatedUser) {
      console.log("Usuário atualizado:", updatedUser);
      // atualizar o usuario que foi editado
      const index = this.users.findIndex(user => user.id === updatedUser.id);
      if (index !== -1) {
        this.users[index] = updatedUser;
        console.log("Usuário atualizado na lista:", this.users[index]);
      }

      // ordenar pelo updated_at
      this.users.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));

    },

    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.fetchUsers(); // Atualiza os usuários
      }
    },

    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
        this.fetchUsers(); // Atualiza os usuários
      }
    }
  },
  created() {
    this.fetchUsers();
  }
};
</script>

<style scoped>
/* Estilos gerais */
body {
  font-family: 'Poppins', Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
}

.title {
  font-size: 20px;
  font-weight: bold;
  color: #4447ed;
  margin-bottom: 2rem;
}

/* Estilo para a listagem de usuários */
.users-list-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh; /* Ajusta para ocupar toda a altura da tela */
  background-color: white;
}

.modal-content {
  background-color: #fff;
  padding: 2rem;
  border-radius: 14px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 100vw; /* Limita a largura */
}

/* Tabela de Usuários */
.users-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.users-table th, .users-table td {
  padding: 12px;
  text-align: left;
  border: 1px solid #ddd;
}

.users-table th {
  background-color: transparent;
  color: #4447ed;
  font-weight: normal;
}

.users-table td {
  background-color: #f9f9f9;
}

.users-table button {
  padding: 5px 10px;
  background-color: #4447ed;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.users-table button:hover {
  background-color: #393beb;
}

/* Paginação */
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.pagination button {
  padding: 8px 15px;
  margin: 0 5px;
  background-color: #4447ed;
  color: white;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  font-size: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
}

.pagination button:disabled {
  background-color: #ccc;
}

.pagination button:hover {
  background-color: #393beb;
}

.pagination .icon {
  font-size: 18px;
}

/* Estilos de ícone para setas */
.icon {
  font-size: 18px;
}
</style>
