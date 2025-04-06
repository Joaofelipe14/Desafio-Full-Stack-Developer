<template>
  <section class="container">
    <div class="card">  
      <span>
        <img class="icon-sair" title="voltar para home" @click="redirectToLogin" src="../assets/icons/left.svg" alt="">
      </span>
      <h1> Entre na sua conta </h1>

      <form @submit.prevent="handleLogin">

        <InputComponent label="Email" v-model="email" placeholder="Digite seu email" type="email" :isError="emailError"
          errorMessage="Email inválido" required />
        <InputComponent label="Senha" v-model="password" placeholder="Digite sua senha" type="password"
          :isError="passwordError" errorMessage="Senha inválida" required />

        <div class="footer-card">
          <ButtonComponent label="Fazer login" type="submit" />
          <h3>Cadastra-se</h3>
        </div>
      </form>

    </div>
  </section>
</template>

<script lang="ts">
import { ref } from 'vue';
import ButtonComponent from '../components/ButtonComponent.vue';
import InputComponent from '../components/InputComponent.vue';
import { AuthService } from '../services/authService';
import { useRouter } from 'vue-router';

export default {
  components: {
    ButtonComponent,
    InputComponent
  },
  setup() {
    const email = ref('');
    const password = ref('');
    const emailError = ref(false);
    const passwordError = ref(false);
    const router = useRouter();



    const handleLogin = async () => {
      emailError.value = !email.value;
      passwordError.value = !password.value;

      if (emailError.value || passwordError.value) {
        console.log('Erro: Campos inválidos');
        return;
      }

      try {
        const loginData = { email: email.value, password: password.value };
        const response = await AuthService.login(loginData);
        router.push('/clients');

        if(response.user){
          alert(response.token)
        }
      } catch (error: any) {
        console.log('Erro no login:', error.message);
        alert(error.message)
      }
    };

    const redirectToLogin = () => {
      router.push('/home');
    };

    return {
      email,
      password,
      emailError,
      passwordError,
      redirectToLogin,
      handleLogin,
    };
  },
};
</script>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
}

.icon-sair {
  position: absolute;
  top: 15px;
  left: 15px;
  width: 15px;
  height: 15px;
  cursor: pointer;
}

.icon-sair:hover{
  transform: scale(1.1);
}
.card {
  display: flex;
  align-items: center;
  flex-direction: column;
  gap: 24px;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  background-color: #fff;
  min-width: 400px;
  position: relative;
}

form {
  width: 100%;
  gap: 10px;
  display: flex;
  flex-direction: column;
}

.footer-card {
  margin-top: 10px;
  display: flex;
  flex-direction: row;
  width: 100%;
  align-items: center;
  justify-content: space-between;
}
</style>
