<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, Head } from '@inertiajs/vue3'

defineProps({
    items: Array,
    flash: Object
})
</script>

<template>
    <Head title="商品管理" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品管理</h2>
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
                                <div class="mb-4 flex justify-between w-full">
                                    <div>商品一覧</div>
                                    <Link
                                        as="button"
                                        :href="route('items.create')"
                                        class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                                    >
                                        商品登録
                                    </Link>
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
                                                商品名
                                            </th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                            >
                                                価格
                                            </th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                            >
                                                ステータス
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in items" :key="item.id">
                                            <td class="px-4 py-3">
                                                <Link
                                                    :href="route('items.show', { item: item.id })"
                                                    class="text-blue-500"
                                                >
                                                    {{ item.id }}
                                                </Link>
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ item.name }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ item.price }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <span v-if="item.is_selling">販売中</span>
                                                <span v-if="!item.is_selling">販売停止中</span>
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
