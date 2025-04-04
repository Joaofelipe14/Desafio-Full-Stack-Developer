<script>
import InputComponent from '../components/InputComponent.vue';


export default {
  components: {
    InputComponent,
  },
  data() {
    return {
      textValue: "",
      searchValue: "",
      // inputState: "inactive",
      // searchState: "inactive",
      errorMessage: "Campo obrigatório!",
    };
  },
};
</script>

<template>
  <div>
    <InputComponent 
      v-model="inputValue" 
      placeholder="Digite seu nome" 
      :state="error" 
      :errorMessage="errorMessage" 
    />
  </div>
</template>

