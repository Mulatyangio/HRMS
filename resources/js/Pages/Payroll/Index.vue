<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const { payrolls } = defineProps({
    payrolls: {
        type: Array,
        default: () => [],
    },
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'KES',
    }).format(value || 0);
};
</script>

<template>
    <Head title="Payroll" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">Payroll</h2>
                    <p class="mt-1 text-sm text-gray-500">Manage employee salaries and payments.</p>
                </div>
                <Link
                    :href="route('payroll.create')"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500"
                >
                    + New Payroll
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Employee</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Month</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Basic Salary</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Allowances</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Bonus</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Overtime</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Net Salary</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="payroll in payrolls" :key="payroll.id">
                                <td class="px-6 py-4">{{ payroll.employee?.name }}</td>
                                <td class="px-6 py-4">{{ payroll.month }}</td>
                                <td class="px-6 py-4">{{ formatCurrency(payroll.basic_salary) }}</td>
                                <td class="px-6 py-4">{{ formatCurrency(payroll.allowances) }}</td>
                                <td class="px-6 py-4">{{ formatCurrency(payroll.bonus) }}</td>
                                <td class="px-6 py-4">{{ formatCurrency(payroll.overtime) }}</td>
                                <td class="px-6 py-4 font-semibold">{{ formatCurrency(payroll.net_salary) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <Link
                                        :href="route('payroll.show', payroll.id)"
                                        class="mr-2 text-green-600 hover:underline"
                                    >
                                        View
                                    </Link>
                                    <Link
                                        :href="route('payroll.edit', payroll.id)"
                                        class="mr-2 text-indigo-600 hover:underline"
                                    >
                                        Edit
                                    </Link>
                                    <Link
                                        :href="route('payroll.destroy', payroll.id)"
                                        method="delete"
                                        as="button"
                                        class="text-red-600 hover:underline"
                                    >
                                        Delete
                                    </Link>
                                </td>
                            </tr>
                            <tr v-if="payrolls.length === 0">
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    No payroll records found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
