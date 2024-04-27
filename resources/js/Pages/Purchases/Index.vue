<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, Head, router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import dayjs from 'dayjs'

defineProps({
    orders: Object,
    flash: Object
})
</script>

<template>
    <Head title="購入履歴" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">購入履歴</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-12 mx-auto">
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <p class="bg-indigo-400 py-2 text-center text-white mb-4" v-if="flash.message">
                                    {{ flash.message }}
                                </p>

                                <!-- 検索フォーム -->
                                <div class="flex items-center justify-center mb-10">
                                    <input
                                        type="text"
                                        class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                        v-model="search"
                                        placeholder="顧客名"
                                    />
                                    <button
                                        @click="handleSearch"
                                        class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                                    >
                                        検索
                                    </button>
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
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                            >
                                                氏名
                                            </th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                            >
                                                合計金額
                                            </th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                            >
                                                ステータス
                                            </th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                            >
                                                購入日
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="order in orders.data" :key="order.id">
                                            <td class="px-4 py-3">
                                                <Link
                                                    :href="route('purchases.show', { purchase: order.id })"
                                                    class="text-blue-500"
                                                >
                                                    {{ order.id }}
                                                </Link>
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ order.customer_name }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ order.total }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ order.status }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ dayjs(order.created_at).format('YYYY-MM-DD HH:mm:ss') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-center mt-6">
                                <Pagination :links="orders.links" />
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
