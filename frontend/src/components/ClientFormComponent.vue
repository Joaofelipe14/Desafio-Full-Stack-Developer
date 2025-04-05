// Then update the component
<template>
  <div class="modal">
    <div class="client-form-modal">
      <div class="header-modal">
        <h2>{{ isEditMode ? 'Editar contato' : 'Cadastrar contato' }}</h2>
      </div>

      <div class="content-modal">
        <InputComponent label="Nome" v-model="formData.name" placeholder="Digite o nome do cliente" type="text"
          :isError="nameError" errorMessage="Nome é obrigatório" required />

        <InputComponent label="Email" v-model="formData.email" placeholder="Digite seu email" type="email"
          :isError="emailError" errorMessage="Email inválido" required />

        <InputComponent label="Celular" v-model="formData.mobile" placeholder="Digite o número de celular" type="tel"
          :isError="mobileError" errorMessage="Celular inválido" required />

        <InputComponent label="Data de Nascimento" v-model="formData.birth_date"
          placeholder="Digite a data de nascimento" type="date" :isError="birthDateError"
          errorMessage="Data inválida" />

        <InputComponent label="Cidade ID" v-model="formData.city_id" placeholder="Digite o ID da cidade" type="number"
          :isError="cityIdError" errorMessage="Cidade inválida" />

        <InputComponent label="Endereço" v-model="formData.address" placeholder="Digite o endereço" type="text"
          :isError="addressError" errorMessage="Endereço inválido" />

        <InputComponent label="Bairro" v-model="formData.neighborhood" placeholder="Digite o bairro" type="text"
          :isError="neighborhoodError" errorMessage="Bairro inválido" />
      </div>

      <div class="footer-modal">
        <ButtonComponent :label="isEditMode ? 'Atualizar' : 'Cadastrar'" @click="handleSubmit" :loading="isLoading" />
        <ButtonComponent label="Cancelar" @click="close" variant="secondary" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, type PropType, ref, watch, computed } from 'vue';
import ButtonComponent from '../components/ButtonComponent.vue';
import InputComponent from '../components/InputComponent.vue';
import type { Client, ClientFormData } from '../types/clients';
import { ClientService } from '../services/clientsService';

export default defineComponent({
  name: 'ClientFormComponent',
  components: {
    InputComponent,
    ButtonComponent
  },
  props: {
    client: {
      type: Object as PropType<Client | null>,
      default: null
    }
  },
  emits: ['close', 'success'],
  setup(props, { emit }) {
    const formData = ref<ClientFormData>({
      name: '',
      mobile: '',
      email: '',
      birth_date: '',
      city_id: null,
      address: null,
      neighborhood: null,

    });

    const isLoading = ref(false);
    const nameError = ref(false);
    const mobileError = ref(false);
    const emailError = ref(false);
    const birthDateError = ref(false);
    const cityIdError = ref(false);
    const addressError = ref(false);
    const neighborhoodError = ref(false);

    const isEditMode = computed(() => !!props.client);


    const resetForm = () => {
      formData.value = {
        name: '',
        mobile: '',
        email: '',
        birth_date: '',
        city_id: null,
        address: null,
        neighborhood: null,

      };
      nameError.value = false;
      mobileError.value = false;
      emailError.value = false;
      birthDateError.value = false;
      cityIdError.value = false;
      addressError.value = false;
      neighborhoodError.value = false;
    };

    watch(() => props.client, (newClient) => {
      if (newClient) {
        formData.value = {
          id: newClient.id,
          name: newClient.name,
          mobile: newClient.mobile,
          email: newClient.email,
          birth_date: newClient.birth_date,
          city_id: newClient.city_id ? Number(newClient.city_id) : null,
          address: newClient.address?.address || null,
          neighborhood: newClient.neighborhood || newClient.address?.neighborhood || null,
        };
      } else {
        resetForm();
      }
    }, { immediate: true });



    const validateForm = () => {
      let isValid = true;

      if (!formData.value.name.trim()) {
        nameError.value = true;
        isValid = false;
      } else {
        nameError.value = false;
      }

      if (!formData.value.mobile.trim() || formData.value.mobile.length < 11) {
        mobileError.value = true;
        isValid = false;
      } else {
        mobileError.value = false;
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!formData.value.email.trim() || !emailRegex.test(formData.value.email)) {
        emailError.value = true;
        isValid = false;
      } else {
        emailError.value = false;
      }

      if (formData.value.birth_date && !isValidDate(formData.value.birth_date)) {
        birthDateError.value = true;
        isValid = false;
      } else {
        birthDateError.value = false;
      }

      return isValid;
    };

    const isValidDate = (dateString: string) => {
      return !isNaN(Date.parse(dateString));
    };

    const handleSubmit = async () => {
      if (!validateForm()) return;

      isLoading.value = true;

      try {
        const payload = {
          ...formData.value,
        };

        if (isEditMode.value && formData.value.id) {
          await ClientService.updateClient(formData.value.id, payload);
        } else {
          await ClientService.createClient(payload);
        }

        emit('success');
        close();
      } catch (error) {
        console.error('Erro ao salvar cliente:', error);
      } finally {
        isLoading.value = false;
      }
    };

    const close = () => {
      emit('close');
    };

    return {
      formData,
      isLoading,
      nameError,
      mobileError,
      emailError,
      birthDateError,
      cityIdError,
      addressError,
      neighborhoodError,
      isEditMode,
      handleSubmit,
      close
    };
  }
});
</script>
<style scoped>
.client-form-modal {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  max-width: 610px;
  width: 100%;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.header-modal {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  flex-direction: row;
  margin-bottom: 20px;
}

.close-button {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
}

.content-modal {
  border-top: 1px solid var(--mine-shaft-30);
  padding-top: 24px;
  gap: 24px;
  display: flex;
  flex-direction: column;
}

.footer-modal {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 24px;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}
</style>