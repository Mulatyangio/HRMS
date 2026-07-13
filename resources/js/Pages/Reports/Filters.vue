<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
    filters: { type: Object, required: true },
    departments: { type: Array, default: () => [] },
});

function applyFilters() {
    router.get(route('reports'), props.filters, {
        preserveState: true,
        preserveScroll: true,
    });
}

function resetFilters() {
    props.filters.from = '';
    props.filters.to = '';
    props.filters.department = '';
    props.filters.status = '';

    applyFilters();
}
</script>

<template>
    <div class="bg-white rounded-xl shadow border border-gray-200 p-6">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-800">
                Report Filters
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

            <!-- From Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    From Date
                </label>

                <input
                    v-model="filters.from"
                    type="date"
                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <!-- To Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    To Date
                </label>

                <input
                    v-model="filters.to"
                    type="date"
                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <!-- Department -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Department
                </label>

                <select
                    v-model="filters.department"
                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option value="">All Departments</option>
                    <option v-for="dept in departments" :key="dept.name" :value="dept.name">{{ dept.name }}</option>
                </select>
            </div>

            <!-- Attendance Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>

                <select
                    v-model="filters.status"
                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option value="">All</option>
                    <option>Present</option>
                    <option>Absent</option>
                    <option>Late</option>
                    <option>On Leave</option>
                </select>
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-6">

            <button
                @click="resetFilters"
                class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300"
            >
                Reset
            </button>

            <button
                @click="applyFilters"
                class="px-5 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700"
            >
                Apply Filters
            </button>

        </div>

    </div>
</template>
