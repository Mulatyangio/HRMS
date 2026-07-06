<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const { leaves } = defineProps({
    leaves: {
        type: Array,
        default: () => [],
    },
});

const statusClass = (status) => {
    return {
        'bg-yellow-100 text-yellow-800': status === 'pending',
        'bg-green-100 text-green-800': status === 'approved',
        'bg-red-100 text-red-800': status === 'rejected',
    };
};
</script>

<template>
    <Head title="Leave Management" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Leave Management
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Review and manage employee leave requests.
                </p>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Employee</th>
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
                                <td class="px-6 py-4">{{ leave.employee?.name }}</td>
                                <td class="px-6 py-4">{{ leave.type }}</td>
                                <td class="px-6 py-4">{{ leave.start_date }}</td>
                                <td class="px-6 py-4">{{ leave.end_date }}</td>
                                <td class="px-6 py-4">{{ leave.reason || '-' }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="rounded-full px-3 py-1 text-xs font-semibold"
                                        :class="statusClass(leave.status)"
                                    >
                                        {{ leave.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <Link
                                        v-if="leave.status === 'pending'"
                                        :href="route('leaves.approve', leave.id)"
                                        method="patch"
                                        as="button"
                                        class="mr-1 rounded bg-green-500 px-3 py-1 text-xs text-white hover:bg-green-600"
                                    >
                                        Accept
                                    </Link>
                                    <Link
                                        v-if="leave.status === 'pending'"
                                        :href="route('leaves.reject', leave.id)"
                                        method="patch"
                                        as="button"
                                        class="mr-1 rounded bg-red-500 px-3 py-1 text-xs text-white hover:bg-red-600"
                                    >
                                        Reject
                                    </Link>
                                    <Link
                                        :href="route('leaves.edit', leave.id)"
                                        class="mr-1 text-indigo-600 hover:underline text-xs"
                                    >
                                        Edit
                                    </Link>
                                </td>
                            </tr>
                            <tr v-if="leaves.length === 0">
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    No leave requests found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
