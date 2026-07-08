<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import { router } from '@inertiajs/vue3';

const addEmployee = () => {
    router.visit(route('employees.create'));
};

const props = defineProps({
    stats: {
        type: Array,
        default: () => [
            { label: 'Total Employees', value: '248', change: '+12', changeType: 'increase', icon: 'users' },
            { label: 'Present Today', value: '215', change: '86.7%', changeType: 'neutral', icon: 'check' },
            { label: 'On Leave', value: '18', change: '+3', changeType: 'increase', icon: 'calendar' },
            { label: 'Open Positions', value: '12', change: '-2', changeType: 'decrease', icon: 'briefcase' },
        ],
    },
    departments: {
        type: Array,
        default: () => [
            { name: 'Engineering', head: 'Sarah Johnson', employees: 45 },
            { name: 'Marketing', head: 'Mike Chen', employees: 28 },
            { name: 'Finance', head: 'Emily Davis', emtimezoneployees: 15 },
            { name: 'Operations', head: 'James Wilson', employees: 32 },
            { name: 'Human Resources', head: 'Lisa Brown', employees: 12 },
            { name: 'Sales', head: 'David Kim', employees: 38 },
        ],
    },
    recentActivities: {
        type: Array,
        default: () => [
            { user: 'Sarah Johnson', action: 'clocked in', time: '2 minutes ago' },
            { user: 'Mike Chen', action: 'submitted leave request', time: '15 minutes ago' },
            { user: 'Emily Davis', action: 'approved overtime', time: '1 hour ago' },
            { user: 'James Wilson', action: 'updated department budget', time: '2 hours ago' },
            { user: 'Lisa Brown', action: 'completed onboarding', time: '3 hours ago' },
            { user: 'David Kim', action: 'submitted expense report', time: '4 hours ago' },
        ],
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
                <p class="mt-1 text-sm text-gray-500">Welcome back, {{ $page.props.auth.user.name }}. Here's what's happening today.</p>
            </div>
        </template>

        <!-- Stats Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div v-for="stat in stats" :key="stat.label" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ stat.label }}</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">{{ stat.value }}</p>
                    </div>
                    <div :class="[
                        'flex h-12 w-12 items-center justify-center rounded-lg',
                        stat.changeType === 'increase' ? 'bg-green-100 text-green-600' :
                        stat.changeType === 'decrease' ? 'bg-red-100 text-red-600' :
                        'bg-blue-100 text-blue-600'
                    ]">
                        <svg v-if="stat.icon === 'users'" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <svg v-else-if="stat.icon === 'check'" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <svg v-else-if="stat.icon === 'calendar'" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <svg v-else class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-1">
                    <span :class="[
                        'text-sm font-medium',
                        stat.changeType === 'increase' ? 'text-green-600' :
                        stat.changeType === 'decrease' ? 'text-red-600' :
                        'text-blue-600'
                    ]">{{ stat.change }}</span>
                    <span class="text-sm text-gray-500">vs last month</span>
                </div>
            </div>
        </div>

        <!-- Charts / Tables Row -->
        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <!-- Departments -->
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">Departments</h3>
                    <button class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                    @onclick="router.visit(route('departments.index'))"
                    >View all</button>
                </div>
                <div class="p-6">
                    <div v-for="(dept, i) in departments" :key="dept.name" :class="i !== departments.length - 1 ? 'mb-4' : ''">
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium text-gray-900">{{ dept.name }}</span>
                            <span class="text-gray-500">{{ dept.employees }} employees</span>
                        </div>
                        <div class="mt-2 flex items-center gap-2">
                            <div class="h-2 flex-1 rounded-full bg-gray-100">
                                <div class="h-2 rounded-full bg-indigo-500" :style="{ width: (dept.employees / 45) * 100 + '%' }"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">Recent Activity</h3>
                    <button class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                    @onclick="router.visit(route('activities.index'))"
                    >View all</button>
                </div>
                <div class="divide-y divide-gray-100">
                    <div v-for="activity in recentActivities" :key="activity.time" class="flex items-center gap-3 px-6 py-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-xs font-medium text-indigo-600">
                            {{ activity.user.charAt(0) }}{{ activity.user.split(' ')[1].charAt(0) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900">
                                <span class="font-medium">{{ activity.user }}</span>
                                {{ activity.action }}
                            </p>
                        </div>
                        <span class="text-xs text-gray-500">{{ activity.time }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-2">
            <!-- Quick Actions -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-base font-semibold text-gray-900">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-3">
                    <button @onclick="addEmployee" class="flex flex-col items-center gap-2 rounded-lg border border-gray-200 p-4 text-sm text-gray-600 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Add Employee
                    </button>
                    <button class="flex flex-col items-center gap-2 rounded-lg border border-gray-200 p-4 text-sm text-gray-600 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Approve Leave
                    </button>
                    <button class="flex flex-col items-center gap-2 rounded-lg border border-gray-200 p-4 text-sm text-gray-600 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Run Payroll
                    </button>
                    <button class="flex flex-col items-center gap-2 rounded-lg border border-gray-200 p-4 text-sm text-gray-600 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Generate Report
                    </button>
                </div>
            </div>

            <!-- Pending Approvals -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-base font-semibold text-gray-900">Pending Approvals</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between rounded-lg bg-amber-50 p-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Leave Request</p>
                            <p class="text-xs text-gray-500">Sarah Johnson &middot; 2 days</p>
                        </div>
                        <span class="rounded-full bg-amber-200 px-2 py-0.5 text-xs font-medium text-amber-800">Pending</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg bg-amber-50 p-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Overtime</p>
                            <p class="text-xs text-gray-500">Mike Chen &middot; 4 hours</p>
                        </div>
                        <span class="rounded-full bg-amber-200 px-2 py-0.5 text-xs font-medium text-amber-800">Pending</span>
                    </div>
                    <div class="flex items-center justify-between rounded-lg bg-amber-50 p-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Expense Report</p>
                            <p class="text-xs text-gray-500">Emily Davis &middot; $250</p>
                        </div>
                        <span class="rounded-full bg-amber-200 px-2 py-0.5 text-xs font-medium text-amber-800">Pending</span>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
