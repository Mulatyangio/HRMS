<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    payrolls: {
        type: Array,
        default: () => [],
    },
});

const search = ref('');

const filteredPayrolls = computed(() => {
    if (!search.value) return props.payrolls;

    return props.payrolls.filter((payroll) => {
        const employee =
            `${payroll.employee?.name?? ''}`.toLowerCase();

        return (
            employee.includes(search.value.toLowerCase()) ||
            payroll.employee?.employee_number
                ?.toLowerCase()
                .includes(search.value.toLowerCase())
        );
    });
});

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-KE', {
        style: 'currency',
        currency: 'KES',
    }).format(amount ?? 0);
};
</script>

<template>
    <div class="bg-white rounded-xl shadow border border-gray-200">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 p-6 border-b">

            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Payroll Report
                </h2>

                <p class="text-sm text-gray-500">
                    Employee payroll summary.
                </p>
            </div>

            <input
                v-model="search"
                type="text"
                placeholder="Search employee..."
                class="w-full md:w-72 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
            >
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Employee No.</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase">Basic Salary</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase">Allowances</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase">Deductions</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase">Net Salary</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase">Month</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    <tr
                        v-for="payroll in filteredPayrolls"
                        :key="payroll.id"
                        class="hover:bg-gray-50"
                    >
                        <td class="px-6 py-4">
                          {{ payroll.employee?.name }}
                        </td>

                        <td class="px-6 py-4">
                            {{ payroll.employee?.phone }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            {{ formatCurrency(payroll.basic_salary) }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            {{ formatCurrency(payroll.allowances) }}
                        </td>  {{ payroll.employee?.first_name }}
                            {{ payroll.employee?.last_name }}

                        <td class="px-6 py-4 text-right">
                            {{ formatCurrency(payroll.deductions) }}
                        </td>

                        <td class="px-6 py-4 text-right font-semibold text-green-600">
                            {{ formatCurrency(payroll.net_salary) }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ payroll.payroll_month }}
                        </td>
                    </tr>

                    <tr v-if="filteredPayrolls.length === 0">

                        <td
                            colspan="7"
                            class="text-center py-10 text-gray-500"
                        >
                            No payroll records found.
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>
</template>