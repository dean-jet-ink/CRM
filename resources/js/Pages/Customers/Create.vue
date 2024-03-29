<script setup>
import InputError from '@/Components/InputError.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { Core as YubinBangoCore } from 'yubinbango-core2'

defineProps({
    errors: Array
})

const form = reactive({
    name: null,
    kana: null,
    tel: null,
    email: null,
    postcode: null,
    address: null,
    birthday: null,
    gender: null,
    memo: null
})

const handleSubmit = () => {
    router.post(route('customers.store'), form)
}

const fetchPostCode = () => {
    new YubinBangoCore(String(form.postcode), value => {
        form.address = value.region + value.locality + value.street
    })
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客登録</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-12 mx-auto">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <!-- 登録フォーム -->
                                <form @submit.prevent="handleSubmit">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="name" class="leading-7 text-sm text-gray-600">顧客名</label>
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
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="kana" class="leading-7 text-sm text-gray-600">カナ</label>
                                                <input
                                                    type="text"
                                                    id="kana"
                                                    name="kana"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    v-model="form.kana"
                                                />
                                                <InputError :message="errors.kana" />
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="tel" class="leading-7 text-sm text-gray-600"
                                                    >電話番号</label
                                                >
                                                <input
                                                    type="tel"
                                                    id="tel"
                                                    name="tel"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    v-model="form.tel"
                                                />
                                                <InputError :message="errors.tel" />
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="email" class="leading-7 text-sm text-gray-600"
                                                    >メールアドレス</label
                                                >
                                                <input
                                                    type="email"
                                                    id="email"
                                                    name="email"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    v-model="form.email"
                                                />
                                                <InputError :message="errors.email" />
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="postcode" class="leading-7 text-sm text-gray-600"
                                                    >郵便番号</label
                                                >
                                                <input
                                                    type="number"
                                                    id="postcode"
                                                    name="postcode"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    @change="fetchPostCode"
                                                    v-model="form.postcode"
                                                />
                                                <InputError :message="errors.postcode" />
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="address" class="leading-7 text-sm text-gray-600"
                                                    >住所</label
                                                >
                                                <input
                                                    type="text"
                                                    id="address"
                                                    name="address"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    v-model="form.address"
                                                />
                                                <InputError :message="errors.address" />
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="price" class="leading-7 text-sm text-gray-600"
                                                    >誕生日</label
                                                >
                                                <input
                                                    type="date"
                                                    id="birthday"
                                                    name="birthday"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    v-model="form.birthday"
                                                />
                                                <InputError :message="errors.birthday" />
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <div>
                                                    <label for="name" class="leading-7 text-sm text-gray-600"
                                                        >性別</label
                                                    >
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <div>
                                                        <input
                                                            id="male"
                                                            type="radio"
                                                            name="gender"
                                                            value="0"
                                                            v-model="form.gender"
                                                        />
                                                        <label for="male"> 男性 </label>
                                                    </div>
                                                    <div>
                                                        <input
                                                            id="female"
                                                            type="radio"
                                                            name="gender"
                                                            value="1"
                                                            v-model="form.gender"
                                                        />
                                                        <label for="female"> 女性 </label>
                                                    </div>
                                                    <div>
                                                        <input
                                                            id="other"
                                                            type="radio"
                                                            name="gender"
                                                            value="2"
                                                            v-model="form.gender"
                                                        />
                                                        <label for="other"> その他 </label>
                                                    </div>
                                                </div>
                                                <InputError :message="errors.gender" />
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
                                                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                                            >
                                                顧客登録
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
