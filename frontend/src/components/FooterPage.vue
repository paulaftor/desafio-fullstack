<template>
    <footer class="footer">
      <p>© 2025 Desafio fullstack Sub100.</p>
    </footer>
  </template>
  
  <script>
  export default {
    name: "FooterPage",
  };
  </script>
  
  <style scoped>
  .footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    box-shadow: 0px -4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 15px 0;
    font-size: 0.9rem;
    color: gray;
    font-family: 'Poppins', Arial, sans-serif;
  }
  
  @media (max-width: 768px) {
    .footer {
      font-size: 0.8rem;
      padding: 12px 0;
    }
  }
  </style>
  