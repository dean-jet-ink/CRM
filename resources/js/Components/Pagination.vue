<script setup>
import { Link } from '@inertiajs/vue3'
import { computed, watchEffect } from 'vue'
const { links, queries } = defineProps({
    links: Object,
    queries: {
        type: Array,
        required: false,
        default: () => []
    },
    isInertia: {
        type: Boolean,
        required: false,
        default: true
    }
})

const emit = defineEmits(['update:page'])

const handleChangePage = url => {
    emit('update:page', url)
}
const q = computed(() =>
    queries.reduce((acc, query) => {
        return acc + '&' + query.key + '=' + query.value
    }, '')
)

watchEffect(() => {
    console.log('queries updated', queries)
    // ここで必要な処理を行う
})
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, index) in links" :key="index">
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label"
                />
                <Link
                    v-if="isInertia"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded focus:border-indigo-500 focus:text-indigo-500"
                    :class="{ 'bg-blue-700 text-white': link.active }"
                    :href="link.url + q"
                    v-html="link.label"
                />
                <div
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded focus:border-indigo-500 focus:text-indigo-500 cursor-pointer"
                    :class="{ 'bg-blue-700 text-white': link.active }"
                    @click="() => handleChangePage(link.url + q)"
                    v-html="link.label"
                ></div>
            </template>
        </div>
    </div>
</template>
