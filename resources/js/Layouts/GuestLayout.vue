<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen flex-col items-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 pt-6 sm:justify-center sm:pt-0">
        <div>
            <Link href="/" class="flex items-center gap-2">
                <ApplicationLogo class="h-10 w-auto" />
                <span class="text-xl font-bold text-indigo-600">HRMS</span>
            </Link>
        </div>

        <div class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-xl sm:border sm:border-gray-200">
            <slot />
        </div>
    </div>
</template>
