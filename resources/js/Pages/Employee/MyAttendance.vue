<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const { attendances, todayRecord, employee } = defineProps({
    attendances: Array,
    todayRecord: Object,
    employee: Object,
});

const isClockedIn = todayRecord && todayRecord.check_in && !todayRecord.check_out;
const hasClockedInToday = todayRecord && todayRecord.check_in;

const clockIn = () => {
    router.post(route('employee.clock-in'));
};

const clockOut = () => {
    router.post(route('employee.clock-out'));
};

const statusColor = (status) => ({
    'Present': 'bg-green-100 text-green-700',
    'Absent': 'bg-red-100 text-red-700',
    'Late': 'bg-yellow-100 text-yellow-700',
}[status] || 'bg-gray-100 text-gray-700');
</script>

<template>
    <Head title="My Attendance" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">My Attendance</h2>
                <p class="mt-1 text-sm text-gray-500">Clock in/out and view your attendance history.</p>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-4xl space-y-6">
                <div v-if="$page.props.flash?.success" class="rounded-lg bg-green-50 p-4 text-sm text-green-700 border border-green-200">
                    {{ $page.props.flash.success }}
                </div>
                <div v-if="$page.props.errors?.clock" class="rounded-lg bg-red-50 p-4 text-sm text-red-700 border border-red-200">
                    {{ $page.props.errors.clock }}
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-500">Today's Status</p>
                        <p class="mt-1 text-4xl font-bold text-gray-900">
                            {{ todayRecord?.date || new Date().toLocaleDateString() }}
                        </p>
                        <div class="mt-4 flex items-center justify-center gap-6 text-sm text-gray-600">
                            <div>
                                <span class="text-gray-400">Clock In:</span>
                                <span class="ml-1 font-medium text-gray-900">{{ todayRecord?.check_in || '--:--' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400">Clock Out:</span>
                                <span class="ml-1 font-medium text-gray-900">{{ todayRecord?.check_out || '--:--' }}</span>
                            </div>
                            <div v-if="todayRecord?.status">
                                <span class="text-gray-400">Status:</span>
                                <span class="ml-1 font-semibold" :class="{ 'text-green-600': todayRecord.status === 'Present', 'text-yellow-600': todayRecord.status === 'Late', 'text-red-600': todayRecord.status === 'Absent' }">{{ todayRecord.status }}</span>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-center gap-4">
                            <button
                                v-if="!hasClockedInToday"
                                @click="clockIn"
                                class="rounded-lg bg-green-600 px-8 py-3 text-sm font-semibold text-white hover:bg-green-700 transition-colors"
                            >
                                <svg class="mr-2 inline h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Clock In
                            </button>
                            <button
                                v-else-if="isClockedIn"
                                @click="clockOut"
                                class="rounded-lg bg-red-600 px-8 py-3 text-sm font-semibold text-white hover:bg-red-700 transition-colors"
                            >
                                <svg class="mr-2 inline h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Clock Out
                            </button>
                            <div v-else class="text-sm text-gray-500">
                                You've completed your attendance for today.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg bg-white shadow overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-base font-semibold text-gray-900">Attendance History</h3>
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
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">No attendance records yet.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
