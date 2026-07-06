<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const { employee, departments } = defineProps({
    employee: {
        type: Object,
        default: () => ({}),
    },
    departments: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: employee.name,
    email: employee.email,
    phone: employee.phone,
    position: employee.position,
    department: employee.department,
    status: employee.status,
    salary: employee.salary,
    hired_at: employee.hired_at,
});

const submit = () => {
    form.put(route('employees.update', employee.id));
};
</script>

<template>
    <Head title="Edit Employee" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Employee</h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-2xl">
                <div class="rounded-lg bg-white p-6 shadow">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Name</label>
                            <input v-model="form.name" type="text" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm" required />
                            <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                            <input v-model="form.email" type="email" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm" required />
                            <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Phone</label>
                            <input v-model="form.phone" type="text" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm" required />
                            <p v-if="form.errors.phone" class="mt-1 text-sm text-red-600">{{ form.errors.phone }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Position</label>
                            <input v-model="form.position" type="text" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm" required />
                            <p v-if="form.errors.position" class="mt-1 text-sm text-red-600">{{ form.errors.position }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Department</label>
                            <select v-model="form.department" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm" required>
                                <option value="">Select Department</option>
                                <option v-for="dept in departments" :key="dept.id" :value="dept.name">{{ dept.name }}</option>
                            </select>
                            <p v-if="form.errors.department" class="mt-1 text-sm text-red-600">{{ form.errors.department }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                            <select v-model="form.status" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="on_leave">On Leave</option>
                            </select>
                        </div>

                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Salary</label>
                                <input v-model.number="form.salary" type="number" step="0.01" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm" />
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Hired At</label>
                                <input v-model="form.hired_at" type="date" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500" :disabled="form.processing">
                                Update
                            </button>
                            <Link :href="route('employees')" class="text-sm text-gray-600 hover:text-gray-900">Cancel</Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
