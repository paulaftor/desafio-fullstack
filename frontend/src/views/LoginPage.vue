<template>
  <div class="login-container">
    <div class="modal-content">
      <div class="title">Login</div>

      <div class="form-container">
        <form @submit.prevent="login">
          <div class="input-container">
            <label for="email">E-mail</label>
            <input type="email" id="email" v-model="email" placeholder="Digite seu e-mail" />
          </div>

          <div class="input-container">
            <label for="password">Senha</label>
            <input type="password" id="password" v-model="password" placeholder="Digite sua senha" />
          </div>

          <button type="submit" class="btn-primary">Entrar</button>

          <p v-if="errorMessage" class="error-message" style="margin-top:1rem; margin-bottom:0">{{ errorMessage }}</p>
        </form>

        <div class="separator">
          <hr />
          <p>ou</p>
        </div>

        <div class="register-link-container">
          <p>Ainda não possui uma conta? 
            <a href="#" @click="$router.push('/cadastro')">Cadastre-se</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      errorMessage: "",
    };
  },
  methods: {
    async login() {
      // Validação: Campo vazio
      if (!this.email || !this.password) {
        this.errorMessage = "Preencha todos os campos.";
        return;
      }

      // Validação: Formato de e-mail
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(this.email)) {
        this.errorMessage = "E-mail inválido.";
        return;
      }

      try {
        const response = await fetch("http://localhost:8000/api/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
          },
          body: JSON.stringify({
            email: this.email,
            senha: this.password,
          }),
        });

        const data = await response.json();

        if (!response.ok) {
          throw new Error();
        }

        localStorage.setItem("token", data.token);
        this.$router.push("/usuarios");
      } catch (error) {
        this.errorMessage = "E-mail ou senha inválidos.";
      }
    },
  },
};
</script>

<style scoped>
.error-message {
  color: red;
  margin-top: 10px;
}
</style>
