<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    employee: Object,
    attendances: Array,
    leaves: Array,
    stats: Object,
});

const statusColor = (status) => ({
    'Present': 'bg-green-100 text-green-700',
    'Absent': 'bg-red-100 text-red-700',
    'Late': 'bg-yellow-100 text-yellow-700',
}[status] || 'bg-gray-100 text-gray-700');

const leaveStatusColor = (status) => ({
    'pending': 'bg-yellow-100 text-yellow-800',
    'approved': 'bg-green-100 text-green-800',
    'rejected': 'bg-red-100 text-red-800',
}[status] || 'bg-gray-100 text-gray-800');
</script>

<template>
    <Head title="My Reports" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">My Reports</h2>
                <p class="mt-1 text-sm text-gray-500">View your attendance and leave summary.</p>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-4xl space-y-6">
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Total Days Present</p>
                        <p class="mt-1 text-2xl font-bold text-green-600">{{ stats.total_present }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Total Leaves Taken</p>
                        <p class="mt-1 text-2xl font-bold text-blue-600">{{ stats.total_approved_leaves }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-medium text-gray-500">Pending Requests</p>
                        <p class="mt-1 text-2xl font-bold text-amber-600">{{ stats.pending_leaves }}</p>
                    </div>
                </div>

                <div class="rounded-lg bg-white shadow overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-base font-semibold text-gray-900">Attendance Summary</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Clock In</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Clock Out</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="record in attendances" :key="record.id">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ record.date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ record.check_in || '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ record.check_out || '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold" :class="statusColor(record.status)">{{ record.status }}</span>
                                </td>
                            </tr>
                            <tr v-if="attendances.length === 0">
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">No records.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="rounded-lg bg-white shadow overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-base font-semibold text-gray-900">Leave History</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Type</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">From</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">To</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Reason</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="leave in leaves" :key="leave.id">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ leave.type }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ leave.start_date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ leave.end_date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ leave.reason || '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold" :class="leaveStatusColor(leave.status)">{{ leave.status }}</span>
                                </td>
                            </tr>
                            <tr v-if="leaves.length === 0">
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No leave records.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
