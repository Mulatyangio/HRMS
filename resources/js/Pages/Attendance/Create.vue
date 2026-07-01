<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    employees: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    employee_id: '',
    date: '',
    check_in: '',
    check_out: '',
    status: 'Present',
    remarks: '',
});

const submit = () => {
    form.post(route('attendance.store'));
};
</script>

<template>
    <Head title="Record Attendance" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">
                    Record Attendance
                </h2>

                <Link
                    :href="route('attendance')"
                    class="bg-gray-600 text-white px-4 py-2 rounded-lg"
                >
                    Back
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">

                <form @submit.prevent="submit" class="space-y-5">

                    <!-- Employee -->
                    <div>
                        <label class="block mb-2 font-medium">
                            Employee
                        </label>

                        <select
                            v-model="form.employee_id"
                            class="w-full border rounded-lg px-4 py-2"
                        >
                            <option value="">Select Employee</option>

                            <option
                                v-for="employee in employees"
                                :key="employee.id"
                                :value="employee.id"
                            >
                                {{ employee.name }}
                            </option>
                        </select>

                        <p
                            v-if="form.errors.employee_id"
                            class="text-red-600 text-sm mt-1"
                        >
                            {{ form.errors.employee_id }}
                        </p>
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block mb-2 font-medium">
                            Date
                        </label>

                        <input
                            v-model="form.date"
                            type="date"
                            class="w-full border rounded-lg px-4 py-2"
                        />
                    </div>

                    <!-- Check In -->
                    <div>
                        <label class="block mb-2 font-medium">
                            Check In
                        </label>

                        <input
                            v-model="form.check_in"
                            type="time"
                            class="w-full border rounded-lg px-4 py-2"
                        />
                    </div>

                    <!-- Check Out -->
                    <div>
                        <label class="block mb-2 font-medium">
                            Check Out
                        </label>

                        <input
                            v-model="form.check_out"
                            type="time"
                            class="w-full border rounded-lg px-4 py-2"
                        />
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block mb-2 font-medium">
                            Status
                        </label>

                        <select
                            v-model="form.status"
                            class="w-full border rounded-lg px-4 py-2"
                        >
                            <option>Present</option>
                            <option>Absent</option>
                            <option>Late</option>
                            <option>Leave</option>
                        </select>
                    </div>

                    <!-- Remarks -->
                    <div>
                        <label class="block mb-2 font-medium">
                            Remarks
                        </label>

                        <textarea
                            v-model="form.remarks"
                            rows="4"
                            class="w-full border rounded-lg px-4 py-2"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700"
                        @click="submit"
                    >
                        {{ form.processing ? 'Saving...' : 'Save Attendance' }}
                    </button>

                </form>

            </div>
        </div>
    </AuthenticatedLayout>
</template>