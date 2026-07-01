<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';


const props = defineProps({
    attendances: {
        type: Array,
        default: () => [],
    },
});
console.log(props.attendances)
</script>

<template>
    <Head title="Attendance" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">
                    Attendance Records
                </h2>

                <Link
                    :href="route('attendance.create')"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                >
                    Record Attendance
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden rounded-lg bg-white shadow">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                    Employee
                                </th>

                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                    Date
                                </th>

                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                    Check In
                                </th>

                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                    Check Out
                                </th>

                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            <tr
                                v-for="attendance in attendances"
                                :key="attendance.id"
                                
                            >
                            
                                <td class="px-6 py-4">
                                    {{ attendance.employee?.name }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ attendance.date }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ attendance.check_in }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ attendance.check_out || '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="rounded-full px-3 py-1 text-xs font-semibold"
                                        :class="{
                                            'bg-green-100 text-green-700': attendance.status === 'Present',
                                            'bg-red-100 text-red-700': attendance.status === 'Absent',
                                            'bg-yellow-100 text-yellow-700': attendance.status === 'Late',
                                            'bg-blue-100 text-blue-700': attendance.status === 'Leave',
                                        }"
                                    >
                                        {{ attendance.status }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <Link
                                        :href="route('attendance.edit', attendance.id)"
                                        class="mr-2 text-indigo-600 hover:underline"
                                    >
                                        Edit
                                    </Link>

                                    <Link
                                        :href="route('attendance.show', attendance.id)"
                                        class="text-green-600 hover:underline"
                                    >
                                        View
                                    </Link>
                                </td>
                            </tr>

                            <tr v-if="attendances.length === 0">
                                <td
                                    colspan="6"
                                    class="px-6 py-8 text-center text-gray-500"
                                >
                                    No attendance records found.
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>