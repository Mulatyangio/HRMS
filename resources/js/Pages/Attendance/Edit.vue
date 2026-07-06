<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const { attendance, employees } = defineProps({
    attendance: {
        type: Object,
        default: () => ({}),
    },
    employees: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    employee_id: attendance.employee_id,
    date: attendance.date,
    check_in: attendance.check_in,
    check_out: attendance.check_out,
    status: attendance.status,
});

const submit = () => {
    form.put(route('attendance.update', attendance.id));
};
</script>

<template>
    <Head title="Edit Attendance" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Attendance</h2>
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
                            <label class="mb-1 block text-sm font-medium text-gray-700">Date</label>
                            <input
                                v-model="form.date"
                                type="date"
                                class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                                required
                            />
                            <p v-if="form.errors.date" class="mt-1 text-sm text-red-600">{{ form.errors.date }}</p>
                        </div>

                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Check In</label>
                                <input
                                    v-model="form.check_in"
                                    type="time"
                                    class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                                    required
                                />
                                <p v-if="form.errors.check_in" class="mt-1 text-sm text-red-600">{{ form.errors.check_in }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Check Out</label>
                                <input
                                    v-model="form.check_out"
                                    type="time"
                                    class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                                />
                                <p v-if="form.errors.check_out" class="mt-1 text-sm text-red-600">{{ form.errors.check_out }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                            <select
                                v-model="form.status"
                                class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm"
                                required
                            >
                                <option value="Present">Present</option>
                                <option value="Absent">Absent</option>
                                <option value="Late">Late</option>
                            </select>
                            <p v-if="form.errors.status" class="mt-1 text-sm text-red-600">{{ form.errors.status }}</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <button
                                type="submit"
                                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500"
                                :disabled="form.processing"
                            >
                                Update
                            </button>
                            <Link
                                :href="route('attendance')"
                                class="text-sm text-gray-600 hover:text-gray-900"
                            >
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
