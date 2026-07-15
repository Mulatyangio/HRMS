<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="No Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Profile Not Found</h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-lg text-center">
                <div class="rounded-xl border border-gray-200 bg-white p-12 shadow-sm">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900">No Employee Profile</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Your account is not linked to an employee profile. Please contact an administrator to set this up.
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
