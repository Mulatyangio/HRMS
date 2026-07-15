<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

import { router } from '@inertiajs/vue3';

const { employees, departments, filters } = defineProps({
    employees: {
        type: Object,
        default: () => ({ data: [], links: [], meta: {} }),
    },
    departments: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({ search: '', department: '' }),
    },
});

const search = ref(filters.search);
const selectedDepartment = ref(filters.department);

let timeout = null;
const applyFilters = () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(route('employees'), {
            search: search.value,
            department: selectedDepartment.value,
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    }, 300);
};
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
                        @input="applyFilters"
                        placeholder="Search employees..."
                        class="max-w-xs rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                    />

                    <select
                        v-model="selectedDepartment"
                        @change="applyFilters"
                        class="rounded-lg border-gray-200 bg-gray-50 py-2 text-sm"
                    >
                        <option value="">All Departments</option>
                        <option
                            v-for="dept in departments"
                            :key="dept.id"
                            :value="dept.name"
                        >
                            {{ dept.name }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- TABLE -->
            <div v-if="employees.data.length > 0" class="overflow-x-auto">
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Account
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white">
                        <tr
                            v-for="employee in employees.data"
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 text-xs rounded-full font-medium"
                                    :class="employee.user ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-500'"
                                >
                                    {{ employee.user ? 'Has Login' : 'No Account' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <Link
                                    :href="route('employees.edit', employee.id)"
                                    class="mr-2 text-indigo-600 hover:underline"
                                >
                                    Edit
                                </Link>
                                <Link
                                    :href="route('employees.destroy', employee.id)"
                                    method="delete"
                                    as="button"
                                    class="text-red-600 hover:underline"
                                >
                                    Delete
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div v-if="employees.links?.length > 1" class="flex items-center justify-center gap-1 border-t border-gray-100 px-6 py-4">
                <component
                    :is="link.url ? Link : 'span'"
                    v-for="link in employees.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    class="rounded-lg px-3 py-1.5 text-sm"
                    :class="{
                        'bg-indigo-600 text-white': link.active,
                        'text-gray-600 hover:bg-gray-100': !link.active && link.url,
                        'text-gray-400 cursor-default': !link.url,
                    }"
                    v-html="link.label"
                />
            </div>

            <!-- NOT FOUND -->
            <div v-else-if="search.trim() && employees.data.length === 0" class="p-6 text-center text-gray-500">
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