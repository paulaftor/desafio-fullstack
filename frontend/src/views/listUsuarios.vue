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
            <td>{{ user.name }}</td>
            <td>{{ user.cpf }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.telefone }}</td>
            <td>
              <button @click="editUser(user)" class="btn-outline">Editar</button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Paginacao -->
      <div class="pagination">
        <button @click="previousPage" :disabled="currentPage === 1" class="btn-outline">Anterior</button>
        <button @click="nextPage" :disabled="currentPage === totalPages" class="btn-outline">Próximo</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [], // Armazena os usuários
      currentPage: 1, // Página atual
      totalPages: 1, // Total de páginas para a paginação
      itemsPerPage: 5, // Número de usuários por página
    };
  },
  computed: {
    paginatedUsers() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.users.slice(start, end);
    },
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await fetch("http://localhost:8000/api/users", {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
          },
        });

        if (!response.ok) {
          // Verifica se a resposta não foi bem-sucedida
          console.error("Erro na resposta da API:", response.statusText);
          return;
        }

        const data = await response.json();

        // Verifica se a resposta está no formato esperado
        if (data && data.success) {
          this.users = data.users;
          this.totalPages = Math.ceil(this.users.length / this.itemsPerPage); // Calcula o número de páginas
        } else {
          // Caso o formato da resposta não seja o esperado
          console.error("Erro ao buscar os usuários:", data);
        }
      } catch (error) {
        // Log de erro mais detalhado
        console.error("Erro na requisição:", error);
      }
    },

    editUser(user) {
      console.log(`Editar usuário ${user.id}`);
      // Lógica para editar o usuário
    },

    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },

    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
  },
  created() {
    this.fetchUsers(); // Buscar os usuários quando o componente for criado
  },
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
  padding: 20px;
}

.modal-content {
  background-color: #fff;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 1000px; /* Ajustado para ocupar mais a tela */
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
  background-color: transparent; /* Fundo transparente */
  color: #4447ed; /* Cor roxa no texto */
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
  padding: 10px 20px;
  margin: 0 5px;
  background-color: #4447ed;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.pagination button:disabled {
  background-color: #ccc;
}

.pagination button:hover {
  background-color: #393beb;
}
</style>
