<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    attendance: {
        type: Array,
        default: () => [],
    },
});

const search = ref('');

const filteredAttendance = computed(() => {
    if (!search.value) return props.attendance;

    return props.attendance.filter(record =>
        record.employee?.first_name?.toLowerCase().includes(search.value.toLowerCase()) ||
        record.employee?.last_name?.toLowerCase().includes(search.value.toLowerCase()) ||
        record.employee?.employee_number?.toLowerCase().includes(search.value.toLowerCase())
    );
});

const badgeClass = (status) => {
    switch (status) {
        case 'Present':
            return 'bg-green-100 text-green-700';

        case 'Absent':
            return 'bg-red-100 text-red-700';

        case 'Late':
            return 'bg-yellow-100 text-yellow-700';

        case 'On Leave':
            return 'bg-blue-100 text-blue-700';

        default:
            return 'bg-gray-100 text-gray-700';
    }
};
</script>

<template>
    <div class="bg-white rounded-xl shadow border border-gray-200">

        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b">

            <div>
                <h2 class="text-xl font-semibold">
                    Attendance Report
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Daily attendance records.
                </p>
            </div>

            <input
                v-model="search"
                type="text"
                placeholder="Search employee..."
                class="w-72 rounded-lg border-gray-300"
            >

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-3 text-left">Employee</th>

                        <th class="px-6 py-3 text-left">Employee No.</th>

                        <th class="px-6 py-3 text-left">Date</th>

                        <th class="px-6 py-3 text-left">Check In</th>

                        <th class="px-6 py-3 text-left">Check Out</th>

                        <th class="px-6 py-3 text-left">Status</th>

                    </tr>

                </thead>

                <tbody>

                    <tr
                        v-for="record in filteredAttendance"
                        :key="record.id"
                        class="border-t hover:bg-gray-50"
                    >

                        <td class="px-6 py-4">
                            {{ record.employee?.first_name }}
                            {{ record.employee?.last_name }}
                        </td>

                        <td class="px-6 py-4">
                            {{ record.employee?.employee_number }}
                        </td>

                        <td class="px-6 py-4">
                            {{ record.date }}
                        </td>

                        <td class="px-6 py-4">
                            {{ record.check_in }}
                        </td>

                        <td class="px-6 py-4">
                            {{ record.check_out ?? '-' }}
                        </td>

                        <td class="px-6 py-4">

                            <span
                                :class="badgeClass(record.status)"
                                class="px-3 py-1 rounded-full text-xs font-semibold"
                            >
                                {{ record.status }}
                            </span>

                        </td>

                    </tr>

                    <tr v-if="filteredAttendance.length === 0">

                        <td
                            colspan="6"
                            class="py-10 text-center text-gray-500"
                        >
                            No attendance records found.
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>
</template>