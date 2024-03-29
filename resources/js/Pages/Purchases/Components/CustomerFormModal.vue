<script setup>
import Modal from '@/Components/Modal.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link } from '@inertiajs/vue3'
import axios from 'axios'
import { reactive, ref } from 'vue'
import Close from 'vue-material-design-icons/Close.vue'

const { show, close } = defineProps({
    show: {
        type: Boolean,
        required: true
    },
    close: {
        type: Function,
        required: true
    }
})

const search = ref('')
const customers = reactive({
    data: null,
    links: {}
})

const emit = defineEmits(['update:customer'])

const handleSelectCustomer = customer => {
    emit('update:customer', customer)
    close()
}

const handleSearchCustomers = async () => {
    try {
        const { data } = await axios.get(`/api/customers?search=${search.value}&per_page=10`)
        customers.data = data.data
        customers.links = data.links
        console.log(data)
    } catch (e) {
        console.log(e)
    }
}

const handleChangePage = async url => {
    try {
        const { data } = await axios.get(url)
        customers.data = data.data
        customers.links = data.links
        console.log(data)
    } catch (e) {
        console.log(e)
    }
}
</script>

<template>
    <Modal :show="show" @close="close">
        <div class="p-6">
            <div class="flex justify-end">
                <Close class="cursor-pointer" @click="close" />
            </div>
            <div class="mt-8">
                <div class="flex items-center justify-center mb-10">
                    <input
                        type="text"
                        class="w-2/3 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                        v-model="search"
                        placeholder="顧客名(かな、カナ)または電話番号"
                    />
                    <button
                        @click="handleSearchCustomers"
                        class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
                    >
                        検索
                    </button>
                </div>
                <table v-if="customers.data?.length > 0" class="table-auto w-full text-left whitespace-no-wrap">
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
                                カナ
                            </th>
                            <th
                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                            >
                                電話番号
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in customers.data" :key="customer.id" className="border-b">
                            <td class="px-4 py-3">
                                <Link as="button" class="text-blue-500" @click="() => handleSelectCustomer(customer)">{{
                                    customer.id
                                }}</Link>
                            </td>
                            <td class="px-4 py-3">
                                {{ customer.name }}
                            </td>
                            <td class="px-4 py-3">
                                {{ customer.kana }}
                            </td>
                            <td class="px-4 py-3">
                                {{ customer.tel }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="customers.data && customers.data?.length === 0" class="w-fit m-auto">
                    顧客が見つかりませんでした
                </div>
                <div class="flex justify-center mt-6">
                    <Pagination
                        :links="customers.links"
                        :queries="[{ key: 'search', value: search }]"
                        :isInertia="false"
                        @update:page="handleChangePage"
                    />
                </div>
            </div>
        </div>
    </Modal>
</template>
