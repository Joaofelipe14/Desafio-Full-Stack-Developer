<template>
  <section class="container">
    <div class="card">

      <h1 class="hef-login" @click="redirectToLogin">Login</h1>

      <ButtonComponent label="Fazer login com a Huggy" @click="handleHuggyLogin" />

    </div>
  </section>

</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import AuthService from '../services/authService';
import { useRouter } from 'vue-router';
import ButtonComponent from '../components/ButtonComponent.vue';

export default defineComponent({
  components: {
    ButtonComponent
  },
  setup() {
    const router = useRouter();
    const error = ref<string | null>(null);
    const isAuthenticated = ref(false);

    onMounted(async () => {
      isAuthenticated.value = await AuthService.isAuthenticated();

      const token = AuthService.getQueryParameter('token');
      if (token) {
        console.log('Token encontrado na URL, processando callback');
        AuthService.processHuggyCallback(token);
      }

      if (isAuthenticated.value) {
        console.log('users autenticado')
        router.push('/clients');
      }
    });

    const handleHuggyLogin = async () => {
      try {
        error.value = null;
        const authWindow = await AuthService.loginWithHuggy();

        AuthService.monitorAuthWindow(authWindow, (token) => {
          console.log('Autenticação Huggy bem-sucedida');
          AuthService.saveToken(token);
          isAuthenticated.value = true;
          router.push('/clients');
        });
      } catch (err) {
        error.value = 'Erro ao iniciar autenticação com Huggy';
      }
    };

    // Função de logout
    const logout = () => {
      AuthService.logout();
      isAuthenticated.value = false;
      router.push('/login');
    };

    const redirectToLogin = () => {
      router.push('/login');
    };
    return {
      error,
      handleHuggyLogin,
      logout,
      redirectToLogin
    };
  }
});
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

.hef-login {
  cursor: pointer; 
}

.hef-login:hover {
  text-decoration: underline; 
}

</style>