<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const { employees } = defineProps({
    employees: {
        type: Array,
        default: () => [],
    },
});

const search = ref('');

const filteredEmployees = computed(() => {
    if (!search.value.trim()) return employees;
    const term = search.value.toLowerCase();
    return employees.filter(e =>
        e.name.toLowerCase().includes(term) ||
        e.email.toLowerCase().includes(term) ||
        e.department.toLowerCase().includes(term) ||
        e.position.toLowerCase().includes(term)
    );
});
</script>

<template>
    <Head title="Employees" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Employees
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Manage your workforce.
                    </p>
                </div>

                <button
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-500"
                    @click="$inertia.visit(route('employees.create'))"
                >
                    + Add Employee
                </button>
            </div>
        </template>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm mt-4">
            <div class="border-b border-gray-100 px-6 py-4">
                <div class="flex items-center gap-4">
                    <input
                        type="text"
                        v-model="search"
                        placeholder="Search employees..."
                        class="max-w-xs rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                    />

                    <select
                        class="rounded-lg border-gray-200 bg-gray-50 py-2 text-sm"
                    >
                        <option>All Departments</option>
                        <option>Engineering</option>
                        <option>Marketing</option>
                        <option>Finance</option>
                    </select>
                </div>
            </div>

            <!-- TABLE -->
            <div v-if="filteredEmployees.length > 0" class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Department
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Phone
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Position
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr
                            v-for="employee in filteredEmployees"
                            :key="employee.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.name }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.email }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.department }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.phone }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.position }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 text-xs rounded-full font-medium"
                                    :class="{
                                        'bg-green-100 text-green-800': employee.status === 'active',
                                        'bg-yellow-100 text-yellow-800': employee.status === 'on_leave',
                                        'bg-red-100 text-red-800': employee.status === 'inactive',
                                    }"
                                >
                                    {{ employee.status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- NOT FOUND -->
            <div v-else-if="search.trim() && filteredEmployees.length === 0" class="p-6 text-center text-gray-500">
                <p class="text-sm font-medium text-gray-900">
                    Not found
                </p>
                <p class="mt-1 text-sm">
                    No employees match your search.
                </p>
            </div>

            <!-- EMPTY STATE -->
            <div v-else class="p-6 text-center text-gray-500">
                <p class="text-sm font-medium text-gray-900">
                    No employees yet
                </p>
                <p class="mt-1 text-sm">
                    Get started by adding your first employee.
                </p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
