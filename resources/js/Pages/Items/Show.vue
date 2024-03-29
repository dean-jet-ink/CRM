<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, Head, router } from '@inertiajs/vue3'
import { nl2br } from '@/util/text'

defineProps({
    item: Object
})

const handleDelete = id => {
    router.delete(route('items.destroy', { item: id }), {
        onBefore: () => confirm('本当に削除しますか？')
    })
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品登録</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-12 mx-auto">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <div class="flex flex-col gap-4 -m-2">
                                    <div class="relative">
                                        <label for="name" class="leading-7 text-sm text-gray-600">商品名</label>
                                        <div
                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                        >
                                            {{ item.name }}
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <label for="price" class="leading-7 text-sm text-gray-600">価格</label>
                                        <div
                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                        >
                                            {{ item.price }}
                                        </div>
                                    </div>
                                    <div v-if="item.is_selling" class="relative">
                                        <label for="price" class="leading-7 text-sm text-gray-600">ステータス</label>
                                        <div
                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                        >
                                            販売中
                                        </div>
                                    </div>
                                    <div v-if="!item.is_selling" class="relative">
                                        <label for="price" class="leading-7 text-sm text-gray-600">ステータス</label>
                                        <div
                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                        >
                                            販売停止中
                                        </div>
                                    </div>
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                            <div
                                                v-html="nl2br(item.memo)"
                                                class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                                            ></div>
                                        </div>
                                    </div>
                                    <div class="p-2 w-full flex items-center">
                                        <Link
                                            as="button"
                                            :href="route('items.edit', { item: item.id })"
                                            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                                        >
                                            編集
                                        </Link>
                                        <button
                                            @click="() => handleDelete(item.id)"
                                            class="flex mx-auto text-white bg-red-400 border-0 py-2 px-8 focus:outline-none hover:bg-red-400 rounded text-lg"
                                        >
                                            削除
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
