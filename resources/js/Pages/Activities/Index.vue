<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    activities: { type: Array, default: () => [] },
});

const badgeColor = (type) => {
    switch (type) {
        case 'employee': return 'bg-blue-100 text-blue-700';
        case 'attendance': return 'bg-green-100 text-green-700';
        case 'leave': return 'bg-yellow-100 text-yellow-700';
        case 'payroll': return 'bg-purple-100 text-purple-700';
        default: return 'bg-gray-100 text-gray-700';
    }
};

const badgeText = (type) => {
    switch (type) {
        case 'employee': return 'Employee';
        case 'attendance': return 'Attendance';
        case 'leave': return 'Leave';
        case 'payroll': return 'Payroll';
        default: return 'Activity';
    }
};
</script>

<template>
    <Head title="Activities" />
    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Activities</h2>
                <p class="mt-1 text-sm text-gray-500">Real-time activity log across the system.</p>
            </div>
        </template>
        <div class="py-8">
            <div class="mx-auto max-w-7xl">
                <div class="bg-white rounded-xl shadow border border-gray-200">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold">Recent Activities</h3>
                    </div>
                    <div v-if="activities.length" class="divide-y divide-gray-100">
                        <div v-for="activity in activities" :key="activity.id"
                            class="flex items-start gap-4 px-6 py-4 hover:bg-gray-50 transition">
                            <span :class="badgeColor(activity.type)"
                                class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap">
                                {{ badgeText(activity.type) }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900">
                                    <span class="font-medium">{{ activity.user }}</span>
                                    {{ activity.action }}
                                </p>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap">{{ activity.time }}</span>
                        </div>
                    </div>
                    <div v-else class="py-12 text-center text-gray-500">
                        No activities recorded yet.
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
