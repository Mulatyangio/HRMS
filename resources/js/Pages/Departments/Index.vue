```vue
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    departments: {
        type: Array,
        default: () => [],
    },
});

const search = ref('');

const filteredDepartments = computed(() => {
    if (!search.value) return props.departments;

    return props.departments.filter((department) =>
        department.name?.toLowerCase().includes(search.value.toLowerCase()) ||
        department.code?.toLowerCase().includes(search.value.toLowerCase()) ||
        department.head?.toLowerCase().includes(search.value.toLowerCase())
    );
});
</script>

<template>
    <Head title="Departments" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Header -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            Departments
                        </h1>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage company departments
                        </p>
                    </div>

                    <Link
                        href="/departments/create"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                    >
                        Add Department
                    </Link>
                </div>

                <!-- Search -->
                <div class="mb-6">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search departments..."
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-500"
                    />
                </div>

                <!-- Table -->
                <div class="overflow-hidden rounded-xl bg-white shadow">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Name
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Code
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Head
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Status
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Created
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr
                                    v-for="department in filteredDepartments"
                                    :key="department.id"
                                >
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ department.name }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ department.code }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ department.head || 'N/A' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span
                                            class="rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800"
                                        >
                                            {{ department.status }}
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                        {{ new Date(department.created_at).toLocaleDateString() }}
                                    </td>
                                </tr>

                                <tr v-if="filteredDepartments.length === 0">
                                    <td
                                        colspan="5"
                                        class="px-6 py-8 text-center text-gray-500"
                                    >
                                        No departments found.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
```
