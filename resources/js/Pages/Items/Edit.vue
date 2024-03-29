<script setup>
import InputError from '@/Components/InputError.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({
    item: Object,
    errors: Array
})

const form = reactive({
    name: props.item.name,
    price: props.item.price,
    is_selling: props.item.is_selling,
    memo: props.item.memo
})

const handleSubmit = () => {
    router.put(route(`items.update`, { item: props.item.id }), form)
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品編集</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-12 mx-auto">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <form @submit.prevent="handleSubmit">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-1/2">
                                            <div class="relative">
                                                <label for="name" class="leading-7 text-sm text-gray-600">商品名</label>
                                                <input
                                                    type="text"
                                                    id="name"
                                                    name="name"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    v-model="form.name"
                                                />
                                                <InputError :message="errors.name" />
                                            </div>
                                        </div>
                                        <div class="p-2 w-1/2">
                                            <div class="relative">
                                                <label for="price" class="leading-7 text-sm text-gray-600">価格</label>
                                                <input
                                                    type="number"
                                                    id="price"
                                                    name="price"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    v-model="form.price"
                                                />
                                                <InputError :message="errors.price" />
                                            </div>
                                        </div>
                                        <div class="pl-2">
                                            <label class="leading-7 text-sm text-gray-600">ステータス</label>
                                            <div class="flex items-center gap-4">
                                                <div>
                                                    <input
                                                        id="selling"
                                                        type="radio"
                                                        name="is_selling"
                                                        v-model="form.is_selling"
                                                        value="1"
                                                    />
                                                    <label for="selling" class="leading-7 text-sm text-gray-600 ml-2"
                                                        >販売中</label
                                                    >
                                                </div>
                                                <div>
                                                    <input
                                                        id="stop"
                                                        type="radio"
                                                        name="is_selling"
                                                        v-model="form.is_selling"
                                                        value="0"
                                                    />
                                                    <label for="stop" class="leading-7 text-sm text-gray-600 ml-2"
                                                        >販売停止中</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                                <textarea
                                                    id="memo"
                                                    name="memo"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                                                    v-model="form.memo"
                                                ></textarea>
                                                <InputError :message="errors.memo" />
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <button
                                                type="submit"
                                                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                                            >
                                                更新
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
