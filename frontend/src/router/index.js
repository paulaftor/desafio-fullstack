import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/LoginPage.vue";
import Register from "../views/cadastroUsuarios.vue";
import UserList from "../views/listUsuarios.vue";

const routes = [
  { path: "/", component: Login },
  { path: "/cadastro", component: Register },
  { path: "/usuarios", component: UserList }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
