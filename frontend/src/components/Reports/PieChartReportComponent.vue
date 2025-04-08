<template>
  <div class="pie-chart-wrapper">
    <h2 class="sub2">{{ title }}</h2>
    <div class="chart-container">
      <Pie :data="processedChartData" :options="dynamicChartOptions" />
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
      isMobile: false,
      baseChartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
          padding: {
            right: 5,
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
              padding: 20
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
    dynamicChartOptions() {
      const options = JSON.parse(JSON.stringify(this.baseChartOptions));
      
      if (this.isMobile) {
        options.plugins.legend.position = 'bottom';
        options.layout.padding.bottom = 100;
      }
      
      return options;
    },
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
  mounted() {
    this.checkScreenSize();
    window.addEventListener('resize', this.checkScreenSize);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.checkScreenSize);
  },
  methods: {
    checkScreenSize() {
      this.isMobile = window.innerWidth <= 756;
    }
  }
};
</script>

<style scoped>
.pie-chart-wrapper {
  max-width: 800px;
}

h2.sub2 {
  text-align: left;
  margin-bottom: 32px;
  padding-left: 40px;
}

.chart-container {
  height: 250px;
  width: calc(100% + 60px);
  margin-left: -60px;
}

@media (max-width: 756px) {
  .chart-container {
    height: 500px; 
    width: 100%;
    margin-left: 0;
  }
  
  h2.sub2 {
    padding-left: 0;
    text-align: center;
  }
}
</style>