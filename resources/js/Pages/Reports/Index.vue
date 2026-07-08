<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import DashboardCards from './DashboardCards.vue';
import DepartmentTable from './DepartmentTable.vue';
import AttendanceTable from './AttendanceTable.vue';
import LeaveTable from './LeaveTable.vue';
import PayrollTable from './PayrollTable.vue';
import RecentActivities from './RecentActivities.vue';
import Charts from './Charts.vue';
import Filters from './Filters.vue';
import ExportButtons from './ExportButtons.vue';

defineProps({
    employees: { type: Object, default: () => ({}) },
    departments: { type: Array, default: () => [] },
    attendance: { type: Object, default: () => ({}) },
    leaves: { type: Object, default: () => ({}) },
    payroll: { type: Object, default: () => ({}) },
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
                <Filters />
                <DashboardCards :employees="employees" />
                <Charts :attendance="attendance" :payroll="payroll" />
                <DepartmentTable :departments="departments" />
                <AttendanceTable :attendance="attendance" />
                <LeaveTable :leaves="leaves" />
                <PayrollTable :payroll="payroll" />
                <RecentActivities />
                <ExportButtons />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
