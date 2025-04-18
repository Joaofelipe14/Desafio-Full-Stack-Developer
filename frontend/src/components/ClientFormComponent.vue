<template>
  <div class="modal">
    <div class="client-form-modal">
      <div class="header-modal">
        <h2>{{ isEditMode ? 'Editar contato' : 'Cadastrar contato' }}</h2>
      </div>

      <div class="content-modal">

        <div class="avatar-upload">
          <div class="avatar-preview" :style="{ backgroundImage: `url(${previewImage || formData.url_perfil})` }">
            <label for="avatar-upload" class="upload-label">
              <span v-if="!previewImage && !formData.url_perfil">+</span>
              <input id="avatar-upload" type="file" accept="image/*" @change="handleImageUpload" class="upload-input" />
            </label>
          </div>
          <p class="avatar-hint">Clique para adicionar foto</p>
        </div>

        <InputComponent label="Nome" v-model="formData.name" placeholder="Digite o nome do cliente" type="text"
          :isError="nameError" errorMessage="Nome é obrigatório" required />

        <div class="row-fields">
          <InputComponent label="Email" v-model="formData.email" placeholder="Digite seu email" type="email"
            :isError="emailError" errorMessage="Email inválido" required />

          <InputComponent label="Celular" v-model="formData.mobile" placeholder="Digite o número de celular" type="tel"
            :isError="mobileError" errorMessage="Celular inválido" required />
        </div>

        <InputComponent label="Data de Nascimento" v-model="formData.birth_date"
          placeholder="Digite a data de nascimento" type="date" :isError="birthDateError"
          errorMessage="Data inválida" />

        <div class="row-fields">
          <InputComponent type="select" label="Estado" v-model="selectedStateId" :options="stateOptions"
            placeholder="Selecione um estado" :isError="stateError" errorMessage="Estado é obrigatório" />

          <InputComponent type="select" label="Cidade" v-model="formData.city_id" :options="cityOptions"
            placeholder="Selecione uma cidade" :disabled="!selectedStateId" :isError="cityError"
            errorMessage="Cidade é obrigatória" />
        </div>

        <div class="row-fields">
          <InputComponent label="Endereço" v-model="formData.address" placeholder="Digite o endereço" type="text"
            :isError="addressError" errorMessage="Endereço inválido" />

          <InputComponent label="Bairro" v-model="formData.neighborhood" placeholder="Digite o bairro" type="text"
            :isError="neighborhoodError" errorMessage="Bairro inválido" />
        </div>
      </div>

      <div class="footer-modal">
        <ButtonComponent label="Cancelar" @click="close" :buttonStyle="'btn-secondary'" />
        <ButtonComponent :label="isEditMode ? 'Atualizar' : 'Salvar'" @click="handleSubmit" :disabled="isLoading" />
      </div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent, type PropType, ref, watch, computed, onMounted } from 'vue';
import ButtonComponent from '../components/ButtonComponent.vue';
import InputComponent from '../components/InputComponent.vue';
import type { Client, ClientFormData } from '../types/clients';
import { ClientService } from '../services/clientService';
import { locationService } from '../services/statesService';
import type { State } from '../types/state';
import { toast } from 'vue3-toastify';

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
      url_perfil: '',
      avatar: null
    });

    const stateOptions = ref<Array<{ value: number, text: string }>>([]);
    const cityOptions = ref<Array<{ value: number, text: string }>>([]);
    const selectedStateId = ref<number | null>(null);
    const isLoading = ref(false);
    const nameError = ref(false);
    const mobileError = ref(false);
    const emailError = ref(false);
    const birthDateError = ref(false);
    const cityError = ref(false);
    const stateError = ref(false);
    const addressError = ref(false);
    const neighborhoodError = ref(false);
    const loadingCities = ref(false);
    const previewImage = ref<string | null>(null);


    const isEditMode = computed(() => !!props.client);

    const loadStates = async () => {
      try {
        const states = await locationService.getStates();
        stateOptions.value = states.map((state: State) => ({
          value: state.id,
          text: `${state.name} (${state.uf})`
        }));
      } catch (error) {
        console.error('Erro ao carregar estados:', error);
      }
    };

    const loadCities = async (stateId: number) => {
      try {
        loadingCities.value = true;
        cityOptions.value = [];
        const cities = await locationService.getCitiesByState(stateId);
        cityOptions.value = cities.map(city => ({
          value: city.id,
          text: city.name
        }));
      } catch (error) {
        console.error('Erro ao carregar cidades:', error);
      } finally {
        loadingCities.value = false;
      }
    };

    const handleImageUpload = (event: Event) => {
      const input = event.target as HTMLInputElement;
      if (input.files && input.files[0]) {
        formData.value.avatar = input.files[0];
        previewImage.value = URL.createObjectURL(input.files[0]);
      }
    };

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
      selectedStateId.value = null;
      nameError.value = false;
      mobileError.value = false;
      emailError.value = false;
      birthDateError.value = false;
      cityError.value = false;
      stateError.value = false;
      addressError.value = false;
      neighborhoodError.value = false;
    };

    watch(() => props.client, async (newClient) => {
      if (newClient) {
        formData.value = {
          id: newClient.id,
          name: newClient.name,
          mobile: newClient.mobile,
          email: newClient.email,
          birth_date: newClient.birth_date,
          city_id: null,
          address: newClient.address?.address || null,
          neighborhood: newClient.neighborhood || newClient.address?.neighborhood || null,
          url_perfil: newClient.url_perfil

        };

        if (newClient.address?.city?.state_id) {
          selectedStateId.value = newClient.address.city.state_id;
          await loadCities(newClient.address.city.state_id);
          formData.value.city_id = newClient.address?.city?.state_id;
        }
      } else {
        resetForm();
      }
    }, { immediate: true });

    watch(selectedStateId, (newStateId) => {
      if (newStateId) {
        loadCities(newStateId);
      } else {
        cityOptions.value = [];
        formData.value.city_id = null;
      }
    });

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

      if (!formData.value.email.trim()) {
        emailError.value = true;
        isValid = false;
      } else {
        emailError.value = false;
      }

      if (!selectedStateId.value) {
        stateError.value = true;
        isValid = false;
      } else {
        stateError.value = false;
      }

      if (!formData.value.city_id) {
        cityError.value = true;
        isValid = false;
      } else {
        cityError.value = false;
      }

      return isValid;
    };



    const handleSubmit = async () => {
      if (!validateForm()) return;

      isLoading.value = true;

      try {
        const payload = {
          ...formData.value,
          state_id: selectedStateId.value
        };
        if (isEditMode.value && formData.value.id) {
          await toast.promise(
            ClientService.updateClient(formData.value.id, payload),
            {
              pending: 'Atualizando cliente...',
              success: 'Cliente atualizado com sucesso!',
              error: 'Erro ao atualizar cliente'
            },
            {
              transition: 'zoom',
              position: 'top-right',
              hideProgressBar: false
            }
          );
        } else {
          await toast.promise(
            ClientService.createClient(payload),
            {
              pending: 'Criando cliente...',
              success: 'Cliente criado com sucesso!',
              error: 'Erro ao criar cliente'
            },
            {
              transition: 'zoom',
              position: 'top-right',
              hideProgressBar: false
            }
          );
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

    onMounted(() => {
      loadStates();
    });

    return {
      formData,
      isLoading,
      nameError,
      mobileError,
      emailError,
      birthDateError,
      cityError,
      stateError,
      addressError,
      neighborhoodError,
      isEditMode,
      handleSubmit,
      close,
      selectedStateId,
      stateOptions,
      cityOptions,
      loadingCities,
      previewImage,
      handleImageUpload
    };
  }
});
</script>

<style scoped>
.client-form-modal {
  background-color: white;
  /* padding: 24px 20px 0px 20px; */
  border-radius: 8px;
  max-width: 610px;
  width: 100%;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.header-modal::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0px;
  right: 0px;
  height: 1px;
  background-color: var(--mine-shaft-30);
}

.header-modal {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  position: relative;
  padding: 24px;
  /* padding-bottom: 20px; */
}

.close-button {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
}

.content-modal {
  /* padding-top: 24px; */
  gap: 24px;
  padding: 24px;
  display: flex;
  flex-direction: column;
}

.row-fields {
  display: flex;
  gap: 16px;
}

.row-fields>* {
  flex: 1;
}

.footer-modal {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  position: relative;
  padding: 16px;
}


.footer-modal::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0px;
  right: 0px;
  height: 1px;
  background-color: var(--mine-shaft-30);
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

.avatar-upload {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.avatar-preview {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: #f0f0f0;
  background-size: cover;
  background-position: center;
  position: relative;
  cursor: pointer;
  border: 2px dashed #ccc;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  color: #666;
}

.upload-label {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.upload-input {
  display: none;
}

.avatar-hint {
  margin-top: 8px;
  font-size: 12px;
  color: #666;
}

@media (max-width: 600px) {
  .row-fields {
    display: flex;
    gap: 16px;
    flex-direction: column;
  }


  .client-form-modal {
    width: 100%;
    height: 100%;
    overflow-y: scroll;
  }
}
</style>