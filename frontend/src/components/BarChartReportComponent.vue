<template>
    <div>
        <h2 class="sub2">{{ title }}</h2>
        <div>
            <Bar :data="processedChartData" :options="chartOptions" />
        </div>
    </div>
</template>

<script>
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const DEFAULT_COLORS = [
    '#060321', '#180D6E', '#271580', '#321BDE', '#5946E4',
    '#7E6FEA', '#9F94EF', '#BD85F4', '#DAD6F9', '#F8F7FD'
];

export default {
    name: 'BarChartReport',
    components: { Bar },
    props: {
        title: {
            type: String,
            required: true
        },
        chartData: {
            type: Object,
            required: true
        },
        horizontal: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            loading: true,
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: this.horizontal ? 'y' : 'x',
                layout: {
                    padding: {
                        right: 5
                    }
                },
                plugins: {
                    legend: {
                        display: false 
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const label = context.dataset.label || '';
                                const value = context.raw || 0;
                                return `${label}: ${value}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#757575'
                        }
                    },
                    y: {
                        grid: {
                            color: '#E0E0E0',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#757575'
                        },
                        beginAtZero: true
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
                datasets: this.chartData.datasets.map((dataset, index) => ({
                    ...dataset,
                    backgroundColor: DEFAULT_COLORS.slice(0, dataset.data.length),
                    borderColor: DEFAULT_COLORS.slice(0, dataset.data.length),
                    borderWidth: 1,
                    borderRadius: 5
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
        },
        horizontal(newValue) {
            this.chartOptions.indexAxis = newValue ? 'y' : 'x';
        }
    }
};
</script>

<style scoped>
h2{
    margin-bottom: 32px;
}
</style>