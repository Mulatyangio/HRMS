<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const { leaves, employee } = defineProps({
    leaves: Array,
    employee: Object,
});

const showForm = ref(false);

const form = useForm({
    type: 'Annual',
    start_date: '',
    end_date: '',
    reason: '',
});

const submit = () => {
    form.post(route('employee.leaves.store'), {
        onSuccess: () => {
            form.reset();
            showForm.value = false;
        },
    });
};

const statusColor = (status) => ({
    'pending': 'bg-yellow-100 text-yellow-800',
    'approved': 'bg-green-100 text-green-800',
    'rejected': 'bg-red-100 text-red-800',
}[status] || 'bg-gray-100 text-gray-800');
</script>

<template>
    <Head title="My Leave Requests" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">My Leave Requests</h2>
                    <p class="mt-1 text-sm text-gray-500">Submit and track your leave requests.</p>
                </div>
                <button @click="showForm = !showForm" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    {{ showForm ? 'Cancel' : 'New Request' }}
                </button>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-4xl space-y-6">
                <div v-if="$page.props.flash?.success" class="rounded-lg bg-green-50 p-4 text-sm text-green-700 border border-green-200">
                    {{ $page.props.flash.success }}
                </div>

                <div v-if="showForm" class="rounded-lg bg-white p-6 shadow">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">New Leave Request</h3>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Leave Type</label>
                            <select v-model="form.type" class="w-full rounded-lg border-gray-300 bg-gray-50 py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Annual">Annual</option>
                                <option value="Sick">Sick</option>
                                <option value="Personal">Personal</option>
                                <option value="Maternity">Maternity</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Start Date</label>
                                <input v-model="form.start_date" type="date" required class="w-full rounded-lg border-gray-300 bg-gray-50 py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">End Date</label>
                                <input v-model="form.end_date" type="date" required class="w-full rounded-lg border-gray-300 bg-gray-50 py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Reason (optional)</label>
                            <textarea v-model="form.reason" rows="3" class="w-full rounded-lg border-gray-300 bg-gray-50 py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                        <button type="submit" :disabled="form.processing" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50">
                            {{ form.processing ? 'Submitting...' : 'Submit Request' }}
                        </button>
                    </form>
                </div>

                <div class="rounded-lg bg-white shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Type</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Start Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">End Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Reason</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="leave in leaves" :key="leave.id">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ leave.type }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ leave.start_date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ leave.end_date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ leave.reason || '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold" :class="statusColor(leave.status)">{{ leave.status }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <template v-if="leave.status === 'pending'">
                                        <Link
                                            :href="route('employee.leaves.edit', leave.id)"
                                            class="mr-2 text-indigo-600 hover:underline text-sm"
                                        >
                                            Edit
                                        </Link>
                                        <Link
                                            :href="route('employee.leaves.destroy', leave.id)"
                                            method="delete"
                                            as="button"
                                            class="text-red-600 hover:underline text-sm"
                                        >
                                            Cancel
                                        </Link>
                                    </template>
                                    <span v-else class="text-xs text-gray-400">-</span>
                                </td>
                            </tr>
                            <tr v-if="leaves.length === 0">
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">No leave requests yet. Click "New Request" to submit one.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
