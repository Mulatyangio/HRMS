<script setup>
import { computed } from 'vue';
import {
    Chart as ChartJS,
    ArcElement,
    Tooltip,
    Legend,
    CategoryScale,
    LinearScale,
    BarElement,
} from 'chart.js';

import { Pie, Bar } from 'vue-chartjs';

ChartJS.register(
    ArcElement,
    Tooltip,
    Legend,
    CategoryScale,
    LinearScale,
    BarElement
);

const props = defineProps({
    attendance: {
        type: Object,
        default: () => ({ present: 0, absent: 0, late: 0 }),
    },
    payroll: {
        type: Object,
        default: () => ({ count: 0, total: 0 }),
    },
});

const hasAttendanceData = computed(() =>
    props.attendance.present > 0 || props.attendance.absent > 0 || props.attendance.late > 0
);

const attendanceData = computed(() => ({
    labels: ['Present', 'Absent', 'Late'],
    datasets: [
        {
            data: [
                props.attendance.present,
                props.attendance.absent,
                props.attendance.late,
            ],
            backgroundColor: ['#22c55e', '#ef4444', '#f59e0b'],
        },
    ],
}));

const hasPayrollData = computed(() => props.payroll.total > 0);

const payrollData = computed(() => ({
    labels: ['Total Net Salary'],
    datasets: [
        {
            label: 'KES',
            data: [props.payroll.total],
            backgroundColor: '#6366f1',
        },
    ],
}));
</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow border border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-5">Attendance Overview</h2>
            <Pie v-if="hasAttendanceData" :data="attendanceData" />
            <p v-else class="text-gray-400 text-center py-12">No attendance data available.</p>
        </div>
        <div class="bg-white rounded-xl shadow border border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-5">Payroll</h2>
            <Bar v-if="hasPayrollData" :data="payrollData" />
            <p v-else class="text-gray-400 text-center py-12">No payroll data available.</p>
        </div>
    </div>
</template>
