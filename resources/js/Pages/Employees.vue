<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Employees" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">Employees</h2>
                    <p class="mt-1 text-sm text-gray-500">Manage your workforce.</p>
                </div>
                <button class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-500">
                    + Add Employee
                </button>
            </div>
        </template>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 px-6 py-4">
                <div class="flex items-center gap-4">
                    <input type="text" placeholder="Search employees..." class="max-w-xs rounded-lg border-gray-200 bg-gray-50 py-2 pl-3 pr-3 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500" />
                    <select class="rounded-lg border-gray-200 bg-gray-50 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option>All Departments</option>
                        <option>Engineering</option>
                        <option>Marketing</option>
                        <option>Finance</option>
                    </select>
                </div>
            </div>
            <div class="p-6 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="mt-4 text-sm font-medium text-gray-900">No employees yet</p>
                <p class="mt-1 text-sm">Get started by adding your first employee.</p>
                <button class="mt-6 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-500">
                    + Add Employee
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
