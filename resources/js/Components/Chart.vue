<script setup>
import { Chart, registerables } from 'chart.js'
import { BarChart } from 'vue-chart-3'
import { computed, reactive } from 'vue'

Chart.register(...registerables)

const props = defineProps({
    labels: {
        type: Array,
        defaultValue: []
    },
    data: {
        type: Array,
        defalutValue: []
    }
})

const l = computed(() => props.labels)
const d = computed(() => props.data)

const barData = reactive({
    labels: l,
    datasets: [
        {
            label: '売上',
            data: d,
            backgroundColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }
    ]
})
</script>

<template>
    <div>
        <BarChart :chartData="barData" />
    </div>
</template>
