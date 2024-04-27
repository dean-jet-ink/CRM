<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { computed, onMounted, reactive, ref } from 'vue'
import dayjs from 'dayjs'

const { order, items } = defineProps({
    order: Array,
    items: Array
})

const form = reactive({
    id: order[0].id,
    customer_id: order[0].customer_id,
    date: dayjs(order[0].created_at).format('YYYY-MM-DD'),
    items: [],
    status: order[0].status
})

const itemList = ref([])

onMounted(() => {
    items.forEach(item => {
        itemList.value.push({
            id: item.id,
            name: item.name,
            price: item.price,
            quantity: item.pivot.quantity
        })
    })

    console.log('order', order)
    console.log('items', items)
})

const quantityList = [0, 1, 2, 3, 4, 5, 6, 7]

const totalPrice = computed(() => {
    const total = itemList.value.reduce((total, item) => total + item.price * item.quantity, 0)

    return total.toLocaleString()
})

const handleSubmit = () => {
    form.items = itemList.value
    console.log(form)
    router.put(route('purchases.update', { purchase: form.id }), form)
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品購入</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-12 mx-auto">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <form @submit.prevent="handleSubmit">
                                    <div class="mb-6">
                                        <label for="customer_id" class="leading-7 text-sm text-gray-600 mr-2">
                                            購入日
                                        </label>
                                        <input type="date" disabled :value="form.date" />
                                    </div>
                                    <div class="mb-6">
                                        <div
                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out cursor-pointer"
                                            @click="handleToggleModal"
                                        >
                                            {{ order[0].customer_name }}
                                        </div>
                                    </div>
                                    <div></div>
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                                >
                                                    商品名
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                                >
                                                    価格
                                                </th>
                                                <th
                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                                >
                                                    数量
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in itemList" :key="item.id">
                                                <td class="px-4 py-3">{{ item.name }}</td>
                                                <td class="px-4 py-3">{{ item.price.toLocaleString() }}</td>
                                                <td class="px-4 py-3">
                                                    <select
                                                        class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10"
                                                        v-model="item.quantity"
                                                    >
                                                        <option v-for="q in quantityList" key="q" :value="q">
                                                            {{ q }}
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="mt-6 flex justify-end">合計金額 {{ totalPrice }}</div>

                                    <div class="mt-6">
                                        <label for="customer_id" class="leading-7 text-sm text-gray-600 mr-2">
                                            ステータス
                                        </label>
                                        <div className="flex items-center gap-2">
                                            <div>
                                                <input type="radio" name="status" v-model="form.status" value="1" />購入
                                            </div>
                                            <div>
                                                <input
                                                    type="radio"
                                                    name="status"
                                                    v-model="form.status"
                                                    value="0"
                                                />キャンセル
                                            </div>
                                        </div>
                                    </div>

                                    <button
                                        class="mt-6 flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                                    >
                                        更新
                                    </button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
