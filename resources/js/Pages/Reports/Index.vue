<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';

import DashboardCards from './DashboardCards.vue';
import DepartmentTable from './DepartmentTable.vue';
import AttendanceTable from './AttendanceTable.vue';
import LeaveTable from './LeaveTable.vue';
import PayrollTable from './PayrollTable.vue';
import RecentActivities from './RecentActivities.vue';
import Charts from './Charts.vue';
import Filters from './Filters.vue';
import ExportButtons from './ExportButtons.vue';

const filters = reactive({
    from: '',
    to: '',
    department: '',
    status: '',
});

defineProps({
    summary: { type: Object, default: () => ({}) },
    departments: { type: Array, default: () => [] },
    attendance: { type: Object, default: () => ({}) },
    attendance_records: { type: Array, default: () => [] },
    leaves: { type: Array, default: () => [] },
    payrolls: { type: Array, default: () => [] },
    payroll: { type: Object, default: () => ({}) },
    activities: { type: Array, default: () => [] },
});
</script>

<template>
    <Head title="Reports" />
    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Reports</h2>
                <p class="mt-1 text-sm text-gray-500">Overview of your organization.</p>
            </div>
        </template>
        <div class="py-8">
            <div class="mx-auto max-w-7xl space-y-8">
                <Filters :filters="filters" :departments="departments" />
                <DashboardCards :summary="summary" />
                <Charts :attendance="attendance" :payroll="payroll" />
                <DepartmentTable :departments="departments" />
                <AttendanceTable :attendance="attendance_records" />
                <LeaveTable :leaves="leaves" />
                <PayrollTable :payrolls="payrolls" />
                <RecentActivities :activities="activities" />
                <ExportButtons :filters="filters" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
