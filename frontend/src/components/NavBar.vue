<template>
    <nav class="navbar">
      <div class="navbar-container">
        <a href="/" class="logo">SUB100 Imóveis</a>
        
        <div class="menu" :class="{ 'open': menuOpen }">
          <a class="menu-item">Quero anunciar</a>
          <a class="menu-item">Dashboard</a>
          <a href="https://blog.sub100sistemas.com.br" target="_blank" class="menu-item">Blog</a>
          <a class="menu-item">Feedback</a>
          <a href="https://sub100sistemas.com.br" target="_blank" class="menu-item">Sobre</a>
          <router-link to="/usuarios" class="menu-item" style="color:#00d39b">Listagem de usuários</router-link>
          <router-link to="/cadastro">
            <button class="btn primary" style="background-color:#4447ed;">Cadastre-se</button>
          </router-link>
          <router-link to="/">
            <button class="btn-secondary">Entrar</button>
          </router-link>
        </div>
      </div>
    </nav>
  </template>
  
  <script>
  export default {
    data() {
      return {
        menuOpen: false,
      };
    },
    methods: {
      toggleMenu() {
        this.menuOpen = !this.menuOpen;
      },
    },
  };
  </script>
  
  <style scoped>

  .navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    padding: 15px 30px;
    z-index: 100;
    font-weight: 500 !important;
    font-size: 14px;
    font-family: 'Poppins', Arial, sans-serif;
  }
  
  .navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
  }
  
  .logo {
    font-size: 1.5rem;
    font-weight: bold;
    color: #4447ed;
    text-decoration: none;
  }
  
  .menu {
    display: flex;
    align-items: center;
    gap: 20px;
  }
  
  .menu-item {
    text-decoration: none;
    color: gray;
    font-size: 1rem;
    transition: color 0.3s ease-in-out;
  }
  
  .menu-item:hover {
    color: #007bff;
  }
  
  .btn {
    padding: 10px 20px;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: 0.3s;
  }
  
  .primary {
    background: #007bff;
    color: white;
  }


  .btn-primary {
    background-color: #4447ed;
    color: #fff;
    padding: 1rem;
    border: none;
    border-radius: 5px;
    width: 20vw;
    cursor: pointer;
  }
  
  .primary:hover {
    background: #0056b3;
  }
  
  .secondary {
    background: transparent;
    border: 2px solid #007bff;
    color: #007bff;
  }
  
  .secondary:hover {
    background: #007bff;
    color: white;
  }
  
  .hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: none;
    border: none;
    cursor: pointer;
  }
  
  .hamburger span {
    width: 30px;
    height: 3px;
    background: #333;
    transition: 0.3s;
  }


.btn-secondary {
    border: 2px solid #4447ed;
    color: #4447ed;
    font-weight: 500 !important;
    font-size: 14px;
    background-color: transparent;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    font-family: 'Poppins', Arial, sans-serif;
}

.btn-secondary:hover {
    background-color: #4447ed;
    color: white;
}

@media (max-width: 768px) {
    .menu {
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
        background: white;
        flex-direction: column;
        align-items: center;
        padding: 20px 0;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-200%);
        transition: transform 0.3s ease-in-out;
    }

    .menu.open {
        transform: translateY(0);
    }

    .hamburger {
        display: flex;
    }

    .hamburger span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .hamburger span:nth-child(2) {
        opacity: 0;
    }

    .hamburger span:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -5px);
    }

    .hamburger.open span:nth-child(1) {
        transform: rotate(0) translate(0, 0);
    }

    .hamburger.open span:nth-child(2) {
        opacity: 1;
    }

    .hamburger.open span:nth-child(3) {
        transform: rotate(0) translate(0, 0);
    }

}
</style>
