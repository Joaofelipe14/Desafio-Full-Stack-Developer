<template>
  <div class="container">
    <h2>Dados sobre contato</h2>
    <div class="logout" @click="logout">Sair</div>

    <div class="card">
      <div class="header-card">
        <ButtonComponent @click="redirectToClient()" :buttonStyle="'btn-secondary'" :label="'voltar'" :icon="'left'" />
      </div>

      <div class="charts-container">
        <PieChartReport v-if="!loading" title="Segmentação por estado" :chartData="stateChartData" />
        <div v-else class="loading-placeholder">Carregando dados...</div>

        <PieChartReport v-if="!loading" title="Segmentação por cidade" :chartData="cityChartData" />
        <div v-else class="loading-placeholder">Carregando dados...</div>

        <BarChartReport v-if="!loading" title="Segmentação por idade" :chartData="ageChartData" :horizontal="false" />
        <div v-else class="loading-placeholder">Carregando dados...</div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { ref, onMounted } from 'vue';
import PieChartReport from '../components/PieChartReportComponent.vue';
import BarChartReport from '../components/BarChartReportComponent.vue';
import router from '../router';
import ButtonComponent from '../components/ButtonComponent.vue';
import { reportService } from '../services/reportService';

export default {
  components: {
    PieChartReport,
    BarChartReport,
    ButtonComponent
  },
  setup() {
    const cityChartData = ref({
      labels: [] as string[],
      datasets: [{
        data: [] as number[],
      }]
    });

    const stateChartData = ref({
      labels: [] as string[],
      datasets: [{
        data: [] as number[],
      }]
    });

    const ageChartData = ref({
      labels: [] as string[],
      datasets: [{
        label: 'Clientes',
        data: [] as number[],
      }]
    });

    const loading = ref(true);

    const fetchData = async () => {
      try {
        const cityResponse = await reportService.getClientsByCity();
        cityChartData.value = {
          labels: cityResponse.map(item => item.city),
          datasets: [{
            data: cityResponse.map(item => item.total),
          }]
        };

        const stateResponse = await reportService.getClientsByState();
        stateChartData.value = {
          labels: stateResponse.map(item => item.state),
          datasets: [{
            data: stateResponse.map(item => item.total),
          }]
        };

        const ageResponse = await reportService.getClientsByAge();
        ageChartData.value = {
          labels: ageResponse.map(item => item.age_range),
          datasets: [{
            label: 'Clientes',
            data: ageResponse.map(item => item.total),
          }]
        };

      } catch (error) {
        console.error('Erro ao carregar dados:', error);
      } finally {
        loading.value = false;
      }
    };

    const logout = () => {
      console.log('Saindo...');
    };

    const redirectToClient = () => {
      router.push('/reports');
    };

    onMounted(() => {
      fetchData();
    });

    return {
      cityChartData,
      stateChartData,
      ageChartData,
      loading,
      logout,
      redirectToClient
    };
  }
};
</script>

<style scoped>
.container {
  max-width: 930px;
  margin: 20px auto;
}

.card {
  background-color: white;
  border: 1px #E1E1E1 solid;
  border-radius: 1rem;
  box-shadow: 0px 1px 2px 0px #00000026;
  min-height: 90vh;
  padding: 16px;
}


.loading-placeholder {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 200px;
  color: #757575;
}

.logout {
  cursor: pointer;
  top: 10px;
  right: 50%;
  position: absolute;
}

.charts-container{
  display: flex;
  flex-direction: column;
  /* gap: 60px; */
}

.header-card {
  padding: 16px;
}

h2 {
  margin: 1rem 0;
}
</style>