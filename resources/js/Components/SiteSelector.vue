<template>
    <vDropdown :distance="10">
        <button class="flex items-center space-x-2 text-sm">
            <span class="text-gray-500 hover:text-gray-700">Select a site</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </button>

        <template #popper="{ hide }">
            <ul class="-space-y-1">
                <li v-for="site in sites" :key="site.id">
                    <Link :href="`/dashboard/${site.id}`" class="px-4 py-2 hover:bg-gray-100 block text-sm text-gray-500 hover:text-gray-700">{{ site.domain }}</Link>
                </li>
                <li>
                    <button v-on:click="showNewSiteModal = true; hide();" class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-indigo-500 font-bold text-sm">Add a site</button>
                </li>
            </ul>
        </template>
    </vDropdown>

    <VueFinalModal v-model="showNewSiteModal" class="flex justify-center items-start pt-16 md:pt-24" content-class="relative max-h-full rounded bg-white w-full max-w-2xl p-4 md:p-6" overlay-class="bg-gradient-to-r from-gray-800 to-gray-500 opacity-50" :esc-to-close="true">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">New site</h2>

        <form v-on:submit.prevent="createSite" class="overflow-hidden space-y-4">
            <InputLabel for="domain" value="Domain" class="sr-only" />
            <TextInput id="domain" type="text" class="block w-full h-9 text-sm" placeholder="e.g. https://codecourse.com" v-model="siteForm.domain" :class="{ 'border-red-500': siteForm.errors.domain }" />
            <InputError class="mt-2" :message="siteForm.errors.domain" />
            <PrimaryButton>
                Add
            </PrimaryButton>

        </form>
    </VueFinalModal>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { VueFinalModal } from 'vue-final-modal'
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputError from '@/Components/InputError.vue'
import { ref } from 'vue'
import 'vue-final-modal/style.css'
import { useForm } from '@inertiajs/vue3'


defineProps({
    sites: Array
})

const showNewSiteModal = ref(false)

const siteForm = useForm({
        domain: null
    })

const createSite = () => {
    siteForm.post('/sites', {
        preserveScroll: true,
        onSuccess: () => {
            siteForm.reset()
            showNewSiteModal.value = false
        }
    })
}

</script>
