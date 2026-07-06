<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const { leave } = defineProps({
    leave: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    employee_id: leave.employee_id,
    type: leave.type,
    start_date: leave.start_date,
    end_date: leave.end_date,
    reason: leave.reason || '',
});

const submit = () => {
    form.put(route('leaves.update', leave.id));
};
</script>

<template>
    <Head title="Edit Leave Request" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Leave Request</h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-2xl">
                <div class="rounded-lg bg-white p-6 shadow">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Leave Type</label>
                            <select v-model="form.type" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm" required>
                                <option value="Sick">Sick</option>
                                <option value="Annual">Annual</option>
                                <option value="Personal">Personal</option>
                                <option value="Maternity">Maternity</option>
                                <option value="Other">Other</option>
                            </select>
                            <p v-if="form.errors.type" class="mt-1 text-sm text-red-600">{{ form.errors.type }}</p>
                        </div>

                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Start Date</label>
                                <input v-model="form.start_date" type="date" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm" required />
                                <p v-if="form.errors.start_date" class="mt-1 text-sm text-red-600">{{ form.errors.start_date }}</p>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">End Date</label>
                                <input v-model="form.end_date" type="date" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm" required />
                                <p v-if="form.errors.end_date" class="mt-1 text-sm text-red-600">{{ form.errors.end_date }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Reason</label>
                            <textarea v-model="form.reason" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm" rows="3"></textarea>
                            <p v-if="form.errors.reason" class="mt-1 text-sm text-red-600">{{ form.errors.reason }}</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500" :disabled="form.processing">
                                Update
                            </button>
                            <Link :href="route('leaves')" class="text-sm text-gray-600 hover:text-gray-900">Cancel</Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
