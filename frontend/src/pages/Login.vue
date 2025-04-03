<template>
  <section class="container">
    <div class="card">

      <h2> Login </h2>

      <button class="btn-principal ">
        Fazer login com a Huggy
      </button>
      
    </div>
  </section>

</template>

<script lang="ts">
export default {
  name: 'Login',
};
</script>

<style scoped>

.container {
  display: flex;
  flex-direction: column;
  align-content: center;
  justify-content: center;
  flex-wrap: wrap;
  height: 100vh;
}

.card {
  display: flex;
  align-items: center;
  flex-direction: column;
  gap: 24px;


}
</style>