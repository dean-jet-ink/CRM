<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { onMounted, reactive } from 'vue'
import { getToday } from '../util/date'
import axios from 'axios'
import Chart from '@/Components/Chart.vue'

const { flash } = defineProps({
    flash: Object
})

const analysis = reactive({
    data: null,
    dates: null,
    totals: null
})

const form = reactive({
    startDate: null,
    endDate: null,
    duration: null,
    type: null
})

onMounted(() => {
    form.startDate = getToday()
    form.endDate = getToday()
    duration = 'day'
    form.type = 'aggregate'
})

const getData = async () => {
    try {
        const res = await axios.get(route('api.analysis'), {
            params: {
                start_date: form.startDate,
                end_date: form.endDate,
                type: form.type
            }
        })

        console.log(res.data)

        return res.data
    } catch (e) {
        console.log(e.message)
    }
}

const handleSubmit = async () => {
    console.log(form)
    const res = await getData()

    analysis.data = res.data
    analysis.dates = res.dates
    analysis.totals = res.totals
}

const types = [
    {
        value: 'aggregate',
        label: '集計'
    },
    {
        value: 'decile',
        label: 'デシル'
    },
    {
        value: 'rmf',
        label: 'RMF'
    }
]

const durationList = [
    {
        value: 'day',
        label: '日別'
    },
    {
        value: 'month',
        label: '月別'
    },
    {
        value: 'year',
        label: '年別'
    }
]
</script>

<template>
    <Head title="データ分析" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">データ分析</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-12 mx-auto">
                            <p class="bg-indigo-400 py-2 text-center text-white mb-4" v-if="flash.message">
                                {{ flash.message }}
                            </p>

                            <form @submit.prevent="handleSubmit">
                                <div>
                                    <select v-model="analysis.type">
                                        <option v-for="t in types" :value="t.value">{{ t.label }}</option>
                                    </select>
                                </div>
                                <div class="flex items-center gap-8">
                                    <div class="flex items-center gap-2">
                                        <label for="startDate">From:</label>
                                        <input id="startDate" type="date" v-model="form.startDate" />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <label for="endDate">To:</label>
                                        <input id="endDate" type="date" v-model="form.endDate" />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <label for="endDate">タイプ:</label>
                                        <select v-model="form.type">
                                            <option v-for="duration in durations" :value="duration.value">
                                                {{ duration.label }}
                                            </option>
                                        </select>
                                    </div>

                                    <button
                                        class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                                    >
                                        分析
                                    </button>
                                </div>
                            </form>

                            <!-- 分析チャート -->
                            <div v-if="analysis.data && analysis.data.length > 0">
                                <Chart :labels="analysis.dates" :data="analysis.totals" />
                            </div>

                            <div v-if="analysis.data && analysis.data.length > 0" class="mt-6">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                            >
                                                年月日
                                            </th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                            >
                                                金額
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="data in analysis.data" :key="data.date">
                                            <td class="px-4 py-3">
                                                {{ data.date }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ data.total }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
