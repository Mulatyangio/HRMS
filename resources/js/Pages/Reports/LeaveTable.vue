<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    leaves: {
        type: Array,
        default: () => [],
    },
});

const search = ref('');

const filteredLeaves = computed(() => {
    if (!search.value) return props.leaves;

    return props.leaves.filter((leave) => {
        const employee =
            `${leave.employee?.name?? ''} `.toLowerCase();

        return (
            employee.includes(search.value.toLowerCase()) ||
            leave.leave_type?.toLowerCase().includes(search.value.toLowerCase())
        );
    });
});

const statusClass = (status) => {
    switch (status) {
        case 'Approved':
            return 'bg-green-100 text-green-700';

        case 'Pending':
            return 'bg-yellow-100 text-yellow-700';

        case 'Rejected':
            return 'bg-red-100 text-red-700';

        default:
            return 'bg-gray-100 text-gray-700';
    }
};
</script>

<template>
    <div class="bg-white rounded-xl shadow border border-gray-200">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 p-6 border-b">

            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Leave Report
                </h2>

                <p class="text-sm text-gray-500">
                    Employee leave requests and approval status.
                </p>
            </div>

            <input
                v-model="search"
                type="text"
                placeholder="Search employee or leave type..."
                class="w-full md:w-72 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
            >
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Leave Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Start Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">End Date</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase">Days</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase">Status</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    <tr
                        v-for="leave in filteredLeaves"
                        :key="leave.id"
                        class="hover:bg-gray-50"
                    >

                        <td class="px-6 py-4">
                            {{ leave.employee?.first_name }}
                            {{ leave.employee?.last_name }}
                        </td>

                        <td class="px-6 py-4">
                            {{ leave.leave_type }}
                        </td>

                        <td class="px-6 py-4">
                            {{ leave.start_date }}
                        </td>

                        <td class="px-6 py-4">
                            {{ leave.end_date }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ leave.days }}
                        </td>

                        <td class="px-6 py-4 text-center">

                            <span
                                :class="statusClass(leave.status)"
                                class="inline-flex px-3 py-1 rounded-full text-xs font-semibold"
                            >
                                {{ leave.status }}
                            </span>

                        </td>

                    </tr>

                    <tr v-if="filteredLeaves.length === 0">

                        <td
                            colspan="6"
                            class="text-center py-10 text-gray-500"
                        >
                            No leave records found.
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>
</template>