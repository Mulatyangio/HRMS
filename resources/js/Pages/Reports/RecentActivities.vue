<script setup>
const props = defineProps({
    activities: {
        type: Array,
        default: () => [],
    },
});

const badgeColor = (type) => {
    switch (type) {
        case 'employee':
            return 'bg-blue-100 text-blue-700';

        case 'attendance':
            return 'bg-green-100 text-green-700';

        case 'leave':
            return 'bg-yellow-100 text-yellow-700';

        case 'payroll':
            return 'bg-purple-100 text-purple-700';

        default:
            return 'bg-gray-100 text-gray-700';
    }
};

const badgeText = (type) => {
    switch (type) {
        case 'employee':
            return 'Employee';

        case 'attendance':
            return 'Attendance';

        case 'leave':
            return 'Leave';

        case 'payroll':
            return 'Payroll';

        default:
            return 'Activity';
    }
};
</script>

<template>
    <div class="bg-white rounded-xl shadow border border-gray-200">

        <!-- Header -->
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">
                Recent Activities
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Latest activities across the HR system.
            </p>
        </div>

        <!-- Activity List -->
        <div v-if="activities.length">

            <div
                v-for="activity in activities"
                :key="activity.id"
                class="flex items-start justify-between p-5 border-b last:border-b-0 hover:bg-gray-50 transition"
            >

                <div>

                    <div class="flex items-center gap-3">

                        <span
                            :class="badgeColor(activity.type)"
                            class="px-3 py-1 rounded-full text-xs font-semibold"
                        >
                            {{ badgeText(activity.type) }}
                        </span>

                        <h3 class="font-medium text-gray-800">
                            {{ activity.title }}
                        </h3>

                    </div>

                    <p class="mt-2 text-sm text-gray-600">
                        {{ activity.description }}
                    </p>

                </div>

                <div class="text-sm text-gray-400 whitespace-nowrap ml-4">
                    {{ activity.created_at }}
                </div>

            </div>

        </div>

        <!-- Empty State -->
        <div
            v-else
            class="py-12 text-center text-gray-500"
        >
            No recent activities available.
        </div>

    </div>
</template>