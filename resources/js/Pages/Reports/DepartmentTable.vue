<script setup>
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
        department.name.toLowerCase().includes(search.value.toLowerCase())
    );
});
</script>

<template>
    <div class="bg-white rounded-xl shadow border border-gray-200">

        <!-- Header -->
        <div
            class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 border-b"
        >
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Department Report
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Overview of all company departments.
                </p>
            </div>

            <div class="w-full md:w-80">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search department..."
                    class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            #
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Department
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Manager
                        </th>

                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Employees
                        </th>

                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Status
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    <tr
                        v-for="(department, index) in filteredDepartments"
                        :key="department.id"
                        class="hover:bg-gray-50 transition"
                    >

                        <td class="px-6 py-4">
                            {{ index + 1 }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ department.name }}
                        </td>

                        <td class="px-6 py-4">
                            {{ department.manager?.name ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ department.employees_count ?? department.employees?.length ?? 0 }}
                        </td>

                        <td class="px-6 py-4 text-center">

                            <span
                                class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700"
                            >
                                Active
                            </span>

                        </td>

                    </tr>

                    <tr v-if="filteredDepartments.length === 0">

                        <td
                            colspan="5"
                            class="py-12 text-center text-gray-500"
                        >
                            No departments found.
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>
</template>