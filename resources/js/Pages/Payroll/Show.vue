<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const { payroll } = defineProps({
    payroll: {
        type: Object,
        default: () => ({}),
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
    <Head title="Payroll Details" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Payroll Details</h2>
                <Link
                    :href="route('payroll.edit', payroll.id)"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500"
                >
                    Edit
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-2xl">
                <div class="rounded-lg bg-white p-6 shadow">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm text-gray-500">Employee</label>
                            <p class="font-medium">{{ payroll.employee?.name }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Month</label>
                            <p class="font-medium">{{ payroll.month }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Basic Salary</label>
                            <p class="font-medium">{{ formatCurrency(payroll.basic_salary) }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Allowances</label>
                            <p class="font-medium">{{ formatCurrency(payroll.allowances) }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Bonus</label>
                            <p class="font-medium">{{ formatCurrency(payroll.bonus) }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Overtime</label>
                            <p class="font-medium">{{ formatCurrency(payroll.overtime) }}</p>
                        </div>
                        <div class="col-span-2 border-t pt-4">
                            <label class="text-sm text-gray-500">Net Salary</label>
                            <p class="text-xl font-bold text-indigo-600">{{ formatCurrency(payroll.net_salary) }}</p>
                        </div>
                        <div v-if="payroll.remarks" class="col-span-2">
                            <label class="text-sm text-gray-500">Remarks</label>
                            <p class="font-medium">{{ payroll.remarks }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <Link
                            :href="route('payroll')"
                            class="text-sm text-gray-600 hover:text-gray-900"
                        >
                            &larr; Back to Payroll
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
