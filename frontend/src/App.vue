<template>
  <div class="header">
    <NavBar />
  </div>

    <main class="content">
        <router-view />
    </main>

</template>

<script>
import NavBar from "@/components/NavBar.vue";

export default {
  components: {
    NavBar,
  },
};
</script>

<style scoped>

.app-container {
  display: flex;
  flex-direction: column; 
  min-height: 100vh;
}
.content{
  flex: 1;
  padding-left: 30px;
  padding-right: 30px;
}

.header{
  margin-bottom: 100px;
}

footer {
  text-align: center;
  background: #f9f9f9;
  color: #333;
  font-size: 14px;
  padding: 10px;
  height: 50px; 
}


</style>
