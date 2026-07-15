<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    attendances: {
        type: Array,
        default: () => [],
    },
    employees: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const filterEmployee = ref(props.filters.employee_id || '');
const filterDateFrom = ref(props.filters.date_from || '');
const filterDateTo = ref(props.filters.date_to || '');

const applyFilters = () => {
    const params = {};
    if (filterEmployee.value) params.employee_id = filterEmployee.value;
    if (filterDateFrom.value) params.date_from = filterDateFrom.value;
    if (filterDateTo.value) params.date_to = filterDateTo.value;
    router.get(route('attendance'), params, { preserveState: true });
};

const clearFilters = () => {
    filterEmployee.value = '';
    filterDateFrom.value = '';
    filterDateTo.value = '';
    router.get(route('attendance'));
};
</script>

<template>
    <Head title="Attendance" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">
                    Attendance Records
                </h2>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl space-y-4">
                <!-- Filters -->
                <div class="rounded-lg bg-white p-4 shadow flex flex-wrap items-end gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                        <select v-model="filterEmployee" class="rounded-lg border-gray-300 text-sm py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Employees</option>
                            <option v-for="emp in employees" :key="emp.id" :value="emp.id">{{ emp.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                        <input v-model="filterDateFrom" type="date" class="rounded-lg border-gray-300 text-sm py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                        <input v-model="filterDateTo" type="date" class="rounded-lg border-gray-300 text-sm py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>
                    <button @click="applyFilters" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Filter</button>
                    <button @click="clearFilters" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Clear</button>
                </div>

                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Employee</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Check In</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Check Out</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="attendance in attendances" :key="attendance.id">
                                <td class="px-6 py-4">{{ attendance.employee?.name }}</td>
                                <td class="px-6 py-4">{{ attendance.date }}</td>
                                <td class="px-6 py-4">{{ attendance.check_in }}</td>
                                <td class="px-6 py-4">{{ attendance.check_out || '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold" :class="{
                                        'bg-green-100 text-green-700': attendance.status === 'Present',
                                        'bg-red-100 text-red-700': attendance.status === 'Absent',
                                        'bg-yellow-100 text-yellow-700': attendance.status === 'Late',
                                        'bg-blue-100 text-blue-700': attendance.status === 'Leave',
                                    }">{{ attendance.status }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <Link :href="route('attendance.edit', attendance.id)" class="mr-2 text-indigo-600 hover:underline">Edit</Link>
                                    <Link :href="route('attendance.show', attendance.id)" class="text-green-600 hover:underline">View</Link>
                                </td>
                            </tr>
                            <tr v-if="attendances.length === 0">
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">No attendance records found.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>