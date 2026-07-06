<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const { employees } = defineProps({
    employees: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    employee_id: '',
    month: '',
    basic_salary: 0,
    allowances: 0,
    bonus: 0,
    overtime: 0,
    net_salary: 0,
    remarks: '',
});

const netSalary = computed(() => {
    return (parseFloat(form.basic_salary) || 0) +
        (parseFloat(form.allowances) || 0) +
        (parseFloat(form.bonus) || 0) +
        (parseFloat(form.overtime) || 0);
});

const submit = () => {
    form.net_salary = netSalary.value;
    form.post(route('payroll.store'));
};
</script>

<template>
    <Head title="New Payroll" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">New Payroll</h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-2xl">
                <div class="rounded-lg bg-white p-6 shadow">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Employee</label>
                            <select
                                v-model="form.employee_id"
                                class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                                required
                            >
                                <option value="">Select Employee</option>
                                <option v-for="emp in employees" :key="emp.id" :value="emp.id">
                                    {{ emp.name }}
                                </option>
                            </select>
                            <p v-if="form.errors.employee_id" class="mt-1 text-sm text-red-600">{{ form.errors.employee_id }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Month</label>
                            <input
                                v-model="form.month"
                                type="month"
                                class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                                required
                            />
                            <p v-if="form.errors.month" class="mt-1 text-sm text-red-600">{{ form.errors.month }}</p>
                        </div>

                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Basic Salary</label>
                                <input
                                    v-model.number="form.basic_salary"
                                    type="number"
                                    step="0.01"
                                    class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                                    required
                                />
                                <p v-if="form.errors.basic_salary" class="mt-1 text-sm text-red-600">{{ form.errors.basic_salary }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Allowances</label>
                                <input
                                    v-model.number="form.allowances"
                                    type="number"
                                    step="0.01"
                                    class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                                />
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Bonus</label>
                                <input
                                    v-model.number="form.bonus"
                                    type="number"
                                    step="0.01"
                                    class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                                />
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Overtime</label>
                                <input
                                    v-model.number="form.overtime"
                                    type="number"
                                    step="0.01"
                                    class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                                />
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Net Salary (auto-calculated)</label>
                            <input
                                :value="netSalary"
                                type="number"
                                class="w-full rounded-lg border-gray-200 bg-gray-100 py-2 px-3 text-sm font-semibold"
                                readonly
                            />
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea
                                v-model="form.remarks"
                                class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                                rows="2"
                            ></textarea>
                        </div>

                        <div class="flex items-center gap-4">
                            <button
                                type="submit"
                                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500"
                                :disabled="form.processing"
                            >
                                Save
                            </button>
                            <Link :href="route('payroll')" class="text-sm text-gray-600 hover:text-gray-900">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
