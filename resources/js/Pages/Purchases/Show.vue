<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import { onMounted } from 'vue'

const { items, order } = defineProps({
    items: Array,
    order: Array
})

onMounted(() => {
    console.log('items: ', items)
    console.log('order: ', order)
})
</script>

<template>
    <Head title="購入履歴詳細" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">購入履歴詳細</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-12 mx-auto">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <div class="mb-6">
                                    <label for="customer_id" class="leading-7 text-sm text-gray-600 mr-2">
                                        購入日
                                    </label>
                                    <div>{{ dayjs(order[0].created_at).format('YYYY-MM-DD') }}</div>
                                </div>
                                <div class="mb-6">
                                    <label for="customer_id" class="leading-7 text-sm text-gray-600 mr-2">
                                        顧客名
                                    </label>
                                    <div>{{ order[0].customer_name }}</div>
                                </div>
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                            >
                                                ID
                                            </th>
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
                                        <tr v-for="item in items" :key="item.item_id">
                                            <td class="px-4 py-3">{{ item.item_id }}</td>
                                            <td class="px-4 py-3">{{ item.item_name }}</td>
                                            <td class="px-4 py-3">{{ item.item_price.toLocaleString() }}</td>
                                            <td class="px-4 py-3">{{ item.quantity }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="mt-6">
                                    <label for="customer_id" class="leading-7 text-sm text-gray-600 mr-2">
                                        合計金額
                                    </label>
                                    <div>{{ order[0].total }}</div>
                                </div>

                                <div class="mt-6">
                                    <label for="customer_id" class="leading-7 text-sm text-gray-600 mr-2">
                                        ステータス
                                    </label>
                                    <div v-if="order[0].status === 1">購入</div>
                                    <div v-if="order[0].status === 0">キャンセル</div>
                                </div>

                                <div v-if="order[0].status === 0" class="mt-6">
                                    <label for="customer_id" class="leading-7 text-sm text-gray-600 mr-2">
                                        キャンセル日
                                    </label>
                                    <div>{{ dayjs(order[0].updated_at).format('YYYY-MM-DD') }}</div>
                                </div>

                                <Link
                                    as="button"
                                    :href="route('purchases.edit', { purchase: order[0].id })"
                                    class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                                >
                                    購入履歴編集
                                </Link>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
