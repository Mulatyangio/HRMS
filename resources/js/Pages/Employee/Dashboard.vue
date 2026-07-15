<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const { employee, stats, recentAttendance, recentLeaves } = defineProps({
    employee: Object,
    stats: Object,
    recentAttendance: Array,
    recentLeaves: Array,
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
    <Head title="My Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">My Dashboard</h2>
                <p class="mt-1 text-sm text-gray-500">Welcome back, {{ employee.name }}. Here's your overview.</p>
            </div>
        </template>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Days Present (This Month)</p>
                <p class="mt-1 text-3xl font-bold text-gray-900">{{ stats.days_present_this_month }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Total Leave Requests</p>
                <p class="mt-1 text-3xl font-bold text-gray-900">{{ stats.total_leaves }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Pending Leaves</p>
                <p class="mt-1 text-3xl font-bold text-amber-600">{{ stats.pending_leaves }}</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Approved Leaves</p>
                <p class="mt-1 text-3xl font-bold text-green-600">{{ stats.approved_leaves }}</p>
            </div>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">Recent Attendance</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    <div v-for="record in recentAttendance" :key="record.id" class="flex items-center justify-between px-6 py-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ record.date }}</p>
                            <p class="text-xs text-gray-500">{{ record.check_in || '--' }} - {{ record.check_out || '--' }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold" :class="statusColor(record.status)">{{ record.status }}</span>
                    </div>
                    <div v-if="recentAttendance.length === 0" class="px-6 py-8 text-center text-sm text-gray-500">No attendance records yet.</div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">Recent Leave Requests</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    <div v-for="leave in recentLeaves" :key="leave.id" class="flex items-center justify-between px-6 py-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ leave.type }}</p>
                            <p class="text-xs text-gray-500">{{ leave.start_date }} to {{ leave.end_date }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold" :class="leaveStatusColor(leave.status)">{{ leave.status }}</span>
                    </div>
                    <div v-if="recentLeaves.length === 0" class="px-6 py-8 text-center text-sm text-gray-500">No leave requests yet.</div>
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-4">
            <button @click="router.visit(route('employee.clock-in-out'))" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm text-left hover:border-indigo-300 hover:bg-indigo-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Clock In / Out</p>
                        <p class="text-xs text-gray-500">Record your attendance</p>
                    </div>
                </div>
            </button>
            <button @click="router.visit(route('employee.leaves'))" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm text-left hover:border-indigo-300 hover:bg-indigo-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Request Leave</p>
                        <p class="text-xs text-gray-500">Submit a new leave request</p>
                    </div>
                </div>
            </button>
        </div>
    </AuthenticatedLayout>
</template>
