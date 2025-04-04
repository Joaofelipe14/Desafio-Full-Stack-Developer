<template>
  <section class="container">
    <div class="card">

      <h1> Login </h1>

      <ButtonComponent label="Fazer login com a Huggy" @click="handleButtonClick" />

    </div>
  </section>

</template>

<script lang="ts">
import ButtonComponent from '../components/ButtonComponent.vue';

export default {
  components: {
    ButtonComponent,
  },
  methods: {
    handleButtonClick() {
      alert("Botão clicado!");
    },
  },
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