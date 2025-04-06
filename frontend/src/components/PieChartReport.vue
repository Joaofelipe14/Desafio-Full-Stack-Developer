<template>
  <div>
    <h2 class="sub2">{{ title }}</h2>
    <div class="chart-container">
      <Pie :data="processedChartData" :options="chartOptions" />
    </div>
  </div>
</template>

<script>
import { Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);

const DEFAULT_COLORS = [
  '#060321', '#180D6E', '#271580', '#321BDE', '#5946E4', 
  '#7E6FEA', '#9F94EF', '#BD85F4', '#DAD6F9', '#F8F7FD'
];

export default {
  name: 'PieChartReport',
  components: { Pie },
  props: {
    title: {
      type: String,
      required: true
    },
    chartData: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      loading: true,
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: {
            right: 5,
            bottom: 100 // Adiciona espaço entre a legenda e o gráfico
          }
        },
        plugins: {
          legend: {
            position: 'right',
            labels: {
              font: {
                size: 12,
                family: 'Roboto',
                weight: 500,
              },
              color: '#757575',
              usePointStyle: true,
            }
          },
          tooltip: {
            callbacks: {
              label: function (context) {
                const label = context.label || '';
                const value = context.raw || 0;
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const percentage = Math.round((value / total) * 100);
                return `${label}: ${value} (${percentage}%)`;
              }
            }
          }
        }
      }
    };
  },
  computed: {
    processedChartData() {
      if (!this.chartData) return null;
      
      return {
        ...this.chartData,
        datasets: this.chartData.datasets.map(dataset => ({
          ...dataset,
          backgroundColor: DEFAULT_COLORS.slice(0, this.chartData.labels?.length || 0)
        }))
      };
    }
  },
  watch: {
    chartData: {
      handler(newData) {
        if (newData?.labels?.length > 0) {
          this.loading = false;
        }
      },
      immediate: true
    }
  }
};
</script>

<style scoped>
h2{
    margin-bottom: 32px;
}
div {
  max-width: 800px;
}

.chart-container {
  height: 250px; 
  margin-top: 10px;
}

.sub2 {
  text-align: left; 
}
</style>
